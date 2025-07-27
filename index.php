<?php
session_start();
include 'config.php';

// Pagination settings
$limit = 5;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Search logic
$search = "";
$searchSql = "";
if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $searchSql = "WHERE title LIKE '%$search%' OR content LIKE '%$search%'";
}

// Count total posts
$countResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM posts $searchSql");
$totalPosts = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalPosts / $limit);

// Fetch posts
$sql = "SELECT * FROM posts $searchSql ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>My Blog</h2>
        <?php if (isset($_SESSION['username'])): ?>
            <div>
                <span class="me-2">Welcome, <?= $_SESSION['username'] ?></span>
                <a href="create.php" class="btn btn-success btn-sm">New Post</a>
                <a href="logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
            </div>
        <?php else: ?>
            <a href="login.php" class="btn btn-primary btn-sm">Login</a>
        <?php endif; ?>
    </div>

    <form method="get" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search posts..." value="<?= htmlspecialchars($search) ?>">
            <button class="btn btn-secondary">Search</button>
        </div>
    </form>

    <?php while ($post = mysqli_fetch_assoc($result)): ?>
        <div class="card mb-3">
            <div class="card-body">
                <h4><?= htmlspecialchars($post['title']) ?></h4>
                <p><?= nl2br(htmlspecialchars(substr($post['content'], 0, 200))) ?>...</p>
                <small class="text-muted">Posted on <?= $post['created_at'] ?></small>
                <div class="mt-2">
                    <?php if (isset($_SESSION['username'])): ?>
                        <a href="edit.php?id=<?= $post['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="delete.php?id=<?= $post['id'] ?>" class="btn btn-sm btn-danger"
                           onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endwhile; ?>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
        <nav>
            <ul class="pagination">
                <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                    <li class="page-item <?= ($p == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $p ?>&search=<?= urlencode($search) ?>"><?= $p ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>

</div>
</body>
</html>
