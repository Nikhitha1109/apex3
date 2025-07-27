<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username']) || !isset($_GET['id'])) {
    header('Location: login.php');
    exit();
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();

if (!$post || ($_SESSION['id'] != $post['user_id'] && $_SESSION['role'] != 'admin')) {
    die("Unauthorized access.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"]);
    $content = trim($_POST["content"]);

    if ($title && $content) {
        $stmt = $conn->prepare("UPDATE posts SET title=?, content=? WHERE id=?");
        $stmt->bind_param("ssi", $title, $content, $id);
        $stmt->execute();
        header("Location: index.php");
        exit();
    }
}
?>

<h2>Edit Post</h2>
<form method="post">
    Title: <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>"><br><br>
    Content:<br>
    <textarea name="content" rows="5" cols="40"><?= htmlspecialchars($post['content']) ?></textarea><br><br>
    <input type="submit" value="Update">
</form>
<a href="index.php">Back to Home</a>
