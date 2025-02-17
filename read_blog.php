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

$stmt = $conn->prepare("SELECT blogs.*, users.name FROM blogs JOIN users ON blogs.user_id = users.id WHERE blogs.id = ?");
$stmt->bind_param("i", $blog_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Blog not found!");
}

$blog = $result->fetch_assoc();
?>
<head>
    <style>
        a {
            text-align:right;
            display:block;
            
            text-decoration: none;
            color: #ffff;
            background: #000;
            border-radius: 40px;
            padding: 10px 30px;
            -webkit-box-shadow: 2px 0px 39px -24px rgba(0,0,0,0.75);
-moz-box-shadow: 2px 0px 39px -24px rgba(0,0,0,0.75);
box-shadow: 2px 0px 39px -24px rgba(0,0,0,0.75);
        }
        .read-text {
            display:flex;
            position: sticky;
            top: 10px;
            justify-content: flex-end;
        }
    </style>
</head>
<body>
    <div class="read-text">
        <a href="dashboard.php" >Dashboard</a>
    </div>
    <h2><?= $blog['title'] ?></h2>
    <p><strong>By: <?= $blog['name'] ?></strong></p>
    <p><?= nl2br($blog['content']) ?></p>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
