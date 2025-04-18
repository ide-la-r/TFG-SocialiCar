module.exports = (sequelize, DataTypes) => {
    const ReservaCoche = sequelize.define('ReservaCoche', {
      fecha_inicio: DataTypes.DATE,
      fecha_final: DataTypes.DATE,
      id_usuario: DataTypes.STRING,
      matricula: DataTypes.STRING,
      id_reserva: {
        type: DataTypes.INTEGER,
        primaryKey: true,
        autoIncrement: true
      },
      ubi_entrega: DataTypes.STRING,
      ubi_recogida: DataTypes.STRING,
      tipo_seguro: DataTypes.STRING,
      fianza: DataTypes.INTEGER,
      precio_reserva: DataTypes.DECIMAL
    }, {
      tableName: 'reserva_coche',
      timestamps: false,
      underscored: true
    });
  
    ReservaCoche.associate = models => {
      ReservaCoche.belongsTo(models.Usuario, { foreignKey: 'id_usuario' });
      ReservaCoche.belongsTo(models.Coche, { foreignKey: 'matricula' });
      ReservaCoche.hasMany(models.Incidencia, { foreignKey: 'id_reserva' });
    };
  
    return ReservaCoche;
  };
  