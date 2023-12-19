<?php
include __DIR__ . "/components/header.php";
?>
<html>
<main>
<body>
<div class="row">
    <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="panel-default"></div>
                <div class="panel-heading">
                    <h3 class="panel-title">
                    <i class="fa-solid fa-money-bill"> Insert Slider</i>
                    </h3>
                </div>
                <div class="panel-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class ="col-md-4 control-label"> <b> Slider name</b></label>
                            <input type="text" name="SliderName" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class ="col-md-4 control-label"> <b> Item ID</b></label>
                            <input type="text" name="StockItemID" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class ="col-md-4 control-label"> <b> Slider Image</b></label>
                            <input type="file" name="ImagePath" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="Submit" class="form-control" value="Insert Slider" required>
                        </div>
                    </form>
                </div>
        </div>
    <div class="col-md-3"></div>
</div>


</body>
</main>
</html>
<?php

if(isset($_POST['Submit'])){
    $SliderName = $_POST['SliderName'];
    $StockItemID = $_POST['StockItemID'];
    $ImagePath = "Pub/Banner/".basename($_FILES['ImagePath']['name']);
    $temp_image = $_FILES['ImagePath']['tmp_name'];
    move_uploaded_file($temp_image, "$ImagePath");
    $insertSlider = insertSlider($SliderName, $ImagePath, $StockItemID, $databaseConnection);

    if($insertSlider){
        echo "<script>alert('Slider has been inserted')</script>";
        echo "<script>window.open('addbanner.php', '_self')</script>";
    }
}


include __DIR__ . "/components/footer.php";
?>