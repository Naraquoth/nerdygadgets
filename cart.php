<?php

include __DIR__ . "/header.php";

$cart = getCart();
if (isset($_POST['edit-item'])) {
  switch ($_POST['edit-item']) {
    case 'plus':
      $cart[$_POST['e-item']]++;
      break;
    case 'minus':
      $cart[$_POST['e-item']]--;
      if ($cart[$_POST['e-item']] <= 0) {
        unset($cart[$_POST['e-item']]);
      }
      break;
    case 'delete':
      unset($cart[$_POST['e-item']]);
      break;
  }
    saveCart($cart);
    header("Location: cart.php");
}
if (isset($_POST['delete-shopping-list-session'])) {
    session_destroy();
    header("Location: cart.php");
}
$totaalPrijs = 0;
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
foreach($cart as $i => $aantal){
    $StockItem = getStockItem($i, $databaseConnection);
    $StockItemImage = getStockItemImage($i, $databaseConnection);
    if (isset($StockItemImage[0]['ImagePath'])){
      $StockItemImage = "Pub/StockItemIMG/" . $StockItemImage[0]['ImagePath'];
    } else {
      $StockItemImage = "Pub/StockGroupIMG/" . $StockItem['BackupImagePath'];
    }
    $totaalPrijs+= $StockItem['SellPrice'] * $aantal;
    
    ?>
    <form method='post' class="grid grid-cols-8 p-4 h-fit w-full">
    <div class="flex flex-row gap-4 col-span-6">
      <div id="ImageFrame"
      class="!w-32 !h-32"
                     style="background-image: url('<?php echo $StockItemImage; ?>'); background-size: cover;">
                     <input type='number' name='e-item' value='<?php echo $i ?>' hidden>
      </div>
      <div class="flex flex-col w-fit h-full">
        <p class="text-white text-m"><?php echo $StockItem['StockItemID'] ?></p>
        <h3 class="text-white text-xl h-fit mb-auto"><?php echo $StockItem['StockItemName'] ?></h3>
        <p class="text-white text-m">Aantal producten op vooraad: <?php echo explode(" ", $StockItem['QuantityOnHand'])[1] ?></p>
      </div>
    </div>
    <div>
      <p class="text-white text-xl">Aantal</p>
      <p class="text-white text-xl"><?php echo $aantal ?></p>
        <button type='submit' name='edit-item' value='plus'>
          <i class="fa fa-solid fa-plus text-2xl"></i>
        </button>
        <button type='submit' name='edit-item' value='minus'>
          <i class="fa fa-solid fa-minus text-2xl"></i>
        </button>
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

<!-- <form method="post">
    <input type="submit" name="delete-shopping-list-session" value="Winkelwagen leegmaken." class="text-left w-fit">
</form> -->

</div>



