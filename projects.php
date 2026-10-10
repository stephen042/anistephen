<?php
$config = require __DIR__ . '/config/config.php';
$projects = require __DIR__ . '/data/projects.php';
require_once __DIR__ . '/includes/functions.php';

$slug = isset($_GET['project']) ? trim((string) $_GET['project']) : '';
if ($slug !== '') {
    // Single-project detail via /projects.php?project=slug (kept for convenience).
    header('Location: project.php?slug=' . urlencode($slug), true, 302);
    exit;
}

$active_nav = 'projects';
$page_title = 'Projects & Products | ' . $config['name'];
$page_description = 'Products and systems built by ' . $config['name'] . ' for businesses, startups and organizations — SaaS, e-commerce, marketplaces and education technology.';
$canonical_path = 'projects.php';

require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/navbar.php';
?>

<!-- <section class="hero-one position-relative bg-black page-hero" style="background-image: url(images/personal/2.png); background-size: cover; background-position: center center;">
    <div class="container">
        <div class="row align-items-center justify-content-center py-50">
            <div class="col-lg-8 text-center py-5">
                <h1 class="text-white fw-medium">Projects &amp; Products</h1>
                <p class="text-white-50">Products and systems I’ve built for businesses, startups and organizations.</p>
            </div>
        </div>
    </div>
</section> -->
<div class="position-relative">
    <div class="shape overflow-hidden text-white">
        <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
        </svg>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <?php foreach ($projects as $project): ?>
                <?php require __DIR__ . '/includes/project-card.php'; ?>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4">
            <a href="index.php#contact" class="btn btn-outline-primary">Have a project in mind? Get in Touch</a>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
