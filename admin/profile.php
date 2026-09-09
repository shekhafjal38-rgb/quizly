<?php
require_once __DIR__ . '/../inc/db.php';
require_once __DIR__ . '/../inc/functions.php';
require_admin();
$admin = get_user($_SESSION['admin_id']);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Profile - Quizly Admin</title>
  <link rel="stylesheet" href="assets/css/admin.css">
  <link rel="stylesheet" href="assets/css/profile.css">
</head>
<body>
  <header><h1>Profile</h1><nav><a href="dashboard.php">Back</a></nav></header>
  <main>
    <div class="profile">
      <img src="assets/img/img.jpg" alt="avatar" width="120">
      <p><strong><?php echo htmlspecialchars($admin['name']); ?></strong></p>
      <p><?php echo htmlspecialchars($admin['email']); ?></p>
      <p><?php echo htmlspecialchars($admin['phone']); ?></p>
      <a href="logout.php">Logout</a>
    </div>
  </main>
</body>
</html>
