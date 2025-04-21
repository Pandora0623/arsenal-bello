<!DOCTYPE html>
<html>
<head>
  <title>Pagar con PayPal</title>
  <script src="https://www.paypal.com/sdk/js?client-id=YR32MQCFBFC6Y"></script>
</head>
<body>
  <h2>Pagar Inscripción</h2>

  <div id="paypal-button-container"></div>

  <script>
    paypal.Buttons({
      createOrder: function(data, actions) {
        return actions.order.create({
          purchase_units: [{
            amount: {
              value: '20000' // Monto en pesos colombianos
            },
            description: "Pago mensual escuela de fútbol"
          }]
        });
      },
      onApprove: function(data, actions) {
        return actions.order.capture().then(function(details) {
          alert('Pago completado por: ' + details.payer.name.given_name);
          // Aquí puedes redireccionar o guardar en BD
        });
      }
    }).render('#paypal-button-container');
  </script>
</body>
</html>
