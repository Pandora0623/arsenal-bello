<?php
require 'includes/db.php';

$mensaje = '';
$valido = false;
$token = $_GET['token'] ?? '';

if ($token) {
    // Verificamos si el token existe y no ha expirado
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE token_recuperacion = ? AND token_expira > NOW()");
    $stmt->execute([$token]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        $valido = true;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nueva_clave = $_POST['nueva_clave'];
            $clave_hash = password_hash($nueva_clave, PASSWORD_DEFAULT);

            $actualizar = $pdo->prepare("UPDATE usuarios SET clave = ?, token_recuperacion = NULL, token_expira = NULL WHERE id = ?");
            $actualizar->execute([$clave_hash, $usuario['id']]);

            header("Location: login.php?mensaje=clave_actualizada");
            exit;
        }
    } else {
        $mensaje = "Token no válido o expirado.";
    }
} else {
    $mensaje = "Token no proporcionado.";
}
?>

<?php include 'includes/header.php'; ?>
<div class="container mt-5">
  <h2>Actualizar Contraseña</h2>

  <?php if ($mensaje): ?>
    <div class="alert alert-danger"> <?= $mensaje ?> </div>
  <?php endif; ?>

  <?php if ($valido): ?>
  <form method="POST" class="col-md-6 mx-auto">
    <div class="mb-3">
      <label>Nueva Contraseña</label>
      <input type="password" name="nueva_clave" class="form-control" required>
    </div>
    <button class="btn btn-primary">Actualizar Contraseña</button>
  </form>
  <?php endif; ?>
</div>
<?php include 'includes/footer.php'; ?>
