const Sequelize = require('sequelize');

// Option 1: Passing parameters separately
const sequelize = new Sequelize('users', 'root', '', {
  host: 'localhost',
  dialect: 'mysql'
});

const User = sequelize.define('utilisateurs', {
    // attributes
    id: {
      type: Sequelize.INTEGER,
      primaryKey: true,
      autoIncrement: true
    },
    nom: {
      type: Sequelize.STRING,
      allowNull: false
    },
    prenom: {
        type: Sequelize.STRING,
        allowNull: false
    },
    mail: {
        type: Sequelize.STRING,
        allowNull: false
    },
    mdp: {
        type: Sequelize.STRING,
        allowNull: false
    },
    localisation: {
        type: Sequelize.STRING,
        allowNull: false
    }
  })

sequelize.authenticate()
    .then(() => {
        console.log('Connection has been established successfully')
    })
    .catch(err => {
        console.error('Unable to connect to the database', err)
    })

module.exports.selectAll = function(){
    return User.findAll({
    attributes: {exclude: ['createdAt', 'updatedAt']}
    })
}