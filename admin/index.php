<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}
include '../includes/db.php';
include 'includes/header.php';
?>

<div class="container mt-4">
  <h2>Panel de Administración</h2>
  <p class="lead">Bienvenido, <?php echo $_SESSION['admin_nombre'] ?? 'Administrador'; ?>.</p>

  <div class="row g-4">
    <div class="col-md-3">
      <div class="card border-primary h-100">
        <div class="card-body">
          <h5 class="card-title">Usuarios</h5>
          <p class="card-text">Padres o tutores registrados</p>
          <a href="usuarios.php" class="btn btn-primary w-100">Gestionar</a>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card border-success h-100">
        <div class="card-body">
          <h5 class="card-title">Pagos</h5>
          <p class="card-text">Historial completo</p>
          <a href="pagos.php" class="btn btn-success w-100">Ver pagos</a>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card border-warning h-100">
        <div class="card-body">
          <h5 class="card-title">Eventos</h5>
          <p class="card-text">Crear, editar y eliminar</p>
          <a href="eventos.php" class="btn btn-warning w-100">Eventos</a>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card border-info h-100">
        <div class="card-body">
          <h5 class="card-title">Mensajes</h5>
          <p class="card-text">Contacto recibidos</p>
          <a href="mensajes.php" class="btn btn-info w-100">Mensajes</a>
        </div>
      </div>
    </div>

    <!-- ✅ Administradores con mismo estilo -->
    <div class="col-md-3">
      <div class="card border-secondary h-100">
        <div class="card-body">
          <h5 class="card-title">Administradores</h5>
          <p class="card-text">Crear o gestionar accesos</p>
          <a href="gestionar_admins.php" class="btn btn-outline-dark w-100">Gestionar Administradores</a>
        </div>
      </div>
    </div>

  </div>
</div>

<?php include '../includes/footer.php'; ?>


