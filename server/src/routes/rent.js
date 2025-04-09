var express = require('express');
var router = express.Router();


router.get('/car-registration', function(req, res, next) {
  res.send('Página de registro de coche.');
});

router.get('/how', function(req, res, next) {
    res.send('Página de como funciona el alquiler.');
});

router.get('/insurance', function(req, res, next) {
    res.send('Página sobre como funciona nuestro seguro.');
});


module.exports = router;