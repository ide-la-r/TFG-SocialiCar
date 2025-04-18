const express = require('express');
const app = express();
const cors = require('cors');

const db = require('./models');

app.use(express.json());
app.use(cors());

// Rutas
/* const indexRouter = require('./routes/index'); */
const usuarioRouter = require('./routes/Usuario');
const cocheRouter = require('./routes/Coche');
/* const blogRouter = require('./routes/Blog');
const premiumRouter = require('./routes/Premium');
const reservaRouter = require('./routes/Reserva'); */

// Delegación de las rutas
/* app.use('/', indexRouter); */
app.use('/users', usuarioRouter);
app.use('/cars', cocheRouter);
/* app.use('/blog', blogRouter);
app.use('/premium', premiumRouter);
app.use('/rent', reservaRouter); */


db.sequelize.sync().then(() => {
    app.listen(3001, () => {
        console.log('Server is running on port 3001');
    });
});
