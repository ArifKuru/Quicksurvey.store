<?php
$host = 'localhost';
$db   = '*';  // Database Name
$user = '*';   // MySQL Username
$pass = '*';           // MySQL Pass
$charset = 'utf8mb4';      // Character set

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // ERROR MODE
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // TAKE DATA AS ARRAY
    PDO::ATTR_EMULATE_PREPARES   => false,                  // USE PREPARED STATEMENTS
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}
?>