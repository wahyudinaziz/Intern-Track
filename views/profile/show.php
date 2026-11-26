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
$pdo     = interntrack_db();

$studentId = (int) ($_GET['id'] ?? 0);

$stmt = $pdo->prepare('SELECT * FROM students WHERE id = :id');
$stmt->execute(['id' => $studentId]);
$student = $stmt->fetch();

if (!$student) {
    http_response_code(404);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Profile Not Found — <?= htmlspecialchars($appName) ?></title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="d-flex align-items-center justify-content-center" style="min-height:100vh;">
      <div class="text-center p-4">
        <h1 class="h4 fw-bold mb-2">Student profile not found</h1>
        <p class="text-muted mb-3">No profile exists with this ID.</p>
        <a class="btn btn-primary" href="<?= htmlspecialchars($appUrl) ?>/views/profile/index.php">Back to Student Profiles</a>
      </div>
    </body>
    </html>
    <?php
    exit;
}

$subjects = $pdo->prepare('SELECT subject_name FROM student_subjects WHERE student_id = :id ORDER BY id');
$subjects->execute(['id' => $studentId]);
$subjects = $subjects->fetchAll(PDO::FETCH_COLUMN);

$projects = $pdo->prepare('SELECT title, description FROM student_academic_projects WHERE student_id = :id ORDER BY id');
$projects->execute(['id' => $studentId]);
$projects = $projects->fetchAll();

$skillsStmt = $pdo->prepare('SELECT skill_type, skill_name FROM student_skills WHERE student_id = :id ORDER BY skill_type, id');
$skillsStmt->execute(['id' => $studentId]);
$skillsByType = [];
foreach ($skillsStmt->fetchAll() as $row) {
    $skillsByType[$row['skill_type']][] = $row['skill_name'];
}

$prefStmt = $pdo->prepare('SELECT preference_type, preference_value FROM student_preferences WHERE student_id = :id ORDER BY preference_type, id');
$prefStmt->execute(['id' => $studentId]);
$prefsByType = [];
foreach ($prefStmt->fetchAll() as $row) {
    $prefsByType[$row['preference_type']][] = $row['preference_value'];
}

$skillTypeLabels = [
    'technical_skill' => 'Technical Skills',
    'software_tool'   => 'Software Tools',
    'soft_skill'      => 'Soft Skills',
    'language'        => 'Languages',
];

