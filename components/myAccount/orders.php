<?php

$orders = getOrderByCustomerId($customer["CustomerID"],$databaseConnection);
if (count($orders) == 0) {
    echo "Geen orders gevonden";
} else {

?>
<head>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
</head>
<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Date
                </th>
                <th scope="col" class="px-6 py-3">
                    Order Number
                </th>
                <th scope="col" class="px-6 py-3">
                    Expected Delivery
                </th>
                <th scope="col" class="px-6 py-3">
                    Order Status
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            
            foreach ($orders as $order) {

            ?>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-blue-400 dark:hover:bg-blue-800 hover:cursor-pointer" onclick='window.location.href = "/account.php?page=order&nr=<?php echo $order["OrderID"] ?>"'>
                
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <?php echo $order["OrderDate"] ?>
                </th>
                <td class="px-6 py-4">
                    <?php echo $order["OrderID"] ?>
                </td>
                <td class="px-6 py-4">
                    <?php echo $order["ExpectedDeliveryDate"] ?>
                </td>
                <td class="px-6 py-4">
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
                </td>
                
            </tr>
            </a>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
<?php
}


