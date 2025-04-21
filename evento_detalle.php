<?php
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='alert alert-danger'>Evento no válido</div>";
    include 'includes/footer.php';
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM eventos WHERE id = ?");
$stmt->execute([$id]);
$evento = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$evento) {
    echo "<div class='alert alert-warning'>Evento no encontrado</div>";
    include 'includes/footer.php';
    exit;
}
?>

<div class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <?php if (!empty($evento['imagen']) && file_exists("assets/eventos/" . $evento['imagen'])): ?>
          <img src="assets/eventos/<?php echo htmlspecialchars($evento['imagen']); ?>" class="card-img-top" alt="Imagen del evento">
        <?php else: ?>
          <img src="assets/eventos/default.jpg" class="card-img-top" alt="Imagen por defecto">
        <?php endif; ?>

        <div class="card-body">
          <h3 class="card-title"><?php echo htmlspecialchars($evento['titulo']); ?></h3>
          <p class="card-text"><?php echo nl2br(htmlspecialchars($evento['descripcion'])); ?></p>
          <p class="card-text">
            <i class="bi bi-calendar-event"></i> <strong>Fecha:</strong> <?php echo date('d M Y', strtotime($evento['fecha'])); ?><br>
            <i class="bi bi-cash-coin"></i> <strong>Valor:</strong> $<?php echo number_format($evento['valor'], 0, ',', '.'); ?>
          </p>
        </div>
      </div>

      <div class="text-center mt-3">
        <a href="eventos.php" class="btn btn-secondary">Volver a Eventos</a>
      </div>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
