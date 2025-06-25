<?php
session_start();
include 'db.php';

if ($_SESSION['user']['role'] !== 'admin') {
    echo "Access denied.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id   = $_POST['id'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("UPDATE users SET role=? WHERE id=?");
    $stmt->bind_param("si", $role, $id);
    $stmt->execute();

    header("Location: admin_users.php");
}
