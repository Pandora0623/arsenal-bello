<?php
require 'includes/enviar_correo.php';

$enviado = enviarCorreo('destinatario@correo.com', 'Correo de prueba', '<h3>¡Esto es un test desde PHPMailer + SendGrid!</h3>');

if ($enviado) {
    echo "Correo enviado correctamente.";
} else {
    echo "Error al enviar el correo.";
}
?>
