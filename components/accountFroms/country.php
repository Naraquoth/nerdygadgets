    <label for="country">Country</label>
    <select name="country" class="text-black" required>
        <?php
        $countries = getCountries($databaseConnection);
        foreach ($countries as $value) {
            echo "<option value='". $value["CountryID"] ."'>".$value["CountryName"]."</option>";
        }
        ?>
    </select>
    <form method="post"><button type="submit" name="terug-country-submit" value="Volgende">Terug</button></form>
    <button type="submit" name="country-submit" value="volgende">volgende</button>