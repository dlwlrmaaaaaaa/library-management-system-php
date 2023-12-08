<?php
$dbname = 'lms';
$dbuser = 'root';
$dbpass = '';
$dbhost = 'localhost';
$dsn = "mysql:host=$dbhost;dbname=$dbname";
try {
    $pdo = new PDO($dsn, $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
} catch (PDOException $e) {
    echo $e->getMessage();
}


?>