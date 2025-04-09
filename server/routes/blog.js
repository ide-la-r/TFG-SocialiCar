var express = require('express');
var router = express.Router();


router.get('/', function(req, res, next) {
  res.send('Página principal del blog.');
});

router.get('/:id', function(req, res, next) {
    res.send('Página principal del blog.');
});

module.exports = router;