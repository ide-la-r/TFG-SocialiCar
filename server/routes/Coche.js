const express = require('express');
const router = express.Router();
const { Coche } = require('../models');

// Ruta para obtener todos los coches
router.get('/', async function(req, res) {
    try {
        const listOfCoches = await Coche.findAll();
        res.json(listOfCoches);
    } catch (error) {
        res.status(500).json({ message: "Error al obtener los coches", error });
    }
});

// Ruta para obtener un coche por ID
router.get("/edit/:id", async (req, res) => {
    const { id } = req.params;
    try {
        const coche = await Coche.findByPk(id);
        if (coche) {
            res.json(coche);
        } else {
            res.status(404).json({ message: "Coche no encontrado" });
        }
    } catch (error) {
        res.status(500).json({ message: "Error al obtener el coche", error });
    }
});

// Ruta para crear un coche
router.post('/rentacar', async (req, res) => {
    const cocheData = req.body;
    try {
        const coche = await Coche.create(cocheData);
        res.status(201).json(coche);
    } catch (error) {
        res.status(500).json({ message: "Error al crear el coche", error });
    }
});

module.exports = router;