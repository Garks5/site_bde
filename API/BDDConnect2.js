const Sequelize = require('sequelize');

// Option 1: Passing parameters separately
const sequelize = new Sequelize('users', 'root', '', {
    host: 'localhost',
    dialect: 'mysql'
});

module.exports.Inscription = sequelize.define('inscriptions', {
    id: {
        type: Sequelize.INTEGER,
        primaryKey: true,
        autoIncrement: true
    },
    date: {
        type: Sequelize.DATE,
    }
}, {
    timestamps: false
})

module.exports.User = sequelize.define('users', {
    // attributes
    id: {
        type: Sequelize.INTEGER,
        primaryKey: true,
        autoIncrement: true
    },
    id_role_id: {
        type: Sequelize.STRING,
        foreignKey: true
    },
    name: {
        type: Sequelize.STRING,
        allowNull: false
    },
    firstname: {
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
}, {
    timestamps: false
})

sequelize.authenticate()
    .then(() => {
        console.log('Connection has been established successfully')
    })
    .catch(err => {
        console.error('Unable to connect to the database', err)
    })

module.exports.selectAll = function (table) {
    return table.findAll({
    })
}

module.exports.add = function (table, jsonData) {
    table.create({ date: jsonData.date }, { fields: ['date'] })
}