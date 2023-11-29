<?php
require_once "./lib/database.php";
// laat checkout formulier zien
// 1 customer gegevens ophalen en juiste customer selecteren of nieuwe aan maken.
// 2 order aanmaken
// 3 order details aanmaken
// bestelling afronden

$databaseConnection = connectToDatabase();

$customer = getCustomerByPeopleID($_SESSION["UserID"], $databaseConnection)[0];

require_once "./components/checkoutForms/customerDetails.php";
