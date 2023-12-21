<!-- de inhoud van dit bestand wordt bovenaan elke pagina geplaatst -->
<?php
session_start();
require_once "./lib/database.php";
$databaseConnection = connectToDatabase();
require_once "./lib/cartfuncties.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>NerdyGadgets</title>

    <!-- Javascript -->
    <!-- <script src="Pub/JS/fontawesome.js"></script> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="Pub/JS/jquery.min.js"></script>
    <script src="Pub/JS/bootstrap.min.js"></script>
    <script src="Pub/JS/popper.min.js"></script>
    <script src="Pub/JS/resizer.js"></script>
    <link rel="icon" type="image/png" href="Pub/img/icon.png" />

    <!-- Style sheets-->
    <link rel="stylesheet" href="Pub/CSS/style.css" type="text/css">
    <link rel="stylesheet" href="Pub/CSS/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="Pub/CSS/typekit.css">
    <script src="https://cdn.tailwindcss.com"></script>
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
        <ul id="ul-class-navigation">
            <li>
                <a href="viewbanner.php" class="HrefDecoration"><i class="fa fa-money-bill search"></i> Banners</a>
            </li>
            <li>
                <a href="browse.php" class="HrefDecoration"><i class="fas fa-search search"></i> Zoeken</a>
            </li>
            <li>
                <a href="cart.php" class="HrefDecoration"><i class="fa fa-shopping-cart search"></i> Cart <?php print(array_sum(getCart())) ?></a>
            </li>
        </ul> 
<!-- einde code voor US3 zoeken -->
    </div>
    <div class="row" id="Content">
        <div class="col-12">
            <div id="SubContent">


