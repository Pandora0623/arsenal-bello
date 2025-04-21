<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login_padres.php");
    exit;
}

$activo = 'mis_pagos';
include 'includes/header.php';
include 'includes/db.php';

$usuario_id = $_SESSION['usuario_id'];
?>

<div class="container py-4">
  <h2 class="mb-4">Historial de Pagos</h2>

  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>#</th>
        <th>Monto</th>
        <th>Método</th>
        <th>Fecha de Pago</th>
        <th>Descripción</th>
        <th>Registrado el</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $stmt = $pdo->prepare("SELECT * FROM pagos WHERE usuario_id = ? ORDER BY creado_en DESC");
      $stmt->execute([$usuario_id]);
      $pagos = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if ($pagos) {
          $i = 1;
          foreach ($pagos as $pago) {
              echo "<tr>
                      <td>{$i}</td>
                      <td>$ " . number_format($pago['monto'], 2) . "</td>
                      <td>" . htmlspecialchars($pago['metodo_pago']) . "</td>
                      <td>" . htmlspecialchars($pago['fecha_pago']) . "</td>
                      <td>" . htmlspecialchars($pago['descripcion']) . "</td>
                      <td>" . htmlspecialchars($pago['creado_en']) . "</td>
                    </tr>";
              $i++;
          }
      } else {
          echo "<tr><td colspan='6'>No se encontraron pagos registrados.</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>

<?php include 'includes/footer.php'; ?>
