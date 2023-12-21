<!-- dit is het bestand dat wordt geladen zodra je naar de website gaat -->
<?php
include __DIR__ . "/components/header.php";

$ids = getSliderID($databaseConnection);
$allImages = [];
foreach ($ids as $id) {
    $images = getSliderImages($id, $databaseConnection);
    $allImages = array_merge($allImages, $images);

}
?>

<main>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div id="Slider" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ul class="carousel-indicators">
                <?php 
                $i = 0;
                foreach ($allImages as $row) {
                    $actives = '';
                    if ($i == 0) {
                        $actives = 'active';
                    }
                
                ?>
                <li data-target="#Slider" data-slide-to="<?= $i; ?>" class="<?= $actives; ?>"></li>
                <?php $i++; } ?>
            </ul>
            <!-- The slideshow -->
            <div class="carousel-inner">
                <?php 
                $i = 0;
                $j = 0;
                foreach ($allImages as $row) {
                    $actives = '';
                    if ($i == 0) {
                        $actives = 'active';
                    }
                    $SID = $ids[$j];
                    $stockItemID = getSliderStockID($SID, $databaseConnection);
                    $stockItemID = $stockItemID ? htmlspecialchars($stockItemID, ENT_QUOTES, 'UTF-8') : '16';
                    $imagePath = isset($row['ImagePath']) ? htmlspecialchars($row['ImagePath'], ENT_QUOTES, 'UTF-8') : 'Pub/Banner/Slider-1.png';
                ?>
                <div class="carousel-item <?= $actives; ?>">
                    <a href="/view.php?id=<?= $stockItemID; ?>">
                        <img src="<?= $imagePath; ?>" alt="SliderImage" width="1100" height="500">
                    </a>
                </div>
                <?php $i++; $j++;
                } ?>
            </div>
            <a class="carousel-control-prev" href="#Slider" role="button" data-slide="prev">
                <span class ="sr-only">Previous</span> </a>

            <a class="carousel-control-next" href="#Slider" role="button" data-slide="next">
                <span class ="sr-only">next</span> </a>

        </div>
    </div>
</div>
</main>

<?php
include __DIR__ . "/components/footer.php";
?>