<?php
require 'includes/db.php';
$activo = 'inscripciones'; 
include 'includes/header.php';
require 'includes/enviar_correo.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_padre = $_POST['nombre_padre'];
    $tipo_documento = $_POST['tipo_documento'];
    $numero_documento = $_POST['numero_documento'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];

    $nombre_nino = $_POST['nombre_nino'];
    $tipo_doc_nino = $_POST['tipo_doc_nino'];
    $numero_doc_nino = $_POST['numero_doc_nino'];
    $edad = $_POST['edad'];
    $categoria = $_POST['categoria'];
    $observaciones = $_POST['observaciones'];

    $clave_plana = bin2hex(random_bytes(4));
    $clave_encriptada = password_hash($clave_plana, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, tipo_documento, numero_documento, correo, telefono, observaciones, clave) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nombre_padre, $tipo_documento, $numero_documento, $correo, $telefono, $observaciones, $clave_encriptada]);
        $usuario_id = $pdo->lastInsertId();

        $stmt = $pdo->prepare("INSERT INTO hijos (usuario_id, nombre, tipo_documento, numero_documento, edad, categoria) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$usuario_id, $nombre_nino, $tipo_doc_nino, $numero_doc_nino, $edad, $categoria]);

        $asunto = "Inscripción confirmada - Escuela de Fútbol";
        $mensaje_html = "
            <h3>Hola {$nombre_padre},</h3>
            <p>Tu inscripción se ha registrado exitosamente. Aquí tienes los datos de acceso para que puedas ingresar a tu cuenta como padre/tutor:</p>
            <ul>
                <li><strong>Usuario:</strong> {$correo}</li>
                <li><strong>Contraseña:</strong> {$clave_plana}</li>
            </ul>
            <p>También se ha registrado la inscripción de tu hijo(a):</p>
            <ul>
                <li><strong>Nombre:</strong> {$nombre_nino}</li>
                <li><strong>Tipo de documento:</strong> {$tipo_doc_nino}</li>
                <li><strong>Número de documento:</strong> {$numero_doc_nino}</li>
                <li><strong>Edad:</strong> {$edad}</li>
                <li><strong>Categoría:</strong> {$categoria}</li>
            </ul>
            <p>¡Bienvenido a la familia de la Escuela de Fútbol Arsenal Bello! ⚽</p>
        ";

        enviarCorreo($correo, $asunto, $mensaje_html);

        $mensaje = "Inscripción registrada correctamente. Se ha enviado confirmación por correo con usuario y clave.";
    } catch (PDOException $e) {
        $mensaje = "Error al registrar la inscripción: " . $e->getMessage();
    }
}
?>

<!-- ✅ Contenedor para separar del borde -->
<div class="form-wrapper">
  <h2>Formulario de Inscripción</h2>

  <?php if ($mensaje): ?>
    <div class="alert alert-info"><?php echo $mensaje; ?></div>
  <?php endif; ?>

  <form method="POST">
    <h5>Datos del Padre/Tutor</h5>
    <div class="mb-3">
      <label class="form-label">Nombre completo</label>
      <input type="text" class="form-control" name="nombre_padre" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Tipo de documento</label>
      <select class="form-select" name="tipo_documento" required>
        <option value="">Seleccionar</option>
        <option value="CC">Cédula de Ciudadanía</option>
        <option value="TI">Tarjeta de Identidad</option>
        <option value="CE">Cédula de Extranjería</option>
        <option value="PP">Pasaporte</option>
        <option value="Otro">Otro</option>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Número de documento</label>
      <input type="text" class="form-control" name="numero_documento" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Correo electrónico</label>
      <input type="email" class="form-control" name="correo" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Teléfono</label>
      <input type="text" class="form-control" name="telefono" required>
    </div>

    <h5>Datos del Niño(a)</h5>
    <div class="mb-3">
      <label class="form-label">Nombre</label>
      <input type="text" class="form-control" name="nombre_nino" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Tipo de documento</label>
      <select class="form-select" name="tipo_doc_nino" required>
        <option value="">Seleccionar</option>
        <option value="RC">Registro Civil</option>
        <option value="TI">Tarjeta de Identidad</option>
        <option value="Otro">Otro</option>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Número de documento</label>
      <input type="text" class="form-control" name="numero_doc_nino" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Edad</label>
      <input type="number" class="form-control" name="edad" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Categoría</label>
      <select name="categoria" class="form-control" required>
        <option value="">Seleccionar</option>
        <option value="Sub-6">Sub-6</option>
        <option value="Sub-8">Sub-8</option>
        <option value="Sub-10">Sub-10</option>
        <option value="Sub-12">Sub-12</option>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Observaciones adicionales</label>
      <textarea class="form-control" name="observaciones" rows="3" placeholder="Escribe aquí si hay algo que debamos saber..."></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Enviar Inscripción</button>
  </form>
</div>

<!-- ✅ Estilo adicional para separar del borde -->
<style>
  .form-wrapper {
    padding: 40px 20px;
    max-width: 900px;
    margin: 0 auto;
    background-color: #fff;
    border-radius: 10px;
  }
</style>

<?php include 'includes/footer.php'; ?>
