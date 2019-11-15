<?php

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