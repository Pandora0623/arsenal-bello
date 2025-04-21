<?php

function enviarCorreo($para, $asunto, $mensaje_html) {
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: Escuela de Fútbol <no-reply@arsenal-bello.com>' . "\r\n";
    
    return mail($para, $asunto, $mensaje_html, $headers);
}

?>