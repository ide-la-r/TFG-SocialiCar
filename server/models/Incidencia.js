module.exports = (sequelize, DataTypes) => {
    const Incidencia = sequelize.define('Incidencia', {
      id_reserva: DataTypes.INTEGER,
      id_incidencia: {
        type: DataTypes.INTEGER,
        primaryKey: true,
        autoIncrement: true
      },
      descripcion: DataTypes.STRING,
      estado: DataTypes.STRING,
      fecha_incidencia: DataTypes.DATE
    }, {
      tableName: 'incidencia',
      timestamps: false,
      underscored: true
    });
  
    Incidencia.associate = models => {
      Incidencia.belongsTo(models.ReservaCoche, { foreignKey: 'id_reserva' });
    };
  
    return Incidencia;
  };
  