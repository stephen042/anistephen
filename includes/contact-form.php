<?php
// AJAX contact form. Submitted via jQuery to contact-submit.php (see js/contact.js).
// No synchronous POST handling here — validation + SMTP delivery happen in
// includes/contact-submit.php, which returns JSON. No SMTP details here.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];
?>

<div id="contact-feedback" class="alert d-none" role="alert" aria-live="polite"></div>

<form id="contact-form" method="post" action="contact-submit.php" novalidate>
    <input type="hidden" name="csrf_token" value="<?= e($csrf_token) ?>" />
    <!-- Honeypot: hidden from humans, catches bots. Checked server-side. -->
    <div class="contact-honeypot" aria-hidden="true">
        <label for="website">Website</label>
        <input type="text" id="website" name="website" value="" tabindex="-1" autocomplete="off" />
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="fw-medium form-label fs-16" for="name">Name</label>
            <input type="text" class="form-control" placeholder="Your name" id="name" name="name" maxlength="100" required autocomplete="name" />
            <div class="invalid-feedback" data-error-for="name"></div>
        </div>
        <div class="col-md-6 mb-3">
            <label class="fw-medium form-label fs-16" for="email">Email</label>
            <input type="email" class="form-control" placeholder="Your email" id="email" name="email" maxlength="254" required autocomplete="email" />
            <div class="invalid-feedback" data-error-for="email"></div>
        </div>
        <div class="col-12 mb-3">
            <label class="fw-medium form-label fs-16" for="subject">Subject</label>
            <input type="text" class="form-control" placeholder="Project, business idea or software requirement" id="subject" name="subject" maxlength="150" required />
            <div class="invalid-feedback" data-error-for="subject"></div>
        </div>
        <div class="col-12 mb-3">
            <label class="fw-medium form-label fs-16" for="message">Message</label>
            <textarea class="form-control" id="message" name="message" placeholder="Tell me about your project..." rows="5" maxlength="5000" required></textarea>
            <div class="invalid-feedback" data-error-for="message"></div>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary mt-2" id="contact-submit-btn">Send Message</button>
        </div>
    </div>
</form>
