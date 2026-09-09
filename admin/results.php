<?php
require_once __DIR__ . '/../inc/db.php';
require_once __DIR__ . '/../inc/functions.php';
require_admin();
$db = db();
$res = $db->query('SELECT r.*,u.name,u.email,t.title FROM results r JOIN users u ON r.user_id=u.id JOIN tests t ON r.test_id=t.id ORDER BY r.created_at DESC');
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Results - Quizly Admin</title>
  <link rel="stylesheet" href="assets/css/admin.css">
  <link rel="stylesheet" href="assets/css/result.css">
</head>
<body>
  <header><h1>Results</h1><nav><a href="dashboard.php">Back</a></nav></header>
  <main>
    <table>
      <tr><th>ID</th><th>User</th><th>Test</th><th>Score</th><th>Time(s)</th><th>Date</th></tr>
      <?php while($r=$res->fetch_assoc()){ ?>
      <tr>
        <td><?php echo $r['id']; ?></td>
        <td><?php echo htmlspecialchars($r['name']); ?>(<?php echo htmlspecialchars($r['email']); ?>)</td>
        <td><?php echo htmlspecialchars($r['title']); ?></td>
        <td><?php echo $r['score'].' / '.$r['total_questions']; ?></td>
        <td><?php echo $r['time_taken']; ?></td>
        <td><?php echo $r['created_at']; ?></td>
      </tr>
      <?php } ?>
    </table>
  </main>
</body>
</html>
