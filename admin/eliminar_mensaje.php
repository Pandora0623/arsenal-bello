<?php
require '../includes/db.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM mensajes_contacto WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: mensajes.php?eliminado=1");
        exit;
    } catch (PDOException $e) {
        echo "Error al eliminar el mensaje: " . $e->getMessage();
    }
} else {
    echo "ID de mensaje no especificado.";
}
