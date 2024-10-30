<?php

$host = "localhost";
$user = "root";
$password = "";
$dbname = "ramenlamig";
$dsn = "mysql:host={$host};dbname={$dbname}";

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET time_zone = '+08:00';");
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit(); // Stop the script if the connection fails
}

?>
