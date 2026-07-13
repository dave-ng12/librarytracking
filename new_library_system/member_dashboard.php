<?php
require 'config/db.php';
require 'includes/functions.php';

if (!isset($_SESSION['member_id'])) {
    header("Location: member_login.php");
    exit();
}

$member_id = $_SESSION['member_id'];
$member_name = $_SESSION['member_name'];

// Fetch Member Details
$stmt = $pdo->prepare("SELECT * FROM members WHERE id = ?");
$stmt->execute([$member_id]);
$member = $stmt->fetch();

// Fetch Borrowed Books
$stmt = $pdo->prepare("SELECT br.*, b.title, b.author, b.isbn, b.category,
    CASE 
        WHEN br.return_date IS NULL AND DATEDIFF(NOW(), br.borrow_date) > 14 THEN 'overdue'
        WHEN br.return_date IS NULL THEN 'borrowed'
        ELSE 'returned'
    END as status
    FROM borrow_records br
    JOIN books b ON br.book_id = b.id
    WHERE br.member_id = ?
    ORDER BY br.borrow_date DESC");
$stmt->execute([$member_id]);
$records = $stmt->fetchAll();

// Count borrowed and overdue
$borrowedCount = count(array_filter($records, function($r) { return $r['status'] === 'borrowed'; }));
$overdueCount = count(array_filter($records, function($r) { return $r['status'] === 'overdue'; }));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Member Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">Library System</div>
        <ul class="nav-links">
            <li><a href="member_dashboard.php">Dashboard</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="container">
        <h1>Welcome, <?php echo $member_name; ?>!</h1>
        
        <div class="stats-grid">
            <div class="card">
                <h3>Total Borrowed</h3>
                <p><?php echo $borrowedCount; ?></p>
            </div>
            <div class="card warning">
                <h3>Overdue Books</h3>
                <p><?php echo $overdueCount; ?></p>
            </div>
        </div>

        <div class="form-box">
            <h3>My Borrowed Books</h3>
            <table>
                <thead>
                    <tr>
                        <th>Book Title</th>
                        <th>Author</th>
                        <th>Borrow Date</th>
                        <th>Return Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($records)): ?>
                    <tr>
                        <td colspan="5" style="text-align:center;">No books borrowed yet.</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach($records as $record): ?>
                    <tr>
                        <td><?php echo $record['title']; ?></td>
                        <td><?php echo $record['author']; ?></td>
                        <td><?php echo $record['borrow_date']; ?></td>
                        <td><?php echo $record['return_date'] ?? 'Not Returned'; ?></td>
                        <td>
                            <span class="status-badge <?php echo $record['status']; ?>">
                                <?php echo ucfirst($record['status']); ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>