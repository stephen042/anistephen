<?php
// Page head + opening body tag. Expects: $config, $page_title, $page_description, $canonical_path, $active_nav
$page_title = $page_title ?? ($config['site_title'] ?? 'Stephen Williams | PHP & Laravel Developer');
$page_description = $page_description ?? ($config['description'] ?? '');
$canonical = canonical_url($config, $canonical_path ?? '');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?= e($page_title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="<?= e($page_description) ?>" />
    <meta name="author" content="Stephen Williams" />
    <?php if ($canonical !== ''): ?>
    <link rel="canonical" href="<?= e($canonical) ?>" />
    <?php endif; ?>
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?= e($page_title) ?>" />
    <meta property="og:description" content="<?= e($page_description) ?>" />
    <?php if ($canonical !== ''): ?>
    <meta property="og:url" content="<?= e($canonical) ?>" />
    <?php endif; ?>

    <link rel="shortcut icon" href="images/favicon.ico" />

    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="css/style.min.css" rel="stylesheet" type="text/css" />
    <link href="css/colors/default.css" rel="stylesheet" type="text/css" id="color-opt" />
    <link href="css/custom.css" rel="stylesheet" type="text/css" />
</head>
<body>
