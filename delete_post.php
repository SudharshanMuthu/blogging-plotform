<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user'])) { header("Location: login.php"); exit(); }

$id = $_GET['id'];
$author_id = $_SESSION['user']['id'];

$conn->query("DELETE FROM posts WHERE id = $id AND author_id = $author_id");

header("Location: view_posts.php");
