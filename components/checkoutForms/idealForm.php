<?php

require_once "./lib/betaalfuncties.php";

$method = getIssuers();

echo 'Select your bank: <select class="text-black" name="issuer" required>';

foreach ($method->issuers() as $issuer) {
    echo '<option value=' . htmlspecialchars($issuer->id) . '>' . htmlspecialchars($issuer->name) . '</option>';
}
?>
<option value="">or select later</option>
</select>

