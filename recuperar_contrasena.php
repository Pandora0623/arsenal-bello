<?php
include 'includes/header.php';
?>

<div class="container mt-5">
  <h2 class="text-center mb-4">Recuperar Contraseña</h2>
  <form action="procesar_recuperacion.php" method="POST" class="col-md-6 mx-auto">
    <div class="mb-3">
      <label class="form-label">Tipo de usuario</label>
      <select name="tipo_usuario" class="form-select" required>
        <option value="padre">Padre/Tutor</option>
        <option value="admin">Administrador</option>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Correo electrónico o Usuario</label>
      <input type="text" name="identificador" class="form-control" required>
    </div>
    <button class="btn btn-primary w-100">Enviar enlace de recuperación</button>
  </form>
</div>

<?php include 'includes/footer.php'; ?>


