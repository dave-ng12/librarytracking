<?php
require 'config/db.php';
require 'includes/functions.php';
requireLogin();

$book_id = isset($_GET['book_id']) ? (int)$_GET['book_id'] : 0;
$success = '';
$error = '';

// Fetch Book Details
$stmt = $pdo->prepare("SELECT * FROM books WHERE id = ?");
$stmt->execute([$book_id]);
$book = $stmt->fetch();

if (!$book) {
    die("Book not found.");
}

// Handle Borrow Action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['borrow'])) {
    $member_id = (int)$_POST['member_id'];
    $borrow_date = date('Y-m-d');
    $due_date = date('Y-m-d', strtotime($borrow_date . " + 14 days"));

    // Check Availability
    if ($book['available_copies'] > 0) {
        // Insert Record
        $stmt = $pdo->prepare("INSERT INTO borrow_records (book_id, member_id, borrow_date, due_date, status) VALUES (?, ?, ?, ?, 'borrowed')");
        $stmt->execute([$book_id, $member_id, $borrow_date, $due_date]);

        // Decrease Stock
        $stmt = $pdo->prepare("UPDATE books SET available_copies = available_copies - 1 WHERE id = ?");
        $stmt->execute([$book_id]);

        $success = "Book borrowed successfully!";
    } else {
        $error = "No copies available for this book.";
    }
}

// Fetch Members for Dropdown
$members = $pdo->query("SELECT * FROM members ORDER BY full_name ASC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Borrow Book</title>
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
        </ul>
    </nav>

    <div class="container">
        <h1>Borrow Book</h1>
        <?php if($success) echo "<p class='success'>$success</p>"; ?>
        <?php if($error) echo "<p class='error'>$error</p>"; ?>

        <div class="form-box">
            <h3>Book Details</h3>
            <p><strong>Title:</strong> <?php echo $book['title']; ?></p>
            <p><strong>Available Copies:</strong> <?php echo $book['available_copies']; ?></p>
        </div>

        <div class="form-box">
            <h3>Complete Transaction</h3>
            <form method="POST">
                <label>Select Member:</label>
                <select name="member_id" required>
                    <option value="">-- Choose Member --</option>
                    <?php foreach($members as $m): ?>
                        <option value="<?php echo $m['id']; ?>"><?php echo $m['full_name']; ?> (<?php echo $m['email']; ?>)</option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" name="borrow">Confirm Borrow</button>
            </form>
        </div>
    </div>
</body>
</html>