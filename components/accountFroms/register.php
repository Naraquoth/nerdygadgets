    <!-- klant gegevnes -->    <label for="email">Email-Address</label>
    <input type="email" name="email" disabled value="<?php echo $_SESSION["email"]?>">
    <label for="full-name">Volledige Naam</label>
    <input type="text" name="full-name">
    <label for="telefoonnummer">Telefoonnummer</label>
    <input type="text" name="telefoonnummer" >
    <!-- verzend gegevens -->
    <label for="postcode">Postcode</label>
    <input id="postcode" name="zip" type="text" inputmode="numeric" pattern="(\d{5}([\-]\d{4})?)" > 
    <!-- pattern="[1-9][0-9]{3}\s?[a-zA-Z]{2}" nederland-->
    <label for="huisnummer">Huisnummer</label>
    <input type="text" name="huisnummer" >
    <label for="straatnaam">Straatnaam</label>
    <input type="text" name="straatnaam"  >
    <label for="woonplaats">Woonplaats</label>
    <select name="woonplaats" class="text-black" >
        <?php
        $provinces = getCitiesByProvinceId($_SESSION["MyProvinceID"], $databaseConnection);
        foreach ($provinces as $value) {
            echo "<option value='". $value["CityID"] ."'>".$value["CityName"]."</option>";
        }
        ?>
    </select>
    <form method="post"><button type="submit" name="terug-register-submit" value="Volgende">Terug</button></form>
    <button type="submit" name="register-submit" value="Volgende">Volgende</button>