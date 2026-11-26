<?php

declare(strict_types=1);

/**
 * Central app configuration. Reads .env (if present) and falls back to
 * request-derived values — no hardcoded port/host (Addendum V3-C / V3-G).
 *
 * Usage: $config = require __DIR__ . '/config/app.php';
 *     or: $config = interntrack_config(); (after this file has been loaded once)
 *
 * interntrack_config() caches its result in a static variable, because
 * require_once only returns a file's `return` value on the FIRST inclusion —
 * later require_once calls to this same file return `true`, not the array.
 */

if (!function_exists('interntrack_env_load')) {
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
}

if (!function_exists('interntrack_config')) {
    function interntrack_config(): array
    {
        static $config = null;

        if ($config !== null) {
            return $config;
        }

        $env = interntrack_env_load(dirname(__DIR__) . '/.env');

        $scheme  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host    = $env['APP_HOST'] ?? ($_SERVER['HTTP_HOST'] ?? 'localhost');
        $appPort = $env['APP_PORT'] ?? null;

        // Base path of the project root (this file lives at <project_root>/config/app.php),
        // not the currently-executing script — so links stay correct from nested
        // pages like views/profile/index.php, not just root-level files.
        $projectRoot  = str_replace('\\', '/', dirname(__DIR__));
        $documentRoot = rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT'] ?? ''), '/');
        $basePath = ($documentRoot !== '' && str_starts_with($projectRoot, $documentRoot))
            ? rtrim(substr($projectRoot, strlen($documentRoot)), '/')
            : '';

        if (!empty($env['APP_URL'])) {
            $appUrl = rtrim($env['APP_URL'], '/');
        } else {
            $hostOnly = explode(':', $host)[0];
            $appUrl = $scheme . '://' . $hostOnly . ($appPort ? ':' . $appPort : '') . $basePath;
        }

        $config = [
            'app' => [
                'name'      => $env['APP_NAME'] ?? 'InternTrack',
                'env'       => $env['APP_ENV'] ?? 'local',
                'url'       => $appUrl,
                'host'      => $host,
                'port'      => $appPort,
                'base_path' => $basePath,
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

        return $config;
    }
}

return interntrack_config();
