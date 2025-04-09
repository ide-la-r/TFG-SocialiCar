const mysql = require("mysql2");

// Creamos un pool de conexiones y le pasamos las opciones de conexión a la bbdd
const pool = mysql.createPool({
    host: process.env.DB_HOST, 
    user: process.env.DB_USER,
    password: process.env.DB_PASSWORD,
    port: process.env.DB_PORT, 
    database: process.env.DB_NAME 
});

// Usamos la versión de promesas del pool
global.db = pool.promise();

// Realizamos una consulta simple para verificar la conexión
pool.promise().query('SELECT 1')
    .then(([rows, fields]) => {
        console.log('Conexión a la base de datos exitosa');
    })
    .catch((err) => {
        console.error('Error al conectar a la base de datos:', err.message);
    });