const express = require('express');
const router = express.Router();
const multer = require('multer');
const path = require('path');
const fs = require('fs');
const { Usuario, Coche } = require('../models');

// Crear carpeta "uploads" si no existe
const uploadsDir = path.join(__dirname, '..', 'uploads');
if (!fs.existsSync(uploadsDir)) {
    fs.mkdirSync(uploadsDir);
}

// Configura el almacenamiento de Multer para guardar las imágenes
const storage = multer.diskStorage({
    destination: (req, file, cb) => {
        const matricula = req.body.matricula;  // Obtén la matrícula desde el body
        const dir = path.join(__dirname, '..', 'uploads', 'coches', matricula);  // Carpeta con el número de matrícula

        // Verifica si la carpeta existe, si no, la crea
        if (!fs.existsSync(dir)) {
            fs.mkdirSync(dir, { recursive: true });
        }

        cb(null, dir);  // Establece la carpeta de destino
    },
    filename: (req, file, cb) => {
        const fileName = `${Date.now()}-${file.originalname}`;  // Nombre único para evitar sobrescribir archivos
        cb(null, fileName);  // Establece el nombre del archivo
    }
});

// Configura Multer con el almacenamiento
const upload = multer({ storage: storage });

// Ruta para obtener todos los coches
router.get('/', async function (req, res) {
    try {
        const listOfCoches = await Coche.findAll();
        res.json(listOfCoches);
    } catch (error) {
        res.status(500).json({ message: "Error al obtener los coches", error });
    }
});

// Ruta de test para depurar
router.post('/test', (req, res) => {
    console.log("Headers:", req.headers);
    console.log("Content-Type:", req.get('Content-Type'));
    console.log("Body recibido:", req.body);
    res.json({ recibido: req.body });
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
router.post('/rentacar', upload.array('ruta_img_coche'), async (req, res) => {
    try {
        // Desestructuración de los datos recibidos
        const {
            id_usuario, matricula, seguro, marca, modelo,
            anno_matriculacion, kilometros, combustible, transmision,
            ubicacion, tipo_aparcamiento, mascota, fumar, movilidadreducia,
            aireacondicionado, gps, wifi, sensoresaparcamiento, camaradereversa,
            controldecrucero, asientoscalefactables
        } = req.body;

        // Validación de los datos requeridos
        if (!id_usuario || !matricula || !seguro || !marca || !modelo || !anno_matriculacion || !kilometros || !combustible || !transmision || !ubicacion || !tipo_aparcamiento) {
            return res.status(400).json({ mensaje: 'Faltan datos obligatorios en el formulario.' });
        }

        // Verificar que el usuario exista en la base de datos
        const usuario = await Usuario.findOne({ where: { dni: id_usuario } });
        if (!usuario) {
            return res.status(400).json({ mensaje: 'El usuario no existe.' });
        }

        const fechaMatriculacion = `${anno_matriculacion}-01`; // Añadimos el día 01 al mes

        // Crear el nuevo coche en la base de datos
        const nuevoCoche = await Coche.create({
            id_usuario: usuario.dni,  // Asignamos el id del usuario desde la base de datos
            matricula,
            seguro: seguro === 'true', 
            marca,
            modelo,
            anno_matriculacion: fechaMatriculacion,  // Usamos la fecha formateada
            kilometros,
            combustible,
            transmision,
            ubicacion,
            tipo_aparcamiento,
            mascota: mascota === 'true',  // Convertimos a booleano
            fumar: fumar === 'true',  
            movilidadreducia: movilidadreducia === 'true',  
            aireacondicionado: aireacondicionado === 'true',  
            gps: gps === 'true',  
            wifi: wifi === 'true', 
            sensoresaparcamiento: sensoresaparcamiento === 'true', 
            camaradereversa: camaradereversa === 'true',  
            controldecrucero: controldecrucero === 'true',  
            asientoscalefactables: asientoscalefactables === 'true',  
            // Ruta con la carpeta específica de la matrícula
            ruta_img_coche: req.files.length > 0 ? `/uploads/coches/${matricula}/${req.files[0].filename}` : null,  
        });

        // Enviar la respuesta de éxito
        res.status(200).json({ mensaje: 'Coche en alquiler correctamente', coche: nuevoCoche });
    } catch (error) {
        console.error(error);
        res.status(500).json({ mensaje: 'Error en el servidor.' });
    }
});


module.exports = router;