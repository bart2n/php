<?php
// Database connection, shared by every page.
// Other files load it with:  require 'db.php';

$host = '127.0.0.1';
$dbname = 'learning';
$user = 'root';
$pass = 'bartunak123';

$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,       // show errors instead of failing silently
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,  // rows come back as ['column' => value]
]);
