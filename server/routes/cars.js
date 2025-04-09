var express = require('express');
const { route } = require('.');
var router = express.Router();

/* GET users listing. */
router.get('/', function(req, res, next) {
  res.send('respond with a resource');
});

// Filtros
router.get("/add", (req, res) => {
  const { page=1, limit=10 } = req.query;
  console.log(page, limit);
  
  res.send('respond with a resource');
});

module.exports = router;
