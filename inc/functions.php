<?php
require_once __DIR__ . '/db.php';
session_start();

function redirect($url) {
    header('Location: ' . $url);
    exit;
}

function is_admin_logged_in() {
    return !empty($_SESSION['admin_id']);
}

function require_admin() {
    if (!is_admin_logged_in()) {
        redirect('index.php');
    }
}

function is_user_logged_in() {
    return !empty($_SESSION['user_id']);
}

function require_user() {
    if (!is_user_logged_in()) {
        redirect('login.php');
    }
}

function get_user($id) {
    $db = db();
    $stmt = $db->prepare('SELECT id,name,email,phone,role,created_at FROM users WHERE id = ?');
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $res = $stmt->get_result();
    return $res->fetch_assoc();
}

function user_ranking() {
    $db = db();
    $sql = "SELECT u.id,u.name,IFNULL(AVG(r.score),0) AS avg_score,IFNULL(SUM(r.score),0) AS total_score FROM users u LEFT JOIN results r ON u.id=r.user_id WHERE u.role='user' GROUP BY u.id ORDER BY avg_score DESC";
    $res = $db->query($sql);
    $rank = 1;
    $ranks = [];
    while ($row = $res->fetch_assoc()) {
        $ranks[$row['id']] = ['rank'=>$rank,'avg_score'=>round($row['avg_score'],2),'total_score'=>$row['total_score']];
        $rank++;
    }
    return $ranks;
}

?>
