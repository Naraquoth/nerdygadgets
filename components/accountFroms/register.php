    <!-- klant gegevnes -->    <label for="email">Email-Address</label>
    <input type="email" name="email" disabled value="<?php echo $_SESSION["email"]?>">
    <label for="full-name">Volledige Naam</label>
    <input type="text" name="full-name" required>
    <label for="telefoonnummer">Telefoonnummer</label>
    <input type="text" name="telefoonnummer" required>
    <!-- verzend gegevens -->
    <label for="postcode">Postcode</label>
    <input id="postcode" name="zip" type="text" inputmode="numeric" pattern="(\d{5}([\-]\d{4})?)" required> 
    <!-- pattern="[1-9][0-9]{3}\s?[a-zA-Z]{2}" nederland-->
    <label for="huisnummer">Huisnummer</label>
    <input type="text" name="huisnummer" required>
    <label for="straatnaam">Straatnaam</label>
    <input type="text" name="straatnaam"  required>
    <label for="woonplaats">Woonplaats</label>
    <select name="woonplaats" class="text-black" required>
        <?php
        $provinces = getCitiesByProvinceId($_SESSION["MyProvinceID"], $databaseConnection);
        foreach ($provinces as $value) {
            echo "<option value='". $value["CityID"] ."'>".$value["CityName"]."</option>";
        }
        ?>
    </select>
    <form method="post"><button type="submit" name="terug-register-submit" value="Volgende">Terug</button></form>
    <button type="submit" name="register-submit" value="Volgende">Volgende</button>