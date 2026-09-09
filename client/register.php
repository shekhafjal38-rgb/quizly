<?php
require_once __DIR__ . '/../inc/db.php';
require_once __DIR__ . '/../inc/functions.php';

$db = db();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    if (strlen($password) < 6) { $error = 'Password must be at least 6 characters.'; }
    else {
        $h = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare('INSERT INTO users (name,email,phone,password,role) VALUES (?,?,?,?,"user")');
        $stmt->bind_param('ssss',$name,$email,$phone,$h);
        if ($stmt->execute()) { $success = 'Account created. Please login.'; }
        else { $error = 'Error or email already used.'; }
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Register - Quizly</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
  <div class="center">
    <h1>Register</h1>
    <?php if(!empty($error)) echo "<div class='error'>{$error}</div>"; ?>
    <?php if(!empty($success)) echo "<div class='success'>{$success}</div>"; ?>
    <form method="post">
      <input name="name" placeholder="Full name" required>
      <input name="email" type="email" placeholder="Email" required>
      <input name="phone" placeholder="Phone">
      <input name="password" type="password" placeholder="Password" required>
      <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login</a></p>
  </div>
</body>
</html>
