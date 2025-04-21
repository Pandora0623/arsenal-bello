<?php
require '../includes/db.php';
require __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Crear el archivo Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle("Padres e Hijos");

// Encabezados
$sheet->setCellValue('A1', 'ID Padre');
$sheet->setCellValue('B1', 'Nombre Padre');
$sheet->setCellValue('C1', 'Tipo Doc. Padre');
$sheet->setCellValue('D1', 'N° Doc. Padre');
$sheet->setCellValue('E1', 'Correo');
$sheet->setCellValue('F1', 'Teléfono');
$sheet->setCellValue('G1', 'Observaciones');

$sheet->setCellValue('H1', 'Nombre Hijo');
$sheet->setCellValue('I1', 'Tipo Doc. Hijo');
$sheet->setCellValue('J1', 'N° Doc. Hijo');
$sheet->setCellValue('K1', 'Edad');
$sheet->setCellValue('L1', 'Categoría');

// Obtener datos con JOIN
$query = "
SELECT 
  u.id AS padre_id, u.nombre AS nombre_padre, u.tipo_documento AS tipo_doc_padre, 
  u.numero_documento AS doc_padre, u.correo, u.telefono, u.observaciones,
  h.nombre AS nombre_hijo, h.tipo_documento AS tipo_doc_hijo, 
  h.numero_documento AS doc_hijo, h.edad, h.categoria
FROM usuarios u
LEFT JOIN hijos h ON u.id = h.usuario_id
ORDER BY u.id DESC
";
$stmt = $pdo->query($query);
$registros = $stmt->fetchAll();

$fila = 2;
foreach ($registros as $r) {
    $sheet->setCellValue('A' . $fila, $r['padre_id']);
    $sheet->setCellValue('B' . $fila, $r['nombre_padre']);
    $sheet->setCellValue('C' . $fila, $r['tipo_doc_padre']);
    $sheet->setCellValue('D' . $fila, $r['doc_padre']);
    $sheet->setCellValue('E' . $fila, $r['correo']);
    $sheet->setCellValue('F' . $fila, $r['telefono']);
    $sheet->setCellValue('G' . $fila, $r['observaciones']);

    $sheet->setCellValue('H' . $fila, $r['nombre_hijo']);
    $sheet->setCellValue('I' . $fila, $r['tipo_doc_hijo']);
    $sheet->setCellValue('J' . $fila, $r['doc_hijo']);
    $sheet->setCellValue('K' . $fila, $r['edad']);
    $sheet->setCellValue('L' . $fila, $r['categoria']);

    $fila++;
}

// Descargar el archivo
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="padres_hijos_registrados.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
