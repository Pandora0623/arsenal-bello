<?php
$activo = 'inicio';
include 'includes/header.php';
?>

<!-- 🎞️ CARRUSEL DE INICIO -->
<div id="carruselInicio" class="carousel slide carousel-fade mb-5" data-bs-ride="carousel" data-bs-interval="5000">
  <div class="carousel-inner">
    
    <!-- Slide 1 -->
    <div class="carousel-item active">
      <img src="assets/img/carrusel1.jpg" class="d-block w-100" alt="Formación futbolística" style="height: 480px; object-fit: cover; object-position: center;">
      <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3" style="margin-bottom: 80px;">
        <h1 class="text-white">Formamos Campeones Dentro y Fuera de la Cancha</h1>
        <a href="inscripciones.php" class="btn btn-primary mt-2">Inscríbete Hoy</a>
      </div>
    </div>

    <!-- Slide 2 -->
    <div class="carousel-item">
      <img src="assets/img/carrusel2.jpg" class="d-block w-100" alt="Valores y deporte" style="height: 480px; object-fit: cover; object-position: center;">
      <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3" style="margin-bottom: 80px;">
        <h1 class="text-white">12 Años Forjando Valores y Talento ⚽</h1>
      </div>
    </div>

    <!-- Slide 3 -->
    <div class="carousel-item">
      <img src="assets/img/carrusel3.jpg" class="d-block w-100" alt="Juventud deportiva" style="height: 480px; object-fit: cover; object-position: center;">
      <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3" style="margin-bottom: 80px;">
        <h1 class="text-white">¡Tu hijo puede ser el próximo crack! 🌟</h1>
      </div>
    </div>

  </div>

  <!-- Controles -->
  <button class="carousel-control-prev" type="button" data-bs-target="#carruselInicio" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carruselInicio" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

<!-- 🔎 QUIÉNES SOMOS -->
<section class="py-5">
  <div class="container">
    <h2 class="mb-4 text-center">¿Quiénes somos?</h2>
    <p class="fs-5 text-center">
      Durante más de 12 años, en el <strong>Club Deportivo Arsenal Bello</strong> hemos formado no solo jugadores, sino personas de valor.
      Nos especializamos en el desarrollo integral de niños y jóvenes, promoviendo el respeto, la disciplina y el trabajo en equipo.
      Nuestra escuela es un espacio donde los sueños empiezan a construirse con esfuerzo, alegría y pasión por el balón.
    </p>
  </div>
</section>

<!-- 🎯 MISIÓN -->
<section class="py-5">
  <div class="container">
    <h2 class="mb-4 text-center">Nuestra Misión</h2>
    <p class="fs-5 text-center">
      Brindar una formación deportiva de calidad, enfocada en el desarrollo técnico, táctico y humano de cada niño.
      Buscamos cultivar valores esenciales para la vida mientras fortalecemos su rendimiento en el campo de juego.
    </p>
  </div>
</section>

<!-- 🚀 VISIÓN -->
<section class="py-5">
  <div class="container">
    <h2 class="mb-4 text-center">Nuestra Visión</h2>
    <p class="fs-5 text-center">
      Ser reconocidos como una de las mejores escuelas de fútbol de Colombia, destacándonos por nuestra excelencia en la formación deportiva y humana.
      Queremos que cada niño que pase por nuestra escuela lleve consigo no solo talento, sino carácter para enfrentar la vida.
    </p>
  </div>
</section>

<?php include 'includes/footer.php'; ?>







