module.exports = (sequelize, DataTypes) => {
    const ImagenCoche = sequelize.define('ImagenCoche', {
      id_imagen_coche: {
        type: DataTypes.INTEGER,
        primaryKey: true
      },
      id_coche: DataTypes.STRING,
      ruta_img_coche: DataTypes.STRING
    }, {
      tableName: 'imagen_coche',
      timestamps: false,
      underscored: true
    });
  
    ImagenCoche.associate = models => {
      ImagenCoche.belongsTo(models.Coche, { foreignKey: 'id_coche' });
    };
  
    return ImagenCoche;
  };  