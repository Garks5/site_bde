const enumTable = require('./enumTable');
const bdd = require('./BDDConnect')
const express = require('express');
const bodyparser = require('body-parser')
const jsToken = require('njwt')
const secret = "5[:8j£NQ4Vcj"

// Nous définissons ici les paramètres du serveur.
const hostname = 'localhost';
const port = 3000;
// Nous créons un objet de type Express.
var app = express();
app.use(bodyparser.json({ extended: true }))
//Afin de faciliter le routage (les URL que nous souhaitons prendre en charge dans notre API), nous créons un objet Router.
//C'est à partir de cet objet myRouter, que nous allons implémenter les méthodes.
var myRouter = express.Router();

// FAUT REGARDER https://scotch.io/tutorials/authenticate-a-node-es6-api-with-json-web-tokens#toc-setup
myRouter.route(['/users', '/inscriptions', '/roles', '/users/[0-9]+', '/boutique', '/boutique/[0-9]+', '/activities', '/activities/[0-9]+', '/commentaries', '/pictures', '/topboutique', '/votes', '/orders', '/components', 'products/[0-9]+', '/myactivities'])
      // GET
      .get(function (req, res) {
            var uri = req.path.split('/')
            var table = uri[1]
            var table = enumTable.table(table)
            var id = uri[2]
            var array = []

            //renvoi les données lorsequ'on est pas connecté (statut visiteur)
            if (((uri[1] == "boutique" && uri[2] == null) || (uri[1] == "activities" && uri[2] == null) || uri[1] == "pictures" || uri[1] == "commentaries") && !req.headers.authorization) {
                  console.log('fonction1')
                  bdd.select(table)
                        .then(response => {
                              if (response.length) {
                                    status = 200
                                    for (let i = 0; i < response.length; i++) {
                                          array.push(response[i].dataValues)
                                    }
                              } else {
                                    status = 400
                              }
                              res.status(status).json(array)
                        })
            }
            //renvoie les données des 3 meilleures ventes
            else if (uri[1] == "topboutique") {
                  bdd.selectTri()
                        .then(response => {
                              for (let i = 0; i < response.length; i++) {
                                    array.push(response[i].dataValues)
                              }
                              res.status(200).json(array)
                        })
            }
            //renvoie les données des produits en fonction de leur types (tri)
            else if ((uri[1] == "boutique" && uri[2] != null)) {
                  bdd.selectType(uri[2])
                        .then(response => {
                              for (let i = 0; i < response.length; i++) {
                                    array.push(response[i].dataValues)
                              }
                              res.status(200).json(array)
                        })
            }
            //renvoie les données pour soit les activités validées par le BDE (quand uri[1]=1) soit pour les données non validées (quand uri[1]=0)
            else if (uri[1] == "activities" && uri[2] != null) {
                  console.log(uri[2])
                  bdd.selectAvailable(uri[2])
                        .then(response => {
                              for (let i = 0; i < response.length; i++) {
                                    array.push(response[i].dataValues)
                              }
                              res.status(200).json(array)
                        })
            }

            else if (uri[1] == "products" && uri[2] != null) {
                  bdd.selectID(uri[2])
                        .then(response => {
                              res.status(200).json(array)
                        })
            }

            //renvoie les données des participants d'une activité pour génération de csv 
            else if (uri[1].split('?')[0] == "activities" && req.query.hasOwnProperty('id') && req.query.download == 'true') {
                  console.log('csv')
                  var token = req.headers.authorization.split(' ')[1]
                  if (req.headers.authorization) {
                        mail = decodeToken(token).mail
                        bdd.userActivity(req.query.id)
                              .then(response => {
                                    if (response) {
                                          for (let i = 0; i < response[0].length; i++) {
                                                array.push(response[0][i])
                                          }
                                          res.status(200).json(array)
                                    }
                              })
                  }
            } else if (req.headers.authorization && uri[1] == 'myactivities') {
                  token = req.headers.authorization.split(' ')[1]
                  mail = decodeToken(token).mail
                  bdd.myActivities(mail, res)
            }
            //renvoie les doonées sans condition particulières || mis en commentaire car grosse faille de sécurité (possibilté d'accéder aux données de certaines tables de notre BDD)
            /*else {
                  token2 = req.headers.authorization
                  token2 = token2.split(' ')
                  if (req.headers.authorization) {
                        bdd.select(table, id)
                              .then(response => {
                                    if (response.length) {
                                          for (let i = 0; i < response.length; i++) {
                                                array.push(response[i].dataValues)
                                          }
                                    } else {
                                          array.push(response.dataValues)
                                    }
                                    res.json(array)
                              })
                  } else {
                        res.json({ message: false })
                  }
            }*/
      })
      //POST
      .post(function (req, res) {
            var uri = req.path.split('/')
            var table = uri[1]
            var table = enumTable.table(table)
            //connection
            if (req.query.connect == "true") {
                  connect(req, res)
            } else {
                  //permet d'ajouter des données aux membres du BDE
                  if (req.headers.authorization && req.body.role == "BDE") {
                        var mail = decodeToken(req.headers.authorization.split(' ')[1]).mail
                        bdd.verifUser(mail, req.body.role)
                              .then(function (response) {
                                    if (response) {
                                          req.body.id = response.dataValues.id
                                          bdd.add(table, req.body, res)
                                    } else {
                                          res.json({ connect: "refused" })
                                    }
                              })
                  }
                  //permet d'ajouter une activité (non vérifiée)
                  else if (req.headers.authorization && table.name == "activities") {
                        var mail = decodeToken(req.headers.authorization.split(' ')[1]).mail
                        var id = decodeToken(req.headers.authorization.split(' ')[1]).id
                        bdd.verifUser(mail, req.body.role)
                              .then(function (response) {
                                    if (response) {
                                          req.body.id = id
                                          bdd.add(table, req.body, res)
                                    } else {
                                          res.status(400).json({ connect: "refused" })
                                    }
                              })

                  }
                  //pour ajouter à notre base de données une inscriptions, un vote, une photo, un commentaire, un paiment et l'objet vendu dans la boutique, un panier
                  else if (req.headers.authorization && (table.name == "inscriptions" || table.name == "votes" || table.name == "pictures" || table.name == "commentaries")) {
                        console.log(req.body.role)
                        var mail = decodeToken(req.headers.authorization.split(' ')[1]).mail
                        bdd.verifUser(mail, req.body.role)
                              .then(function (response) {
                                    if (response) {
                                          bdd.add(table, req.body, res)
                                    } else {
                                          res.json({ connect: "refused" })
                                    }
                              })
                  } else if (req.headers.authorization && table.name == 'components') {
                        var mail = decodeToken(req.headers.authorization.split(' ')[1]).mail
                        bdd.buy(res, req.body, mail)
                  }
                  //inscription
                  else if (req.body.inscription == "true") { //inscription
                        bdd.add(table, req.body, res)
                  }
            }
      })
      //PUT
      .put(function (req, res) {
            var uri = req.path.split('/')
            var table = uri[1]
            var table = enumTable.table(table)
            //pour faire passer une activité non vérifiée à une activité vérifiée (seulement pour le BDE)
            if (req.headers.authorization && (req.body.role == "BDE" || req.body.role == "Personnel CESI") && table.name == 'activities') {
                  bdd.modify(table, req.body, res)
            }
      })
      //DELETE
      .delete(function (req, res) {
            var uri = req.path.split('/')
            var table = uri[1]
            var table = enumTable.table(table)
            //pour supprimer des données dans une table (seulement pour le BDE)
            if (req.body.role == "BDE" && (table.name == "commentaries" || table.name == "pictures" || table.name == "products" || table.name == "activities")) {
                  bdd.delete(table, req.body, res)
            }
      });



