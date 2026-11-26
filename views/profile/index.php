<?php

declare(strict_types=1);

session_start();

$config = require_once __DIR__ . '/../../config/app.php';

if (empty($_SESSION['is_authenticated'])) {
    header('Location: ' . $config['app']['base_path'] . '/login.php');
    exit;
}

require __DIR__ . '/../../config/database.php';

$appUrl  = $config['app']['url'];
$appName = $config['app']['name'];

$students = interntrack_db()
    ->query('SELECT id, display_name, institution_name, course_name, study_year, current_cgpa, cgpa_scale, preferred_work_mode FROM students ORDER BY display_name')
    ->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Profiles — <?= htmlspecialchars($appName) ?></title>
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
  .student-card {
    border: 1px solid #e7e8f3;
    border-radius: 1rem;
    background: #fff;
    transition: transform .15s ease, box-shadow .15s ease;
  }
  .student-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 .75rem 1.5rem rgba(79,70,229,.12);
  }
  .avatar-circle {
    width: 46px; height: 46px;
    border-radius: 50%;
    background: #eef0ff;
    color: var(--brand);
    display: flex; align-items: center; justify-content: center;
    font-weight: 600;
    flex-shrink: 0;
  }
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-white border-bottom">
  <div class="container d-flex flex-wrap align-items-center justify-content-between gap-2 py-2">
    <a class="navbar-brand fw-semibold mb-0" href="<?= htmlspecialchars($appUrl) ?>/">
      <strong><?= htmlspecialchars($appName) ?></strong>
    </a>
    <div class="d-flex align-items-center gap-2">
      <a href="<?= htmlspecialchars($appUrl) ?>/" class="btn btn-sm btn-outline-secondary">Back to Dashboard</a>
      <a href="<?= htmlspecialchars($appUrl) ?>/logout.php" class="btn btn-sm btn-outline-secondary">Log Out</a>
    </div>
  </div>
</nav>

<main class="container py-4 py-md-5">
  <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-end gap-2 mb-4">
    <div>
      <h1 class="h4 fw-bold mb-1">Student Profiles</h1>
      <p class="text-muted small mb-0">Demo UiTM student profiles stored in the <code>interntrack</code> database.</p>
    </div>
    <span class="text-muted small"><?= count($students) ?> profile<?= count($students) === 1 ? '' : 's' ?></span>
  </div>

  <?php if (empty($students)): ?>
  <div class="alert alert-light border">No student profiles found. Import <code>database/seed_demo.sql</code> first.</div>
  <?php else: ?>
  <div class="row g-3 g-md-4">
    <?php foreach ($students as $s): ?>
    <div class="col-12 col-sm-6 col-lg-4">
      <a class="text-decoration-none text-reset" href="<?= htmlspecialchars($appUrl) ?>/views/profile/show.php?id=<?= (int) $s['id'] ?>">
        <div class="student-card p-4 h-100">
          <div class="d-flex align-items-center gap-3 mb-3">
            <div class="avatar-circle">
              <?= htmlspecialchars(mb_substr($s['display_name'], 0, 1)) ?>
            </div>
            <div>
              <h2 class="h6 fw-semibold mb-0"><?= htmlspecialchars($s['display_name']) ?></h2>
              <p class="text-muted small mb-0"><?= htmlspecialchars($s['institution_name']) ?></p>
            </div>
          </div>
          <p class="small mb-1"><?= htmlspecialchars($s['course_name'] ?? 'Course not set') ?></p>
          <div class="d-flex flex-wrap gap-2 small text-muted">
            <span>Year <?= htmlspecialchars((string) ($s['study_year'] ?? '-')) ?></span>
            <span>&middot;</span>
            <span>CGPA <?= $s['current_cgpa'] !== null ? htmlspecialchars((string) $s['current_cgpa']) . '/' . htmlspecialchars((string) $s['cgpa_scale']) : 'Not set' ?></span>
            <span>&middot;</span>
            <span class="text-capitalize"><?= htmlspecialchars($s['preferred_work_mode'] ?? 'flexible') ?></span>
          </div>
        </div>
      </a>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</main>

</body>
</html>
