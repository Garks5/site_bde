const connection = require('./config.js')
const table = require('./enumTable')
const Sequelize = require('sequelize')

//connection à la BDD
connection.sequelize.authenticate()
    .then(() => {
        console.log('Connection has been established successfully   ')
    })
    .catch(err => {
        console.error('Unable to connect to the database', err)
    })

//pour réaliser un SELECT soit pour toute une table, soit avec une condition sur l'id
module.exports.select = function (table, id) {
    if (!id) {
        return table.findAll({})
    } else {
        return table.findOne({ where: { id: id } })
    }
}

//pour réaliser un SELECT dans la table products, dans l'ordre décroissant du nombre de vente (carrousel top vente)
module.exports.selectTri = function () {
    return table.table("boutique").findAll({
        order: [
            ['nb_vendu', 'DESC']
        ],
        limit: 3
    })
}

module.exports.selectID = function (id) {
    return table.table("boutique").findOne({
        where: { id: id }
    })
}

module.exports.myActivities = function (mail, res) {
    array = []
    table.table('users').findOne({ where: { mail: mail } })
        .then(response => {
            if (response) {
                connection.sequelize.query('SELECT  `activities`.`id`, `activities`.`users_id`, ' +
                    '`activities`.`date`, `activities`.`available`, `activities`.`place`, `activities`.`name`, ' +
                    '`activities`.`description` FROM `activities` INNER JOIN `inscriptions` ON `inscriptions`.`activities_id`' +
                    ' = `activities`.`id` WHERE `inscriptions`.`users_id` = 15 ORDER BY `activities`.`date` DESC')
                    .then(activities => {
                        if (activities) {
                            for (let i = 0; i < activities[0].length; i++) {
                                array.push(activities[0][i])
                            }
                            res.status(200).json(array)
                        } else {
                            res.status(400).json({ status: "400" })
                        }
                    })
            }
        })
}

//pour réaliser un SELECT avec une condition sur le type des produits de la table products (tri par catégorie de produit)
module.exports.selectType = function (id) {
    console.log(id)
    return table.table("boutique").findAll({
        where: { types_id: id }
    })
}

//pour réaliser un SELECT quand une activité soit certifiée soit non certifiée
module.exports.selectAvailable = function (available) {
    console.log(available)
    return table.table("activities").findAll({
        where: { available: available }
    })
}

//vérification de connexion
module.exports.connect = function (table, jsonData) {
    return table.findOne({ where: { mail: jsonData.mail, mdp: jsonData.mdp } })
}

//pour ajouter des données dans une table
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
            console.log(jsonData)
            table.create({ users_id: jsonData.id, date: jsonData.date.date, available: jsonData.available, place: jsonData.place, name: jsonData.name, description: jsonData.description })
            res.status(200).json({ add: "succeed" })
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
            table.create({ users_id: jsonData.users_id, activities_id: jsonData.activities_id, url: jsonData.url, description: jsonData.description })
            res.status(200).json({ add: "succeed" })
            break
        case "votes":
            table.create({ users_id: jsonData.users_id, activities_id: jsonData.activities_id })
            res.status(200).json({ add: "succeed " })
            break
        case "orders":
            table.create({ users_id: jsonData.users_id, available: jsonData.available })
            res.status(200).json({ add: "succeed " })
            break
        case "components":
            table.create({ products_id: jsonData.products_id, quantity: jsonData.quantity })
            res.status(200).json({ add: "succeed " })
            break
    }
}

//pour modifier les données d'une table
module.exports.modify = function (table, jsonData, res) {
    var obj = Object.keys(jsonData)
    console.log(obj)
    if (jsonData.id) {
        table.findOne({ where: { id: jsonData.id } })
            .then(function (user) {
                for (var i = 2; i < obj.length; i++) {
                    user[obj[i]] = jsonData[obj[i]]
                }
                user.save().then(function () {
                    res.status(200).json({ modif: "succeed" })
                }).catch(err => {
                    res.status(400).json({ error: err })
                });
            });
    } else {
        connection.sequelize.query('UPDATE ' + table.name + ' SET ' + obj[0] + '="' + jsonData['changes'][obj[0]] + '" WHERE ' + obj[0] + '="' + jsonData[obj[0]] + '"')
    }
}

//pour supprimer les activités d'une table
module.exports.delete = function (table, jsonData, res) {
    table.destroy({ where: { id: jsonData.id } })
    res.status(200).json({ delete: "succeed" })
}

//pour vérifier qu'un utilisateur ne triche pas sur son role
module.exports.verifRole = function (mail) {
    return connection.sequelize.query('SELECT `role`.`name` AS `role.name`, `users`.`name` AS `users.name` FROM `users` AS `users` LEFT OUTER JOIN `roles` AS `role` ON `users`.`roles_id` = `role`.`id` WHERE `users`.`mail` = "' + mail + '" LIMIT 1')
}

//pour retrouver l'id d'un utilsateur via son mail
module.exports.findID = function (mail) {
    return table.table("users").findOne({ where: { mail: mail } })
}

//pour vérifier qu'un utilisateur ne triche pas sur son mail
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

//pour renvoyer les utilisateurs inscrit à une certaine activité
module.exports.userActivity = function (id) {
    return connection.sequelize.query("SELECT users.name, users.firstname, users.mail, users.localisation FROM `users` INNER JOIN inscriptions ON users.id = inscriptions.users_id WHERE inscriptions.activities_id =" + id)
}