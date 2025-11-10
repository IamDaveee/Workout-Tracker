<?php

$dsn="mysql:host=localhost;dbname=workout_tracker";
$dbusername="root";
$dbpassword="";

try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword); //Connection
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //error handling
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

