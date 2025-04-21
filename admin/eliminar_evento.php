<?php
require '../includes/db.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: eventos.php");
    exit();
}

$id = intval($_GET['id']);

try {
    $stmt = $pdo->prepare("DELETE FROM eventos WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: eventos.php");
    exit();
} catch (PDOException $e) {
    echo "Error al eliminar el evento: " . $e->getMessage();
}
?>
