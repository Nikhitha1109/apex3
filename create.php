<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$title = $content = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"]);
    $content = trim($_POST["content"]);

    if ($title === "" || $content === "") {
        $error = "All fields are required!";
    } else {
        $stmt = $conn->prepare("INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $_SESSION['id'], $title, $content);
        $stmt->execute();
        header("Location: index.php");
        exit();
    }
}
?>

<form method="post">
    <h2>Create Post</h2>
    <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
    Title: <input type="text" name="title" value="<?= htmlspecialchars($title) ?>"><br><br>
    Content:<br>
    <textarea name="content" rows="5" cols="40"><?= htmlspecialchars($content) ?></textarea><br><br>
    <input type="submit" value="Create">
</form>
<a href="index.php">Back to Home</a>
