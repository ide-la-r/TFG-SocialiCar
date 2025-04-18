module.exports = (sequelize, DataTypes) => {
    const Coche = sequelize.define('Coche', {
      id_usuario: DataTypes.STRING,
      matricula: {
        type: DataTypes.STRING,
        primaryKey: true
      },
      seguro: DataTypes.BOOLEAN,
      marca: DataTypes.STRING,
      modelo: DataTypes.STRING,
      anno_matriculacion: DataTypes.DATE,
      kilometros: DataTypes.DECIMAL,
      combustible: DataTypes.STRING,
      transmision: DataTypes.STRING,
      ubicacion: DataTypes.STRING,
      tipo_aparcamiento: DataTypes.STRING,
      mascota: DataTypes.BOOLEAN,
      fumar: DataTypes.BOOLEAN,
      ruta_img_coche: DataTypes.STRING
    }, {
      tableName: 'coche',
      timestamps: false,
      underscored: true
    });
  
    Coche.associate = models => {
      Coche.belongsTo(models.Usuario, { foreignKey: 'id_usuario' });
      Coche.hasMany(models.ReservaCoche, { foreignKey: 'matricula' });
      Coche.hasMany(models.ImagenCoche, { foreignKey: 'id_coche' });
    };
  
    return Coche;
  };