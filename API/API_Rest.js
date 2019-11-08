
const tables = require('./enumTable');
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


myRouter.route(['/users', '/inscriptions', '/roles', '/users/[0-9]+', '/boutique'])
      // GET
      .get(function (req, res) {
            if (req.path.split('/')[1] == "boutique") {
                  bdd.select(tables.table(req.path.split('/')[1]))
                        .then(response => {
                              console.log(response)
                              res.send("tamere")
                        })
            } else {

            }
      })
      //POST
      .post(function (req, res) {
            if (req.query.connect == "true") {
                  connect(req, res)
            } else {
                  bdd.add(tables.table(req.path.split('/')[1]), req.body)
            }
      })
      //PUT
      .put(function (req, res) {
            bdd.modify(tables.table(req.path.split('/')[1]), req.body)
            res.json({ message: "Mise à jour des informations d'une piscine dans la liste", methode: req.method });
      })
      //DELETE
      .delete(function (req, res) {
            bdd.delete(tables.table(req.path.split('/')[1]), req.body)
            res.json({ message: "Suppression d'une piscine dans la liste", methode: req.method });
      });
// Nous demandons à l'application d'utiliser notre routeur
app.use(myRouter);
// Démarrer le serveur 
app.listen(port, hostname, function () {
      console.log("Mon serveur fonctionne sur http://" + hostname + ":" + port);
});


function connect(req, res) {
      var result = {}
      bdd.connect(tables.table(req.path.split('/')[1]), req.body)
            .then(function (response) {
                  if (response) {
                        status = 200
                        const payload = { "mail": response.dataValues.mail }
                        var token = jsToken.create(payload, secret, "HS256")
                        token = token.compact()
                        result.token = token
                        result.status = status
                        res.status(status).json(result)
                  } else {
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