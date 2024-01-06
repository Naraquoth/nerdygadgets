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
    <!-- Dit is een button die niet zichtbaar is, en er voor zorgt dat je niet met enter kan submitten -->
    <button type="submit" disabled style="display: none" aria-hidden="true"></button> 
    <div class=" w-72 mx-auto [&>input]:text-black">
        
    <?php

    require_once "./components/account.php";
    ?>
    </div>
    </form>
    <?php
} else {
    $people = getPeopleById($_SESSION["userID"], $databaseConnection)[0];
    require_once "./lib/adminCheck.php";
    ?>
    <form method="post" class="container [&>div]:w-full grid [&>div>a]:mx-auto grid-flow-col">
            <div class="">
                <a href="/account.php?page=gegevens">Gegevens</a>
            </div>
        <?PHP
        if (adminCheck($people)){
            ?>
                <div class="">
                    <a href="/account.php?page=viewbanner">Banner</a>
                </div>
            <?PHP
        }

        ?>
            <div class="">
                <button type="submit" name="logout-submit">
                    Logout
                </button>
            </div>
    </form>
    <br>
    <div class="container">

    <?php
    $page = "";
    if (isset($_GET["page"])){
        $page = $_GET["page"];
    }
    switch ($page) {
    case "gegevens":
        $customer = getCustomerByPeopleID($_SESSION["userID"], $databaseConnection)[0];
        
        require_once "./components/checkoutForms/customerDetails.php";
        break;
    case "viewbanner":
        require_once "./components/admin/banner/viewbanner.php";
        break;
    case "addbanner":
        require_once "./components/admin/banner/addbanner.php";
        break;
    case "editbanner":
        require_once "./components/admin/banner/editbanner.php";
        break;
    default:
        echo "Welkom op uw accountpagina. ";
    }
}
echo "</div>";
require_once "./components/footer.php";
?>