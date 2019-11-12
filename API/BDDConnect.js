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
                        //return false
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
        case "activities":
            table.create({ users_id: jsonData.id, date: jsonData.date, available: jsonData.available})
            res.status(200).json({add : "succeed"})
            break
        case "products":
            table.create({types_id: jsonData.types_id, name: jsonData.name, price: jsonData.price, description: jsonData.description, nb_vendu: jsonData.nb_vendu})
            res.status(200).json({add : "succeed"})
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
    return connection.sequelize.query('SELECT `role`.`name` AS `role.name`, `users`.`name` AS `users.name` FROM `users` AS `users` LEFT OUTER JOIN `roles` AS `role` ON `users`.`roles_id` = `role`.`id` WHERE `users`.`mail` = "' + mail + '" LIMIT 1')
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

module.exports.verifUser = function (mail, role) {
    var roleID
    switch (role){
        case "Etudiant":
            roleID = 1
            break;
        case "MembreBDE":
            roleID = 2
            break;
        case "PeronnelCESI":
            roleID = 3
            break;
    }
    return table.table("users").findOne({where: {mail: mail, roles_id: roleID}})
}