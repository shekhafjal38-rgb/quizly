<?php
require_once __DIR__ . '/../inc/db.php';
require_once __DIR__ . '/../inc/functions.php';
require_admin();

$db = db();
$users_count = $db->query('SELECT COUNT(*) AS c FROM users WHERE role="user"')->fetch_assoc()['c'];
$tests_count = $db->query('SELECT COUNT(*) AS c FROM tests')->fetch_assoc()['c'];
$results_count = $db->query('SELECT COUNT(*) AS c FROM results')->fetch_assoc()['c'];
$feedbacks_count = $db->query('SELECT COUNT(*) AS c FROM feedbacks')->fetch_assoc()['c'];

?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Dashboard - Quizly Admin</title>
  <link rel="stylesheet" href="assets/css/admin.css">
  <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>
  <header>
    <h1>Quizly Admin</h1>
    <nav>
      <a href="dashboard.php">Dashboard</a>
      <a href="create_test.php">Create Test</a>
      <a href="tests_list.php">Tests</a>
      <a href="users.php">Users</a>
      <a href="results.php">Results</a>
      <a href="profile.php">Profile</a>
      <a href="logout.php">Logout</a>
    </nav>
  </header>
  <main>
    <div class="cards">
      <div class="card">Users<br><strong><?php echo $users_count; ?></strong></div>
      <div class="card">Tests<br><strong><?php echo $tests_count; ?></strong></div>
      <div class="card">Results<br><strong><?php echo $results_count; ?></strong></div>
      <div class="card">Feedbacks<br><strong><?php echo $feedbacks_count; ?></strong></div>
    </div>
  </main>
</body>
</html>
