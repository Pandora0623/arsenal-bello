<?php
session_start();
unset($_SESSION['usuario_id']);
unset($_SESSION['usuario_nombre']);
session_destroy();
header("Location: ./login.php");
exit;
