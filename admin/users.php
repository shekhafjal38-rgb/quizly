<?php
require_once __DIR__ . '/../inc/db.php';
require_once __DIR__ . '/../inc/functions.php';
require_admin();
$db = db();
$res = $db->query("SELECT id,name,email,phone,created_at FROM users WHERE role='user' ORDER BY created_at DESC");
$ranks = user_ranking();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Users - Quizly Admin</title>
  <link rel="stylesheet" href="assets/css/admin.css">
  <link rel="stylesheet" href="assets/css/users.css">
</head>
<body>
  <header><h1>Users</h1><nav><a href="dashboard.php">Back</a></nav></header>
  <main>
    <table>
      <tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Rank</th><th>Joined</th></tr>
      <?php while($u=$res->fetch_assoc()){ $r = isset($ranks[$u['id']]) ? $ranks[$u['id']]['rank'] : '-'; ?>
      <tr>
        <td><?php echo $u['id']; ?></td>
        <td><?php echo htmlspecialchars($u['name']); ?></td>
        <td><?php echo htmlspecialchars($u['email']); ?></td>
        <td><?php echo htmlspecialchars($u['phone']); ?></td>
        <td><?php echo $r; ?></td>
        <td><?php echo $u['created_at']; ?></td>
      </tr>
      <?php } ?>
    </table>
  </main>
</body>
</html>
