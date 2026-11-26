<?php
declare(strict_types=1);

/**
 * InternTrack — Entry Point (Project Shell)
 * Config (incl. .env, anti-hardcode port/URL per Addendum V3-C) lives in config/app.php.
 */

session_start();

$config = require __DIR__ . '/config/app.php';

if (empty($_SESSION['is_authenticated'])) {
    header('Location: ' . $config['app']['base_path'] . '/login.php');
    exit;
}

$appUrl     = $config['app']['url'];
$appName    = $config['app']['name'];
$appEnv     = $config['app']['env'];
$appVersion = 'v0.1.0 — Project Shell';

$modules = [
    ['icon' => 'user-round',       'title' => 'Student Profile',       'desc' => 'Academic profile, skills & preferences with photo upload.'],
    ['icon' => 'layout-dashboard', 'title' => 'Dashboard',             'desc' => 'KPIs & Chart.js visualisations from live MySQL data.'],
    ['icon' => 'building-2',       'title' => 'Company Directory',     'desc' => 'Malaysian companies listed by industry and location.'],
    ['icon' => 'search',           'title' => 'Internship Discovery',  'desc' => 'Explore internship opportunities with honestly labelled data sources.'],
    ['icon' => 'sparkles',         'title' => 'AI Match Results',      'desc' => 'Deterministic 100-point scoring plus Claude API reasoning.'],
    ['icon' => 'kanban',           'title' => 'My Applications',       'desc' => 'Track applications from saved through to offer or rejection.'],
    ['icon' => 'calendar-clock',   'title' => 'Calendar / Reminders',  'desc' => 'Plan interview dates and important deadlines.'],
    ['icon' => 'file-text',        'title' => 'Resume / CV Builder',   'desc' => 'Auto-populated from your profile, with PDF export.'],
    ['icon' => 'settings',         'title' => 'Settings / Data',       'desc' => 'Export/import JSON, toggle AI, reset demo data.'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($appName) ?> — AI-Powered Malaysia Internship Discovery</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  :root {
    --brand: #4f46e5;
    --brand-dark: #3730a3;
    --bg-soft: #f6f7fb;
  }
  body {
    background: var(--bg-soft);
    font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
  }
  .navbar-brand strong { color: var(--brand); }
  .hero {
    background: linear-gradient(135deg, var(--brand) 0%, var(--brand-dark) 100%);
    color: #fff;
    border-radius: 0 0 1.25rem 1.25rem;
  }
  .hero h1 {
    font-size: 1.6rem;
  }
  @media (min-width: 576px) {
    .hero h1 { font-size: 2.1rem; }
  }
  @media (min-width: 768px) {
    .hero { border-radius: 0 0 2rem 2rem; }
    .hero h1 { font-size: 2.75rem; }
  }
  .badge-status {
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.35);
  }
  .module-card {
    border: 1px solid #e7e8f3;
    border-radius: 1rem;
    transition: transform .15s ease, box-shadow .15s ease;
    background: #fff;
  }
  .module-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 .75rem 1.5rem rgba(79,70,229,.12);
  }
  .module-icon {
    width: 44px; height: 44px;
    border-radius: .75rem;
    background: #eef0ff;
    color: var(--brand);
    display: flex; align-items: center; justify-content: center;
  }
  .tech-pill {
    background: #eef0ff;
    color: var(--brand-dark);
    font-size: .8rem;
    border-radius: 999px;
    padding: .3rem .8rem;
  }
  footer { color: #6b7280; }
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-white border-bottom">
  <div class="container d-flex flex-wrap align-items-center justify-content-between gap-2 py-2">
    <a class="navbar-brand fw-semibold mb-0" href="<?= htmlspecialchars($appUrl) ?>/">
      <strong><?= htmlspecialchars($appName) ?></strong>
    </a>
    <div class="d-flex align-items-center gap-2">
      <span class="badge rounded-pill text-bg-light border"><?= htmlspecialchars($appVersion) ?></span>
      <span class="text-muted small d-none d-sm-inline">Signed in as <strong><?= htmlspecialchars($_SESSION['username'] ?? '') ?></strong></span>
      <a href="<?= htmlspecialchars($appUrl) ?>/logout.php" class="btn btn-sm btn-outline-secondary">Log Out</a>
    </div>
  </div>
</nav>

<header class="hero py-4 py-md-5 mb-4 mb-md-5">
  <div class="container py-3 py-md-4">
    <span class="badge badge-status rounded-pill px-3 py-2 mb-3">Localhost Web App · Open Source Learning Project</span>
    <h1 class="fw-bold mb-3">AI-Powered Malaysia Internship Discovery<br>&amp; Student Matching</h1>
    <p class="lead col-12 col-lg-8 mb-4">
      InternTrack helps university students build an academic profile, discover Malaysian
      companies and internship opportunities, understand why an AI match is strong or weak,
      and track applications from saved through to offer — with honestly labelled data, never
      fabricated.
    </p>
    <div class="d-flex gap-2 flex-wrap">
      <span class="tech-pill bg-white">PHP 8+ Native</span>
      <span class="tech-pill bg-white">MySQL / MariaDB</span>
      <span class="tech-pill bg-white">Bootstrap 5.3.3</span>
      <span class="tech-pill bg-white">Chart.js</span>
      <span class="tech-pill bg-white">Claude API</span>
    </div>
  </div>
</header>

<main class="container pb-5">
  <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-end gap-2 mb-4">
    <h2 class="h5 h4-md fw-semibold mb-0">Core Application Modules</h2>
    <span class="text-muted small">10 modules per the v3 build specification</span>
  </div>

  <div class="row g-3 g-md-4">
    <?php foreach ($modules as $m): ?>
    <div class="col-12 col-sm-6 col-lg-4">
      <div class="module-card p-4 h-100">
        <div class="module-icon mb-3">
          <i data-lucide="<?= htmlspecialchars($m['icon']) ?>"></i>
        </div>
        <h3 class="h6 fw-semibold mb-1"><?= htmlspecialchars($m['title']) ?></h3>
        <p class="text-muted small mb-0"><?= htmlspecialchars($m['desc']) ?></p>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <div class="alert alert-light border mt-4 mt-md-5 d-flex align-items-start gap-3">
    <i data-lucide="info" class="text-primary flex-shrink-0 mt-1"></i>
    <div>
      <strong>Current status:</strong> Project shell only — the folder structure, <code>.env</code>
      config, database schema and the modules above are still under development
      (<?= htmlspecialchars($appVersion) ?>). This page confirms the base URL
      (<code><?= htmlspecialchars($appUrl) ?></code>) resolves correctly with no hardcoded port or
      host — values are read from <code>.env</code> or derived automatically from the current
      request (environment: <code><?= htmlspecialchars($appEnv) ?></code>).
    </div>
  </div>
</main>

<footer class="container text-center small py-4 border-top">
  &copy; <?= date('Y') ?> <?= htmlspecialchars($appName) ?> — Open Source Learning Project (MIT License, coming soon)
</footer>

<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
<script>lucide.createIcons();</script>
</body>
</html>
