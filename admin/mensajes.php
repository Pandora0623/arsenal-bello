<?php include '../includes/db.php'; ?>
<?php include 'includes/header.php'; ?>

<div class="container mt-4">
  <h2>Mensajes de Contacto</h2>

  <!-- Botón para volver al panel principal -->
  <a href="index.php" class="btn btn-secondary mb-3">← Volver al Panel Principal</a>

  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Correo</th>
        <th>Teléfono</th>
        <th>Mensaje</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $mensajes = $pdo->query("SELECT * FROM mensajes_contacto ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
      foreach ($mensajes as $msg): ?>
        <tr>
          <td><?= $msg['id'] ?></td>
          <td><?= htmlspecialchars($msg['nombre']) ?></td>
          <td><?= htmlspecialchars($msg['correo']) ?></td>
          <td><?= htmlspecialchars($msg['telefono']) ?></td>
          <td>
            <?php if (strlen($msg['mensaje']) > 100): ?>
              <?= htmlspecialchars(substr($msg['mensaje'], 0, 100)) . '...' ?>
            <?php else: ?>
              <?= htmlspecialchars($msg['mensaje']) ?>
            <?php endif; ?>
          </td>
          <td>
            <a href="ver_mensaje.php?id=<?= $msg['id'] ?>" class="btn btn-info btn-sm">Ver más</a>
            <a href="eliminar_mensaje.php?id=<?= $msg['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este mensaje?')">Eliminar</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php include '../includes/footer.php'; ?>

