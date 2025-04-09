var express = require('express');
var router = express.Router();


router.get('/', function(req, res, next) {
  res.send('Página para hacerte premium en nuestra web.');
});


module.exports = router;