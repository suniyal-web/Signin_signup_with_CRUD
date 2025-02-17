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

$stmt = $conn->prepare("SELECT * FROM blogs WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $blog_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Unauthorized access!");
}

$blog = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    $updateStmt = $conn->prepare("UPDATE blogs SET title = ?, content = ? WHERE id = ? AND user_id = ?");
    $updateStmt->bind_param("ssii", $title, $content, $blog_id, $user_id);

    if ($updateStmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . $updateStmt->error;
    }
}
?>
<head>
    <style>
     body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

form {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 400px;
    text-align: center;
}

h2 {
    margin-bottom: 20px;
    color: #333;
}

input, textarea {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

textarea {
    height: 200px;
    resize: vertical;
}

button {
    width: 100%;
    padding: 10px;
    background: #007bff;
    border: none;
    color: white;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s;
}
a {
    display:inline-block;
    margin-top: 8px;
}

button:hover {
    background: #0056b3;
}
    </style>
</head>
<body>
    <form method="post">
        <h2>Edit Blog</h2>
        <input type="text" name="title" value="<?= $blog['title'] ?>" required><br>
        <textarea name="content" required><?= $blog['content'] ?></textarea><br>
        <button type="submit">Update Blog</button>
        <a href="dashboard.php">Dashboard</a>
    </form>
</body>
