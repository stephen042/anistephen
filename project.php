<?php
// Reusable project detail. URL: /project.php?slug=bestschoolpage (same structure for every project).
// Also reachable via /projects.php?project=<slug> (redirects here).
$config = require __DIR__ . '/config/config.php';
$projects = require __DIR__ . '/data/projects.php';
require_once __DIR__ . '/includes/functions.php';

$slug = trim((string) ($_GET['slug'] ?? ''));
$project = $slug !== '' ? find_project($projects, $slug) : null;

$active_nav = 'projects';

if ($project === null) {
    http_response_code(404);
    $page_title = 'Project not found | ' . $config['name'];
    $page_description = 'The requested project could not be found.';
    $canonical_path = 'projects.php';
    require __DIR__ . '/includes/header.php';
    require __DIR__ . '/includes/navbar.php';
    ?>
    <section class="section" style="padding-top: 140px;">
        <div class="container text-center">
            <h1 class="fs-2 text-dark">Project not found</h1>
            <p class="text-muted mb-4">The project you’re looking for doesn’t exist or was moved.</p>
            <a href="projects.php" class="btn btn-primary">Back to Projects</a>
        </div>
    </section>
    <?php require __DIR__ . '/includes/footer.php'; ?>
    <?php exit; ?>
<?php
}

$page_title = $project['title'] . ' | ' . $config['name'];
$page_description = project_summary($project);
$canonical_path = 'project.php?slug=' . $project['slug'];
$slider_id = 'project-slider';

require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/navbar.php';
?>

<section class="section project-detail" style="padding-top: 120px;">
    <div class="container detail-wrap">
        <a href="projects.php" class="btn btn-sm btn-outline-primary mb-3">&larr; All Projects</a>

        <!-- 1–2. Title, category, status, short summary -->
        <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
            <p class="text-muted mb-0 fs-13 text-uppercase"><?= e($project['category'] ?? '') ?></p>
            <?php if (!empty($project['status'])): ?>
                <span class="status-badge"><?= e($project['status']) ?></span>
            <?php endif; ?>
        </div>
        <h1 class="fs-2 fw-medium text-dark mb-2"><?= e($project['title']) ?></h1>
        <p class="text-gray-700 fs-18 mb-4"><?= e(project_summary($project)) ?></p>

        <!-- 3. Screenshot slider -->
        <?php require __DIR__ . '/includes/slider.php'; ?>
        <p class="text-muted fs-13 mt-2">Screenshots are placeholders until real product captures are added — add files to <code>images/projects/<?= e($project['slug']) ?>/</code> and list them in <code>data/projects.php</code>.</p>

        <!-- 4. Live project -->
        <div class="d-flex gap-2 flex-wrap my-4">
            <a href="<?= e($project['live_url']) ?>" target="_blank" rel="noopener" class="btn btn-primary">Visit Live Project</a>
            <a href="index.php#contact" class="btn btn-outline-primary">Discuss a Similar Project</a>
        </div>

        <div class="row">
            <div class="col-lg-7">
                <!-- 5. About the product -->
                <h2 class="fs-22 fw-medium text-dark mt-2 mb-2">About the product</h2>
                <p class="text-muted"><?= e(project_body($project)) ?></p>

                <?php if (!empty($project['business_context'])): ?>
                    <h2 class="fs-22 fw-medium text-dark mt-4 mb-2">The business problem</h2>
                    <p class="text-muted"><?= e($project['business_context']) ?></p>
                <?php endif; ?>

                <!-- 6. What I built -->
                <?php if (!empty($project['what_built'])): ?>
                    <h2 class="fs-22 fw-medium text-dark mt-4 mb-2">What I built</h2>
                    <ul class="text-muted">
                        <?php foreach ($project['what_built'] as $item): ?>
                            <li><?= e($item) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
            <div class="col-lg-5">
                <!-- 7–8. Technology + status -->
                <div class="card rounded shadow-sm border-0">
                    <div class="card-body p-4">
                        <h5 class="fw-medium text-dark mb-2">Technology</h5>
                        <div class="mb-3">
                            <?php foreach ($project['technologies'] as $tech): ?>
                                <span class="badge badge-lg rounded bg-soft-alt-info fw-normal fs-12 text-uppercase me-1 mb-1"><?= e($tech) ?></span>
                            <?php endforeach; ?>
                        </div>
                        <?php if (!empty($project['status'])): ?>
                            <hr class="hr-dashed" />
                            <p class="mb-0"><span class="fw-medium text-dark">Status:</span> <span class="status-badge"><?= e($project['status']) ?></span></p>
                        <?php endif; ?>
                        <a href="<?= e($project['live_url']) ?>" target="_blank" rel="noopener" class="btn btn-primary w-100 mt-3">Visit Live Project</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
