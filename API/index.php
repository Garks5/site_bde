<?php
use \Firebase\JWT\JWT;
/*
$mdp = crypt("bonjour", "3#5b[PzGu%P8");

$data = array("mail" => "lucas.duleu@viacesi.fr", "mdp" => $mdp);
$data_string = json_encode($data);
echo $data_string;
$header = array(
    'Accept: application/json',
    'Content-Type: application/json'
);
$ch = curl_init('localhost:3000/users?connect=true');

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
$result = curl_exec($ch);
$result = json_decode($result, true);
$mail = JWT::decode($result['token'], '5[:8j£NQ4Vcj', array('HS256'));
echo $mail;*/

$key = "example_key";
$token = array(
    "iss" => "http://example.org",
    "aud" => "http://example.com",
    "iat" => 1356999524,
    "nbf" => 1357000000
);

/**
 * IMPORTANT:
 * You must specify supported algorithms for your application. See
 * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
 * for a list of spec-compliant algorithms.
 */
$jwt = JWT::encode($token, $key, 'HS256');
$decoded = JWT::decode($jwt, $key, array('HS256'));

print_r($decoded);

/*
 NOTE: This will now be an object instead of an associative array. To get
 an associative array, you will need to cast it as such:
*/

$decoded_array = (array) $decoded;

/**
 * You can add a leeway to account for when there is a clock skew times between
 * the signing and verifying servers. It is recommended that this leeway should
 * not be bigger than a few minutes.
 *
 * Source: http://self-issued.info/docs/draft-ietf-oauth-json-web-token.html#nbfDef
 */
JWT::$leeway = 60; // $leeway in seconds
$decoded = JWT::decode($jwt, $key, array('HS256'));


?>