$prefTypeLabels = [
    'industry'  => 'Preferred Industries',
    'job_role'  => 'Preferred Job Roles',
    'state'     => 'Preferred States',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($student['display_name']) ?> — <?= htmlspecialchars($appName) ?></title>
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
  .profile-hero {
    background: linear-gradient(135deg, var(--brand) 0%, var(--brand-dark) 100%);
    color: #fff;
    border-radius: 1rem;
  }
  .avatar-circle-lg {
    width: 64px; height: 64px;
    border-radius: 50%;
    background: rgba(255,255,255,.18);
    display: flex; align-items: center; justify-content: center;
    font-weight: 700;
    font-size: 1.4rem;
    flex-shrink: 0;
  }
  .info-card {
    border: 1px solid #e7e8f3;
    border-radius: 1rem;
    background: #fff;
  }
  .pill {
    background: #eef0ff;
    color: var(--brand-dark);
    font-size: .8rem;
    border-radius: 999px;
    padding: .3rem .8rem;
    display: inline-block;
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
      <a href="<?= htmlspecialchars($appUrl) ?>/views/profile/index.php" class="btn btn-sm btn-outline-secondary">Back to Student Profiles</a>
      <a href="<?= htmlspecialchars($appUrl) ?>/logout.php" class="btn btn-sm btn-outline-secondary">Log Out</a>
    </div>
  </div>
</nav>

<main class="container py-4 py-md-5">

  <div class="profile-hero p-4 p-md-5 mb-4">
    <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-3">
      <div class="avatar-circle-lg">
        <?= htmlspecialchars(mb_substr($student['display_name'], 0, 1)) ?>
      </div>
      <div>
        <h1 class="h4 fw-bold mb-1"><?= htmlspecialchars($student['display_name']) ?></h1>
        <p class="mb-0 opacity-90"><?= htmlspecialchars($student['institution_name']) ?></p>
        <p class="mb-0 opacity-75 small"><?= htmlspecialchars($student['course_name'] ?? 'Course not set') ?></p>
      </div>
    </div>
  </div>

  <div class="row g-3 g-md-4">
    <div class="col-12 col-lg-6">
      <div class="info-card p-4 h-100">
        <h2 class="h6 fw-semibold mb-3">Academic Information</h2>
        <dl class="row small mb-0">
          <dt class="col-5 text-muted">Faculty</dt><dd class="col-7"><?= htmlspecialchars($student['faculty'] ?? '-') ?></dd>
          <dt class="col-5 text-muted">Qualification</dt><dd class="col-7"><?= htmlspecialchars($student['qualification_level'] ?? '-') ?></dd>
          <dt class="col-5 text-muted">Study Year / Semester</dt><dd class="col-7">Year <?= htmlspecialchars((string) ($student['study_year'] ?? '-')) ?>, Semester <?= htmlspecialchars((string) ($student['current_semester'] ?? '-')) ?></dd>
          <dt class="col-5 text-muted">CGPA</dt><dd class="col-7"><?= $student['current_cgpa'] !== null ? htmlspecialchars((string) $student['current_cgpa']) . ' / ' . htmlspecialchars((string) $student['cgpa_scale']) : 'Not set' ?></dd>
          <dt class="col-5 text-muted">Latest Semester GPA</dt><dd class="col-7"><?= htmlspecialchars((string) ($student['latest_semester_gpa'] ?? 'Not set')) ?></dd>
          <dt class="col-5 text-muted">Expected Graduation</dt><dd class="col-7"><?= htmlspecialchars($student['expected_graduation_date'] ?? '-') ?></dd>
        </dl>
      </div>
    </div>

    <div class="col-12 col-lg-6">
      <div class="info-card p-4 h-100">
        <h2 class="h6 fw-semibold mb-3">Internship &amp; Preferences</h2>
        <dl class="row small mb-0">
          <dt class="col-5 text-muted">Availability</dt><dd class="col-7"><?= htmlspecialchars($student['internship_start_date'] ?? '-') ?> to <?= htmlspecialchars($student['internship_end_date'] ?? '-') ?></dd>
          <dt class="col-5 text-muted">Duration</dt><dd class="col-7"><?= htmlspecialchars((string) ($student['internship_duration_weeks'] ?? '-')) ?> weeks</dd>
          <dt class="col-5 text-muted">Work Mode</dt><dd class="col-7 text-capitalize"><?= htmlspecialchars($student['preferred_work_mode'] ?? 'flexible') ?></dd>
          <dt class="col-5 text-muted">Minimum Allowance</dt><dd class="col-7"><?= $student['minimum_allowance'] !== null ? 'RM ' . htmlspecialchars((string) $student['minimum_allowance']) : 'Not specified' ?></dd>
          <dt class="col-5 text-muted">Willing to Relocate</dt><dd class="col-7"><?= $student['willing_to_relocate'] ? 'Yes' : 'No' ?></dd>
          <dt class="col-5 text-muted">Transport</dt><dd class="col-7"><?= htmlspecialchars($student['transport_availability'] ?? '-') ?></dd>
          <dt class="col-5 text-muted">Preferred Company Size</dt><dd class="col-7"><?= htmlspecialchars($student['preferred_company_size'] ?? '-') ?></dd>
        </dl>
      </div>
    </div>

    <div class="col-12 col-lg-6">
      <div class="info-card p-4 h-100">
        <h2 class="h6 fw-semibold mb-3">Relevant Subjects</h2>
        <?php if (empty($subjects)): ?>
          <p class="text-muted small mb-0">No subjects recorded.</p>
        <?php else: ?>
          <ul class="small mb-0 ps-3">
            <?php foreach ($subjects as $subject): ?>
              <li><?= htmlspecialchars($subject) ?></li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
    </div>

    <div class="col-12 col-lg-6">
      <div class="info-card p-4 h-100">
        <h2 class="h6 fw-semibold mb-3">Academic Projects</h2>
        <?php if (empty($projects)): ?>
          <p class="text-muted small mb-0">No academic projects recorded.</p>
        <?php else: ?>
          <?php foreach ($projects as $project): ?>
            <div class="mb-2">
              <p class="small fw-semibold mb-0"><?= htmlspecialchars($project['title']) ?></p>
              <p class="small text-muted mb-0"><?= htmlspecialchars($project['description'] ?? '') ?></p>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>

    <div class="col-12">
      <div class="info-card p-4">
        <h2 class="h6 fw-semibold mb-3">Skills</h2>
        <?php if (empty($skillsByType)): ?>
          <p class="text-muted small mb-0">No skills recorded.</p>
        <?php else: ?>
          <?php foreach ($skillTypeLabels as $type => $label): ?>
            <?php if (!empty($skillsByType[$type])): ?>
              <p class="small text-muted mb-1"><?= htmlspecialchars($label) ?></p>
              <div class="d-flex flex-wrap gap-2 mb-3">
                <?php foreach ($skillsByType[$type] as $skill): ?>
                  <span class="pill"><?= htmlspecialchars($skill) ?></span>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>

    <div class="col-12">
      <div class="info-card p-4">
        <h2 class="h6 fw-semibold mb-3">Preferences</h2>
        <?php if (empty($prefsByType)): ?>
          <p class="text-muted small mb-0">No preferences recorded.</p>
        <?php else: ?>
          <?php foreach ($prefTypeLabels as $type => $label): ?>
            <?php if (!empty($prefsByType[$type])): ?>
              <p class="small text-muted mb-1"><?= htmlspecialchars($label) ?></p>
              <div class="d-flex flex-wrap gap-2 mb-3">
                <?php foreach ($prefsByType[$type] as $value): ?>
                  <span class="pill"><?= htmlspecialchars($value) ?></span>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>

</main>

</body>
</html>
