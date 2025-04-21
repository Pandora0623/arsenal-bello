<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

require '../includes/db.php';

$mensaje = '';

// Eliminar administrador
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $pdo->prepare("DELETE FROM administradores WHERE id = ?")->execute([$id]);
    $mensaje = "✅ Administrador eliminado correctamente.";
}

// Crear nuevo administrador
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear'])) {
    $usuario = trim($_POST['usuario']);
    $clave = trim($_POST['clave']);
    $clave_encriptada = password_hash($clave, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO administradores (usuario, clave) VALUES (?, ?)");
        $stmt->execute([$usuario, $clave_encriptada]);
        $mensaje = "✅ Nuevo administrador creado con éxito.";
    } catch (PDOException $e) {
        $mensaje = "❌ Error al crear el administrador: " . $e->getMessage();
    }
}

// Obtener lista de administradores
$admins = $pdo->query("SELECT id, usuario FROM administradores ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include '../includes/header.php'; ?>

<div class="container mt-5">
  <h2 class="mb-4">Gestionar Administradores</h2>

  <?php if ($mensaje): ?>
    <div class="alert alert-info"><?= $mensaje ?></div>
  <?php endif; ?>

  <!-- Formulario para crear nuevo administrador -->
  <form method="POST" class="col-md-6 mb-4">
    <h4>Nuevo Administrador</h4>
    <div class="mb-3">
      <label class="form-label">Usuario</label>
      <input type="text" name="usuario" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Contraseña</label>
      <input type="password" name="clave" class="form-control" required>
    </div>
    <button type="submit" name="crear" class="btn btn-primary">Crear Administrador</button>
  </form>

  <!-- Tabla de administradores existentes -->
  <h4 class="mt-5">Administradores Existentes</h4>
  <table class="table table-bordered table-hover">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Usuario</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($admins as $admin): ?>
        <tr>
          <td><?= $admin['id'] ?></td>
          <td><?= htmlspecialchars($admin['usuario']) ?></td>
          <td>
            <a href="editar_admin.php?id=<?= $admin['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
            <a href="?eliminar=<?= $admin['id'] ?>" 
               class="btn btn-danger btn-sm" 
               onclick="return confirm('¿Estás seguro de que deseas eliminar este administrador?');">
               Eliminar
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <a href="index.php" class="btn btn-secondary mt-3">← Volver al Panel Principal</a>
</div>

<?php include '../includes/footer.php'; ?>

