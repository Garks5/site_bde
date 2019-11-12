const connection = require('./config.js')
const table = require('./enumTable')
const Sequelize = require('sequelize')


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
    console.log(jsonData.mail)
    return table.findOne({ where: { mail: jsonData.mail, mdp: jsonData.mdp } })
}
module.exports.add = function (table, jsonData, res) {
    switch (table.name) {
        case "users":
            console.log("c bon")
            table.findOne({ where: { mail: jsonData.mail } })
                .then(function (user) {
                    if (!user) {
                        console.log("pk sa bug")
                        table.create({ roles_id: jsonData.roles_id, name: jsonData.name, firstname: jsonData.firstname, mail: jsonData.mail, mdp: jsonData.mdp, localisation: jsonData.localisation })
                        res.json({ inscription: "réussi" })
                    } else {
                        res.json({inscription : "false"})
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
    console.log(obj)
    if (jsonData.id) {
        table.findOne(Sequelize.literal('WHERE id=' + jsonData.id))
            .then(function (user) {
                for (var i = 1; i < obj.length; i++) {
                    user[obj[i]] = jsonData[obj[i]]
                }
                user.save().then(function () {
                });
            });
    } else {
        connection.sequelize.query('UPDATE ' + table.name + ' SET ' + obj[0] + '="' + jsonData['changes'][obj[0]] + '" WHERE ' + obj[0] + '="' + jsonData[obj[0]] + '"')
    }
}

module.exports.delete = function (table, jsonData) {
    table.destroy({ where: { id: jsonData.id } })
}

module.exports.verifRole = function (mail) {
    return connection.sequelize.query('SELECT `users`.`id`, `users`.`roles_id`, `users`.`name`, `users`.`firstname`, `users`.`mail`, `users`.`mdp`, `users`.`localisation`, `users`.`roles_Id`, `role`.`id` AS `role.id`, `role`.`name` AS `role.name` FROM `users` AS `users` LEFT OUTER JOIN `roles` AS `role` ON `users`.`roles_id` = `role`.`id` WHERE `users`.`mail` = "' + mail + '" LIMIT 1')
    /*table.table('users').belongsTo(table.table('roles'))
    return table.table('roles').findOne({
        include: [{
            model: table.table('users'),
            where: {mail: mail}
        }]
    })
    .then( response => {
        console.log(response)
    })*/
}