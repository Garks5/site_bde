const tables = require('./tables')


module.exports.table = function (table) {
    switch (table) {
        case "users":
            return tables.User
        case "inscriptions":
            return tables.Inscription
        case "roles":
            return tables.Role
        case "boutique":
            return tables.Products
        case "activities":
            return tables.Activities
        case "commentaries":
            return tables.Commentaries
    }
}