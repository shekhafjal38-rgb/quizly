<?php
require_once __DIR__ . '/../inc/db.php';
require_once __DIR__ . '/../inc/functions.php';
require_admin();
$db = db();
$res = $db->query('SELECT f.*,u.name,u.email FROM feedbacks f LEFT JOIN users u ON f.user_id=u.id ORDER BY f.created_at DESC');
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Feedbacks - Quizly Admin</title>
  <link rel="stylesheet" href="assets/css/admin.css">
  <link rel="stylesheet" href="assets/css/feedbacks.css">
</head>
<body>
  <header><h1>Feedbacks</h1><nav><a href="dashboard.php">Back</a></nav></header>
  <main>
    <table>
      <tr><th>ID</th><th>User</th><th>Email</th><th>Message</th><th>Date</th></tr>
      <?php while($f=$res->fetch_assoc()){ ?>
      <tr>
        <td><?php echo $f['id']; ?></td>
        <td><?php echo htmlspecialchars($f['name']?:'Guest'); ?></td>
        <td><?php echo htmlspecialchars($f['email']); ?></td>
        <td><?php echo nl2br(htmlspecialchars($f['message'])); ?></td>
        <td><?php echo $f['created_at']; ?></td>
      </tr>
      <?php } ?>
    </table>
  </main>
</body>
</html>
