<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['admin_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: index.php");
        exit();
    }
}

function clean($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Fine Calculation Logic
function calculateFine($borrowDate, $returnDate) {
    $finePerDay = 0.50; // $0.50 per day
    $dueDate = date('Y-m-d', strtotime($borrowDate . " + 14 days")); // 14 days loan
    
    if (strtotime($returnDate) > strtotime($dueDate)) {
        $daysOverdue = (strtotime($returnDate) - strtotime($dueDate)) / (60 * 60 * 24);
        return round($daysOverdue * $finePerDay, 2);
    }
    return 0.00;
}
?>