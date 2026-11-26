<?php

declare(strict_types=1);

session_start();

$config = require __DIR__ . '/config/app.php';

$_SESSION = [];
session_destroy();

header('Location: ' . $config['app']['base_path'] . '/login.php');
exit;
