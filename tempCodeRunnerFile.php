<?php
$i = 0;
                foreach ($allImages as $row) {
                    $actives = '';
                    if ($i == 0) {
                        $actives = 'active';
                    }
                $stockItemID = getSliderStockID($ids, $databaseConnection);
                ?>
    <div class="carousel-item <?= $actives; ?>">
    <a href="/view.php?id=<?= htmlspecialchars($StockItemID, ENT_QUOTES, 'UTF-8'); ?>">
        <img src="<?= htmlspecialchars($row['ImagePath'], ENT_QUOTES, 'UTF-8'); ?>" alt="SliderImage" width="1100" height="500">
                </a>
                </div>
                <?php $i++;