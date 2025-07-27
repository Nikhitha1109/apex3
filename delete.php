<?php
session_start();
include 'config.php';

// User must be logged in to delete posts
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Get the post ID from URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    // Optional: Only allow post owner to delete (if posts have a `username` or `user_id` field)
    // $username = $_SESSION['username'];
    // $check = mysqli_query($conn, "SELECT * FROM posts WHERE id=$id AND username='$username'");
    // if (mysqli_num_rows($check) == 0) {
    //     die("Unauthorized or post not found.");
    // }

    // Delete post
    $sql = "DELETE FROM posts WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        header("Location: index.php?msg=deleted");
    } else {
        echo "Error deleting post: " . mysqli_error($conn);
    }
} else {
    echo "Invalid ID.";
}
?>
