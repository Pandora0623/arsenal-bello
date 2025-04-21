<?php
session_start();
include 'includes/db.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo']);
    $clave = trim($_POST['clave']);
    $clave_hash = hash('sha256', $clave);

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE correo = ? AND clave = ?");
    $stmt->execute([$correo, $clave_hash]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];
        header("Location: pagos.php");
        exit;
    } else {
        $mensaje = "Correo o contraseña incorrectos.";
    }
}
?>

<?php include 'includes/header.php'; ?>

<h2>Iniciar Sesión - Padres</h2>

<?php if ($mensaje): ?>
  <div class="alert alert-danger"><?php echo $mensaje; ?></div>
<?php endif; ?>

<form method="POST" class="col-md-6 mx-auto">
  <div class="mb-3">
    <label for="correo" class="form-label">Correo electrónico</label>
    <input type="email" name="correo" id="correo" class="form-control" required>
  </div>
  <div class="mb-3">
    <label for="clave" class="form-label">Contraseña</label>
    <input type="password" name="clave" id="clave" class="form-control" required>
  </div>
  <button class="btn btn-primary w-100">Ingresar</button>
</form>

<?php include 'includes/footer.php'; ?>
