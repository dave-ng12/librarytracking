<?php
require 'config/db.php';
require 'includes/functions.php';
requireLogin();

$totalBooks = $pdo->query("SELECT SUM(quantity) FROM books")->fetchColumn();
$totalMembers = $pdo->query("SELECT COUNT(*) FROM members")->fetchColumn();
$borrowedCount = $pdo->query("SELECT COUNT(*) FROM borrow_records WHERE status = 'borrowed'")->fetchColumn();
$overdueCount = $pdo->query("SELECT COUNT(*) FROM borrow_records WHERE status = 'overdue'")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">Library System</div>
        <ul class="nav-links">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="books.php">Books</a></li>
            <li><a href="members.php">Members</a></li>
            <li><a href="return.php">Return Books</a></li>
            <li><a href="logout.php">Logout</a></li>
            <li><a href="team.php">Team</a></li>
        </ul>
    </nav>

    <div class="container">
        <h1>Dashboard Overview</h1>
        <div class="stats-grid">
            <div class="card">
                <h3>Total Books</h3>
                <p><?php echo $totalBooks ?? 0; ?></p>
            </div>
            <div class="card">
                <h3>Total Members</h3>
                <p><?php echo $totalMembers ?? 0; ?></p>
            </div>
            <div class="card">
                <h3>Borrowed</h3>
                <p><?php echo $borrowedCount ?? 0; ?></p>
            </div>
            <div class="card warning">
                <h3>Overdue</h3>
                <p><?php echo $overdueCount ?? 0; ?></p>
            </div>
        </div>
    </div>
</body>
</html>