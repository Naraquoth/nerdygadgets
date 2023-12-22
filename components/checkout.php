<?php
require_once "./lib/database.php";
// laat checkout formulier zien
// 1 customer gegevens ophalen en juiste customer selecteren of nieuwe aan maken.
// 2 order aanmaken
// 3 order details aanmaken
// bestelling afronden

$databaseConnection = connectToDatabase();

if (!isset($_SESSION["CustomerDetails"])){
   $_SESSION["CustomerDetails"] = getCustomerByPeopleID($_SESSION["userID"], $databaseConnection)[0];
}
$customer = $_SESSION["CustomerDetails"];
print_r($customer);

if (isset($_POST["pay-submit"])){
    require_once "./lib/betaalfuncties.php";
    $amount = number_format($totaalPrijs, 2, '.', ''); // maak een variable aan voor de totaal prijs en zet het in het juiste formats
    
    // create order

    $orderid = createNewOrder($_SESSION["CustomerDetails"]["CustomerID"], $_SESSION["userID"], $cartItems, $databaseConnection);

    $payment = createPayment($amount, $_POST["issuer"], $orderid);

    session_destroy();

    header("Location: " . $payment->getCheckoutUrl(), true, 303);
    die();
    

} else {
    $people = getPeopleById($_SESSION["userID"], $databaseConnection)[0];
    require_once "./components/checkoutForms/idealForm.php";
    echo "<br><br>";
    require_once "./components/checkoutForms/customerDetails.php";
    echo "<br><br>";
}
