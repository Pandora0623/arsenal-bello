<?php
include '../includes/db.php';
include '../includes/header.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}

$mensaje = '';
$directorio = "../assets/eventos/";

// Verificar si se envió un ID de evento
if (!isset($_GET['id'])) {
    echo "<div class='alert alert-danger'>ID de evento no proporcionado.</div>";
    exit;
}

$id_evento = $_GET['id'];

// Obtener datos actuales del evento
$stmt = $pdo->prepare("SELECT * FROM eventos WHERE id = ?");
$stmt->execute([$id_evento]);
$evento = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$evento) {
    echo "<div class='alert alert-danger'>Evento no encontrado.</div>";
    exit;
}

// Procesar actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $fecha = $_POST['fecha'];
    $valor = $_POST['valor'];
    $descripcion = trim($_POST['descripcion']);

    $imagenNombre = $evento['imagen']; // mantener la imagen existente

    if (!empty($_FILES['imagen']['name'])) {
        $nuevoNombre = time() . "_" . basename($_FILES["imagen"]["name"]);
        $rutaDestino = $directorio . $nuevoNombre;

        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaDestino)) {
            // Eliminar la imagen anterior si existía
            if (!empty($evento['imagen']) && file_exists($directorio . $evento['imagen'])) {
                unlink($directorio . $evento['imagen']);
            }
            $imagenNombre = $nuevoNombre;
        }
    }

    try {
        $stmt = $pdo->prepare("UPDATE eventos SET titulo = ?, fecha = ?, valor = ?, descripcion = ?, imagen = ? WHERE id = ?");
        $stmt->execute([$titulo, $fecha, $valor, $descripcion, $imagenNombre, $id_evento]);

        // Redirigir al listado de eventos con mensaje (opcionalmente se puede usar una sesión flash para mostrar mensaje)
        header("Location: eventos.php");
        exit;

    } catch (PDOException $e) {
        $mensaje = "Error al actualizar el evento: " . $e->getMessage();
    }
}
?>

<div class="container mt-4">
  <h2>Editar Evento</h2>

  <?php if ($mensaje): ?>
    <div class="alert alert-info"><?php echo $mensaje; ?></div>
  <?php endif; ?>

  <form method="POST" enctype="multipart/form-data" class="col-md-8">
    <div class="mb-3">
      <label class="form-label">Nombre del evento</label>
      <input type="text" name="titulo" class="form-control" value="<?php echo htmlspecialchars($evento['titulo']); ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Fecha</label>
      <input type="date" name="fecha" class="form-control" value="<?php echo $evento['fecha']; ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Valor</label>
      <input type="number" name="valor" class="form-control" value="<?php echo $evento['valor']; ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Descripción</label>
      <textarea name="descripcion" class="form-control" rows="4"><?php echo htmlspecialchars($evento['descripcion']); ?></textarea>
    </div>
    <div class="mb-3">
      <label class="form-label">Imagen actual</label><br>
      <?php if ($evento['imagen']): ?>
        <img src="../assets/eventos/<?php echo $evento['imagen']; ?>" alt="Evento" width="150">
      <?php else: ?>
        <span>No hay imagen</span>
      <?php endif; ?>
    </div>
    <div class="mb-3">
      <label class="form-label">Cambiar imagen</label>
      <input type="file" name="imagen" class="form-control" accept="image/*">
    </div>

    <button type="submit" class="btn btn-primary">Actualizar Evento</button>
    <a href="eventos.php" class="btn btn-secondary">Cancelar</a>
  </form>
</div>

<?php include '../includes/footer.php'; ?>
