<?php 
$activo = 'contacto';
include 'includes/header.php'; 
include 'includes/db.php'; 
require 'includes/enviar_correo.php'; 

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $telefono = trim($_POST['telefono']);
    $comentario = trim($_POST['mensaje']);

    try {
        $stmt = $pdo->prepare("INSERT INTO mensajes_contacto (nombre, correo, telefono, mensaje) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nombre, $correo, $telefono, $comentario]);
    } catch (PDOException $e) {
        $mensaje = "Error al guardar el mensaje: " . $e->getMessage();
    }

    $asunto = "Nuevo mensaje de contacto";
    $mensaje_html = "
        <h3>Nuevo mensaje desde el formulario de contacto</h3>
        <p><strong>Nombre:</strong> {$nombre}</p>
        <p><strong>Correo:</strong> {$correo}</p>
        <p><strong>Teléfono:</strong> {$telefono}</p>
        <p><strong>Mensaje:</strong><br>{$comentario}</p>
    ";

    $admin_email = "escuelafutbol@correo.com"; // Cambiar por correo real

    if (enviarCorreo($admin_email, $asunto, $mensaje_html)) {
        $mensaje = "Tu mensaje ha sido enviado y registrado. Pronto te contactaremos.";
    } else {
        $mensaje = "Tu mensaje se registró, pero hubo un error al enviarlo por correo.";
    }
}
?>

<div class="container mt-5">
  <!-- ✅ Título alineado con los campos -->
  <div class="col-md-8 mx-auto">
    <h2 class="mb-4">Contáctanos</h2>

    <?php if ($mensaje): ?>
      <div class="alert alert-info"><?php echo $mensaje; ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Correo electrónico</label>
        <input type="email" name="correo" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Teléfono</label>
        <input type="text" name="telefono" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Mensaje</label>
        <textarea name="mensaje" class="form-control" rows="5" required></textarea>
      </div>
      <button class="btn btn-primary">Enviar mensaje</button>
    </form>
  </div>

  <!-- 🎯 Preguntas Frecuentes -->
  <div class="col-md-10 mx-auto mt-5">
    <h3 class="text-center mb-4">Preguntas Frecuentes</h3>
    <div class="accordion" id="faqAccordion">
      <div class="accordion-item">
        <h2 class="accordion-header" id="faq1">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
            ¿Cuál es el horario de entrenamientos?
          </button>
        </h2>
        <div id="collapse1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            Los entrenamientos se realizan de lunes a viernes en horarios de tarde, y los sábados en la mañana según la categoría.
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header" id="faq2">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
            ¿Cuál es el valor mensual de la escuela?
          </button>
        </h2>
        <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            El valor mensual es de $120.000 COP. Este incluye entrenamientos, seguro deportivo y participación en eventos locales.
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header" id="faq3">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
            ¿Desde qué edad se pueden inscribir los niños?
          </button>
        </h2>
        <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            A partir de los 4 años en adelante. Las categorías están organizadas por edades: Sub-6, Sub-8, Sub-10, etc.
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
