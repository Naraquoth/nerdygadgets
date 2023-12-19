<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Method not allowed";
    exit;
}

require_once "./lib/database.php";
$databaseConnection = connectToDatabase();

$json = file_get_contents('php://input');

if ($json != null){
    $data = json_decode($json, true); 
    if (isset($data["sensor_id"]) && isset($data["temp"]) && isset($data["date"])){
        // TODO: store data in database
        print_r($data);
        insertSensorData($data["sensor_id"], $data["temp"], $data["date"], $databaseConnection);
    } else {
        http_response_code(400);
        echo "JSON data is not valid";
    }
} else {
    http_response_code(400);
    echo "no JSON data received";
}

