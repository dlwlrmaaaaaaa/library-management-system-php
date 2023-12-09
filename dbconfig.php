<?php
$dbname = 'lms';
$dbuser = 'root';
$dbpass = '';
$dbhost = 'localhost';
$dsn = "mysql:host=$dbhost;dbname=$dbname";
try {
    $pdo = new PDO($dsn, $dbuser, $dbpass);
} catch (PDOException $e) {
    echo $e->getMessage();
}


?>