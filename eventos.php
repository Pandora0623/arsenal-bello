<?php
require 'includes/db.php';
$activo = 'eventos'; 
include 'includes/header.php';

// Obtener los eventos futuros
$stmt = $pdo->query("SELECT * FROM eventos WHERE fecha >= CURDATE() ORDER BY fecha ASC");
$eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container py-5">
  <h2 class="text-center mb-5">Próximos Eventos</h2>
  <div class="row">
    <?php foreach ($eventos as $evento): ?>
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm border-0">
          <?php if (!empty($evento['imagen'])): ?>
            <img src="assets/eventos/<?php echo htmlspecialchars($evento['imagen']); ?>" class="card-img-top" alt="Imagen del evento">
          <?php endif; ?>
          <div class="card-body">
            <h5 class="card-title"><?php echo htmlspecialchars($evento['titulo']); ?></h5>
            <p class="card-text"><?php echo htmlspecialchars($evento['descripcion']); ?></p>
          </div>
          <div class="card-footer d-flex justify-content-between align-items-center bg-light">
            <small class="text-muted">
              <i class="bi bi-calendar-event"></i>
              <?php echo date('d M Y', strtotime($evento['fecha'])); ?>
            </small>
            <small class="text-muted">
              <i class="bi bi-cash-coin"></i>
              $<?php echo number_format($evento['valor'], 0, ',', '.'); ?>
            </small>
          </div>
          <div class="card-footer bg-white border-0 text-end">
            <a href="evento_detalle.php?id=<?php echo $evento['id']; ?>" class="btn btn-primary btn-sm">
              Ver más
            </a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="text-center mt-4">
    <a href="todos_eventos.php" class="btn btn-dark">Ver todos los eventos</a>
  </div>
</div>

<?php include 'includes/footer.php'; ?>