// Nous demandons à l'application d'utiliser notre routeur
app.use(myRouter);
// Démarrer le serveur 
app.listen(port, hostname, () => {
      console.log("Mon serveur fonctionne sur http://" + hostname + ":" + port);
});

//fonction permettant la connexion
function connect(req, res) {
      var result = {}
      bdd.connect(enumTable.table(req.path.split('/')[1]), req.body)
            .then(function (user) {
                  if (user) {
                        status = 200
                        result.id = user.dataValues.id
                        const payload = { "mail": user.dataValues.mail }
                        var token = jsToken.create(payload, secret, "HS256")
                        bdd.verifRole(user.dataValues.mail)
                              .then(response => {
                                    token = token.compact()
                                    result.token = token
                                    result.role = response[0][0]['role.name']
                                    result.firstname = user.dataValues['firstname']
                                    result.status = status
                                    res.status(status).json(result)
                              })
                  } else {
                        status = 400
                        result.status = status
                        res.json({ connect: false })
                  }
            })
}

//Permet de décoder un token pour retrouver l'adresse mail et l'id de l'utilisateur connecté
function decodeToken(token) {
      var decoded = {}
      var decodedToken = jsToken.verify(token, secret, "HS256")
      decoded.mail = decodedToken.body.mail
      decoded.id = decodedToken.body.id
      return decoded;
}