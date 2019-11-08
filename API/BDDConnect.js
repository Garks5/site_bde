const connection = require('./config.js')

connection.sequelize.authenticate()
    .then(() => {
        console.log('Connection has been established successfully   ')
    })
    .catch(err => {
        console.error('Unable to connect to the database', err)
    })

module.exports.select = function (table, id) {
    if (!id) {
        return table.findAll({
        })
    } else {
        return table.findOne({ where: { id: id } })
    }

}

module.exports.connect = function (table, jsonData) {
    return table.findOne({ where: { mail: jsonData.mail, mdp: jsonData.mdp } })
}
module.exports.add = function (table, jsonData) {
    switch (table.name) {
        case "users":
            console.log("bonjour")
            table.findOne({ where: { mail: jsonData.mail } })
                .then(function (user) {
                    if (!user) {
                        table.create({ roles_id: jsonData.roles_id, name: jsonData.name, firstname: jsonData.firstname, mail: jsonData.mail, mdp: jsonData.mdp, localisation: jsonData.localisation })
                    }
                })
            break
        case "inscriptions":
            console.log("bonjour2")
            table.create({ date: jsonData.date })
            break
        case "roles":
            table.findOne({ where: { name: jsonData.name } })
                .then(function (role) {
                    if (role) {
                        console.log(role)
                        return false
                    } else {
                        table.create({ name: jsonData.name })
                        return true
                    }
                })
            break
    }
}

module.exports.modify = function (table, jsonData) {
    var obj = Object.keys(jsonData)
    table.findOne({ where: { id: jsonData.id } })
        .then(function (user) {
            for (var i = 1; i < obj.length; i++) {
                user[obj[i]] = jsonData[obj[i]]
            }
            user.save().then(function () {
            });
        });
}

module.exports.delete = function (table, jsonData) {
    table.destroy({ where: { id: jsonData.id } })
}