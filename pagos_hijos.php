<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

require 'includes/db.php';
include 'includes/header.php';

$usuario_id = $_SESSION['usuario_id'];

// Obtener hijos del usuario
$sql_hijos = $pdo->prepare("SELECT id, nombre FROM hijos WHERE usuario_id = ?");
$sql_hijos->execute([$usuario_id]);
$hijos = $sql_hijos->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
  <h2>Pagos de Mis Hijos</h2>

  <?php if (empty($hijos)): ?>
    <div class="alert alert-warning">No se encontraron hijos registrados.</div>
  <?php else: ?>
    <?php foreach ($hijos as $hijo): ?>
      <h4 class="mt-4"><?= htmlspecialchars($hijo['nombre']) ?></h4>
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
          $sql_pagos = $pdo->prepare("SELECT * FROM pagos WHERE hijo_id = ? ORDER BY creado_en DESC");
          $sql_pagos->execute([$hijo['id']]);
          $pagos = $sql_pagos->fetchAll(PDO::FETCH_ASSOC);
          if ($pagos):
            $i = 1;
            foreach ($pagos as $pago):
          ?>
              <tr>
                <td><?= $i++ ?></td>
                <td>$ <?= number_format($pago['monto'], 2) ?></td>
                <td><?= htmlspecialchars($pago['metodo_pago']) ?></td>
                <td><?= $pago['fecha_pago'] ?></td>
                <td><?= htmlspecialchars($pago['descripcion']) ?></td>
                <td><?= $pago['creado_en'] ?></td>
              </tr>
          <?php
            endforeach;
          else:
            echo "<tr><td colspan='6'>No hay pagos registrados para este hijo.</td></tr>";
          endif;
          ?>
        </tbody>
      </table>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
