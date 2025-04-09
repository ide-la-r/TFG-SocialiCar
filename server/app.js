var express = require('express');
var path = require('path');
var cookieParser = require('cookie-parser');
var logger = require('morgan');
const fs = require('fs/promises');


// Rutas de las páginas
var indexRouter = require('./routes/index');
var usersRouter = require('./routes/users');
var carsRouter = require('./routes/cars');
var loginRouter = require('./routes/login');
var registerRouter = require('./routes/register');
var blogRouter = require('./routes/blog');
var premiumRouter = require('./routes/premium');
var rentRouter = require('./routes/rent');

var app = express();

app.set('views', path.join(__dirname, 'views')); // Establece la carpeta de vistas

app.use(logger('dev'));
app.use(express.json());
app.use(express.urlencoded({ extended: false }));
app.use(cookieParser());
app.use(express.static(path.join(__dirname, 'public')));


app.use(async (req, res, next) => {
  // Middleware para gestionar las peticiones
  await fs.appendFile("./main.log", `Método: ${req.method} - URL: ${req.url} - Fecha: ${new Date()}\n`)
  next();
});


// Delegación de las rutas
app.use('/', indexRouter);
app.use('/users', usersRouter);
app.use('/cars', carsRouter);
app.use('/login', loginRouter);
app.use('/registro', registerRouter);
app.use('/blog', blogRouter);
app.use('/premium', premiumRouter);
app.use('/rent', rentRouter);


module.exports = app;