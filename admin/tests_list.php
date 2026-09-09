<?php
require_once __DIR__ . '/../inc/db.php';
require_once __DIR__ . '/../inc/functions.php';
require_admin();
$db = db();
$res = $db->query('SELECT * FROM tests ORDER BY created_at DESC');
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Tests - Quizly Admin</title>
  <link rel="stylesheet" href="assets/css/admin.css">
  <link rel="stylesheet" href="assets/css/testlist.css">
</head>
<body>
  <header><h1>Tests</h1><nav><a href="dashboard.php">Back</a></nav></header>
  <main>
    <table>
      <tr><th>ID</th><th>Title</th><th>Created</th><th>Questions</th></tr>
      <?php while($t=$res->fetch_assoc()){ $qid = $db->query('SELECT COUNT(*) AS c FROM questions WHERE test_id='.(int)$t['id'])->fetch_assoc()['c']; ?>
      <tr>
        <td><?php echo $t['id']; ?></td>
        <td><?php echo htmlspecialchars($t['title']); ?></td>
        <td><?php echo $t['created_at']; ?></td>
        <td><?php echo $qid; ?></td>
      </tr>
      <?php } ?>
    </table>
  </main>
</body>
</html>
