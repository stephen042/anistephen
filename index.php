<?php
// Session is used only for the contact form CSRF token (see includes/contact-form.php).
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$config = require __DIR__ . '/config/config.php';
$projects = require __DIR__ . '/data/projects.php';
$profile = require __DIR__ . '/data/profile.php';
require_once __DIR__ . '/includes/functions.php';

$active_nav = 'home';
$page_title = $config['site_title'];
$page_description = $config['description'];
$canonical_path = 'index.php';

$featured = array_values(array_filter($projects, fn($p) => !empty($p['featured'])));
$featured = array_slice($featured, 0, 4);
$card_class = 'col-lg-6 col-md-6';

require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/navbar.php';
?>

<!-- 1. HERO -->
<!-- NOTE: images/personal/2.png is the Selfown template's stock photo (placeholder).
     Replace it with your own portrait (same filename) before publishing. -->
<section class="hero-one position-relative main-bg" id="home" style="background-image: url(images/personal/main-bg.png); background-size: cover; background-position: center center;">
    <div class="container">
        <div class="row align-items-center justify-content-center hero-row">
            <div class="col-lg-6 text-center hero-text">
                <h5 class="d-inline-block py-1 px-3 rounded text-muted font-secondary">Hi, I'm <?= e($config['name']) ?></h5>
                <h1 class="hero-title mb-3 font-secondary"><?= e($config['hero_heading']) ?></h1>
                <p class="text-muted fs-18 mb-4 hero-sub"><?= e($config['hero_supporting']) ?></p>
                <div class="d-flex gap-2 justify-content-center flex-wrap hero-buttons">
                    <a href="projects.php" class="btn btn-primary">View My Work</a>
                    <a href="#contact" class="btn btn-outline-primary">Get In Touch</a>
                </div>
            </div>
            <div class="col-lg-6 text-center hero-media">
                <div class="hero-photo-card">
                    <img src="images/personal/2.png" alt="<?= e($config['name']) ?>" class="img-fluid hero-portrait" />
                </div>
            </div>
        </div>
    </div>
</section>
<div class="position-relative">
    <div class="shape overflow-hidden text-white">
        <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
        </svg>
    </div>
</div>

<!-- 2. SHORT PERSONAL INTRODUCTION -->
<section class="section" id="about">
    <div class="container narrow-wrap">
        <div class="text-center">
            <span class="badge badge-lg rounded bg-soft-alt-success fw-normal fs-13 text-uppercase">About</span>
            <h2 class="fs-2 fw-medium lh-1 text-dark my-3"><?= e($profile['about']['heading']) ?></h2>
        </div>
        <?php foreach ($profile['about']['paragraphs'] as $para): ?>
            <p class="text-muted fs-18 text-center"><?= e($para) ?></p>
        <?php endforeach; ?>
        <div class="social mt-3 text-center">
            <a href="<?= e($config['github']) ?>" target="_blank" rel="noopener" aria-label="GitHub">
                <i class="lab la-github github me-1"></i>
            </a>
        </div>
    </div>
</section>

<!-- 3. I BUILD MORE THAN WEBSITES -->
<section class="section pt-0" id="capabilities">
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-12 col-md-10 col-lg-7 text-center">
                <span class="badge badge-lg rounded bg-soft-alt-success fw-normal fs-13 text-uppercase">Capabilities</span>
                <h2 class="fs-2 fw-medium lh-1 text-dark my-3"><?= e($profile['capabilities']['heading']) ?></h2>
                <p class="text-gray-700 fs-18 mb-4 lh-lg"><?= e($profile['capabilities']['intro']) ?></p>
            </div>
        </div>
        <div class="row">
            <?php foreach ($profile['capabilities']['items'] as $cap): ?>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card rounded shadow border-0 h-100">
                        <div class="card-body p-4">
                            <h5 class="text-dark fs-18 fw-medium mb-2"><?= e($cap['title']) ?></h5>
                            <p class="text-muted mb-0"><?= e($cap['text']) ?></p>
                        </div>
                    </div>
                </div>
        <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- 4–5. FEATURED PRODUCTS -->
<section class="section bg-gradient-light-white" id="featured-products">
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-12 col-md-10 col-lg-7 text-center">
                <span class="badge badge-lg rounded bg-soft-alt-success fw-normal fs-13 text-uppercase">Selected Work</span>
                <h2 class="fs-2 fw-medium lh-1 text-dark my-3">Software I've Built</h2>
                <p class="text-gray-700 fs-18 mb-4 lh-lg">Real software products and systems developed for businesses, organizations and real-world use cases.</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <?php foreach ($featured as $project): ?>
                <?php require __DIR__ . '/includes/project-card.php'; ?>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-3">
            <a href="projects.php" class="btn btn-primary">View All Projects &rarr;</a>
        </div>
    </div>
</section>

