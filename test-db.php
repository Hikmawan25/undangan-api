<?php
echo "Testing PostgreSQL Connection...\n";

// Test 1: Basic PDO connection
try {
    $dsn = "pgsql:host=127.0.0.1;port=5432;dbname=postgres";
    $pdo = new PDO($dsn, 'postgres', 'secret123');
    echo "✅ PDO Connection: SUCCESS\n";
} catch (PDOException $e) {
    echo "❌ PDO Connection: " . $e->getMessage() . "\n";
}

// Test 2: Socket connection
echo "\nTesting socket connection...\n";
$fp = @fsockopen('127.0.0.1', 5432, $errno, $errstr, 5);
if ($fp) {
    echo "✅ Socket Connection: SUCCESS\n";
    fclose($fp);
} else {
    echo "❌ Socket Connection: $errstr ($errno)\n";
}

// Test 3: Check available drivers
echo "\nAvailable PDO drivers:\n";
print_r(PDO::getAvailableDrivers());
