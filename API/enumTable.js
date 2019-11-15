const tables = require('./tables')

//pour renvoyer la bonne table
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
        case "pictures":
            return tables.Pictures
        case "votes":
            return tables.Votes
        case "orders":
            return tables.Orders
        case "components":
            return tables.Components
    }
}