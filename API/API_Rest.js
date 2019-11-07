var bdd = require('./BDDConnect2');

var express = require('express');

// Nous définissons ici les paramètres du serveur.
var hostname = 'localhost';
var port = 3000;
// Nous créons un objet de type Express.
var app = express();

//Afin de faciliter le routage (les URL que nous souhaitons prendre en charge dans notre API), nous créons un objet Router.
//C'est à partir de cet objet myRouter, que nous allons implémenter les méthodes.
var myRouter = express.Router();


myRouter.route('/users/d?')
// GET
.get(function(req,res){
      var array = []
      var result = bdd.selectAll()
      result.then(response => {
            for(let i = 0; i < response.length; i++){
                  array.push(response[i].dataValues)
            }
            res.json(array)
      })
})
//POST
.post(function(req,res){
      res.json({message : "Ajoute une nouvelle piscine à la liste", methode : req.method});
})
//PUT
.put(function(req,res){
      res.json({message : "Mise à jour des informations d'une piscine dans la liste", methode : req.method});
})
//DELETE
.delete(function(req,res){ 
      res.json({message : "Suppression d'une piscine dans la liste", methode : req.method});  
      }); 
       
// Nous demandons à l'application d'utiliser notre routeur
app.use(myRouter);  
// Démarrer le serveur 
app.listen(port, hostname, function(){
      console.log("Mon serveur fonctionne sur http://"+ hostname +":"+port); 
});
