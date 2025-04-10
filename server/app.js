const express = require('express');
const http = require('http');
const app = express();
const cors = require('cors');
const bodyParser = require('body-parser');

require('dotenv').config();

app.use(express.json());
app.use(cors());
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

// Rutas de las páginas
var indexRouter = require('./src/routes/index');
var usersRouter = require('./src/routes/users');
var carsRouter = require('./src/routes/cars');
var blogRouter = require('./src/routes/blog');
var premiumRouter = require('./src/routes/premium');
var rentRouter = require('./src/routes/rent');

// Delegación de las rutas
app.use('/', indexRouter);
app.use('/users', usersRouter);
app.use('/cars', carsRouter);
app.use('/blog', blogRouter);
app.use('/premium', premiumRouter);
app.use('/rent', rentRouter);

// Configuración de la BBDD
require('./src/config/db');

// Creación y lanzamiento del servidor
const server = http.createServer(app);
const PORT = process.env.PORT || 3001;
server.listen(PORT);

server.on('listening', () => {
    console.log(`Servidor escuchando en el puerto ${PORT}`);
});

module.exports = app;