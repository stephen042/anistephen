<?php
// =====================================================================
// Contact form AJAX endpoint — returns JSON only. No HTML is output here.
// URL: contact-submit.php (root wrapper) or includes/contact-submit.php
//
// Flow: validate POST -> PHPMailer SMTP -> JSON response.
// SMTP credentials are read server-side from config/mail.php and are
// NEVER included in any response. Detailed errors go to the server
// error log (error_log), visitors only see friendly generic messages.
// =====================================================================

declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json; charset=UTF-8');
// Never cache a form endpoint.
header('Cache-Control: no-store, no-cache, must-revalidate');

use PHPMailer\PHPMailer\PHPMailer;

$respond = static function (bool $ok, string $message, array $errors = [], int $status = 200, array $extra = []): void {
    http_response_code($status);
    echo json_encode(array_merge([
        'success' => $ok,
        'message' => $message,
        'errors'  => $errors,
    ], $extra));
    exit;
};

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    $respond(false, 'Invalid request method.', [], 405);
}

require_once __DIR__ . '/functions.php';

$root = dirname(__DIR__);

// --- CSRF check (token is rendered into the form by includes/contact-form.php) ---
$postedToken  = (string) ($_POST['csrf_token'] ?? '');
$sessionToken = (string) ($_SESSION['csrf_token'] ?? '');
if ($sessionToken === '' || $postedToken === '' || !hash_equals($sessionToken, $postedToken)) {
    $respond(false, 'Please reload the page and try again.', [], 419);
}

// --- Honeypot: visually hidden field. Bots fill it, humans never see it. ---
// Pretend success so automated submitters learn nothing.
if (trim((string) ($_POST['website'] ?? '')) !== '') {
    $respond(true, "Message sent successfully. I'll get back to you soon.");
}

// --- Simple rate limit: one submission per 30 seconds per session. ---
$now = time();
if (isset($_SESSION['contact_last_send']) && ($now - (int) $_SESSION['contact_last_send']) < 30) {
    $respond(false, 'Please wait a moment before sending another message.', [], 429);
}

// --- Trim + validate inputs (never trust browser-side validation). ---
$name    = trim((string) ($_POST['name'] ?? ''));
$email   = trim((string) ($_POST['email'] ?? ''));
$subject = trim((string) ($_POST['subject'] ?? ''));
$message = trim((string) ($_POST['message'] ?? ''));

$errors = [];

if ($name === '') {
    $errors['name'] = 'Please enter your name.';
} elseif (mb_strlen($name) > 100) {
    $errors['name'] = 'Name is too long (max 100 characters).';
} elseif (has_header_injection($name)) {
    $errors['name'] = 'Invalid characters in name.';
}

if ($email === '') {
    $errors['email'] = 'Please enter your email address.';
} elseif (mb_strlen($email) > 254 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Please enter a valid email address.';
} elseif (has_header_injection($email)) {
    $errors['email'] = 'Invalid characters in email address.';
}

if ($subject === '') {
    $errors['subject'] = 'Please enter a subject.';
} elseif (mb_strlen($subject) > 150) {
    $errors['subject'] = 'Subject is too long (max 150 characters).';
} elseif (has_header_injection($subject)) {
    $errors['subject'] = 'Invalid characters in subject.';
}

if ($message === '') {
    $errors['message'] = 'Please enter a message.';
} elseif (mb_strlen($message) > 5000) {
    $errors['message'] = 'Message is too long (max 5000 characters).';
}

if ($errors !== []) {
    $first = reset($errors);
    $respond(false, is_string($first) ? $first : 'Please check the form and try again.', $errors, 422);
}

// --- Load SMTP config (single source of truth: config/mail.php). ---
$mailFile = $root . '/config/mail.php';
if (!is_file($mailFile)) {
    error_log('[contact] missing config/mail.php');
    $respond(false, 'Unable to send your message right now. Please try again.', [], 500);
}

/** @var array $mail */
$mail = require $mailFile;

$required = ['host', 'port', 'username', 'password', 'from_email', 'to_email'];
foreach ($required as $key) {
    if (empty($mail[$key])) {
        error_log('[contact] SMTP config key missing or empty: ' . $key);
        $respond(false, 'Unable to send your message right now. Please try again.', [], 500);
    }
}

// Refuse to attempt delivery with unconfigured placeholder values.
if (in_array($mail['host'], ['smtp.example.com', ''], true)
    || in_array($mail['username'], ['my@email.com', ''], true)
    || $mail['password'] === 'MY_SMTP_PASSWORD'
) {
    error_log('[contact] SMTP config still holds placeholder values; email not attempted.');
    $respond(false, 'Unable to send your message right now. Please try again.', [], 500);
}

$autoload = $root . '/vendor/autoload.php';
if (!is_file($autoload)) {
    error_log('[contact] vendor/autoload.php missing — run `composer install`.');
    $respond(false, 'Unable to send your message right now. Please try again.', [], 500);
}
require_once $autoload;

// --- Normalize for safe use in headers/body (strip CR/LF). ---
$safeName    = str_replace(["\r", "\n"], ' ', $name);
$safeEmail   = str_replace(["\r", "\n"], '', $email);
$safeSubject = str_replace(["\r", "\n"], ' ', $subject);

try {
    $phpMailer = new PHPMailer(true);
    $phpMailer->isSMTP();
    $phpMailer->Host       = (string) $mail['host'];
    $phpMailer->Port       = (int) $mail['port'];
    $phpMailer->SMTPAuth   = true;
    $phpMailer->Username   = (string) $mail['username'];
    $phpMailer->Password   = (string) $mail['password'];
    $phpMailer->CharSet    = 'UTF-8';

    $encryption = strtolower((string) ($mail['encryption'] ?? 'tls'));
    if ($encryption === 'ssl') {
        $phpMailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    } elseif ($encryption === 'tls') {
        $phpMailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    } else {
        $phpMailer->SMTPSecure = false;
        $phpMailer->SMTPAutoTLS = false;
    }

    // From: the configured site mailbox (improves deliverability).
    // Reply-To: the visitor, so hitting "Reply" reaches them.
    $phpMailer->setFrom((string) $mail['from_email'], (string) ($mail['from_name'] ?? ''));
    $phpMailer->addAddress((string) $mail['to_email'], (string) ($mail['to_name'] ?? ''));
    $phpMailer->addReplyTo($safeEmail, $safeName);

    $phpMailer->isHTML(false);
    $phpMailer->Subject = 'Portfolio Contact: ' . $safeSubject;
    $phpMailer->Body    = "New message from your portfolio website\n\n"
        . "Name:\n{$safeName}\n\n"
        . "Email:\n{$safeEmail}\n\n"
        . "Subject:\n{$safeSubject}\n\n"
        . "Message:\n{$message}\n";

    $phpMailer->send();

    $_SESSION['contact_last_send'] = $now;
    // Rotate the CSRF token after a successful send.
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    $respond(true, "Message sent successfully. I'll get back to you soon.", [], 200, [
        'csrf_token' => $_SESSION['csrf_token'],
    ]);
} catch (Throwable $e) {
    // Detailed reason stays in the server log — never sent to the browser.
    error_log('[contact] SMTP send failed: ' . $e->getMessage());
    $respond(false, 'Unable to send your message right now. Please try again.', [], 500);
}
