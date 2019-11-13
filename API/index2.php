<?php
$ch = curl_init();
 
curl_setopt($ch, CURLOPT_URL, "http://localhost:3000/users");
 $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJtYWlsIjoibHVjYXMuZHVsZXVAdmlhY2VzaS5mciIsImp0aSI6ImNkZTk2MDAwLWI4MmMtNGJjNS05YTQ1LTI2YzQxNTg0ZDUyYiIsImlhdCI6MTU3MzYzNjUwMywiZXhwIjoxNTczNjQwMTAzfQ.aEmu6T1EpYSiBQ5hV9ANcsEJgDXvXn5Ogyl_vn_wvAY";
$header = array(
   'Accept: application/json',
   'Content-Type: application/json',
   'Authorization: Bearer ' .$token
   );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
 
       $result = curl_exec($ch);
 
        json_decode($result);
	    var_dump ($result);
	    curl_close($ch);