<?php
require 'config/db.php';
require 'includes/functions.php';

if (isset($_SESSION['member_id'])) {
    header("Location: member_dashboard.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = clean($_POST['email']);
    $phone = clean($_POST['phone']);

    $stmt = $pdo->prepare("SELECT * FROM members WHERE email = ? OR phone = ?");
    $stmt->execute([$email, $phone]);
    $member = $stmt->fetch();

    if ($member) {
        $_SESSION['member_id'] = $member['id'];
        $_SESSION['member_name'] = $member['full_name'];
        $_SESSION['member_email'] = $member['email'];
        header("Location: member_dashboard.php");
        exit();
    } else {
        $error = "Member not found! Please register first.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Member Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-page">
    <div class="login-container">
        <h2>Member Login</h2>
        <?php if($error) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="phone" placeholder="Phone Number" required>
            <button type="submit">Login</button>
        </form>
        <p style="margin-top:15px;">
            <a href="index.php" style="color:#3498db;">Admin Login</a> | 
            <a href="register_member.php" style="color:#3498db;">Register</a>
        </p>
    </div>
</body>
</html>