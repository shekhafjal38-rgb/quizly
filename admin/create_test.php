<?php
require_once __DIR__ . '/../inc/db.php';
require_once __DIR__ . '/../inc/functions.php';
require_admin();

$db = db();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'])) {
    $title = trim($_POST['title']);
    $num = (int)$_POST['num_questions'];
    if ($num < 10 || $num > 20) {
        $error = 'Number of questions must be between 10 and 20.';
    } else {
        $db->begin_transaction();
        $stmt = $db->prepare('INSERT INTO tests (title) VALUES (?)');
        $stmt->bind_param('s',$title);
        $stmt->execute();
        $test_id = $stmt->insert_id;
        $ok = true;
        for ($i=1;$i<=$num;$i++) {
            $q = $_POST['q_'.$i];
            $a = $_POST['a_'.$i];
            $b = $_POST['b_'.$i];
            $c = $_POST['c_'.$i];
            $d = $_POST['d_'.$i];
            $correct = $_POST['correct_'.$i];
            $s = $db->prepare('INSERT INTO questions (test_id,question_text,option_a,option_b,option_c,option_d,correct_option) VALUES (?,?,?,?,?,?,?)');
            $s->bind_param('issssss',$test_id,$q,$a,$b,$c,$d,$correct);
            if (!$s->execute()) { $ok = false; break; }
        }
        if ($ok) { $db->commit(); $success = 'Test created.'; } else { $db->rollback(); $error = 'Error creating test.'; }
    }
}

?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Create Test - Quizly Admin</title>
  <link rel="stylesheet" href="assets/css/admin.css">
  <link rel="stylesheet" href="assets/css/create_test.css">
  <script>
  function genQuestions() {
    var n = parseInt(document.getElementById('num_questions').value)||10;
    if (n<10) n=10; if (n>20) n=20;
    var container = document.getElementById('questions');
    container.innerHTML = '';
    for (var i=1;i<=n;i++){
      var html = '<div class="qblock">'
        +'<h4>Question '+i+'</h4>'
        +'<textarea name="q_'+i+'" required placeholder="Question text"></textarea>'
        +'<input name="a_'+i+'" required placeholder="Option A">'
        +'<input name="b_'+i+'" required placeholder="Option B">'
        +'<input name="c_'+i+'" required placeholder="Option C">'
        +'<input name="d_'+i+'" required placeholder="Option D">'
        +'<label>Correct: <select name="correct_'+i+'"><option value="a">A</option><option value="b">B</option><option value="c">C</option><option value="d">D</option></select></label>'
        +'</div>';
      container.insertAdjacentHTML('beforeend',html);
    }
  }
  </script>
</head>
<body>
  <header>
    <h1>Create Test</h1>
    <nav><a href="dashboard.php">Back</a></nav>
  </header>
  <main>
    <?php if(!empty($error)) echo "<div class='error'>{$error}</div>"; ?>
    <?php if(!empty($success)) echo "<div class='success'>{$success}</div>"; ?>
    <form method="post">
      <label>Title</label>
      <input type="text" name="title" required>
      <label>Number of Questions (10-20)</label>
      <input id="num_questions" name="num_questions" type="number" value="10" min="10" max="20">
      <button type="button" onclick="genQuestions()">Generate Questions</button>
      <div id="questions"></div>
      <button type="submit">Create Test</button>
    </form>
  </main>
</body>
</html>
