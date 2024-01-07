<?php

$order = getOrderById($_GET["nr"],$databaseConnection)[0];
$orderItems = getOrderDetailsByOrderId($_GET["nr"], $databaseConnection);

if (count($order) == 0 && $order["CustomerID"] != $customer["CustomerID"]) {
    echo "Geen orders gevonden";
} else {

$countTotal = 0;
$countQuantity = 0;
?>

<div class="relative overflow-x-auto">
    <div class="mb-4">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Order <?php echo $order["OrderID"] ?></h1>
        <p class="text-sm text-gray-700 dark:text-gray-400">
            Date of order: <?php echo $order["OrderDate"] ?>
        </p>
        <p class="text-sm text-gray-700 dark:text-gray-400">
            Expected Delivery: <?php echo $order["ExpectedDeliveryDate"] ?>
        </p>
        <p class="text-sm text-gray-700 dark:text-gray-400">
            Order Status: 
            <?php 
                if ($order["DeliveryInstructions"] != null) {
                    echo "Order verzonden: " . $order["DeliveryInstructions"];
                }
                elseif ($order["PickedByPersonID"] != null){
                    echo "Order staat klaar voor verzending";
                } else {
                    echo "Order is nog niet klaar gezet";
                }
            ?>
    </div>
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Item Price
                </th>
                <th scope="col" class="px-6 py-3">
                    Tax Rate
                </th>
                <th scope="col" class="px-6 py-3">
                    Quantity
                </th>
                <th scope="col" class="px-6 py-3">
                    Total Item Price
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            
            foreach ($orderItems as $item) {

            ?>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-blue-400 dark:hover:bg-blue-800" onclick='window.location.href = "/view.php?id=<?php echo $item["StockItemID"] ?>"'>
                
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <!-- file deepcode ignore XSS: data is from database no reason for cross site scripting -->
                    <?php echo $item["StockItemName"] ?>
                </th>
                <td class="px-6 py-4">
                    <?php echo sprintf("€ %.2f", $item["UnitPrice"]) ?>
                    
                </td>
                <td class="px-6 py-4">
                    <?php echo $item["TaxRate"] . "%" ?>
                </td>
                <td class="px-6 py-4">
                    <?php 
                    $countQuantity += $item["Quantity"];
                    echo $item["Quantity"] 
                    ?>
                </td>
                <td class="px-6 py-4">
                    <?php
                    $total = ($item["UnitPrice"] * (1+ ($item["TaxRate"] / 100))) * $item["Quantity"];
                    $countTotal += $total;
                    echo  sprintf("€ %.2f", $total)
                    ?>
                </td>
            </tr>
            </a>
            <?php
            }
            ?>
        </tbody>
        <tfoot>
            <tr class="font-semibold text-gray-900 dark:text-white">
                <th scope="row" class="px-6 py-3 text-base">Total:</th>
                <td class="px-6 py-3"></td>
                <td class="px-6 py-3"></td>
                <td class="px-6 py-3"><?php echo $countQuantity ?></td>
                <td class="px-6 py-3"><?php echo sprintf("€ %.2f", $countTotal) ?></td>
            </tr>
        </tfoot>
    </table>
</div>

<?php
}