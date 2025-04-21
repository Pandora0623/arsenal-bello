<?php
require 'includes/db.php';
require 'includes/enviar_correo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo_usuario = $_POST['tipo_usuario'];
    $identificador = trim($_POST['identificador']);

    if ($tipo_usuario === 'padre') {
        $stmt = $pdo->prepare("SELECT id, correo FROM usuarios WHERE correo = ?");
        $stmt->execute([$identificador]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            $token = bin2hex(random_bytes(16));
            $expira = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $stmt = $pdo->prepare("UPDATE usuarios SET token_recuperacion = ?, token_expira = ? WHERE id = ?");
            $stmt->execute([$token, $expira, $usuario['id']]);

            $enlace = "http://localhost/arsenal-bello/restablecer_contrasena.php?token=$token&tipo=padre";
            $asunto = "Recuperación de Contraseña";
            $mensaje = "<p>Hola, haz clic en el siguiente enlace para restablecer tu contraseña:</p>
                        <p><a href='$enlace'>$enlace</a></p>
                        <p>Este enlace expira en 1 hora.</p>";

            enviarCorreo($usuario['correo'], $asunto, $mensaje);
        }

    } elseif ($tipo_usuario === 'admin') {
        $stmt = $pdo->prepare("SELECT id, usuario FROM administradores WHERE usuario = ?");
        $stmt->execute([$identificador]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin) {
            $token = bin2hex(random_bytes(16));
            $expira = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $stmt = $pdo->prepare("UPDATE administradores SET token_recuperacion = ?, token_expira = ? WHERE id = ?");
            $stmt->execute([$token, $expira, $admin['id']]);

            $enlace = "http://localhost/arsenal-bello/restablecer_contrasena.php?token=$token&tipo=admin";
            $asunto = "Recuperación de Contraseña";
            $mensaje = "<p>Hola, haz clic en el siguiente enlace para restablecer tu contraseña:</p>
                        <p><a href='$enlace'>$enlace</a></p>
                        <p>Este enlace expira en 1 hora.</p>";

            enviarCorreo($admin['usuario'], $asunto, $mensaje);
        }
    }
}

header("Location: login.php?recuperacion=ok");
exit;
