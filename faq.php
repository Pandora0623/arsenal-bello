<?php
$activo = 'faq';
include 'includes/header.php';
?>

<!-- ❓ PREGUNTAS FRECUENTES -->
<section class="py-5 bg-light">
  <div class="container">
    <h2 class="mb-4 text-center">Preguntas Frecuentes</h2>

    <div class="accordion" id="faqAccordion">

      <div class="accordion-item">
        <h2 class="accordion-header" id="faq1">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#respuesta1" aria-expanded="true" aria-controls="respuesta1">
            ¿Cuál es la edad mínima para inscribirse?
          </button>
        </h2>
        <div id="respuesta1" class="accordion-collapse collapse show" aria-labelledby="faq1" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            Aceptamos niños y niñas desde los 4 años en adelante.
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header" id="faq2">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#respuesta2" aria-expanded="false" aria-controls="respuesta2">
            ¿Dónde se realizan los entrenamientos?
          </button>
        </h2>
        <div id="respuesta2" class="accordion-collapse collapse" aria-labelledby="faq2" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            Los entrenamientos se realizan en nuestras canchas ubicadas en Bello, Antioquia.
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header" id="faq3">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#respuesta3" aria-expanded="false" aria-controls="respuesta3">
            ¿Cuánto cuesta la mensualidad?
          </button>
        </h2>
        <div id="respuesta3" class="accordion-collapse collapse" aria-labelledby="faq3" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            El valor varía según la categoría y número de clases semanales. Puedes consultarlo en la sección de <a href="pagos.php">Pagos</a>.
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header" id="faq4">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#respuesta4" aria-expanded="false" aria-controls="respuesta4">
            ¿Debo llevar uniforme desde el primer día?
          </button>
        </h2>
        <div id="respuesta4" class="accordion-collapse collapse" aria-labelledby="faq4" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            No es obligatorio el primer día. Sin embargo, puedes adquirirlo con nosotros una vez se confirme la inscripción.
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
