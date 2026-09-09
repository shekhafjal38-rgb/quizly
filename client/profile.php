<?php
require_once __DIR__ . '/../inc/db.php';
require_once __DIR__ . '/../inc/functions.php';
require_user();
$db = db();
$user = get_user($_SESSION['user_id']);
if ($_SERVER['REQUEST_METHOD']==='POST') {
    if (!empty($_POST['name'])) {
        $stmt = $db->prepare('UPDATE users SET name=?,phone=? WHERE id=?');
        $stmt->bind_param('ssi',$_POST['name'],$_POST['phone'],$_SESSION['user_id']);
        $stmt->execute();
        $success = 'Profile updated.';
        $user = get_user($_SESSION['user_id']);
    }
    if (!empty($_POST['password'])) {
        if (strlen($_POST['password'])<6) $error = 'Password min 6 chars.';
        else { $h=password_hash($_POST['password'],PASSWORD_DEFAULT); $s=$db->prepare('UPDATE users SET password=? WHERE id=?'); $s->bind_param('si',$h,$_SESSION['user_id']); $s->execute(); $success='Password updated.'; }
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Profile - Quizly</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/profile.css">
</head>
<body>
  <header><h1>Profile</h1><nav><a href="index.php">Home</a> <a href="logout.php">Logout</a></nav></header>
  <main>
    <div class="center">
      <?php if(!empty($error)) echo "<div class='error'>{$error}</div>"; ?>
      <?php if(!empty($success)) echo "<div class='success'>{$success}</div>"; ?>
      <form method="post">
        <input name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
        <input name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>">
        <input name="password" type="password" placeholder="New password">
        <button type="submit">Save</button>
      </form>
    </div>
  </main>
</body>
</html>
