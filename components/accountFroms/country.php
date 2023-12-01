    <label for="country">Country</label>
    <select name="country" class="text-black" required>
        <option  disabled>Selecteer een Land</option>
        <?php
        $countries = getCountries($databaseConnection);
        foreach ($countries as $value) {
            if ($value["CountryID"] == 230){
                echo "<option value='". $value["CountryID"] ."' default>".$value["CountryName"]."</option>";
            } else {
                echo "<option value='". $value["CountryID"] ."' disabled>".$value["CountryName"]."</option>";
            }
            
        }
        ?>
    </select>
    <form method="post"><button type="submit" name="terug-country-submit" value="Volgende">Terug</button></form>
    <button type="submit" name="country-submit" value="volgende">volgende</button>