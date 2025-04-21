<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Club Deportivo Arsenal Bello</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap & Fuentes -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Anton&family=Open+Sans&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root {
      --azul-arsenal: #0A2C5A;
      --rojo-arsenal: #D32F2F;
      --blanco: #ffffff;
    }

    body {
      font-family: 'Open Sans', sans-serif;
      background-color: #ffffff;
      margin: 0;
      padding: 0;
    }

    h1, h2 {
      font-family: 'Anton', sans-serif;
    }

    .navbar-custom {
      background-color: var(--azul-arsenal);
    }

    .navbar-custom .nav-link,
    .navbar-custom .navbar-brand,
    .navbar-custom .dropdown-item {
      color: var(--blanco);
      transition: color 0.3s ease, font-weight 0.3s ease;
    }

    .navbar-custom .nav-link:hover,
    .navbar-custom .dropdown-item:hover {
      color: var(--rojo-arsenal);
    }

    .navbar-custom .nav-link.active {
      color: var(--rojo-arsenal) !important;
      font-weight: bold;
    }

    .btn-primary {
      background-color: var(--azul-arsenal);
      border-color: var(--azul-arsenal);
    }

    .btn-primary:hover {
      background-color: var(--rojo-arsenal);
      border-color: var(--rojo-arsenal);
    }

    .btn-danger {
      background-color: var(--rojo-arsenal);
      border-color: var(--rojo-arsenal);
    }

    .btn-danger:hover {
      background-color: #a52222;
      border-color: #a52222;
    }

    footer {
      background-color: var(--azul-arsenal);
      color: var(--blanco);
      padding: 20px 0;
      text-align: center;
    }

    .carousel-caption h1 {
      font-size: 2.5rem;
    }

    .social-icons a i {
      transition: color 0.3s;
    }

    .social-icons a:hover i {
      color: var(--rojo-arsenal);
    }

    .contenido-principal {
      padding: 20px;
      margin-top: 20px;
    }
  </style>
</head>
<body>

<!-- 🧑‍💼 Usuario logueado -->
<?php if (isset($_SESSION['usuario_nombre'])): ?>
  <div class="bg-dark text-white text-end px-4 py-2 small">
    Bienvenido, <?php echo $_SESSION['usuario_nombre']; ?> |
    <a href="./logout_padre.php" class="text-white text-decoration-underline">Cerrar sesión</a>
  </div>
<?php elseif (isset($_SESSION['admin'])): ?>
  <div class="bg-dark text-white text-end px-4 py-2 small">
    Panel Administrador |
    <a href="../admin/logout.php" class="text-white text-decoration-underline">Cerrar sesión</a>
  </div>
<?php endif; ?>

<!-- 🧭 Barra de navegación -->
<nav class="navbar navbar-expand-lg navbar-custom">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="./index.php">
      <img src="/arsenal-bello/assets/img/logo-arsenal1.png" alt="Logo Arsenal Bello" width="50" height="50" class="me-2">
      <span>Club Deportivo Arsenal Bello</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="menu">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link <?php echo (isset($activo) && $activo === 'inicio') ? 'active' : ''; ?>" href="./index.php">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo (isset($activo) && $activo === 'inscripciones') ? 'active' : ''; ?>" href="./inscripciones.php">Inscripciones</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo (isset($activo) && $activo === 'eventos') ? 'active' : ''; ?>" href="./eventos.php">Eventos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo (isset($activo) && $activo === 'pagos') ? 'active' : ''; ?>" href="./pagos.php">Pagos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo (isset($activo) && $activo === 'contacto') ? 'active' : ''; ?>" href="./contactanos.php">Contáctanos</a>
        </li>

        <?php if (isset($_SESSION['usuario_id'])): ?>
          <li class="nav-item">
            <a class="nav-link <?php echo ($activo === 'mis_pagos') ? 'active' : ''; ?>" href="./historial_pagos.php">Mis Pagos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo ($activo === 'mis_hijos') ? 'active' : ''; ?>" href="./mis_hijos.php">Mis Hijos</a>
          </li>
        <?php endif; ?>

        <?php if (isset($_SESSION['admin'])): ?>
          <li class="nav-item">
            <a class="nav-link <?php echo ($activo === 'mensajes') ? 'active' : ''; ?>" href="./admin/mensajes.php">Mensajes</a>
          </li>
        <?php endif; ?>

        <?php if (!isset($_SESSION['usuario_id']) && !isset($_SESSION['admin'])): ?>
          <li class="nav-item">
            <a class="nav-link <?php echo ($activo === 'login') ? 'active' : ''; ?>" href="./login.php">Iniciar Sesión</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
