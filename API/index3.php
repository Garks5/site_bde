<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
    <head>
        <title>Mon blog</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link href="style.css" rel="stylesheet" type="text/css" />
    </head>
         
    <body>
    <form method="post" enctype="multipart/form-data">
        <p>
                Formulaire d'envoi de fichier :<br />
                <input type="file" name="monfichier" /><br />
                <input type="submit" value="Envoyer le fichier" />
        </p>
</form>
 
<?php
 
 $nom = crypt($_FILES['monficher']['name']);
 $uploaddir = '/Users/rodriguetaccoen/Desktop/photo/';
 $uploadfile = $uploaddir . basename($_FILES['monfichier']['name']);
 echo $uploadfile;
 echo $_FILES['monfichier']['tmp_name'];
// Testons si le fichier a bien été envoyé et s'il n'y a pas d'erreur
if (isset($_FILES['monfichier']) AND $_FILES['monfichier']['error'] == 0)
{
        // Testons si le fichier n'est pas trop gros
        if ($_FILES['monfichier']['size'] <= 1000000)
        {
                // Testons si l'extension est autorisée
                $infosfichier = pathinfo($_FILES['monfichier']['name']);
                $extension_upload = $infosfichier['extension'];
                $extensions_autorisees = array('jpg', 'jpeg', 'png');
                if (in_array($extension_upload, $extensions_autorisees))
                {
                    // On peut valider le fichier et le stocker définitivement
                    $resultat = move_uploaded_file($_FILES['monfichier']['tmp_name'], $uploadfile);
                    if ($resultat){
                        echo "Transfert réussi";
                        rename($uploadfile, $uploaddir . $nom . '.png');
                    }else { 
                        echo 'echec transfert';
                    }
                }
        }
}
if(isset($_FILES['monfichier'])){
$data = array("users_id" => 1, "activities_id" => 1, "url" => $uploaddir . $nom . '.png', "description" => "pull CESI", "role" => "BDE");
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://localhost:3000/pictures");
$token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJtYWlsIjoicGF1bGluZS5sZWdyb3V4QHZpYWNlc2kuZnIiLCJpZCI6MTEsImp0aSI6Ijc3MjA5OWEwLTEzZjYtNDBmZS04NjI5LTM5NjkwYTU4NDJkYiIsImlhdCI6MTU3Mzc0MDYwMCwiZXhwIjoxNTczNzQ0MjAwfQ.YlR7VePHX5ajUwy2vEBZgz9z7JvptCXg7gPYpJfZWGY";
$header = array(
    'Accept: application/json',
    'Content-Type: application/json',
    'Authorization: Bearer ' .$token,
    'Content-Length' . strlen($data)
    );
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$result = curl_exec($ch);
$result = json_decode($result, true);
if($result){
    echo 'bonjour';
}
}
/*try
{
    // On se connecte à MySQL
    $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
    $bdd = new PDO('mysql:host=localhost;dbname=test', 'root', '', $pdo_options);
     
    // On récupère tout le contenu de la table photo
    $reponse = $bdd->query('SELECT * FROM photo');
    
 
$req = $bdd->prepare('INSERT INTO photo (image) VALUES(?)');
$req->execute(array($nom));
 
 
    // On affiche chaque entrée une à une
    while ($donnees = $reponse->fetch())
    {
 ?>
    <img src="../site/<?php echo $nom; ?>">
    <?php
 
    }
     
    $reponse->closeCursor(); // Termine le traitement de la requête
 
}
catch(Exception $e)
{
    // En cas d'erreur précédemment, on affiche un message et on arrête tout
    die('Erreur : '.$e->getMessage());
}
 */
 
?>
 
</body>
</html>