<?php
session_start();

if (!isset($_SESSION['usuario_id']) && !isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit;
}

$activo = 'pagos'; // ✅ Este debe ir ANTES del header
require 'includes/db.php';
include 'includes/header.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $monto = $_POST['monto'];
  $metodo = $_POST['metodo'];
  $descripcion = $_POST['descripcion'];
  $fecha_pago = date('Y-m-d');
  $usuario_id = $_SESSION['usuario_id'];

  $stmt = $pdo->prepare("INSERT INTO pagos (usuario_id, monto, metodo_pago, fecha_pago, descripcion) VALUES (?, ?, ?, ?, ?)");
  $stmt->execute([$usuario_id, $monto, $metodo, $fecha_pago, $descripcion]);
  $mensaje = "Pago registrado correctamente.";
}

$stmt = $pdo->prepare("SELECT monto, metodo_pago, fecha_pago, descripcion FROM pagos WHERE usuario_id = ? ORDER BY fecha_pago DESC");
$stmt->execute([$_SESSION['usuario_id']]);
$pagos = $stmt->fetchAll();
?>

<script src="https://cdn.jsdelivr.net/npm/js-md5@0.8.3/src/md5.min.js"></script>

<div class="container mt-4">
  <h2>Gestión de Pagos</h2>

  <?php if ($mensaje): ?>
    <div class="alert alert-success"><?php echo $mensaje; ?></div>
  <?php endif; ?>

  <form method="post" action="https://sandbox.checkout.payulatam.com/ppp-web-gateway-payu/" class="border p-4 shadow-sm rounded">

<input name="merchantId"      type="hidden" value="508029" id="merchantId">
<input name="accountId"       type="hidden" value="512321">
<input name="description"     type="hidden" value="Test PAYU">
<input name="referenceCode"   type="hidden" value="Prueba1" id="referenceCode">
<input name="tax"             type="hidden" value="0" >
<input name="taxReturnBase"   type="hidden" value="0">
<input name="currency"        type="hidden" value="COP">
<input name="signature"       type="hidden" value="" id="signature">
<input name="test"            type="hidden" value="0">
<input name="responseUrl"     type="hidden" value="http://www.test.com/response">
<input name="confirmationUrl" type="hidden" value="http://www.test.com/confirmation">

<div class="mb-3">
  <label for="amount" class="form-label">Monto</label>
  <input name="amount" id="amount" type="text" class="form-control" value="" required>
</div>

<div class="mb-3">
  <label for="buyerEmail" class="form-label">Correo del comprador</label>
  <input name="buyerEmail" id="buyerEmail" type="email" class="form-control" value="" required>
</div>

<button type="submit" class="btn btn-primary">Pagar ahora</button>
</form>

</div>

<script>
  document.getElementById('amount').addEventListener("change", (event) => {
    console.log('cambio')
    var hash= md5('4Vj8eK4rloUd272L48hsrarnUA~'+ document.getElementById('merchantId').value+'~'+ document.getElementById('referenceCode').value+'~'+document.getElementById('amount').value+'~COP')
    console.log('4Vj8eK4rloUd272L48hsrarnUA~'+ document.getElementById('merchantId')+'~'+ document.getElementById('referenceCode')+'~'+document.getElementById('amount')+'~COP')
    console.log(hash)
    document.getElementById('signature').value=hash 
});
 
</script>

<?php include 'includes/footer.php'; ?>

