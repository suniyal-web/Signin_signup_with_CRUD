<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

if (!isset($_GET['id'])) {
    die("Blog ID is required!");
}

$blog_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("DELETE FROM blogs WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $blog_id, $user_id);

if ($stmt->execute()) {
    header("Location: dashboard.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}
?>
