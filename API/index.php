<?php

$data = array("name" => "Hoang", "firstname" => "Kevin", "mail" => "kevin.hoang@viacesi.fr", "mdp" => "*¨%£¨*¨", "localisation" => "CESI LILLE");
$data2 = array("id" => 5, "id" => 4);
$data_string = json_encode($data2);

$ch = curl_init('http://localhost:3000/users');

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string))                                                                 
);

$result = curl_exec($ch);

?>