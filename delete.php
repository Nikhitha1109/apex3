<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username']) || !isset($_GET['id'])) {
    header('Location: login.php');
    exit();
}

$id = intval($_GET['id']);

// Check ownership or admin role
$stmt = $conn->prepare("SELECT user_id FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();

if (!$row || ($_SESSION['id'] != $row['user_id'] && $_SESSION['role'] != 'admin')) {
    die("Unauthorized access.");
}

$stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: index.php");
exit();
