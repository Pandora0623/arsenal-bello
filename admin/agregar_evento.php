<?php
include '../includes/db.php';
include '../includes/header.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $fecha = $_POST['fecha'];
    $valor = $_POST['valor'];
    $imagen = null;

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $nombreArchivo = time() . '_' . basename($_FILES['imagen']['name']);
        $rutaDestino = '../assets/eventos/' . $nombreArchivo;

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
            $imagen = $nombreArchivo;
        }
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO eventos (titulo, descripcion, fecha, valor, imagen, creado_en) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$titulo, $descripcion, $fecha, $valor, $imagen]);
        header("Location: eventos.php");
        exit;
    } catch (PDOException $e) {
        $mensaje = "❌ Error: " . $e->getMessage();
    }
}
?>

<h2>Agregar Nuevo Evento</h2>

<?php if ($mensaje): ?>
  <div class="alert alert-info"><?php echo $mensaje; ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data" class="col-md-8 mx-auto">
  <div class="mb-3">
    <label class="form-label">Nombre del evento</label>
    <input type="text" name="titulo" class="form-control" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Fecha</label>
    <input type="date" name="fecha" class="form-control" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Valor</label>
    <input type="number" name="valor" class="form-control" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Descripción</label>
    <textarea name="descripcion" class="form-control" rows="4"></textarea>
  </div>

  <div class="mb-3">
    <label class="form-label">Imagen del evento</label>
    <input type="file" name="imagen" class="form-control">
  </div>

  <button class="btn btn-primary">Agregar Evento</button>
</form>

<?php include '../includes/footer.php'; ?>
