<?php
$mdp = crypt("bonjour", "3#5b[PzGu%P8");

$data = array("mail" => "lucas.duleu@viacesi.fr", "mdp" => $mdp);
$data_string = json_encode($data);
echo $data_string;

$ch = curl_init('http://localhost:3000/users?connect=true');

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string))                                                              
);

$result = curl_exec($ch);
sleep(1);
echo "c bon ";
if($_POST == array()){
    echo "bite";
}
echo $_SERVER['REQUEST_METHOD'];
foreach($_POST as $clef => $value){
    echo $clef;
    echo "bonjour";
}
?>