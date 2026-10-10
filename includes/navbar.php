<?php
// Top navigation. Only: Home, Projects, Get in Touch. Expects $active_nav ('home'|'projects').
$active_nav = $active_nav ?? 'home';
$is_home = ($active_nav === 'home');
$contact_href = $is_home ? '#contact' : 'index.php#contact';
?>
<nav class="navbar navbar-expand-lg fixed-top sticky" id="navbar">
    <div class="container">
        <a href="index.php" class="navbar-brand brand-text">A.M<span class="brand-dot">.</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggle-icon"><i data-feather="menu"></i></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto navbar-center mt-lg-0 mt-2">
                <li class="nav-item">
                    <a class="nav-link <?= $active_nav === 'home' ? 'active' : '' ?>" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $active_nav === 'projects' ? 'active' : '' ?>" href="projects.php">Projects</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= e($contact_href) ?>">Get in Touch</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="assets/files/Ani_Makuochukwu_Stephen_CV.pdf" download>Download CV</a>
                </li>
            </ul>
            <a href="<?= e($contact_href) ?>" class="btn btn-sm nav-btn text-primary mb-4 mb-lg-0">Hire Me! <i class="icon-xxs ms-1" data-feather="chevrons-right"></i></a>
        </div>
    </div>
</nav>
