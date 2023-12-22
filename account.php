<?php

use PhpParser\Node\Expr\AssignOp\Div;

require_once "./components/header.php";

if(isset($_POST["logout-submit"])){
        session_destroy();
        header("Refresh:0"); // refresh de pagina
        die();
}


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

    <form method="post" class="container">
        <!-- <div class="row">
            <div class="col-12">
                <h1>Account</h1>
            </div>
        </div> -->
        <!-- <div class="row">
            <div class="col-12">
                <h2>Bestellingen</h2>
            </div>
        </div> -->
        <div class="row">
            <div class="col-12">
                <a href="?page=gegevens">Gegevens</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <button type="submit" name="logout-submit">
                    Logout
                </button>
            </div>
        </div>

    <?php
    $page = "";
    if (isset($_GET["page"])){
        $page = $_GET["page"];
    }
    switch ($page) {
    case "gegevens":
        $customer = getCustomerByPeopleID($_SESSION["userID"], $databaseConnection)[0];
        $people = getPeopleById($_SESSION["userID"], $databaseConnection)[0];
        require_once "./components/checkoutForms/customerDetails.php";
        break;
    case "banner":

        echo "banner";
        break;
    default:
        echo "Your favorite fruit is neither apple nor banana!";
    }

}
require_once "./components/footer.php";
?>