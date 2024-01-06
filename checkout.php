<?php

include_once  __DIR__ . "/components/header.php";

$cart = getCart(); // ophalen van de winkelwagen

if (count($cart) == 0){
    header("Location: cart.php"); // redirect naar de winkelwagen pagina als de winkelwagen leeg is
}
$totaalPrijs = 0; // maak een variable aan voor de totaal prijs
$cartItems = []; // maak een array aan voor de cart items
foreach($cart as $i => $aantal){
                $StockItem = getStockItem($i, $databaseConnection); // opvragen van de stockitem gegevens
                $totaalPrijs+=$StockItem['SellPrice'] * $aantal;
                $prijs;
                $StockItem["aantal"] = $aantal;
                $cartItems[] = $StockItem;
}
?>

<div id="CenteredContent">
<h1 class="text-3xl font-bold">Checkout</h1>
<br>
<form method="post" >
    <!-- Dit is een button die niet zichtbaar is, en er voor zorgt dat je niet met enter kan submitten -->
    <button type="submit" disabled style="display: none" aria-hidden="true"></button> 
<div class="w-full grid grid-cols-5 gap-4">
    <div class=" col-span-3 [&>input]:text-black">
        
        <?php
        if (!isset($_SESSION["userID"])){
            require_once "./components/account.php";
        } else {
            require_once "./components/checkout.php";
        }
        ?>
        
    </div>
    <div class="col-span-2">
        <div>
            <?php
            foreach($cartItems as $StockItem){
            ?>
            <div class="cursor-pointer" onclick="window.location.href ='<?php echo $_ENV['WEB_URL'].'/view.php?id='.$StockItem['StockItemID'] ?>'">
                <p class="text-xl font-medium">Product: <?php echo $StockItem['StockItemName']; ?></p>
                <p class="text-lg font-medium">Aantal: <?php echo $StockItem["aantal"] ?></p>
                <p class="text-lg font-medium">Prijs: <?php echo sprintf("€ %.2f", $StockItem['SellPrice'] * $StockItem["aantal"]) ?></p>
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
                <?php if (isset($_SESSION["userID"])){ ?>
                    <form method="post" class=" text-right w-full">
                <button type="submit" name="pay-submit" class="bg-white text-black text-xl px-4 py-2 rounded-md ml-auto mr-0 right-0">Afrekenen</button>
                </form>
                <?php } ?>
            </div>
        </div>
    </div>
</form>
</div>