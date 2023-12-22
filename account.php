<?php

use PhpParser\Node\Expr\AssignOp\Div;

require_once "./components/header.php";


if (!isset($_SESSION["userID"])){
    

    ?>
    
    <form method="post">
    <div class=" w-72 mx-auto [&>input]:text-black">
    <?php

    require_once "./components/account.php";
    ?>
    </div>
    </form>
    
    <?php
    
} else {
    ?>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Account</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h2>Bestellingen</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h2>Gegevens</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h2>Wachtwoord wijzigen</h2>
            </div>
        </div>

    <?php
}
require_once "./components/footer.php";
?>