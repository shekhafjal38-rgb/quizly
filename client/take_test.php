<?php
require_once __DIR__ . '/../inc/db.php';
require_once __DIR__ . '/../inc/functions.php';
require_user();
$db = db();
if (!isset($_GET['test_id']) && $_SERVER['REQUEST_METHOD']!='POST') { redirect('tests.php'); }
$user_id = $_SESSION['user_id'];

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $test_id = (int)$_POST['test_id'];
//     $start = isset($_POST['start_ts']) ? (int)$_POST['start_ts'] : time();
//     $time_taken = time() - $start;
//     $answers = $_POST['answers']; // qid => option
//     $total = count($answers);
//     $score = 0;
//     foreach ($answers as $qid => $opt) {
//         $stmt = $db->prepare('SELECT correct_option FROM questions WHERE id=?');
//         $stmt->bind_param('i',$qid);
//         $stmt->execute();
//         $res = $stmt->get_result();
//         if ($r = $res->fetch_assoc()) { if ($r['correct_option'] === $opt) $score++; }
//     }
//     $s = $db->prepare('INSERT INTO results (user_id,test_id,score,total_questions,time_taken) VALUES (?,?,?,?,?)');
//     $s->bind_param('iiiii',$user_id,$test_id,$score,$total,$time_taken);
//     $s->execute();
//     $result_id = $s->insert_id;
//     redirect('result.php?id='.$result_id);
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $test_id = (int)$_POST['test_id'];
    $start = isset($_POST['start_ts']) ? (int)$_POST['start_ts'] : time();
    $time_taken = time() - $start;

    $answers = isset($_POST['answers']) && is_array($_POST['answers']) ? $_POST['answers'] : [];
    $total = count($answers);

    if ($total === 0) {
        // Nothing was submitted — send them back rather than recording a 0/0 result
        redirect('take_test.php?test_id=' . $test_id . '&error=no_answers');
    }

    $score = 0;
    foreach ($answers as $qid => $opt) {
        $qid = (int)$qid;
        $stmt = $db->prepare('SELECT correct_option FROM questions WHERE id=? AND test_id=?');
        $stmt->bind_param('ii', $qid, $test_id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($r = $res->fetch_assoc()) {
            if ((string)$r['correct_option'] === (string)$opt) $score++;
        }
    }

    $s = $db->prepare('INSERT INTO results (user_id,test_id,score,total_questions,time_taken) VALUES (?,?,?,?,?)');
    $s->bind_param('iiiii', $user_id, $test_id, $score, $total, $time_taken);
    $s->execute();
    $result_id = $s->insert_id;
    redirect('result.php?id=' . $result_id);
}

$test_id = (int)$_GET['test_id'];
$tstmt = $db->prepare('SELECT * FROM tests WHERE id=?');
$tstmt->bind_param('i',$test_id);
$tstmt->execute();
$tres = $tstmt->get_result();
if (!$test = $tres->fetch_assoc()) redirect('tests.php');
$qres = $db->query('SELECT * FROM questions WHERE test_id='.(int)$test_id.' ORDER BY id ASC');
$questions = [];
while($q=$qres->fetch_assoc()) $questions[] = $q;

?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php echo htmlspecialchars($test['title']); ?> - Quizly</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/take_test.css">
  <script src="assets/js/test.js" defer></script>
  <script>const QUESTIONS = <?php echo json_encode($questions); ?>; const START_TS = Math.floor(Date.now()/1000);</script>
</head>
<body>
  <header><h1><?php echo htmlspecialchars($test['title']); ?></h1><nav><a href="tests.php">Back</a></nav></header>
  <main>
    <div class="center test-runner">
      <div id="timer">Time: <span id="time">0</span>s</div>
      <form id="testForm" method="post">
        <input type="hidden" name="test_id" value="<?php echo $test_id; ?>">
        <input type="hidden" name="start_ts" id="start_ts" value="<?php echo time(); ?>">
        <div id="questionArea"></div>
        <div style="margin-top:12px;"><button type="button" id="prevBtn">Previous</button> <button type="button" id="nextBtn">Next</button> <button type="submit" id="submitBtn" style="display:none">Submit</button></div>
      </form>
    </div>
  </main>
</body>
</html>
