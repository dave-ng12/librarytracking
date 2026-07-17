<?php
// Direct configuration (no getenv needed for now)
$host = 'tokaido.proxy.rlwy.net';
$port = '24372';
$dbname = 'railway';
$username = 'root';
$password = 'LhwHETkimVDUPvtEeSLysoDwZjtPIpmn';

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
    echo "✅ Connected successfully!";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
