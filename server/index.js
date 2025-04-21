const express = require('express');
const app = express();
const cors = require('cors');
const path = require('path');

const db = require('./models');

app.use(express.json());
app.use(cors());
app.use('/uploads', express.static(path.join(__dirname, 'uploads')));

// Rutas
const usuarioRouter = require('./routes/Usuario');
const cocheRouter = require('./routes/Coche');
const uploadRouter = require('./routes/uploadRoutes');


// Delegación de las rutas
app.use('/users', usuarioRouter);
app.use('/cars', cocheRouter);
app.use('/upload-images', uploadRouter);


db.sequelize.sync().then(() => {
    app.listen(3001, () => {
        console.log('Server is running on port 3001');
    });
});
