var express = require('express');
var router = express.Router();


router.get('/', function(req, res, next) {
  res.send('Página de todos los coches en alquiler.');
});

router.get('/:id', function(req, res, next) {
  res.send('Página del coche.');
});

router.get('/:id/rental-checkout', function(req, res, next) {
  res.send('Página de alquiler del coche.');
});

router.get('/:id/rental-checkout/payment', function(req, res, next) {
  res.send('Página de pago del alquiler del coche.');
});


module.exports = router;