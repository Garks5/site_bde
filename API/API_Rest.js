const tables = require('./enumTable');
const bdd = require('./BDDConnect')
const express = require('express');
const bodyparser = require('body-parser')

// Nous définissons ici les paramètres du serveur.
const hostname = 'localhost';
const port = 3000;
// Nous créons un objet de type Express.
var app = express();
app.use(bodyparser.json({ extended: true }))
//Afin de faciliter le routage (les URL que nous souhaitons prendre en charge dans notre API), nous créons un objet Router.
//C'est à partir de cet objet myRouter, que nous allons implémenter les méthodes.
var myRouter = express.Router();


myRouter.route(['/users', '/inscriptions', '/roles', '/users/[0-9]+'])
      // GET
      .get(function (req, res) {
            var array = []
            var uri = req.path.split('/')
            var result = bdd.select(tables.table(uri[1]), uri[2])
            result.then(response => {
                  console.log(response)
                  console.log(response.lenght)
                  if (!uri[2]) {
                        for (let i = 0; i < response.length; i++) {
                              array.push(response[i].dataValues)
                              console.log("bite")
                        }
                        console.log(array)
                        res.json(array)
                  } else {
                        res.json(response.dataValues)
                  }
            })
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
      bdd.connect(tables.table(req.path.split('/')[1]), req.body)
            .then(function (response) {
                  if (response) {
                        console.log('c bon ')
                        res.json({ connect: true, methode: req.method });
                  } else {
                        res.json({ connect: false })
                  }
            })
}