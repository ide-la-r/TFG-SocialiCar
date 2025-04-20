module.exports = (sequelize, DataTypes) => {
    const Usuario = sequelize.define('Usuario', {
      nombre: DataTypes.STRING,
      apellido: DataTypes.STRING,
      dni: {
        type: DataTypes.STRING,
        primaryKey: true,
      },
      correo: {
        type: DataTypes.STRING,
        unique: true,
      },
      contrasena: DataTypes.STRING,
      telefono: DataTypes.STRING,
      foto_perfil: DataTypes.STRING,
      fecha_registro: DataTypes.DATE,
      fecha_update: DataTypes.DATE,
      ruta_img_dni: DataTypes.STRING,
      ruta_img_carnet: DataTypes.STRING
    }, {
      tableName: 'usuario',
      timestamps: false,
      underscored: true
    });
  
    Usuario.associate = models => {
      Usuario.hasMany(models.Coche, { foreignKey: 'id_usuario' });
      Usuario.hasMany(models.ReservaCoche, { foreignKey: 'id_usuario' });
    };
  
    return Usuario;
  };