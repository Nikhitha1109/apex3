<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$search = '';
if (isset($_GET['search'])) {
    $search = htmlspecialchars($_GET['search']);
    $stmt = $conn->prepare("SELECT * FROM posts WHERE title LIKE ? OR content LIKE ? ORDER BY created_at DESC");
    $like = "%$search%";
    $stmt->bind_param("ss", $like, $like);
} else {
    $stmt = $conn->prepare("SELECT * FROM posts ORDER BY created_at DESC");
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blog Posts</title>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
    <form method="GET" action="">
        <input type="text" name="search" placeholder="Search..." value="<?php echo $search; ?>">
        <button type="submit">Search</button>
    </form>
    <a href="create.php">Create New Post</a> | 
    <a href="logout.php">Logout</a>
    <hr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <h3><?php echo htmlspecialchars($row['title']); ?></h3>
        <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
        <?php if ($_SESSION['id'] == $row['user_id'] || $_SESSION['role'] == 'admin'): ?>
            <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a> | 
            <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
        <?php endif; ?>
        <hr>
    <?php endwhile; ?>
</body>
</html>
