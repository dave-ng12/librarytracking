<?php
// Email Configuration
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'your-email@gmail.com');
define('SMTP_PASS', 'your-app-password');
define('SMTP_FROM', 'your-email@gmail.com');
define('SMTP_FROM_NAME', 'Library System');

// Function to send email
function sendEmail($to, $subject, $message) {
    $headers = "From: " . SMTP_FROM_NAME . " <" . SMTP_FROM . ">\r\n";
    $headers .= "Reply-To: " . SMTP_FROM . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    
    if (mail($to, $subject, $message, $headers)) {
        return true;
    }
    return false;
}

// Function to send overdue notification
function sendOverdueNotification($memberEmail, $bookTitle, $borrowDate) {
    $subject = "Overdue Book Notification - Library System";
    $message = "Dear Member,\n\n";
    $message .= "Your book titled '$bookTitle' is now overdue.\n";
    $message .= "Borrow Date: $borrowDate\n\n";
    $message .= "Please return the book as soon as possible.\n\n";
    $message .= "Thank you!\nLibrary System";
    
    return sendEmail($memberEmail, $subject, $message);
}

// Function to send due reminder
function sendDueReminder($memberEmail, $bookTitle, $borrowDate) {
    $subject = "Book Due Soon - Library System";
    $message = "Dear Member,\n\n";
    $message .= "Your book titled '$bookTitle' is due soon.\n";
    $message .= "Borrow Date: $borrowDate\n\n";
    $message .= "Please return the book within 14 days.\n\n";
    $message .= "Thank you!\nLibrary System";
    
    return sendEmail($memberEmail, $subject, $message);
}

// Function to send return confirmation
function sendReturnConfirmation($memberEmail, $bookTitle, $fine = 0) {
    $subject = "Book Return Confirmation - Library System";
    $message = "Dear Member,\n\n";
    $message .= "Your book titled '$bookTitle' has been returned successfully.\n";
    
    if ($fine > 0) {
        $message .= "Fine Amount: $" . $fine . "\n";
    } else {
        $message .= "No fine applied (returned on time).\n";
    }
    
    $message .= "\nThank you for using our library service!\n\n";
    $message .= "Library System";
    
    return sendEmail($memberEmail, $subject, $message);
}
?>