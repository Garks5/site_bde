<?php
session_start();
$mdp = crypt("bonjour", "3#5b[PzGu%P8");

$data = array("mail" => "lucas.duleu@viacesi.fr", "mdp" => $mdp);
$data_string = json_encode($data);
echo $data_string;

$ch = curl_init('http://localhost:3000/users?connect=true');

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
if($_SESSION['user']){
    $data = array("token" => $_SESSION['user']);
    $data_string = json_encode($data);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
}else{
    echo "bonour";
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
}
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string))                                                              
);

$result = curl_exec($ch);
$result = json_decode($result, true);

foreach($result as $clef => $value){
    echo $clef . ' = ' . $value;
    if($clef == 'token'){
        $_SESSION['user'] = $value;
    }
}
?>