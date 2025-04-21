<?php
session_start();
require 'includes/db.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $telefono = trim($_POST['telefono']);
    $clave = hash('sha256', trim($_POST['clave'])); // Encriptar contraseña

    // Verificar si el correo ya está registrado
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE correo = ?");
    $stmt->execute([$correo]);
    if ($stmt->fetch()) {
        $mensaje = "Ya existe un usuario con este correo.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, correo, telefono, clave) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nombre, $correo, $telefono, $clave]);
            $mensaje = "Registro exitoso. Ya puedes iniciar sesión.";
        } catch (PDOException $e) {
            $mensaje = "Error al registrar: " . $e->getMessage();
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

<h2>Registro de Padre/Tutor</h2>

<?php if ($mensaje): ?>
  <div class="alert alert-info"><?php echo $mensaje; ?></div>
<?php endif; ?>

<form method="POST" class="col-md-6 mx-auto">
  <div class="mb-3">
    <label for="nombre" class="form-label">Nombre completo</label>
    <input type="text" name="nombre" id="nombre" class="form-control" required>
  </div>
  <div class="mb-3">
    <label for="correo" class="form-label">Correo electrónico</label>
    <input type="email" name="correo" id="correo" class="form-control" required>
  </div>
  <div class="mb-3">
    <label for="telefono" class="form-label">Teléfono</label>
    <input type="text" name="telefono" id="telefono" class="form-control" required>
  </div>
  <div class="mb-3">
    <label for="clave" class="form-label">Contraseña</label>
    <input type="password" name="clave" id="clave" class="form-control" required>
  </div>
  <button class="btn btn-primary w-100">Registrarse</button>
</form>

<?php include 'includes/footer.php'; ?>
