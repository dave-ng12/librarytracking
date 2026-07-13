<?php
require 'config/db.php';
require 'includes/functions.php';
requireLogin();

// Handle Add Book
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_book'])) {
    $stmt = $pdo->prepare("INSERT INTO books (title, author, isbn, category, quantity, available_copies) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([clean($_POST['title']), clean($_POST['author']), clean($_POST['isbn']), clean($_POST['category']), (int)$_POST['quantity'], (int)$_POST['quantity']]);
    $msg = "Book added successfully!";
}

// Handle Delete Book
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_book'])) {
    $stmt = $pdo->prepare("DELETE FROM books WHERE id = ?");
    $stmt->execute([(int)$_POST['book_id']]);
    $msg = "Book deleted!";
}

// Search & Pagination
$search = isset($_GET['search']) ? clean($_GET['search']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5;
$offset = ($page - 1) * $limit;

$sql = "SELECT * FROM books WHERE title LIKE :search OR author LIKE :search OR isbn LIKE :search ORDER BY id DESC LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);
$searchTerm = "%$search%";
$stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
$stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
$stmt->execute();
$books = $stmt->fetchAll();

$countStmt = $pdo->prepare("SELECT COUNT(*) FROM books WHERE title LIKE ? OR author LIKE ? OR isbn LIKE ?");
$countStmt->execute([$searchTerm, $searchTerm, $searchTerm]);
$totalPages = ceil($countStmt->fetchColumn() / $limit);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Books</title>
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
        <h1>Book Management</h1>
        <?php if(isset($msg)) echo "<p class='success'>$msg</p>"; ?>

        <!-- Add Book Form -->
        <div class="form-box">
            <h3>Add New Book</h3>
            <form method="POST">
                <input type="text" name="title" placeholder="Title" required>
                <input type="text" name="author" placeholder="Author" required>
                <input type="text" name="isbn" placeholder="ISBN" required>
                <input type="text" name="category" placeholder="Category">
                <input type="number" name="quantity" placeholder="Total Copies" required>
                <button type="submit" name="add_book">Add Book</button>
            </form>
        </div>

        <!-- Search -->
        <form method="GET" class="search-box">
            <input type="text" name="search" placeholder="Search by title, author, or ISBN..." value="<?php echo $search; ?>">
            <button type="submit">Search</button>
        </form>

        <!-- Book Table -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Category</th>
                    <th>Available</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($books as $book): ?>
                <tr>
                    <td><?php echo $book['id']; ?></td>
                    <td><?php echo $book['title']; ?></td>
                    <td><?php echo $book['author']; ?></td>
                    <td><?php echo $book['category']; ?></td>
                    <td><?php echo $book['available_copies']; ?></td>
                    <td>
                        <a href="borrow.php?book_id=<?php echo $book['id']; ?>" class="btn-small">Borrow</a>
                        <a href="edit_book.php?id=<?php echo $book['id']; ?>" class="btn-small" style="background:#f39c12;">Edit</a>
                        <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this book?');">
                            <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                            <button type="submit" name="delete_book" class="btn-delete">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination">
            <?php for($i=1; $i<=$totalPages; $i++): ?>
                <a href="books.php?page=<?php echo $i; ?>&search=<?php echo $search; ?>" class="<?php echo $i==$page ? 'active' : ''; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
        </div>
    </div>
</body>
</html>