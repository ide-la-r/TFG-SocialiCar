const express = require('express');
const router = express.Router();
const { Usuario } = require('../models');


router.get('/', function(req, res, next) {
    res.send('Página del perfil de usuario.');
});

router.get("/edit/:id", (req, res) => {
    const { id } = req.params;
    res.send(`Página de perfil de usuario con id: ${id}.`);
});

router.get("/register", async function(req, res) {
    const listOfUsers = await Usuario.findAll();
    res.json(listOfUsers);
});

router.post('/register', async (req, res) => {
    const user = req.body;
    await Usuario.create(user);
    res.json(user);
});

router.get("/payout", (req, res) => {
    res.send(`Página de retiro de saldo.`);
});

router.get("/earnings", (req, res) => {
    res.send(`Página de movimiento en transacciones.`);
});

router.get("/payment_cards", (req, res) => {
    res.send(`Página de metodos de pago. (Proximamente)`);
});


module.exports = router;