<!-- 6. SOFTWARE / PRODUCT EXPERIENCE -->
<section class="section" id="experience">
    <div class="container narrow-wrap">
        <div class="row justify-content-center mb-4">
            <div class="col-12 col-md-10 col-lg-8 text-center">
                <span class="badge badge-lg rounded bg-soft-alt-success fw-normal fs-13 text-uppercase">Experience</span>
                <h2 class="fs-2 fw-medium lh-1 text-dark my-3">Experience Building Real Products</h2>
                <p class="text-gray-700 fs-18 mb-4 lh-lg"><?= e($profile['product_experience']['intro']) ?></p>
            </div>
        </div>
        <?php foreach ($profile['product_experience']['items'] as $item): ?>
            <div class="card rounded bg-white border shadow-sm mb-3">
                <div class="card-body p-4">
                    <div class="d-flex flex-wrap justify-content-between align-items-baseline gap-2">
                        <h5 class="text-dark fs-18 fw-medium mb-1"><?= e($item['title']) ?></h5>
                        <?php if (!empty($item['status'])): ?><span class="status-badge"><?= e($item['status']) ?></span><?php endif; ?>
                    </div>
                    <p class="fw-medium text-muted mb-2"><?= e($item['subtitle']) ?></p>
                    <p class="text-muted mb-2"><?= e($item['text']) ?></p>
                    <?php if (!empty($item['slug'])): ?>
                        <a href="project.php?slug=<?= e($item['slug']) ?>" class="fs-14">View product details &rarr;</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="text-center mt-4">
            <a href="assets/files/Ani_Makuochukwu_Stephen_CV.pdf" class="btn btn-outline-primary" download>Download CV</a>
        </div>
    </div>
</section>

<!-- 7. TECHNICAL STACK -->
<section class="section pt-0" id="stack">
    <div class="container narrow-wrap">
        <div class="row justify-content-center mb-4">
            <div class="col-12 col-md-10 col-lg-7 text-center">
                <span class="badge badge-lg rounded bg-soft-alt-success fw-normal fs-13 text-uppercase">Stack</span>
                <h2 class="fs-2 fw-medium lh-1 text-dark my-3">Technical Experience</h2>
            </div>
        </div>
        <?php foreach ($profile['tech_groups'] as $group): ?>
            <div class="tech-group">
                <h5 class="tech-group-title"><?= e($group['title']) ?></h5>
                <div class="d-flex flex-wrap gap-2">
                    <?php foreach ($group['items'] as $tech): ?>
                        <span class="skill-pill <?= in_array($tech, ['PHP', 'Laravel'], true) ? 'skill-primary' : '' ?>"><?= e($tech) ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- 8. EDUCATION -->
<section class="section pt-0" id="education">
    <div class="container narrow-wrap">
        <h3 class="fs-22 fw-medium text-dark mb-3">Education</h3>
        <?php foreach ($profile['education'] as $edu): ?>
            <div class="card rounded bg-light border-0 mb-3">
                <div class="card-body">
                    <h5 class="text-dark fs-18 fw-medium mb-1"><?= e($edu['title']) ?></h5>
                    <p class="text-muted mb-0"><?= e($edu['school']) ?><?= $edu['date'] !== '' ? ' — ' . e($edu['date']) : '' ?></p>
                    <?php if (!empty($edu['description'])): ?><p class="text-muted mb-0"><?= e($edu['description']) ?></p><?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- 9. CONTACT -->
<section class="section bg-light" id="contact">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card bg-white" style="background: url(images/personal/testi-pet.png); background-repeat: no-repeat; background-size: 15%; background-position: right bottom;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h2 class="fs-2 fw-normal lh-1 text-dark mb-3">Have a project in mind?</h2>
                                <p class="text-gray-700 fs-18 mb-4">Let's talk about what you're building.</p>
                                <?php require __DIR__ . '/includes/contact-form.php'; ?>
                            </div>
                            <div class="col-md-4 contact-side">
                                <img src="images/personal/contact.svg" alt="Contact" height="200" class="mx-auto d-block mb-5" />
                                <div class="d-flex">
                                    <div class="bg-light d-flex justify-content-center align-items-center thumb-lg rounded">
                                        <i class="ti ti-mail fs-22"></i>
                                    </div>
                                    <div class="align-self-center ms-3">
                                        <span class="d-block lh-1">Email</span>
                                        <span class="text-muted fs-14 mt-n2">Via the form — replies from my inbox</span>
                                    </div>
                                </div>
                                <hr class="hr-dashed my-3" />
                                <div class="d-flex">
                                    <div class="bg-light d-flex justify-content-center align-items-center thumb-lg rounded">
                                        <i class="ti ti-brand-github fs-22"></i>
                                    </div>
                                    <div class="align-self-center ms-3">
                                        <span class="d-block lh-1">GitHub</span>
                                        <a class="text-muted fs-14 mt-n2" href="<?= e($config['github']) ?>" target="_blank" rel="noopener">github.com/stephen042</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
