<?php include '../includes/db.php'; ?>
<?php include '../includes/header.php'; ?>

<div class="container mt-4">
  <h2 class="mb-4">Usuarios Registrados</h2>

  <!-- Botones -->
  <a href="index.php" class="btn btn-secondary mb-3">← Volver al Panel Principal</a>
  <a href="exportar_padres_excel.php" class="btn btn-success mb-3">Descargar Excel</a>

  <!-- Tabla de datos combinados -->
  <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
      <thead class="table-dark text-center">
        <tr>
          <th>ID</th>
          <th>Nombre del Padre/Tutor</th>
          <th>Correo</th>
          <th>Teléfono</th>
          <th>Documento del Padre</th>
          <th>Nombre del Hijo(a)</th>
          <th>Documento del Hijo(a)</th>
          <th>Edad</th>
          <th>Categoría</th>
          <th>Creado en</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $stmt = $pdo->query("
          SELECT 
            u.id AS usuario_id, 
            u.nombre AS nombre_padre, 
            u.correo, 
            u.telefono, 
            CONCAT(u.tipo_documento, ' ', u.numero_documento) AS documento_padre,
            u.creado_en, 
            h.nombre AS nombre_hijo, 
            CONCAT(h.tipo_documento, ' ', h.numero_documento) AS documento_hijo,
            h.edad, 
            h.categoria
          FROM usuarios u
          LEFT JOIN hijos h ON h.usuario_id = u.id
          ORDER BY u.creado_en DESC
        ");
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($usuarios as $usuario): ?>
          <tr>
            <td><?= $usuario['usuario_id'] ?></td>
            <td><?= $usuario['nombre_padre'] ?></td>
            <td><?= $usuario['correo'] ?></td>
            <td><?= $usuario['telefono'] ?></td>
            <td><?= $usuario['documento_padre'] ?></td>
            <td><?= $usuario['nombre_hijo'] ?? '-' ?></td>
            <td><?= $usuario['documento_hijo'] ?? '-' ?></td>
            <td><?= $usuario['edad'] ?? '-' ?></td>
            <td><?= $usuario['categoria'] ?? '-' ?></td>
            <td><?= $usuario['creado_en'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
