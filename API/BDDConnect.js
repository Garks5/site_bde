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
        return table.findAll({})
    } else {
        return table.findOne({ where: { id: id } })
    }
}

module.exports.selectTri = function () {
    return table.table("boutique").findAll({
        order: [
            ['nb_vendu', 'DESC']
        ],
        limit: 3
    })
}

module.exports.selectID = function (id){
    console.log(id)
    return table.table("boutique").findAll({
        where: {types_id : id}
    })
}


module.exports.connect = function (table, jsonData) {
    console.log(jsonData.mail)
    return table.findOne({ where: { mail: jsonData.mail, mdp: jsonData.mdp } })
}
module.exports.add = function (table, jsonData, res) {
    switch (table.name) {
        case "users":
            table.findOne({ where: { mail: jsonData.mail } })
                .then(function (user) {
                    if (!user) {
                        table.create({ roles_id: jsonData.roles_id, name: jsonData.name, firstname: jsonData.firstname, mail: jsonData.mail, mdp: jsonData.mdp, localisation: jsonData.localisation })
                        res.status(200).json({ inscription: "réussi" })
                    } else {
                        res.status(400).json({ inscription: "false" })
                    }
                })
            break
        case "activities":
            if (jsonData.role == "BDE") {
                table.create({ users_id: jsonData.id, date: jsonData.date, available: jsonData.available, place:jsonData.place, name:jsonData.name, description:jsonData.description})
                res.status(200).json({ add: "succeed" })
            } else {
                res.status(400).json({ authorization: "Not authorized" })
            }
            break
        case "products":
            if (jsonData.role == "BDE") {
                table.create({ types_id: jsonData.types_id, name: jsonData.name, price: jsonData.price, description: jsonData.description, picture: jsonData.picture, nb_vendu: jsonData.nb_vendu })
                res.status(200).json({ add: "succeed" })
            } else {
                res.status(400).json({ authorization: "Not authorized" })
            }
            break
        case "inscriptions":
            table.create({ activities_id: jsonData.activities_id, users_id: jsonData.users_id })
            res.status(200).json({ add: "succeed" })
            break
        case "commentaries":
            table.create({ users_id: jsonData.users_id, commentary: jsonData.commentary, activities_id: jsonData.activities_id })
            res.status(200).json({ add: "succeed" })
            break
        case "pictures":
            table.create({users_id:jsonData.users_id, activities_id:jsonData.activities_id, url:jsonData.url, description:jsonData.description})
            res.status(200).json({ add: "succeed" })
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
}

module.exports.findID = function (mail){
    return table.table("users").findOne({ where: {mail : mail}})
}

module.exports.verifUser = function (mail, role) {
    var roleID
    switch (role) {
        case "Étudiant":
            roleID = 1
            break;
        case "BDE":
            roleID = 2
            break;
        case "PeronnelCESI":
            roleID = 3
            break;
    }
    return table.table("users").findOne({ where: { mail: mail, roles_id: roleID } })
}