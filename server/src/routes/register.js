var express = require('express');
var router = express.Router();
const UserController = require('../controllers/users.controller');

router.get('/', UserController.register);

router.get('/validacion', function(req, res, next) {
    res.send('Página de registro dos.');
});

module.exports = router;
