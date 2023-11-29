<?php

include_once  __DIR__ . "/components/header.php";

$cart = getCart();
$totaalPrijs = 0; // maak een variable aan voor de totaal prijs

if (count($cart) == 0){
    header("Location: cart.php"); // redirect naar de winkelwagen pagina als de winkelwagen leeg is
}

?>

<div id="CenteredContent">
<h1 class="text-3xl font-bold">Checkout</h1>
<br>

<div class="w-full grid grid-cols-5 gap-4">
    <div class=" col-span-3">
        <?php
        $_SESSION["UserID"] = 3003; 
        if (!isset($_SESSION["UserID"])){
            require_once "./components/account.php";
        } else {
            require_once "./components/checkout.php";
        }
        ?>
    </div>
    <div class="col-span-2">
        <div>
            <?php
            foreach($cart as $i => $aantal){
                $StockItem = getStockItem($i, $databaseConnection); // opvragen van de stockitem gegevens
                $prijs = $StockItem['SellPrice'] * $aantal;
                $totaalPrijs+= $prijs;
            ?>
            <div class="cursor-pointer" onclick="window.location.href ='<?php echo $_ENV['WEB_URL'].'/view.php?id='.$i ?>'">
                <p class="text-xl font-medium">Product: <?php echo $StockItem['StockItemName']; ?></p>
                <p class="text-lg font-medium">Aantal: <?php echo $aantal ?></p>
                <p class="text-lg font-medium">Prijs: <?php echo sprintf("€ %.2f", $prijs) ?></p>
            </div>
            <br>
            <?php
            }
            ?>
        </div>
        <br>
        <div class="w-full">
            <div class="flex flex-row justify-between w-fit gap-4" >
            <p class="text-xl font-bold">Totaalprijs:</p>
            <p class="text-xl font-bold"><?php echo sprintf("€ %.2f", $totaalPrijs) ?></p>
            </div>
            </div>
            <div class=" text-right w-full">
                <button class="bg-white text-black text-xl px-4 py-2 rounded-md ml-auto mr-0 right-0" onclick="window.location.href = '/checkout.php'">Afrekenen</button>
            </div>
        </div>
    </div>
</div>



</div>