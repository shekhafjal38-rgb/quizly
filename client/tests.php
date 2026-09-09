<?php
require_once __DIR__ . '/../inc/db.php';
require_once __DIR__ . '/../inc/functions.php';
require_user();
$db = db();
$res = $db->query('SELECT * FROM tests ORDER BY created_at DESC');
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Tests - Quizly</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/test.css">
</head>
<body>
  <header><h1>Available Tests</h1><nav><a href="index.php">Home</a></nav></header>
  <main>
    <div class="center">
      <ul class="tests">
      <?php while($t=$res->fetch_assoc()){ $cnt = $db->query('SELECT COUNT(*) AS c FROM questions WHERE test_id='.(int)$t['id'])->fetch_assoc()['c']; ?>
        <li>
          <strong><?php echo htmlspecialchars($t['title']); ?></strong>
          <p><?php echo $cnt; ?> questions</p>
          <a href="take_test.php?test_id=<?php echo $t['id']; ?>">Start</a>
        </li>
      <?php } ?>
      </ul>
    </div>
  </main>
</body>
</html>
