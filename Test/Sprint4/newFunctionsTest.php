<?php

require_once __DIR__ . '/../../lib/database.php';

$email = $_GET["email"];

$databaseConnection = connectToDatabase();

$People = getPeopleByEmail($email,$databaseConnection)[0];

print_r($People);

echo "<br><br>";

$customer = getCustomerByPeopleID($People["PersonID"],$databaseConnection);

print_r($customer);

echo "<br><br>";

$orders = getOrderByCustomerId($customer[0]["CustomerID"],$databaseConnection);

print_r($orders[count($orders) - 1]);

echo "<br><br>";

$orderDetails = getOrderDetailsByOrderId($orders[0]["OrderID"],$databaseConnection);

print_r($orderDetails);

echo "<br><br>";