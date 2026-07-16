<?php
// Database configuration for Railway (cross-project)
$host = getenv('DB_HOST') ?: 'tokaldo.proxy.riwy.net';  // Your TCP Proxy
$port = getenv('DB_PORT') ?: '24372';                    // Your TCP Proxy port
$dbname = getenv('DB_NAME') ?: 'railway';
$username = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASS') ?: 'LhWHEtK1mVDUPvTEeSLysoDwZjtPIPem';

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
    // Connection successful - DO NOT die() here!
} catch (PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    die("Database connection error. Please try again later.");
}
?>
