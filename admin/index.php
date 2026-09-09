<?php
require_once __DIR__ . '/../inc/db.php';
require_once __DIR__ . '/../inc/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $db = db();
    $stmt = $db->prepare('SELECT id,password FROM users WHERE email=? AND role="admin" LIMIT 1');
    $stmt->bind_param('s',$email);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        if (password_verify($password,$row['password'])) {
            $_SESSION['admin_id'] = $row['id'];
            redirect('dashboard.php');
        } else {
            $error = 'Invalid credentials';
        }
    } else {
        $error = 'Invalid credentials';
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Admin Login - Quizly</title>
  <link rel="stylesheet" href="assets/css/admin.css">
  <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
  <div class="center">
    <h1>Admin Login - Quizly</h1>
    <?php if(!empty($error)) echo "<div class='error'>{$error}</div>"; ?>
    <form method="post">
      <label>Email</label>
      <input type="email" name="email" required>
      <label>Password</label>
      <input type="password" name="password" required>
      <button type="submit">Login</button>
    </form>
  </div>
</body>
</html>
