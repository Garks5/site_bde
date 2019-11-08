<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost:3000/users?connect=true');