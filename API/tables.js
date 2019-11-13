const connection = require('./config')
const Sequelize = require('sequelize')

module.exports.User = connection.sequelize.define('users', {
    id: {
        type: Sequelize.INTEGER,
        primaryKey: true,
        autoIncrement: true
    },
    roles_id: {
        type: Sequelize.STRING,
        foreignKey: true
    },
    name: {
        type: Sequelize.STRING,
        allowNull: false
    },
    firstname: {
        type: Sequelize.STRING,
        allowNull: false
    },
    mail: {
        type: Sequelize.STRING,
        allowNull: false
    },
    mdp: {
        type: Sequelize.STRING,
        allowNull: false
    },
    localisation: {
        type: Sequelize.STRING,
        allowNull: false
    }
}, {
    underscored: true,
    timestamps: false
})

module.exports.Inscription = connection.sequelize.define('inscriptions', {
    id: {
        type: Sequelize.INTEGER,
        primaryKey: true,
        autoIncrement: true,
    },
    activities_id: {
        type: Sequelize.INTEGER,
        allowNull: true,
    },
    users_id: {
        type: Sequelize.INTEGER,
        allowNull: true,
    }
}, {
    timestamps: false
})

module.exports.Role = connection.sequelize.define('roles', {
    id: {
        type: Sequelize.INTEGER,
        primaryKey: true,
        autoIncrement: true,

    },
    name: {
        type: Sequelize.STRING,
        allowNull: false
    }
}, {
    timestamps: false
})

module.exports.Products = connection.sequelize.define('products', {
    id: {
        type: Sequelize.INTEGER,
        primaryKey: true,
        autoIncrement: true
    },
    types_id: {
        type: Sequelize.STRING,
        foreignKey: true
    },
    name: {
        type: Sequelize.STRING,
        allowNull: false
    },
    price: {
        type: Sequelize.FLOAT,
        allowNull: false
    },
    description: {
        type: Sequelize.STRING,
        allowNull: false
    },
    nb_vendu: {
        type: Sequelize.INTEGER,
        allowNull: true
    },
    picture: {
        type: Sequelize.STRING,
        allowNull: true
    }
}, {
    timestamps: false
})

module.exports.Activities = connection.sequelize.define('activities', {
    id: {
        type: Sequelize.INTEGER,
        primaryKey: true,
        autoIncrement: true
    },
    users_id: {
        type: Sequelize.INTEGER,
        foreignKey: true,
        allowNull: true,
    },
    date: {
        type: Sequelize.DATE,
    },
    available: {
        type: Sequelize.BOOLEAN,
    }
}, {
    timestamps: false
})

module.exports.Commentaries = connection.sequelize.define('commentaries', {
    id: {
        type: Sequelize.INTEGER,
        primaryKey: true,
        autoIncrement: true,
    },
    users_id: {
        type: Sequelize.INTEGER,
        foreignKey: true,
        allowNull: true,
    },
    commentary: {
        type: Sequelize.STRING,
    },
    activities_id: {
        type: Sequelize.INTEGER,
        allowNull: true,
    }
}, {
    timestamps: false
})

module.exports.Components = connection.sequelize.define('components', {
    id: {
        type: Sequelize.INTEGER,
        primaryKey: true,
        autoIncrement: true,
    },
    users_id: {
        type: Sequelize.INTEGER,
        foreignKey: true,
        allowNull: true,
    },
    quantity: {
        type: Sequelize.INTEGER,
    }
}, {
    timestamps: false
})

module.exports.Components_orders = connection.sequelize.define('components_orders', {
    components_id: {
        type: Sequelize.INTEGER,
        primaryKey: true,
        foreignKey: true,
    },
    orders_id: {
        type: Sequelize.INTEGER,
        foreignKey: true,
        primaryKey: true,
    },
}, {
    timestamps: false
})

module.exports.Orders = connection.sequelize.define('orders', {
    id: {
        type: Sequelize.INTEGER,
        primaryKey: true,
        autoIncrement: true,
    },
    users_id: {
        type: Sequelize.INTEGER,
        foreignKey: true,
        allowNull: true,
    },
}, {
    timestamps: false
})

module.exports.Pictures = connection.sequelize.define('pictures', {
    id: {
        type: Sequelize.INTEGER,
        primaryKey: true,
        autoIncrement: true,
    },
    users_id: {
        type: Sequelize.INTEGER,
        allowNull: true,
    },
    activities_id: {
        type: Sequelize.INTEGER,
        allowNull: true,
    },
    url: {
        type: Sequelize.STRING,
    },
    description: {
        type: Sequelize.STRING,
    }
}, {
    timestamps: false
})

module.exports.Types = connection.sequelize.define('types', {
    id: {
        type: Sequelize.INTEGER,
        primaryKey: true,
        autoIncrement: true,
    },
    name: {
        type: Sequelize.STRING,
    }
})


module.exports.Votes = connection.sequelize.define('votes', {
    id: {
        type: Sequelize.INTEGER,
        primaryKey: true,
        autoIncrement: true
    },
    users_id: {
        type: Sequelize.INTEGER,
        allowNull: true
    }
})
