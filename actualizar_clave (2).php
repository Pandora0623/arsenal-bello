<?php
// 1. Guardar en la base de datos cuando el pago es exitoso
// Este archivo se llamaría desde el evento onApprove del cliente JS usando fetch o AJAX

require '../includes/db.php'; // Asegúrate de tener tu conexión a la base de datos aquí

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos desde fetch
    $data = json_decode(file_get_contents("php://input"), true);

    $nombrePagador = $data['payer_name'] ?? 'Desconocido';
    $email = $data['payer_email'] ?? 'no_email@correo.com';
    $monto = $data['amount'] ?? 0;
    $descripcion = $data['description'] ?? 'Pago PayPal';
    $fecha_pago = date('Y-m-d');

    $stmt = $pdo->prepare("INSERT INTO pagos (usuario_id, monto, metodo_pago, fecha_pago, descripcion, creado_en) VALUES (?, ?, ?, ?, ?, NOW())");
    // Supongamos que es usuario_id 1 (puedes obtenerlo por sesión o correlación con correo)
    $stmt->execute([1, $monto, 'PayPal', $fecha_pago, $descripcion]);

    echo json_encode(['status' => 'ok', 'msg' => 'Pago registrado exitosamente']);
} else {
    echo json_encode(['status' => 'error', 'msg' => 'Método no permitido']);
}
