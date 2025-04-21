module.exports = (sequelize, DataTypes) => {
  const Coche = sequelize.define('Coche', {
    id_usuario: {
      type: DataTypes.STRING,
      allowNull: false
    },
    matricula: {
      type: DataTypes.STRING,
      allowNull: false
    },
    seguro: {
      type: DataTypes.BOOLEAN,
      allowNull: false
    },
    marca: {
      type: DataTypes.STRING,
      allowNull: false
    },
    modelo: {
      type: DataTypes.STRING,
      allowNull: false
    },
    anno_matriculacion: {
      type: DataTypes.DATE,
      allowNull: false
    },
    kilometros: {
      type: DataTypes.INTEGER,
      allowNull: false
    },
    combustible: {
      type: DataTypes.STRING,
      allowNull: false
    },
    transmision: {
      type: DataTypes.STRING,
      allowNull: false
    },
    ubicacion: {
      type: DataTypes.STRING,
      allowNull: false
    },
    tipo_aparcamiento: {
      type: DataTypes.STRING,
      allowNull: false
    },
    mascota: {
      type: DataTypes.BOOLEAN,
      allowNull: false
    },
    fumar: {
      type: DataTypes.BOOLEAN,
      allowNull: false
    },
    ruta_img_coche: {
      type: DataTypes.STRING,
      allowNull: true
    },
    movilidadreducia: {
      type: DataTypes.BOOLEAN,
      allowNull: false
    },
    aireacondicionado: {
      type: DataTypes.BOOLEAN,
      allowNull: false
    },
    gps: {
      type: DataTypes.BOOLEAN,
      allowNull: false
    },
    wifi: {
      type: DataTypes.BOOLEAN,
      allowNull: false
    },
    sensoresaparcamiento: {
      type: DataTypes.BOOLEAN,
      allowNull: false
    },
    camaradereversa: {
      type: DataTypes.BOOLEAN,
      allowNull: false
    },
    controldecrucero: {
      type: DataTypes.BOOLEAN,
      allowNull: false
    },
    asientoscalefactables: {
      type: DataTypes.BOOLEAN,
      allowNull: false
    }
  });
  return Coche;
};