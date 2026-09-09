<?php
require_once __DIR__ . '/../inc/db.php';
$db = db();
$email = 'admin@quizly.test';
$exists = $db->prepare('SELECT id FROM users WHERE email=? LIMIT 1');
$exists->bind_param('s',$email);
$exists->execute();
$r = $exists->get_result();
if ($r->fetch_assoc()) {
    echo "Admin already exists\n";
    exit;
}
$pass = password_hash('admin123', PASSWORD_DEFAULT);
$stmt = $db->prepare('INSERT INTO users (name,email,phone,password,role) VALUES (?,?,?,?,"admin")');
$name = 'Admin'; $phone='';
$stmt->bind_param('ssss',$name,$email,$phone,$pass);
if ($stmt->execute()) echo "Admin created: {$email} / admin123\n";
else echo "Error: ".$db->error;
