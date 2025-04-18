const express = require('express');
const router = express.Router();
const { Coche } = require('../models');


router.get('/', function(req, res, next) {
    res.send('Página del perfil de usuario.');
});

router.get("/edit/:id", (req, res) => {
    const { id } = req.params;
    res.send(`Página para editar vehiculo con id: ${id}.`);
});

router.get("/rentacar", async function(req, res) {
    const listOfCoches = await Coche.findAll();
    res.json(listOfCoches);
});

router.post('/rentacar', async (req, res) => {
    const coche = req.body;
    await Coche.create(coche);
    res.json(coche);
});

console.log("Coche router cargado");


module.exports = router;