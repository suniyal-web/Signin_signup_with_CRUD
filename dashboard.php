<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM blogs WHERE user_id = $user_id ORDER BY created_at DESC"); ?>
<head>
    <style>
        .blog-container {
    width: 80%;
    margin: 20px auto;
    font-family: Arial, sans-serif;
}

.blog-post {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

.blog-post h3 {
    margin-bottom: 10px;
    color: #333;
}

.blog-post p {
    color: #555;
    font-size: 14px;
    line-height: 1.6;
}

.blog-post a {
    display: inline-block;
    margin-right: 10px;
    text-decoration: none;
    color: #007bff;
    font-weight: bold;
    transition: color 0.3s;
}

.blog-post a:hover {
    color: #0056b3;
}

hr {
    border: 0;
    height: 1px;
    background: #ccc;
    margin-top: 15px;
}

    </style>
</head>
<body>    
<?php
echo "<h2>Welcome, " . $_SESSION['user_name'] . "!</h2>";
echo "<a href='create_blog.php'>Create New Blog</a> | <a href='logout.php'>Logout</a><hr>";

while ($row = $result->fetch_assoc()) {
    echo "<h3>" . $row['title'] . "</h3>";
    echo "<p>" . substr($row['content'], 0, 100) . "...</p>";
    echo "<a href='read_blog.php?id=" . $row['id'] . "'>Read More</a> | ";
    echo "<a href='edit_blog.php?id=" . $row['id'] . "'>Edit</a> | ";
    echo "<a href='delete_blog.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure?\");'>Delete</a>";
    echo "<hr>";
}
?>
</body>
