const multer = require('multer');
const path = require('path');
const fs = require('fs');

// Configuración de Multer
const storage = multer.diskStorage({
  destination: (req, file, cb) => {
    const carId = req.body.matricula; // Asegúrate de enviar la matrícula en la solicitud
    const dir = `uploads/${carId}/`; // Carpeta dinámica con la matrícula

    if (!fs.existsSync(dir)){
      fs.mkdirSync(dir, { recursive: true });
    }

    cb(null, dir);
  },
  filename: (req, file, cb) => {
    const ext = path.extname(file.originalname);
    const uniqueName = `${Date.now()}${ext}`; // Nombre único basado en el timestamp

    cb(null, uniqueName);
  }
});

// Limitar los tipos de archivos aceptados (solo imágenes)
const fileFilter = (req, file, cb) => {
  const filetypes = /jpeg|jpg|png|gif/;
  const mimetype = filetypes.test(file.mimetype);

  if (mimetype) {
    return cb(null, true); // Aceptar el archivo
  } else {
    cb(new Error('Solo se permiten imágenes'), false); // Rechazar el archivo
  }
};

// Configuración de Multer
const upload = multer({
  storage: storage,
  fileFilter: fileFilter,
  limits: { fileSize: 5 * 1024 * 1024 } // Limitar tamaño máximo a 5MB
});

module.exports = upload;
