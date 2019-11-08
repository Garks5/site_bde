const connection = require('./config')

module.exports.User = connection.define('users', {
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
    timestamps: false
})

module.exports.Inscription = connection.define('inscriptions', {
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

module.exports.Role = connection.define('roles', {
    id: {
        type: Sequelize.INTEGER,
        primaryKey: true,
        autoIncrement: true
    },
    name: {
        type: Sequelize.STRING,
        allowNull: false
    }
}, {
    timestamps: false
})

module.exports.Products = sequelize.define('products', {
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
        allowNull: false
    }
}, {
    timestamps: false
})

module.exports.Activities = sequelize.define('activities', {
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

module.exports.Commentaries = sequelize.define('commentaries', {
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
    }
}, {
    timestamps: false
})

module.exports.Components = sequelize.define('components', {
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

module.exports.Components_orders = sequelize.define('components_orders', {
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

module.exports.Orders = sequelize.define('orders', {
    id: {
        type: Sequelize.INTEGER,
        primaryKey: true,
        autoIncrement: true,
    },
    users_id: {
        type: Sequelize.INTEGER,
        foreignKey: true,
        allowNull:true,
    },
}, {
    timestamps: false
})

modul.exports.Pictures = sequelize.define('pictures', {
    id: {
        type: Sequelize.INTEGER,
        primaryKey: true,
        autoIncrement: true,
    },
    users_id: {
        type: Sequelize.INTEGER,
        allowNull: true,
    },
    activties_id:{
        type: sequelize.INTEGER,
        allowNull: true,
    },
    url: {
        type: Sequelize.STRING,
    },
    description: {
        type: Sequelize.STRING,
    }
})

module.exports.Types = sequelize.define('types', {
    id: {
        type: Sequelize.INTEGER,
        primaryKey: true,
        autoIncrement: true,
    },
    name: {
        type: Sequelize.STRING,
    }
})


module.exports.Votes = sequelize.define('votes', {
    id: {
        type: Sequelize.INTEGER,
        primaryKey: true,
        autoIncrement: true,
    },
    users_id: {
        type: Sequelize.INTEGER,
        autoIncrement: true,
        allowNull: true,
    }
})