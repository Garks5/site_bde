
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
myRouter.route(['/users', '/inscriptions', '/roles', '/users/[0-9]+', '/boutique', '/activities', '/commentaries', '/pictures'])
      // GET
      .get(function (req, res) {
            var uri = req.path.split('/')
            var table = uri[1]
            var table = enumTable.table(table)
            var id = uri[2]
            var array = []
            if (uri[1] == "boutique" || uri[1] == "activities" || uri[1] == "pictures") {
                  bdd.select(table)
                        .then(response => {
                              //console.log(response[0].dataValues)
                              //console.log(response[1].dataValues)
                              console.log(response.lenght)
                              if (response.lenght) {
                                    console.log(response)
                                    status = 200
                                    for (let i = 0; i < response.lenght; i++) {
                                          array.push(response[i].dataValues)
                                    }
                              } else if (response) {
                                    status = 200
                                    array.push(response[0].dataValues)
                              } else {
                                    status = 400
                              }
                              res.status(status).json(array)
                        })
            } else {
                  token2 = req.headers.authorization
                  token2 = token2.split(' ')
                  console.log(token2[1])
                  //token = token['input'].match('(?!Bearer )([a-zA-Z0-9-.])')
                  console.log(token2)
                  if (req.headers.authorization) {
                        bdd.select(table, id)
                              .then(response => {
                                    if (response.lenght) {
                                          for (let i = 0; i < response.lenght; i++) {
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
            }
      })
      //POST
      .post(function (req, res) {
            var uri = req.path.split('/')
            var table = uri[1]
            var table = enumTable.table(table)
            if (req.query.connect == "true") { //connection
                  console.log(req.body.mail)
                  connect(req, res)
            } else {
                  if (req.body.token && req.body.role == "BDE") {
                        var mail = decodeToken(req.body.token)
                        bdd.verifUser(mail, req.body.role)
                              .then(function (response) {
                                    if (response) {
                                          req.body.id = response.dataValues.id
                                          bdd.add(table, req.body, res)
                                    } else {
                                          res.json({ connect: refused })
                                    }
                              })
                  } else if (req.body.inscription == "true") { //inscription
                        console.log("bonjour " + table)
                        bdd.add(table, req.body, res)
                  }
            }
      })
      //PUT
      .put(function (req, res) {
            var uri = req.path.split('/')
            var table = uri[1]
            var table = enumTable.table(table)
            if (req.body.token) {

            }
            //bdd.modify(enumTable.table(req.path.split('/')[1]), req.body, res)
      })
      //DELETE
      .delete(function (req, res) {
            var uri = req.path.split('/')
            var table = uri[1]
            var table = enumTable.table(table)
            if (req.body.role == "BDE" && (table.name == "commentaries" || table.name == "pictures")) {
                  bdd.delete(table, req.body)
            }
      });



// Nous demandons à l'application d'utiliser notre routeur
app.use(myRouter);
// Démarrer le serveur 
app.listen(port, hostname, function () {
      console.log("Mon serveur fonctionne sur http://" + hostname + ":" + port);
});


function connect(req, res) {
      var result = {}
      bdd.connect(enumTable.table(req.path.split('/')[1]), req.body)
            .then(function (response) {
                  if (response) {
                        status = 200

                        const payload = { "mail": response.dataValues.mail }
                        var token = jsToken.create(payload, secret, "HS256")
                        bdd.verifRole(response.dataValues.mail)
                              .then(response => {
                                    token = token.compact()
                                    result.token = token
                                    result.role = response[0][0]['role.name']
                                    result.name = response[0][0]['users.name']
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
// Pour l'instant on considère que le token se trouve dans le body
function decodeToken(token) {
      var decodedToken = jsToken.verify(token, secret, "HS256")
      decodedMail = decodedToken.body.mail
      return decodedMail;
}