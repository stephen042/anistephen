<?php
// Reusable project card. Expects $project array.
// Optional: $card_class (grid column classes). Defaults to 3-per-row desktop.
$card_class = $card_class ?? 'col-lg-4 col-md-6';
$card_cover = project_cover($project);
$card_summary = project_summary($project);
?>
<div class="<?= e($card_class) ?> mb-4">
    <div class="card rounded shadow border-0 h-100 project-card">
        <?php if ($card_cover !== ''): ?>
        <a href="project.php?slug=<?= e($project['slug']) ?>" class="project-thumb-link">
            <img src="<?= e($card_cover) ?>" alt="<?= e($project['title']) ?> screenshot" class="img-fluid rounded-top project-thumb" loading="lazy" />
        </a>
        <?php endif; ?>
        <div class="card-body p-4 d-flex flex-column">
            <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                <p class="text-muted mb-0 fs-13 text-uppercase"><?= e($project['category'] ?? '') ?></p>
                <?php if (!empty($project['status'])): ?>
                    <span class="status-badge"><?= e($project['status']) ?></span>
                <?php endif; ?>
            </div>
            <h5 class="text-dark fs-20 fw-medium mb-2">
                <a href="project.php?slug=<?= e($project['slug']) ?>" class="text-dark"><?= e($project['title']) ?></a>
            </h5>
            <p class="text-muted mb-3"><?= e($card_summary) ?></p>
            <div class="mb-3">
                <?php foreach (array_slice($project['technologies'], 0, 4) as $tech): ?>
                    <span class="badge badge-lg rounded bg-soft-alt-info fw-normal fs-12 text-uppercase me-1 mb-1"><?= e($tech) ?></span>
                <?php endforeach; ?>
            </div>
            <div class="d-flex gap-2 flex-wrap mt-auto">
                <a href="project.php?slug=<?= e($project['slug']) ?>" class="btn btn-sm btn-primary">View Project &rarr;</a>
                <a href="<?= e($project['live_url']) ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline-primary">Live Website</a>
            </div>
        </div>
    </div>
</div>
