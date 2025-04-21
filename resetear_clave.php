<?php
require 'includes/db.php';

$token = $_GET['token'] ?? null;
$mensaje = '';
$mostrarFormulario = false;

if ($token) {
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE token_recuperacion = ? AND token_expira > NOW()");
    $stmt->execute([$token]);
    $usuario = $stmt->fetch();

    if ($usuario) {
        $mostrarFormulario = true;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nueva_clave = trim($_POST['clave']);
            $clave_segura = hash('sha256', $nueva_clave);

            $stmt = $pdo->prepare("UPDATE usuarios SET clave = ?, token_recuperacion = NULL, token_expira = NULL WHERE id = ?");
            $stmt->execute([$clave_segura, $usuario['id']]);

            $mensaje = "Tu contraseña ha sido actualizada correctamente.";
            $mostrarFormulario = false;
        }
    } else {
        $mensaje = "Este enlace es inválido o ha expirado.";
    }
} else {
    $mensaje = "Token no válido.";
}
?>

<?php include 'includes/header.php'; ?>

<h2>Restablecer contraseña</h2>

<?php if ($mensaje): ?>
  <div class="alert alert-<?php echo $mostrarFormulario ? 'warning' : 'info'; ?>">
    <?php echo $mensaje; ?>
  </div>
<?php endif; ?>

<?php if ($mostrarFormulario): ?>
  <form method="POST" class="col-md-6 mx-auto">
    <div class="mb-3">
      <label class="form-label">Nueva contraseña</label>
      <input type="password" name="clave" class="form-control" required>
    </div>
    <button class="btn btn-primary w-100">Guardar nueva contraseña</button>
  </form>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
