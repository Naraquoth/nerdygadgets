<?php

require_once __DIR__ . '/../../lib/database.php';

$databaseConnection = connectToDatabase();

$People = getPeopleByEmail("bala@example.com",$databaseConnection)[0];

print_r($People);

echo "\n";

$customer = getCustomerByPeopleID($People["PersonID"],$databaseConnection);

print_r($customer);

echo "\n";

$orders = getOrderByCustomerId($customer[0]["CustomerID"],$databaseConnection);

print_r($orders[0]);

echo "\n";

$orderDetails = getOrderDetailsByOrderId($orders[0]["OrderID"],$databaseConnection);

print_r($orderDetails);

echo "\n";