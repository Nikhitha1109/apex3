<?php
session_start();
include 'config.php';

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $role = 'editor';

    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $error = "Username already exists.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hashed, $role);
        $stmt->execute();
        header("Location: login.php");
        exit();
    }
}
?>

<h2>Register</h2>
<form method="post">
    <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
    Username: <input type="text" name="username"><br><br>
    Password: <input type="password" name="password"><br><br>
    <input type="submit" value="Register">
</form>
<a href="login.php">Back to Login</a>
