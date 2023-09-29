<!-- de inhoud van dit bestand wordt bovenaan elke pagina geplaatst -->
<?php
session_start();
include "database.php";
$databaseConnection = connectToDatabase();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>NerdyGadgets</title>

    <!-- Javascript -->
    <script src="Pub/JS/fontawesome.js"></script>
    <script src="Pub/JS/jquery.min.js"></script>
    <script src="Pub/JS/bootstrap.min.js"></script>
    <script src="Pub/JS/popper.min.js"></script>
    <script src="Pub/JS/resizer.js"></script>

    <!-- Style sheets-->
    <link rel="stylesheet" href="Pub/CSS/style.css" type="text/css">
    <link rel="stylesheet" href="Pub/CSS/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="Pub/CSS/typekit.css">
</head>
<body>
<div class="Background">
    <div class="row" id="Header">
        <div class="col-2"><a href="./" id="LogoA">
                <div id="LogoImage">
                    <img src="Pub/img/logo.png" alt="NerdyGadgetsLogo" height="100%" width="auto" style=" margin-left: auto; margin-right: auto;" >
                </div>
            </a></div>
        <div class="col-8" id="CategoriesBar">
            <ul id="ul-class">
                <?php
                $HeaderStockGroups = getHeaderStockGroups($databaseConnection);

                foreach ($HeaderStockGroups as $HeaderStockGroup) {
                    ?>
                    <li>
                        <a href="browse.php?category_id=<?php print $HeaderStockGroup['StockGroupID']; ?>"
                           class="HrefDecoration"><?php print $HeaderStockGroup['StockGroupName']; ?></a>
                    </li>
                    <?php
                }
                ?>
                <li>
                    <a href="categories.php" class="HrefDecoration">Alle categorieën</a>
                </li>
            </ul>
        </div>
<!-- code voor US3: zoeken -->



<!-- einde code voor US3 zoeken -->
    </div>
    <div class="row" id="Content">
        <div class="col-12">
            <div id="SubContent">


