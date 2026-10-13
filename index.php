<?php
// Quick check that PHP and MySQL are working.
// XAMPP default MySQL login: user "root", empty password.
$host = '127.0.0.1';
$user = 'root';
$pass = 'bartunak123';

echo "<h1>PHP is working!</h1>";
echo "<p>PHP version: " . phpversion() . "</p>";

try {
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $user, $pass);
    $version = $pdo->query('SELECT VERSION()')->fetchColumn();
    echo "<p style='color:green'>Connected to MySQL/MariaDB $version</p>";
} catch (PDOException $e) {
    echo "<p style='color:red'>MySQL connection failed: " . htmlspecialchars($e->getMessage()) . "</p>";
}
