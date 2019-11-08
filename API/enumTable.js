const tables = require('./BDDConnect')
module.exports.table = function (table) {
    switch (table) {
        case "users":
            return tables.User
        case "inscriptions":
            return tables.Inscription
        case "roles":
            return tables.Role
    }
}