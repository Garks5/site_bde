const Sequelize = require('sequelize')

const dbName = 'users'
const username = 'root'
const password = ''
const host = 'localhost'
const dialect = 'mysql'

module.exports.sequelize = new Sequelize(dbName, username, password, {
    host: host,
    dialect: dialect
})