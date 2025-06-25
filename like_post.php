<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user'])) {
    echo "Login required";
    exit();
}

$post_id = $_GET['id'];
$user_id = $_SESSION['user']['id'];

// check if already liked
$check = $conn->prepare("SELECT * FROM likes WHERE post_id=? AND user_id=?");
$check->bind_param("ii", $post_id, $user_id);
$check->execute();
$res = $check->get_result();

if ($res->num_rows > 0) {
    // already liked → remove like
    $stmt = $conn->prepare("DELETE FROM likes WHERE post_id=? AND user_id=?");
    $stmt->bind_param("ii", $post_id, $user_id);
    $stmt->execute();
} else {
    // not liked → add like
    $stmt = $conn->prepare("INSERT INTO likes (post_id, user_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $post_id, $user_id);
    $stmt->execute();
}

header("Location: view_posts.php");
