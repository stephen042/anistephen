<?php
// Reusable responsive screenshot slider (Bootstrap 5 carousel — touch swipe built in).
// Expects: $project array, and $slider_id string (unique per page).
$slider_images = project_images($project);
$slider_id = $slider_id ?? ('slider-' . preg_replace('/[^a-z0-9-]/', '', (string) ($project['slug'] ?? 'project')));
?>
<?php if (!empty($slider_images)): ?>
<div id="<?= e($slider_id) ?>" class="carousel slide project-slider" data-bs-ride="false" data-bs-touch="true" data-bs-interval="false">
    <?php if (count($slider_images) > 1): ?>
    <div class="carousel-indicators">
        <?php foreach ($slider_images as $i => $img): ?>
            <button type="button" data-bs-target="#<?= e($slider_id) ?>" data-bs-slide-to="<?= (int) $i ?>" <?= $i === 0 ? 'class="active" aria-current="true"' : '' ?> aria-label="Screenshot <?= (int) $i + 1 ?>"></button>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <div class="carousel-inner rounded shadow-sm">
        <?php foreach ($slider_images as $i => $img): ?>
            <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                <img src="<?= e($img) ?>" class="d-block w-100 project-slide-img" alt="<?= e($project['title']) ?> — screenshot <?= (int) $i + 1 ?>" loading="<?= $i === 0 ? 'eager' : 'lazy' ?>" />
            </div>
        <?php endforeach; ?>
    </div>
    <?php if (count($slider_images) > 1): ?>
    <button class="carousel-control-prev" type="button" data-bs-target="#<?= e($slider_id) ?>" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#<?= e($slider_id) ?>" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
    <?php endif; ?>
</div>
<?php endif; ?>
