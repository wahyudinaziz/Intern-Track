<?php

declare(strict_types=1);

/**
 * Central app configuration. Reads .env (if present) and falls back to
 * request-derived values — no hardcoded port/host (Addendum V3-C / V3-G).
 *
 * Usage: $config = require __DIR__ . '/config/app.php';
 */

function interntrack_env_load(string $path): array
{
    if (!is_file($path)) {
        return [];
    }
    $values = [];
    foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
            continue;
        }
        [$key, $value] = explode('=', $line, 2);
        $values[trim($key)] = trim($value, " \t\"'");
    }
    return $values;
}

$env = interntrack_env_load(dirname(__DIR__) . '/.env');

$scheme   = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host     = $env['APP_HOST'] ?? ($_SERVER['HTTP_HOST'] ?? 'localhost');
$appPort  = $env['APP_PORT'] ?? null;
$basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/')), '/');

if (!empty($env['APP_URL'])) {
    $appUrl = rtrim($env['APP_URL'], '/');
} else {
    $hostOnly = explode(':', $host)[0];
    $appUrl = $scheme . '://' . $hostOnly . ($appPort ? ':' . $appPort : '') . $basePath;
}

return [
    'app' => [
        'name'       => $env['APP_NAME'] ?? 'InternTrack',
        'env'        => $env['APP_ENV'] ?? 'local',
        'url'        => $appUrl,
        'host'       => $host,
        'port'       => $appPort,
        'base_path'  => $basePath,
    ],
    'db' => [
        'host'    => $env['DB_HOST'] ?? '127.0.0.1',
        'port'    => $env['DB_PORT'] ?? '3306',
        'name'    => $env['DB_NAME'] ?? 'interntrack',
        'user'    => $env['DB_USER'] ?? 'root',
        'pass'    => $env['DB_PASS'] ?? '',
        'charset' => $env['DB_CHARSET'] ?? 'utf8mb4',
    ],
    'ai' => [
        'anthropic_api_key' => $env['ANTHROPIC_API_KEY'] ?? '',
        'enabled'           => filter_var($env['AI_FEATURE_ENABLED'] ?? true, FILTER_VALIDATE_BOOLEAN),
    ],
    'academic' => [
        'cgpa_scale_default' => (float) ($env['CGPA_SCALE_DEFAULT'] ?? 4.00),
    ],
    'auth' => [
        'admin_username' => $env['ADMIN_USERNAME'] ?? 'admin',
        'admin_password' => $env['ADMIN_PASSWORD'] ?? 'admin',
    ],
];
