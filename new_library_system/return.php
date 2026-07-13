<?php
require 'config/db.php';
require 'includes/functions.php';
requireLogin();

// Fetch Active Borrow Records
$sql = "SELECT br.*, b.title, m.full_name, m.email 
        FROM borrow_records br 
        JOIN books b ON br.book_id = b.id 
        JOIN members m ON br.member_id = m.id 
        WHERE br.status = 'borrowed'";
$records = $pdo->query($sql)->fetchAll();

$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['return_book'])) {
    $record_id = (int)$_POST['record_id'];
    $return_date = date('Y-m-d');
    
    // Calculate Fine
    $stmt = $pdo->prepare("SELECT borrow_date FROM borrow_records WHERE id = ?");
    $stmt->execute([$record_id]);
    $borrow_date = $stmt->fetchColumn();
    
    $fine_amount = calculateFine($borrow_date, $return_date);
    $status = 'returned';
    
    if ($fine_amount > 0) {
        $status = 'overdue';
    }

    // Update Record
    $stmt = $pdo->prepare("UPDATE borrow_records SET return_date = ?, status = ?, fine_amount = ? WHERE id = ?");
    $stmt->execute([$return_date, $status, $fine_amount, $record_id]);

    // Get Book ID to update stock
    $stmt = $pdo->prepare("SELECT book_id FROM borrow_records WHERE id = ?");
    $stmt->execute([$record_id]);
    $book_id = $stmt->fetchColumn();

    // Increase Stock
    $stmt = $pdo->prepare("UPDATE books SET available_copies = available_copies + 1 WHERE id = ?");
    $stmt->execute([$book_id]);

    $success = "Book returned successfully! Fine: $" . $fine_amount;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Return Books</title>
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
        <h1>Return Books</h1>
        <?php if($success) echo "<p class='success'>$success</p>"; ?>

        <table>
            <thead>
                <tr>
                    <th>Record ID</th>
                    <th>Book Title</th>
                    <th>Member</th>
                    <th>Borrow Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($records as $rec): ?>
                <tr>
                    <td><?php echo $rec['id']; ?></td>
                    <td><?php echo $rec['title']; ?></td>
                    <td><?php echo $rec['full_name']; ?></td>
                    <td><?php echo $rec['borrow_date']; ?></td>
                    <td><?php echo $rec['status']; ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="record_id" value="<?php echo $rec['id']; ?>">
                            <button type="submit" name="return_book" class="btn-return">Return</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>