var express = require('express');
var path = require('path');
var router = express.Router();

router.get('/', function(req, res, next) {
    res.sendFile(path.join(__dirname, '../views/registro.html'));
});

router.get('/validacion', function(req, res, next) {
    res.sendFile(path.join(__dirname, '../views/registro_imagen.html'));
});

module.exports = router;
