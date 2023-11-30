<?php
require_once "./lib/database.php";
// laat checkout formulier zien
// 1 customer gegevens ophalen en juiste customer selecteren of nieuwe aan maken.
// 2 order aanmaken
// 3 order details aanmaken
// bestelling afronden

$databaseConnection = connectToDatabase();

$customer = getCustomerByPeopleID($_SESSION["userID"], $databaseConnection)[0];

if (isset($_POST["pay-submit"])){
    require_once "./lib/betaalfuncties.php";
    $amount = number_format($totaalPrijs, 2, '.', ''); // maak een variable aan voor de totaal prijs en zet het in het juiste formats
    
    // create order
    


    $payment = createPayment($amount, $_POST["issuer"], 0001);

    header("Location: " . $payment->getCheckoutUrl(), true, 303);
    

} else {
    require_once "./components/checkoutForms/idealForm.php";
    echo "<br><br>";
    require_once "./components/checkoutForms/customerDetails.php";
    echo "<br><br>";
}
