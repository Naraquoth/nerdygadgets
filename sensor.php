<?php
// vang hier postrequest af van de pi en zet dit in de juiste database.
$random = rand(1,400);
$url = 'http://numbersapi.com/'.$random.'/trivia';
$crl = curl_init();
curl_setopt($crl, CURLOPT_URL, $url);
curl_setopt($crl, CURLOPT_FRESH_CONNECT, true);
curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($crl);
curl_close($crl);
print($response);


// Access the JSON data from $_POST


// Check if data is available
