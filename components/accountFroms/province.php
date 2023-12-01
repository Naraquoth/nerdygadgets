
    
    <label for="province">Province</label>
    <select name="province" class="text-black" required>
        <?php
        $provinces = getProvincesByCountryId($_SESSION["MyCountryID"], $databaseConnection);
        foreach ($provinces as $value) {
            echo "<option value='". $value["StateProvinceID"] ."'>".$value["StateProvinceName"]."</option>";
        }
        ?>
    </select>
    <form method="post"><button type="submit" name="terug-province-submit" value="Volgende">Terug</button></form>
    <button type="submit" name="province-submit" value="volgende">volgende </button>