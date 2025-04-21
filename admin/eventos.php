<?php
require '../includes/db.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM eventos ORDER BY fecha ASC");
$eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'includes/header.php'; ?>

<div class="container mt-4">
  <h2>Eventos Disponibles</h2>

  <!-- Botón para volver al panel principal -->
  <a href="index.php" class="btn btn-secondary mb-3">← Volver al Panel Principal</a>

  <a href="agregar_evento.php" class="btn btn-success mb-3 ms-2">Agregar Nuevo Evento</a>

  <table class="table table-bordered table-hover">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Imagen</th>
        <th>Nombre</th>
        <th>Fecha</th>
        <th>Valor</th>
        <th>Descripción</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($eventos as $evento): ?>
      <tr>
        <td><?php echo $evento['id']; ?></td>
        <td>
          <?php if ($evento['imagen']): ?>
            <img src="../assets/eventos/<?php echo $evento['imagen']; ?>" alt="Evento" width="80">
          <?php else: ?>
            Sin imagen
          <?php endif; ?>
        </td>
        <td><?php echo htmlspecialchars($evento['titulo']); ?></td>
        <td><?php echo htmlspecialchars($evento['fecha']); ?></td>
        <td>$<?php echo number_format($evento['valor'], 0, ',', '.'); ?></td>
        <td><?php echo htmlspecialchars($evento['descripcion']); ?></td>
        <td>
          <a href="editar_evento.php?id=<?php echo $evento['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
          <a href="eliminar_evento.php?id=<?php echo $evento['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este evento?');">Eliminar</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php include '../includes/footer.php'; ?>
