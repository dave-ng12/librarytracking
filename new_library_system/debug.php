<?php
echo "<h2>Database Connection Debug</h2>";

// Show environment variables
echo "<h3>Environment Variables:</h3>";
echo "DB_HOST: " . (getenv('DB_HOST') ?: 'NOT SET') . "<br>";
echo "DB_PORT: " . (getenv('DB_PORT') ?: 'NOT SET') . "<br>";
echo "DB_NAME: " . (getenv('DB_NAME') ?: 'NOT SET') . "<br>";
echo "DB_USER: " . (getenv('DB_USER') ?: 'NOT SET') . "<br>";
echo "DB_PASS: " . (getenv('DB_PASS') ? 'SET (hidden)' : 'NOT SET') . "<br><br>";

// Test TCP Proxy connection
$host = getenv('DB_HOST') ?: 'tokaldo.proxy.riwy.net';
$port = getenv('DB_PORT') ?: '24372';

echo "<h3>Testing TCP Connection:</h3>";
$fp = @fsockopen($host, $port, $errno, $errstr, 5);
if ($fp) {
    echo "✅ Can reach MySQL server!<br>";
    fclose($fp);
} else {
    echo "❌ Cannot reach MySQL server: $errstr ($errno)<br>";
}

// Test PDO connection
echo "<h3>Testing PDO Connection:</h3>";
try {
    $dbname = getenv('DB_NAME') ?: 'railway';
    $username = getenv('DB_USER') ?: 'root';
    $password = getenv('DB_PASS') ?: '';
    
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo "✅ PDO Connection successful!<br>";
    
    $stmt = $pdo->query("SELECT DATABASE() as db");
    $row = $stmt->fetch();
    echo "Connected to database: " . $row['db'] . "<br>";
} catch (PDOException $e) {
    echo "❌ PDO Error: " . $e->getMessage() . "<br>";
}
?>
