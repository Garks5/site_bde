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
    switch (table.name) {
        case "users":
            console.log("bonjour")
            table.create({ name: jsonData.name, firstname: jsonData.firstname, mail: jsonData.mail, mdp: jsonData.mdp, localisation: jsonData.localisation })
            break
        case "inscriptions":
            console.log("bonjour2")
            table.create({ date: jsonData.date })
            break
    }
}

module.exports.modify = function (table, jsonData) {
    var obj = Object.keys(jsonData)
    switch (table.name) {
        case "users":
            table.findOne({ where: { id: jsonData.id } })
                .then(function (user) {
                    //user.name = jsonData.name;
                    for(var i = 1; i < obj.length; i++){
                        user[obj[i]] = jsonData[obj[i]]
                    }
                    user.save().then(function () {
                        // done
                    });

                });
            break
        case "inscriptions":
            table.update({ date: jsonData.date }, { where: { id: jsonData.id } })
            break
    }
}

module.exports.delete = function (table, jsonData) {
    switch (table.name) {
        case "users":
            table.destroy({ where: { id: jsonData.id } })
            break
        case "inscriptions":
            table.destroy({ where: { id: jsonData.id } })
            break
    }
}

function test(jsonData) {
    var jsonString = JSON.stringify(jsonData)

}