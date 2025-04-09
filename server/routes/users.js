var express = require('express');
var path = require('path');
var router = express.Router();


router.get('/', function(req, res, next) {
  res.sendFile(path.join(__dirname, '../views/login.html'));
});

router.get("/edit:id", (req, res) => {
  const { id } = req.params;
  res.send(`Página de perfil de usuario con id: ${id}.`);
});

router.get("/payout", (req, res) => {
  res.send(`Página de retiro de saldo.`);
});

router.get("/earnings", (req, res) => {
  res.send(`Página de movimiento en transacciones.`);
});

router.get("/payment_cards", (req, res) => {
  res.send(`Página de metodos de pago. (Proximamente)`);
});


module.exports = router;