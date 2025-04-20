const express = require('express');
const router = express.Router();
const multer = require('multer');
const path = require('path');
const fs = require('fs');

// Configuración de Multer
const storage = multer.diskStorage({
  destination: (req, file, cb) => {
    const matricula = req.body.matricula;  // Asegúrate de que la matrícula esté en el cuerpo de la solicitud
    const uploadPath = `./uploads/${matricula}`;

    // Crear la carpeta si no existe
    if (!fs.existsSync(uploadPath)) {
      fs.mkdirSync(uploadPath, { recursive: true });
    }

    cb(null, uploadPath); // Carpeta donde se guardarán las imágenes
  },
  filename: (req, file, cb) => {
    cb(null, `${Date.now()}-${file.originalname}`); // Nombre único para evitar conflictos
  }
});

const upload = multer({
  storage,
  fileFilter: (req, file, cb) => {
    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
    if (!allowedTypes.includes(file.mimetype)) {
      return cb(new Error('Solo se permiten imágenes JPG, PNG, JPEG o WEBP. '));
    }
    cb(null, true);
  }
});

// Controlador para subir las imágenes
router.post('/images', upload.array('images', 10), async (req, res) => {
  if (!req.files) {
    return res.status(400).send({ message: 'No se han subido imágenes.' });
  }

  try {
    // Suponiendo que tienes el modelo Coche y que la matrícula está en el cuerpo de la solicitud
    const matricula = req.body.matricula;
    const imagePaths = req.files.map(file => `/uploads/${matricula}/${file.filename}`);

    // Aquí guardas las rutas de las imágenes en la base de datos
    // Suponiendo que el modelo de Coche tiene una columna 'ruta_img_coche'
    // Si un coche tiene varias imágenes, puedes almacenar esas rutas como un array o como un string de rutas separadas por comas
    const coche = await Coche.findOne({ where: { matricula: matricula } });

    if (coche) {
      // Si el coche ya existe en la base de datos, actualizamos las rutas
      coche.ruta_img_coche = imagePaths.join(',');  // Si son varias imágenes, puedes guardarlas como un string separado por comas
      await coche.save();
    } else {
      // Si el coche no existe, puedes crear un nuevo registro
      await Coche.create({
        matricula: matricula,
        ruta_img_coche: imagePaths.join(',')
      });
    }

    res.status(200).send({
      message: 'Imágenes subidas correctamente',
      files: req.files,  // Detalles de los archivos subidos
      imagePaths: imagePaths  // Rutas de las imágenes
    });

  } catch (error) {
    console.error(error);
    res.status(500).send({ message: 'Error al guardar las imágenes en la base de datos.' });
  }
});

module.exports = router;