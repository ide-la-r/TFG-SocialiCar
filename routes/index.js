var express = require('express');
var path = require('path');
var router = express.Router(); // Nos permite gestionar las peticiones HTTP

/* GET home page. */
router.get('/', function(req, res, next) {
  res.sendFile(path.join(__dirname, '../views/index.html'));
});

module.exports = router;