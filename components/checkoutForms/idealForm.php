<?php

require_once "./lib/betaalfuncties.php";

$method = getIssuers();

echo '<label for="issuer">Select your bank:</label> <select class="text-black" name="issuer" required>';

foreach ($method->issuers() as $issuer) {
    echo '<option value=' . htmlspecialchars($issuer->id) . '>' . htmlspecialchars($issuer->name) . '</option>';
}
?>
<option value="" selected>or select later</option>

</select>
