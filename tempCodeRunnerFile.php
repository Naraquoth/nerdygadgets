<?php
if(isset($_GET['slider_delete_id'])){
    $id= intval($_GET['slider_delete_id']);
    $filePath = getSliderImages($id, $databaseConnection);
    if(file_exists($filePath[0]['ImagePath'])){
        unlink($filePath[0]['ImagePath']);
    }
    $deleteSlider = deleteSlider($id, $databaseConnection);
    if($deleteSlider){
        echo "<script>alert('Slider has been deleted')</script>";
        echo "<script>window.open('viewbanner.php', '_self')</script>";
    }
}