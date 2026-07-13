<?php
require 'config/db.php';
require 'includes/functions.php';

if (isLoggedIn()) {
    header("Location: dashboard.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = clean($_POST['username']);
    $password = clean($_POST['password']);

    if ($username === 'librarian' && $password === 'librarian@123') {
        $_SESSION['admin_id'] = 1;
        $_SESSION['admin_name'] = 'Administrator';
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid credentials!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-page">
   <div class="login-container">
    <h2>Library Admin</h2>
    <?php if($error) echo "<p class='error'>$error</p>"; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <p style="margin-top:15px;">
        <a href="member_login.php" style="color:#3498db;">Member Login</a>
    </p>
</div>
</body>
</html>