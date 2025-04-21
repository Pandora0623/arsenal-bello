<?php
require '../includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: gestionar_admins.php");
    exit;
}

$id = $_GET['id'];

try {
    // Eliminar el administrador por ID
    $stmt = $pdo->prepare("DELETE FROM administradores WHERE id = ?");
    $stmt->execute([$id]);
} catch (PDOException $e) {
    echo "Error al eliminar el administrador: " . $e->getMessage();
    exit;
}

// Redirigir de vuelta a la gestión de administradores
header("Location: gestionar_admins.php");
exit;
?>
