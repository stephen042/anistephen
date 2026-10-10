<?php
// Shared helpers. No framework, plain PHP.

if (!function_exists('e')) {
function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
}

if (!function_exists('find_project')) {
/** Find a project by slug, or null. */
function find_project(array $projects, string $slug): ?array
{
    foreach ($projects as $project) {
        if (($project['slug'] ?? '') === $slug) {
            return $project;
        }
    }
    return null;
}
}

if (!function_exists('canonical_url')) {
/** Build the canonical URL for a path, or empty string if site_url is unset. */
function canonical_url(array $config, string $path = ''): string
{
    $base = rtrim($config['site_url'] ?? '', '/');
    if ($base === '') {
        return '';
    }
    return $base . '/' . ltrim($path, '/');
}
}

if (!function_exists('has_header_injection')) {
/** Detect header-injection attempts (CR/LF in a header field). */
function has_header_injection(string $value): bool
{
    return preg_match("/[\r\n]/", $value) === 1;
}
}

if (!function_exists('project_images')) {
/** Screenshot list for a project. Supports 'images' (new) and 'image' (legacy) keys. */
function project_images(array $project): array
{
    if (!empty($project['images']) && is_array($project['images'])) {
        return array_values($project['images']);
    }
    if (!empty($project['image'])) {
        return [(string) $project['image']];
    }
    return [];
}
}

if (!function_exists('project_cover')) {
/** First screenshot, or empty string when a project has no images yet. */
function project_cover(array $project): string
{
    $images = project_images($project);
    return $images[0] ?? '';
}
}

if (!function_exists('project_summary')) {
/** Short description, falling back to the legacy 'description' key. */
function project_summary(array $project): string
{
    return (string) ($project['short_description'] ?? $project['description'] ?? '');
}
}

if (!function_exists('project_body')) {
/** Full description, falling back to the legacy 'long_description' key. */
function project_body(array $project): string
{
    return (string) ($project['full_description'] ?? $project['long_description'] ?? project_summary($project));
}
}
