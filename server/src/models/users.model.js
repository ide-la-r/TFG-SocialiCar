const insert = async ({ nombre, apellido, dni, correo, contrasena, telefono, ruta_img_dni, ruta_img_carnet }) => {
    try {
        await db.query(
            `INSERT INTO usuario (nombre, apellido, dni, correo, contrasena, telefono, foto_perfil, fecha_registro, fecha_update, ruta_img_dni, ruta_img_carnet) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)`,
            [nombre, apellido, dni, correo, contrasena, telefono, null, new Date(), new Date(), ruta_img_dni, ruta_img_carnet]
        );
        console.log('Usuario insertado correctamente');
    } catch (err) {
        console.error('Error al insertar usuario:', err.message);
        throw err;
    }
};


// Verificar si el correo ya está registrado
const findByEmail = async (correo) => {
    try {
        const [rows] = await db.query('SELECT * FROM usuario WHERE correo = ?', [correo]);
        return rows[0];
    } catch (err) {
        console.error('Error al buscar usuario por correo:', err.message);
        throw err;
    }
};

// Verificar si el DNI ya está registrado
const findByDNI = async (dni) => {
    try {
        const [rows] = await db.query('SELECT * FROM usuario WHERE dni = ?', [dni]);
        return rows[0];
    } catch (err) {
        console.error('Error al buscar usuario por DNI:', err.message);
        throw err;
    }
};

// Verificar si el teléfono ya está registrado
const findByPhone = async (telefono) => {
    try {
        const [rows] = await db.query('SELECT * FROM usuario WHERE telefono = ?', [telefono]);
        return rows[0];
    } catch (err) {
        console.error('Error al buscar usuario por teléfono:', err.message);
        throw err;
    }
};


module.exports = {
    insert, findByDNI, findByEmail, findByPhone
};