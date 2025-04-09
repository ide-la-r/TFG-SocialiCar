var express = require('express');
var path = require('path');
var router = express.Router();

/* GET users listing. */
router.get('/', function(req, res, next) {
  res.sendFile(path.join(__dirname, '../views/login.html'));
});

router.get('/registro', function(req, res, next) {
  res.sendFile(path.join(__dirname, '../views/registro.html'));
});

router.get("/perfil:id", (req, res) => {
  const { id } = req.params;
  res.send(`Perfil de usuario con id: ${id}`);
});

module.exports = router;
