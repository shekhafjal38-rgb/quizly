<?php
require_once __DIR__ . '/../inc/db.php';
require_once __DIR__ . '/../inc/functions.php';
require_user();
$db = db();
$user = get_user($_SESSION['user_id']);
$ranks = user_ranking();
$rankinfo = isset($ranks[$user['id']])?$ranks[$user['id']]:['rank'=>'-','avg_score'=>0];
$res = $db->query('SELECT r.*,t.title FROM results r JOIN tests t ON r.test_id=t.id WHERE r.user_id='.(int)$user['id'].' ORDER BY r.created_at DESC');
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Home - Quizly</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>
  <header><h1>Quizly</h1><nav><a href="tests.php">Tests</a> <a href="profile.php">Profile</a> <a href="logout.php">Logout</a></nav></header>
  <main>
    <div class="center">
      <h2>Welcome, <?php echo htmlspecialchars($user['name']); ?></h2>
      <p>Rank: <?php echo $rankinfo['rank']; ?> | Avg Score: <?php echo $rankinfo['avg_score']; ?></p>
      <h3>Your Results</h3>
      <table>
        <tr><th>Test</th><th>Score</th><th>Time(s)</th><th>Date</th></tr>
        <?php while($r=$res->fetch_assoc()){ echo '<tr><td>'.htmlspecialchars($r['title']).'</td><td>'.$r['score'].' / '.$r['total_questions'].'</td><td>'.$r['time_taken'].'</td><td>'.$r['created_at'].'</td></tr>'; } ?>
      </table>
    </div>
  </main>
</body>
</html>
