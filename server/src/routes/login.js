var express = require('express');
var path = require('path');
var router = express.Router();


router.get('/', function(req, res, next) {
    res.send('Página de login.');
});


module.exports = router;
