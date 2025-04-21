<?php
require 'includes/db.php';
session_start();

$mensaje = '';
$tipo = $_GET['tipo'] ?? '';
token:
$token = $_GET['token'] ?? '';

if (!$tipo || !$token) {
    echo "<div class='alert alert-danger'>Token inválido o tipo no especificado.</div>";
    exit;
}

// Validar token y obtener usuario
$tabla = $tipo === 'admin' ? 'administradores' : 'usuarios';
$stmt = $pdo->prepare("SELECT * FROM $tabla WHERE token_recuperacion = ? AND token_expira > NOW()");
$stmt->execute([$token]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    echo "<div class='alert alert-danger'>Token inválido o expirado.</div>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nueva_clave = $_POST['nueva_clave'];
    $confirmar = $_POST['confirmar_clave'];

    if ($nueva_clave !== $confirmar) {
        $mensaje = "Las contraseñas no coinciden.";
    } else {
        $clave_hash = password_hash($nueva_clave, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE $tabla SET clave = ?, token_recuperacion = NULL, token_expira = NULL WHERE id = ?");
        $stmt->execute([$clave_hash, $usuario['id']]);

        $mensaje = "Contraseña actualizada con éxito. Puedes iniciar sesión.";
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="container mt-5">
  <h2>Restablecer Contraseña</h2>

  <?php if ($mensaje): ?>
    <div class="alert alert-info"><?php echo $mensaje; ?></div>
  <?php endif; ?>

  <form method="POST" class="col-md-6 mx-auto">
    <div class="mb-3">
      <label class="form-label">Nueva contraseña</label>
      <input type="password" name="nueva_clave" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Confirmar contraseña</label>
      <input type="password" name="confirmar_clave" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Actualizar Contraseña</button>
  </form>
</div>

<?php include 'includes/footer.php'; ?>
