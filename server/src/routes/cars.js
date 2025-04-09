var express = require('express');
var router = express.Router();

// Página de todos los coches
router.get('/', function(req, res) {
  res.send('Página de todos los coches en alquiler.');
});

// Página de pago del alquiler del coche
router.get('/:id/rental-checkout/payment', function(req, res) {
  res.send('Página de pago del alquiler del coche.');
});

// Página de alquiler del coche
router.get('/:id/rental-checkout', function(req, res) {
  res.send('Página de alquiler del coche.');
});

// Página de información del coche
router.get('/:id', function(req, res) {
  res.send('Página del coche.');
});

module.exports = router;
