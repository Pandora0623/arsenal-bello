<?php

if ($_SERVER['HTTP_HOST'] =='localhost'){
$host = 'localhost';
$db = 'arsenalbello';
$user = 'root';
$pass = ''; // o tu contraseña
} else {
$host = 'localhost';
$db = 'u499753567_arsenalbello';
$user = 'u499753567_stefania';
$pass = 'Venus0623.'; // o tu contraseña
}
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
