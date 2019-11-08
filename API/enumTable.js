const tables = require('./BDDConnect')


module.exports.table = function (table) {
    switch (table) {
        case "users":
            return tables.User
        case "inscriptions":
            return Inscription = tables.sequelize.define('inscriptions', {
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

        case "roles":
            return tables.Role
        case "boutique":
            return tables.Products
    }
}