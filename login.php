<?php
session_start();
include 'includes/db.php';
$activo = 'login'; 


$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo_usuario = $_POST['tipo_usuario'];
    $correo = trim($_POST['correo']);
    $clave = $_POST['clave'];

    if ($tipo_usuario === 'padre') {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE correo = ?");
    } else {
        $stmt = $pdo->prepare("SELECT * FROM administradores WHERE usuario = ?");
    }

    $stmt->execute([$correo]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($clave, $usuario['clave'])) {
        if ($tipo_usuario === 'padre') {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            header("Location: pagos.php");
        } else {
            $_SESSION['admin'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['usuario'];
            header("Location: admin/index.php");
        }
        exit;
    } else {
        $mensaje = "Credenciales incorrectas.";
    }
}
?>

<?php include 'includes/header.php'; ?>
<div class="col-md-5 mx-auto my-5 p-4 shadow rounded bg-light">
  <h2 class="text-center">Iniciar Sesión</h2>

  <?php if ($mensaje): ?>
    <div class="alert alert-danger"><?php echo $mensaje; ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Tipo de usuario</label>
      <select name="tipo_usuario" class="form-select" required>
        <option value="padre">Padre/Tutor</option>
        <option value="admin">Administrador</option>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Correo electrónico o Usuario</label>
      <input type="text" name="correo" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Contraseña</label>
      <input type="password" name="clave" class="form-control" required>
    </div>
    <button class="btn btn-primary w-100">Ingresar</button>
  </form>

  <div class="text-center mt-3">
    <a href="recuperar_clave.php" class="text-decoration-none">
      🔑 ¿Olvidaste tu contraseña?
    </a>
  </div>
</div>
<?php include 'includes/footer.php'; ?>
