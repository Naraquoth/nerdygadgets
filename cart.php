<?php

include __DIR__ . "/header.php";

$cart = getCart();
if (isset($_POST['delete-item'])) {
    unset($cart[$_POST['d-item']]);
    saveCart($cart);
    header("Location: cart.php");
}
if (isset($_POST['delete'])) {
    session_destroy();
    header("Location: cart.php");
}
?>
<script src="https://cdn.tailwindcss.com"></script>
<div id="CenteredContent">
<h1 class="text-3xl font-bold">Inhoud Winkelwagen</h1>
<table class="table-auto">
  <thead>
    <tr>
      <th>Item</th>
      <th>Aantal</th>
      <th>Totaal</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
<?php

//print_r($cart);
//gegevens per artikelen in $cart (naam, prijs, etc.) uit database halen
//totaal prijs berekenen
//mooi weergeven in html
//etc.
foreach($cart as $i => $aantal){
    $StockItem = getStockItem($i, $databaseConnection);
    print "<tr>";
    print "<td><a href='view.php?id=$i'>" . $StockItem['StockItemName'] . "</a></td>";
    print "<td>" . $aantal . "</td>";
    print "<td>" . sprintf("€ %.2f", $StockItem['SellPrice'] * $aantal) . "</td>";
    print "<td><form method='post'><input type='number' name='d-item' value='$i' hidden><input type='submit' name='delete-item' value='Verwijder'></form></td>";
    print "</tr>";
}
?>
  </tbody>
</table>
<form method="post">
    <input type="submit" name="delete" value="Winkelwagen leegmaken." class="text-left w-fit">
</form>
</div>


