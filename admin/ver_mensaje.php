<?php
include '../includes/db.php';
include '../includes/header.php';

if (!isset($_GET['id'])) {
    echo "<div class='alert alert-danger'>ID de mensaje no proporcionado.</div>";
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM mensajes_contacto WHERE id = ?");
$stmt->execute([$id]);
$mensaje = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$mensaje) {
    echo "<div class='alert alert-danger'>Mensaje no encontrado.</div>";
    exit;
}
?>

<div class="container mt-4">
  <h2>Mensaje de <?= htmlspecialchars($mensaje['nombre']) ?></h2>
  <a href="mensajes.php" class="btn btn-secondary mb-3">← Volver a Mensajes</a>

  <div class="card">
    <div class="card-body">
      <p><strong>Correo:</strong> <?= htmlspecialchars($mensaje['correo']) ?></p>
      <p><strong>Teléfono:</strong> <?= htmlspecialchars($mensaje['telefono']) ?></p>
      <p><strong>Mensaje:</strong></p>
      <p><?= nl2br(htmlspecialchars($mensaje['mensaje'])) ?></p>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
