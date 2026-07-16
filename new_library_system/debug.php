<?php
echo "<h2>Database Connection Debug</h2>";

// Direct connection test (no environment variables)
$host = 'tokaido.proxy.rlwy.net';
$port = '24372';
$dbname = 'railway';
$username = 'root';
$password = 'LhWHEtK1mVDUPvTEeSLysoDwZjtPIPem';

echo "<h3>Testing Direct Connection:</h3>";
echo "Host: $host<br>";
echo "Port: $port<br>";
echo "Database: $dbname<br>";
echo "Username: $username<br><br>";

// Test TCP connection
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
