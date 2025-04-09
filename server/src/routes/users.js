var express = require('express');
var router = express.Router();
const UserController = require('../controllers/users.controller');


router.get('/', function(req, res, next) {
  res.send('Página del perfil de usuario.');
});

router.get("/edit/:id", (req, res) => {
  const { id } = req.params;
  res.send(`Página de perfil de usuario con id: ${id}.`);
});

router.post('/register', UserController.register);

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