<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

require '../includes/db.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario']);
    $clave = trim($_POST['clave']);
    $clave_encriptada = password_hash($clave, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO administradores (usuario, clave) VALUES (?, ?)");
        $stmt->execute([$usuario, $clave_encriptada]);
        $mensaje = "Nuevo administrador creado con éxito.";
    } catch (PDOException $e) {
        $mensaje = "Error al crear el administrador: " . $e->getMessage();
    }
}
?>

<?php include '../includes/header.php'; ?>

<div class="container mt-5">
  <h2>Crear Nuevo Administrador</h2>

  <?php if ($mensaje): ?>
    <div class="alert alert-info"><?php echo $mensaje; ?></div>
  <?php endif; ?>

  <form method="POST" class="col-md-6 mx-auto mt-4">
    <div class="mb-3">
      <label class="form-label">Usuario</label>
      <input type="text" name="usuario" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Contraseña</label>
      <input type="password" name="clave" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Crear Administrador</button>
  </form>

  <div class="mt-3">
    <a href="index.php" class="btn btn-secondary">← Volver al Panel</a>
  </div>
</div>

<?php include '../includes/footer.php'; ?>

