<?php

declare(strict_types=1);

/**
 * PDO connector, built from config/app.php's db.* settings.
 *
 * Usage: require __DIR__ . '/config/database.php'; $pdo = interntrack_db();
 */

if (!function_exists('interntrack_db')) {
    function interntrack_db(): PDO
    {
        static $pdo = null;

        if ($pdo !== null) {
            return $pdo;
        }

        $config = require __DIR__ . '/app.php';
        $db = $config['db'];

        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=%s',
            $db['host'],
            $db['port'],
            $db['name'],
            $db['charset']
        );

        $pdo = new PDO($dsn, $db['user'], $db['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);

        return $pdo;
    }
}
