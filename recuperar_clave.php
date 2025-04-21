<?php
require 'includes/db.php';
require 'includes/enviar_correo.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo']);
    $tipo = $_POST['tipo_usuario'];

    if ($tipo === 'padre') {
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE correo = ?");
    } else {
        $stmt = $pdo->prepare("SELECT id FROM administradores WHERE usuario = ?");
    }

    $stmt->execute([$correo]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        $token = bin2hex(random_bytes(32));
        $expira = date('Y-m-d H:i:s', strtotime('+1 hour'));

        if ($tipo === 'padre') {
            $pdo->prepare("UPDATE usuarios SET token_recuperacion = ?, token_expira = ? WHERE id = ?")
                ->execute([$token, $expira, $usuario['id']]);
            $url = "http://localhost/arsenal-bello/actualizar_clave.php?token=$token&tipo=padre";
        } else {
            $pdo->prepare("UPDATE administradores SET token_recuperacion = ?, token_expira = ? WHERE id = ?")
                ->execute([$token, $expira, $usuario['id']]);
            $url = "http://localhost/arsenal-bello/actualizar_clave.php?token=$token&tipo=admin";
        }

        $asunto = "Recuperación de Contraseña";
        $contenido = "<p>Haz clic en el siguiente enlace para restablecer tu contraseña:</p><p><a href='$url'>$url</a></p>";

        if ($tipo === 'padre') {
            enviarCorreo($correo, $asunto, $contenido);
        } else {
            enviarCorreo($correo, $asunto, $contenido); // usuario también es correo en admin
        }

        $mensaje = "Se ha enviado un enlace de recuperación a tu correo.";
    } else {
        $mensaje = "No se encontró ninguna cuenta asociada.";
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="container mt-5">
  <h2 class="mb-4">Recuperar Contraseña</h2>
  <?php if ($mensaje): ?>
    <div class="alert alert-info"> <?= $mensaje ?> </div>
  <?php endif; ?>

  <form method="POST" class="col-md-6 mx-auto">
    <div class="mb-3">
      <label class="form-label">Tipo de usuario</label>
      <select name="tipo_usuario" class="form-select" required>
        <option value="padre">Padre/Tutor</option>
        <option value="admin">Administrador</option>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Correo electrónico o usuario</label>
      <input type="email" name="correo" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">Enviar enlace</button>
  </form>
</div>

<?php include 'includes/footer.php'; ?>
