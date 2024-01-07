<div>
    <!-- Meest Gekocht Producten -->
    <h1 style="font-size: 24px; color: red;">Meest Gekocht producten</h1>
    <div class="MeestGekochteContainer">
        <?php
        $mostSoldProducts = meestVerkochtProduct(3, $databaseConnection);

        foreach ($mostSoldProducts as $product) {
            $productId = $product['StockItemID'];
            $productInfo = getStockItem($productId, $databaseConnection);
            $productImages = getStockItemImage($productId, $databaseConnection);

            if ($productInfo) {
                $shortenedName = substr($productInfo['StockItemName'], 0, 15) . '...';
        ?>
                <!-- Meest gekocht producten item -->
                <div class="MeestGekochtProduct">
                    <!-- Product Image -->
                    <div class="ImageFrame" style="background-image: url('Pub/StockItemIMG/<?php print $productImages[0]['ImagePath']; ?>'); background-size: cover; background-repeat: no-repeat; background-position: center; height: 100px; width: 100px;">
                    </div>

                    <!-- Product Information -->
                    <div class="ArticleHeader">
                        <h4 class="StockItemID">Artikelnummer: <?php print $productInfo["StockItemID"]; ?></h4>
                        <h4 class="StockItemNameViewSize1 StockItemName"><?php print $shortenedName; ?></h4>
                        <p class="StockItemPriceText"><b><?php print sprintf("€ %.2f", $productInfo['SellPrice']); ?></b></p>
                        <form method="post">
                            <input type="number" name="stockItemID" value="<?php print $productId; ?>" hidden>
                            <button class="mt-2" type="submit" name="submit-add-to-card" value="Voeg toe aan winkelmandje">Voeg toe aan <i class="fa fa-shopping-cart"></i></button>
                        </form>
                        <?php
                        if (isset($_POST["submit-add-to-card"]) && $_POST["stockItemID"] == $productId) { 
                            print("Product toegevoegd. <br> <a href='cart.php'> Ga naar je winkelmand!</a>");
                        }
                        ?>
                    </div>
                </div>
        <?php
            }else {
                ?><h2 id="ProductNotFound">Het opgevraagde product is niet gevonden.</h2><?php
        }} 
        ?>
    </div>
</div>
