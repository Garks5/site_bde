const tables = require('./BDDConnect2')
module.exports.table = function(table){
    switch(table){
        case "users":
            return tables.User
        case "inscriptions":
            return tables.Inscription
    }
}