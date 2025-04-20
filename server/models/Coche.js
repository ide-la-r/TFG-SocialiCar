module.exports = (sequelize, DataTypes) => {
  const Coche = sequelize.define('Coche', {
    id_usuario: DataTypes.STRING,
    matricula: {
      type: DataTypes.STRING,
      primaryKey: true
    },
    seguro: {
      type: DataTypes.BOOLEAN,
      allowNull: true 
    },
    marca: {
      type: DataTypes.STRING,
      allowNull: true 
    },
    modelo: {
      type: DataTypes.STRING,
      allowNull: true 
    },
    anno_matriculacion: {
      type: DataTypes.DATE,
      allowNull: true
    },
    kilometros: {
      type: DataTypes.DECIMAL,
      allowNull: true
    },
    combustible: {
      type: DataTypes.STRING,
      allowNull: true
    },
    transmision: {
      type: DataTypes.STRING,
      allowNull: true
    },
    ubicacion: {
      type: DataTypes.STRING,
      allowNull: true
    },
    tipo_aparcamiento: {
      type: DataTypes.STRING,
      allowNull: true
    },
    mascota: {
      type: DataTypes.BOOLEAN,
      allowNull: true
    },
    fumar: {
      type: DataTypes.BOOLEAN,
      allowNull: true 
    },
    ruta_img_coche: {
      type: DataTypes.STRING,
      allowNull: true 
    },
    movilidadreducia: {
      type: DataTypes.BOOLEAN,
      allowNull: true
    },
    aireacondicionado: {
      type: DataTypes.BOOLEAN,
      allowNull: true 
    },
    gps: {
      type: DataTypes.BOOLEAN,
      allowNull: true 
    },
    wifi: {
      type: DataTypes.BOOLEAN,
      allowNull: true 
    },
    sensoresaparcamiento: {
      type: DataTypes.BOOLEAN,
      allowNull: true 
    },
    camaradereversa: {
      type: DataTypes.BOOLEAN,
      allowNull: true
    },
    controldecrucero: {
      type: DataTypes.BOOLEAN,
      allowNull: true 
    },
    asientoscalefactables: {
      type: DataTypes.BOOLEAN,
      allowNull: true 
    }
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
