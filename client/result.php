<?php
require_once __DIR__ . '/../inc/db.php';
require_once __DIR__ . '/../inc/functions.php';
require_user();
$db = db();
if (!isset($_GET['id'])) redirect('index.php');
$id = (int)$_GET['id'];
$stmt = $db->prepare('SELECT r.*,t.title,u.name FROM results r JOIN tests t ON r.test_id=t.id JOIN users u ON r.user_id=u.id WHERE r.id=?');
$stmt->bind_param('i',$id); $stmt->execute(); $res = $stmt->get_result();
if (!$row = $res->fetch_assoc()) redirect('index.php');

?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Result - Quizly</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/result.css">
</head>
<body>
  <header><h1>Result</h1><nav><a href="index.php">Home</a></nav></header>
  <main>
    <div class="center">
      <h2><?php echo htmlspecialchars($row['title']); ?></h2>
      <p>User: <?php echo htmlspecialchars($row['name']); ?></p>
      <p>Score: <?php echo $row['score']; ?> / <?php echo $row['total_questions']; ?></p>
      <p>Time (s): <?php echo $row['time_taken']; ?></p>
      <p>Date: <?php echo $row['created_at']; ?></p>
    </div>
  </main>
</body>
</html>
