<?php

declare(strict_types=1);

session_start();

$config = require_once __DIR__ . '/config/app.php';

if (!empty($_SESSION['is_authenticated'])) {
    header('Location: ' . $config['app']['base_path'] . '/index.php');
    exit;
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submittedToken = $_POST['csrf_token'] ?? '';
    $username = trim($_POST['username'] ?? '');
    $password = (string) ($_POST['password'] ?? '');

    if (!hash_equals($_SESSION['csrf_token'], $submittedToken)) {
        $error = 'Your session expired. Please try again.';
    } elseif ($username === '' || $password === '') {
        $error = 'Please enter both username and password.';
    } elseif (
        hash_equals($config['auth']['admin_username'], $username)
        && hash_equals($config['auth']['admin_password'], $password)
    ) {
        session_regenerate_id(true);
        $_SESSION['is_authenticated'] = true;
        $_SESSION['username'] = $username;
        header('Location: ' . $config['app']['base_path'] . '/index.php');
        exit;
    } else {
        $error = 'Incorrect username or password.';
    }
}

$appName = $config['app']['name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Log In — <?= htmlspecialchars($appName) ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  :root {
    --brand: #4f46e5;
    --brand-dark: #3730a3;
    --bg-soft: #f6f7fb;
  }
  body {
    background: linear-gradient(135deg, var(--brand) 0%, var(--brand-dark) 100%);
    font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1.5rem;
  }
  .login-card {
    width: 100%;
    max-width: 380px;
    background: #fff;
    border-radius: 1rem;
    padding: 2rem 1.75rem;
    box-shadow: 0 1rem 2.5rem rgba(0,0,0,.25);
  }
  .brand-mark {
    width: 48px; height: 48px;
    border-radius: .85rem;
    background: #eef0ff;
    color: var(--brand);
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 1rem;
  }
  .btn-brand {
    background: var(--brand);
    border-color: var(--brand);
  }
  .btn-brand:hover {
    background: var(--brand-dark);
    border-color: var(--brand-dark);
  }
</style>
</head>
<body>

<div class="login-card">
  <div class="brand-mark">
    <i data-lucide="graduation-cap"></i>
  </div>
  <h1 class="h4 fw-bold mb-1"><?= htmlspecialchars($appName) ?></h1>
  <p class="text-muted small mb-4">Sign in to continue to the admin/demo dashboard.</p>

  <?php if ($error !== ''): ?>
  <div class="alert alert-danger py-2 small" role="alert"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="post" action="" novalidate>
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
    <div class="mb-3">
      <label for="username" class="form-label small fw-semibold">Username</label>
      <input type="text" class="form-control" id="username" name="username" autocomplete="username" required autofocus>
    </div>
    <div class="mb-4">
      <label for="password" class="form-label small fw-semibold">Password</label>
      <input type="password" class="form-control" id="password" name="password" autocomplete="current-password" required>
    </div>
    <button type="submit" class="btn btn-brand w-100 text-white fw-semibold">Log In</button>
  </form>

  <p class="text-muted small mt-4 mb-0 text-center">
    Demo / admin access only — see <code>.env.example</code> for credentials setup.
  </p>
</div>

<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
<script>lucide.createIcons();</script>
</body>
</html>
