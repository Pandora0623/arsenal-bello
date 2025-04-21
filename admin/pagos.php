<?php include '../includes/db.php'; ?>
<?php include 'includes/header.php'; ?>

<div class="container mt-4">
  <h2>Pagos Registrados</h2>

  <!-- Botón para volver al panel principal -->
  <a href="index.php" class="btn btn-secondary mb-3">← Volver al Panel Principal</a>

  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Usuario ID</th>
        <th>Monto</th>
        <th>Método de Pago</th>
        <th>Fecha</th>
        <th>Descripción</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $pagos = $pdo->query("SELECT * FROM pagos ORDER BY creado_en DESC")->fetchAll(PDO::FETCH_ASSOC);
      foreach ($pagos as $pago): ?>
        <tr>
          <td><?= $pago['id'] ?></td>
          <td><?= $pago['usuario_id'] ?></td>
          <td>$<?= number_format($pago['monto'], 0) ?></td>
          <td><?= $pago['metodo_pago'] ?></td>
          <td><?= $pago['fecha_pago'] ?></td>
          <td><?= $pago['descripcion'] ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php include '../includes/footer.php'; ?>
