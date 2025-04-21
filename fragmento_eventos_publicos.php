<?php
require_once 'includes/db.php';

$stmt = $pdo->query("SELECT * FROM eventos ORDER BY fecha ASC");
$eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="row">
  <?php foreach ($eventos as $evento): ?>
    <div class="col-md-4 mb-4">
      <div class="card h-100 shadow-sm">
        <?php if (!empty($evento['imagen']) && file_exists('uploads/' . $evento['imagen'])): ?>
          <img src="uploads/<?php echo htmlspecialchars($evento['imagen']); ?>" class="card-img-top" alt="Imagen del evento">
        <?php else: ?>
          <img src="assets/img/default-event.jpg" class="card-img-top" alt="Sin imagen">
        <?php endif; ?>
        <div class="card-body">
          <h5 class="card-title"><?php echo htmlspecialchars($evento['titulo']); ?></h5>
          <p class="card-text"><?php echo htmlspecialchars($evento['descripcion']); ?></p>
        </div>
        <div class="card-footer text-muted d-flex justify-content-between">
          <small>📅 <?php echo date("d/m/Y", strtotime($evento['fecha'])); ?></small>
          <small>💰 $<?php echo number_format($evento['valor'], 0, ',', '.'); ?></small>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
