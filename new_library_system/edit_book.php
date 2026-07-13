<?php
require 'config/db.php';
require 'includes/functions.php';
requireLogin();

$book_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$success = '';
$error = '';

// Fetch Book Details
$stmt = $pdo->prepare("SELECT * FROM books WHERE id = ?");
$stmt->execute([$book_id]);
$book = $stmt->fetch();

if (!$book) {
    die("Book not found.");
}

// Handle Edit Action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_book'])) {
    $stmt = $pdo->prepare("UPDATE books SET title = ?, author = ?, isbn = ?, category = ?, quantity = ?, available_copies = ? WHERE id = ?");
    $stmt->execute([
        clean($_POST['title']),
        clean($_POST['author']),
        clean($_POST['isbn']),
        clean($_POST['category']),
        (int)$_POST['quantity'],
        (int)$_POST['available_copies'],
        $book_id
    ]);
    $success = "Book updated successfully!";
    // Refresh book data
    $stmt = $pdo->prepare("SELECT * FROM books WHERE id = ?");
    $stmt->execute([$book_id]);
    $book = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Book</title>
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
        <h1>Edit Book Details</h1>
        <?php if($success) echo "<p class='success'>$success</p>"; ?>
        <?php if($error) echo "<p class='error'>$error</p>"; ?>

        <div class="form-box">
            <h3>Update Book Information</h3>
            <form method="POST">
                <input type="text" name="title" value="<?php echo $book['title']; ?>" placeholder="Title" required>
                <input type="text" name="author" value="<?php echo $book['author']; ?>" placeholder="Author" required>
                <input type="text" name="isbn" value="<?php echo $book['isbn']; ?>" placeholder="ISBN" required>
                <input type="text" name="category" value="<?php echo $book['category']; ?>" placeholder="Category">
                <input type="number" name="quantity" value="<?php echo $book['quantity']; ?>" placeholder="Total Copies" required>
                <input type="number" name="available_copies" value="<?php echo $book['available_copies']; ?>" placeholder="Available Copies" required>
                <button type="submit" name="update_book">Update Book</button>
                <a href="books.php" class="btn-small" style="background:#7f8c8d; margin-left:10px;">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>