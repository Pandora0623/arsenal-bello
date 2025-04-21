<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

require '../includes/db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    echo "ID inválido.";
    exit;
}

// Obtener datos actuales del admin
$stmt = $pdo->prepare("SELECT * FROM administradores WHERE id = ?");
$stmt->execute([$id]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$admin) {
    echo "Administrador no encontrado.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario']);
    $nueva_clave = trim($_POST['clave']);

    // Actualiza usuario
    $stmt = $pdo->prepare("UPDATE administradores SET usuario = ? WHERE id = ?");
    $stmt->execute([$usuario, $id]);

    // Si se proporciona nueva contraseña, se actualiza
    if (!empty($nueva_clave)) {
        $clave_encriptada = password_hash($nueva_clave, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE administradores SET clave = ? WHERE id = ?");
        $stmt->execute([$clave_encriptada, $id]);
    }

    // 🔁 Redirige a la página de gestión con mensaje opcional
    header("Location: gestionar_admins.php?editado=1");
    exit;
}
?>

<?php include '../includes/header.php'; ?>

<div class="container mt-5">
  <h2>Editar Administrador</h2>

  <form method="POST" class="col-md-6">
    <div class="mb-3">
      <label class="form-label">Usuario</label>
      <input type="text" name="usuario" class="form-control" value="<?= htmlspecialchars($admin['usuario']) ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Nueva Contraseña (deja en blanco si no quieres cambiarla)</label>
      <input type="password" name="clave" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    <a href="gestionar_admins.php" class="btn btn-secondary">Cancelar</a>
  </form>
</div>

<?php include '../includes/footer.php'; ?>
