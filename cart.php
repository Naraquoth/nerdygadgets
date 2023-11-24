<?php

include __DIR__ . "/components/header.php";

// haal alle items uit de winkelwagen op
$cart = getCart();

// als je de winkelwagen aan past (aantal veranderen of verwijderen)
if (isset($_POST['edit-item'])) {
  switch ($_POST['edit-item']) {
    case 'change': // waneer je het aantal veranderd
      $cart[$_POST['e-item']] = $_POST['e-item-aantal']; // verander het aantal in de winkelwagen array
      if ($cart[$_POST['e-item']] <= 0) { // als het aantal 0 of minder is
        unset($cart[$_POST['e-item']]); // verwijder het item uit de winkelwagen array
      }
      break;
    case 'delete': // waneer je een item verwijderd
      unset($cart[$_POST['e-item']]); // verwijder het item uit de winkelwagen array
      break;
  }
    saveCart($cart); // sla de winkelwagen op
    header("Location: cart.php"); // refresh de pagina
}

// als je de winkelwagen leeg maakt
if (isset($_POST['delete-shopping-list-session'])) {
    session_destroy();  // verwijder de sessie
    header("Location: cart.php"); // refresh de pagina
}
$totaalPrijs = 0; // maak een variable aan voor de totaal prijs
?>

<div id="CenteredContent">
<h1 class="text-3xl font-bold">Inhoud Winkelwagen</h1>
<div class="w-full flex flex-col gap-4">
<?php

//print_r($cart);
//gegevens per artikelen in $cart (naam, prijs, etc.) uit database halen
//totaal prijs berekenen
//mooi weergeven in html
//etc.
if (count($cart)  == 0){
  echo "<p class='my-4 text-xl'>Winkelwagen is leeg.</p>";
}
foreach($cart as $i => $aantal){
    $StockItem = getStockItem($i, $databaseConnection); // opvragen van de stockitem gegevens
    $StockItemImage = getStockItemImage($i, $databaseConnection); // opvragen van de stockitem image gegevens lijst
    if (isset($StockItemImage[0]['ImagePath'])){  // als er een lijst met images aanwezig is?
      $StockItemImage = "Pub/StockItemIMG/" . $StockItemImage[0]['ImagePath']; // pak de eerste image
    } else {
      $StockItemImage = "Pub/StockGroupIMG/" . $StockItem['BackupImagePath']; // anders pak de backup image
    }

    $totaalPrijs+= $StockItem['SellPrice'] * $aantal;
    
    ?>
    <form method='post' class="grid xl:grid-cols-8 grid-cols-6 p-4 gap-4 h-fit w-full">
    <div class="flex flex-row gap-4 col-span-4 xl:col-span-6 cursor-pointer" onclick="window.location.href ='<?php echo '/view.php?id='.$i ?>'">
      <div id="ImageFrame"
      class="!w-32 !h-32"
                     style="background-image: url('<?php echo $StockItemImage; ?>'); background-size: cover;">
                     
      </div>
      <div class="flex flex-col w-fit h-full">
        <p class="text-white text-m"><?php echo $StockItem['StockItemID'] ?></p>
        <h3 class="text-white text-xl h-fit mb-auto"><?php echo $StockItem['StockItemName'] ?></h3>
        <p class="text-white text-m">Aantal producten op vooraad: <?php echo explode(" ", $StockItem['QuantityOnHand'])[1] ?></p>
      </div>
    </div>
    <div>
      <p class="text-white text-xl">Aantal</p>
      <!-- <p class="text-white text-xl"><?php echo $aantal ?></p> -->
      <input type='number' name='e-item' value='<?php echo $i ?>' hidden>
      <input type='number' name='e-item-aantal' id="e-item-aantal-<?php echo $i ?>" class=" bg-transparent text-white text-xl" value='<?php echo $aantal ?>' >
      <button type='submit' name='edit-item' id="edit-item-<?php echo $i ?>" hidden></button>
        <script>
        document.getElementById('e-item-aantal-<?php echo $i ?>').addEventListener('change', function(){
          document.getElementById('edit-item-<?php echo $i ?>').value = 'change';
          document.getElementById('edit-item-<?php echo $i ?>').click();
        });
      </script>
    </div>
    <div>
      <p class="text-white text-xl">Prijs</p>
      <p class="text-white text-xl"><?php echo sprintf("€ %.2f", $StockItem['SellPrice'] * $aantal) ?></p>
      <button type='submit' name='edit-item' value='delete'>
        <i class="fa fa-solid fa-trash text-2xl"></i>
      </button>
    </div>
  </form>
    <?php
    
}
?>
</div>
<div class="grid grid-cols-2">
  <div>
  <form method="post">
      <input type="submit" name="delete-shopping-list-session" value="Winkelwagen leegmaken." class="text-left w-fit">
  </form>
  </div>
  <div class="text-right text-white pb-4">
    <p class="text-2xl font-medium">Totaal prijs</p>
    <p class="text-xl"><?php echo sprintf("€ %.2f", $totaalPrijs) ?></p>
  </div>
</div>


</div>

<?php 
include __DIR__ . "/components/footer.php";
?>



