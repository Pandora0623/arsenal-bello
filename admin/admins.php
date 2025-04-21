<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}

include '../includes/db.php';

// Eliminar administrador si se envía ID por GET
if (isset($_GET['eliminar'])) {
    $id = (int) $_GET['eliminar'];
    $stmt = $pdo->prepare("DELETE FROM administradores WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: gestionar_admins.php");
    exit;
}

$admins = $pdo->query("SELECT * FROM administradores")->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include '../includes/header.php'; ?>

<div class="container mt-4">
  <h2>Administradores</h2>
  <a href="crear_admin.php" class="btn btn-success mb-3">+ Nuevo Administrador</a>
  <table class="table table-bordered table-striped">
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
            <a href="gestionar_admins.php?eliminar=<?= $admin['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este administrador?')">Eliminar</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php include '../includes/footer.php'; ?>
