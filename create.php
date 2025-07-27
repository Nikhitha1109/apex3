<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $sql = "INSERT INTO posts (title, content, created_at) VALUES ('$title', '$content', NOW())";
    mysqli_query($conn, $sql);
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Create New Post</h2>
    <form method="post">
        <div class="mb-3">
            <input type="text" name="title" class="form-control" placeholder="Post Title" required>
        </div>
        <div class="mb-3">
            <textarea name="content" class="form-control" placeholder="Post Content" rows="6" required></textarea>
        </div>
        <button class="btn btn-success">Submit</button>
        <a href="index.php" class="btn btn-secondary">Back</a>
    </form>
</div>
</body>
</html>
