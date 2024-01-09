<div>
<!-- klant gegevnes -->
    <label for="email">Email-Address</label>
    <input type="email" name="email" disabled value="<?php echo $people["EmailAddress"]?>">
    <label for="naam">Naam</label>
    <input type="text" name="naam" disabled value="<?php echo $customer["CustomerName"]?>">
    <label for="telefoonnummer">Telefoonnummer</label>
    <input type="text" name="telefoonnummer" disabled value="<?php echo $customer["PhoneNumber"]?>">

    <!-- verzend gegevens -->
    <label for="postcode">Postcode</label>
    <input id="postcode" name="zip" type="text" disabled value="<?php echo $customer["PostalPostalCode"]?>">
    <label for="huisnummer">Huisnummer</label>
    <input type="text" name="huisnummer" disabled value="<?php echo $customer["DeliveryAddressLine1"]?>">
    <label for="straatnaam">Straatnaam</label>
    <input type="text" name="straatnaam" disabled value="<?php echo $customer["DeliveryAddressLine2"]?>">
    <label for="woonplaats">Woonplaats</label>
    <input type="text" name="woonplaats" disabled value="<?php echo $customer["CityName"]?>">
</div>



