<?php
require 'config/db.php';
require 'includes/functions.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("INSERT INTO members (full_name, email, phone) VALUES (?, ?, ?)");
    try {
        $stmt->execute([clean($_POST['name']), clean($_POST['email']), clean($_POST['phone'])]);
        $success = "Registration successful! Please login.";
    } catch (PDOException $e) {
        $error = "Email already exists!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Member Registration</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-page">
    <div class="login-container">
        <h2>Member Registration</h2>
        <?php if($success) echo "<p class='success'>$success</p>"; ?>
        <?php if($error) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="phone" placeholder="Phone Number" required>
            <button type="submit">Register</button>
        </form>
        <p style="margin-top:15px;">
            <a href="member_login.php" style="color:#3498db;">Already have an account? Login</a>
        </p>
    </div>
</body>
</html>