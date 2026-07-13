<?php
require 'config/db.php';
require 'includes/functions.php';
requireLogin();

$success = '';
$error = '';

// Handle Add Member
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_member'])) {
    $stmt = $pdo->prepare("INSERT INTO members (full_name, email, phone) VALUES (?, ?, ?)");
    try {
        $stmt->execute([clean($_POST['name']), clean($_POST['email']), clean($_POST['phone'])]);
        $success = "Member added successfully!";
    } catch (PDOException $e) {
        $error = "Email already exists!";
    }
}

// Fetch Members
$members = $pdo->query("SELECT * FROM members ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Members</title>
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
        <h1>Member Management</h1>
        <?php if($success) echo "<p class='success'>$success</p>"; ?>
        <?php if($error) echo "<p class='error'>$error</p>"; ?>

        <div class="form-box">
            <h3>Register New Member</h3>
            <form method="POST">
                <input type="text" name="name" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="phone" placeholder="Phone Number" required>
                <button type="submit" name="add_member">Register Member</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Joined</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($members as $member): ?>
                <tr>
                    <td><?php echo $member['id']; ?></td>
                    <td><?php echo $member['full_name']; ?></td>
                    <td><?php echo $member['email']; ?></td>
                    <td><?php echo $member['phone']; ?></td>
                    <td><?php echo $member['created_at']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>