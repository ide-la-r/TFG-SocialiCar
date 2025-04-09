const bcrypt = require('bcryptjs');
const User = require('../models/users.model');

const register = async (req, res) => {
    req.body.contrasena = bcrypt.hashSync(req.body.contrasena, 12); // Encriptar la contraseña

    const { nombre, apellido, dni, correo, contrasena, telefono, ruta_img_dni, ruta_img_carnet } = req.body;

    if (!nombre || !apellido || !dni || !correo || !contrasena || !telefono) {
        return res.status(400).json({ message: 'Faltan datos obligatorios' });
    }

    // Verificar si el correo ya está registrado
    const existingUser = await User.findByEmail(correo);
    if (existingUser) {
        return res.status(400).json({ message: 'El correo ya está registrado' });
    }

    // Verificar si el DNI ya está registrado
    const existingDNI = await User.findByDNI(dni);
    if (existingDNI) {
        return res.status(400).json({ message: 'El DNI ya está registrado' });
    }

    // Verificar si el teléfono ya está registrado
    const existingPhone = await User.findByPhone(telefono);
    if (existingPhone) {
        return res.status(400).json({ message: 'El teléfono ya está registrado' });
    }

    // Insertar el nuevo usuario
    try {
        await User.insert({ nombre, apellido, dni, correo, contrasena, telefono, ruta_img_dni, ruta_img_carnet });
        res.status(201).json({ message: 'Usuario registrado correctamente' });
    } catch (error) {
        console.error('Error al registrar el usuario:', error);
        res.status(500).json({ message: 'Error al registrar el usuario' });
    }
};

module.exports = { register };