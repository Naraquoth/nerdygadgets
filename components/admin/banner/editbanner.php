<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/lib/adminCheck.php");
adminOnly($people);
?>

<html>
<main>
<body>
    <?php 
    $id=$_GET['slider_id'];
    $getSlider = getSliderbyID($id,$databaseConnection);
    if (is_array($getSlider)) {
        foreach ($getSlider as $row){
           $SliderName = $row["SliderName"];
           $ImagePath = $row["ImagePath"];
           $StockItemID = $row["StockItemID"];
           $SliderID = $row["SliderID"];
    ?>
<div class="row">
    <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="panel-default"></div>
                <div class="panel-heading">
                    <h3 class="panel-title">
                    <i class="fa-solid fa-money-bill"> Edit Slider</i>
                    </h3>
                </div>
                <div class="panel-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class ="col-md-4 control-label"> <b> Slider name</b></label>
                            <input type="text" name="SliderName" class="form-control" value="<?php echo htmlspecialchars("$SliderName") ?>"required>
                        </div>
                        <div class="form-group">
                            <label class ="col-md-4 control-label"> <b> Item ID</b></label>
                            <input type="text" name="StockItemID" class="form-control" value="<?php echo htmlspecialchars("$StockItemID") ?>"required>
                        </div>
                        <div class="form-group">
                            <label class ="col-md-4 control-label"> <b> Slider Image</b></label>
                            <input type="file" name="ImagePath" class="form-control" required>
                            <img src="<?php echo htmlspecialchars("$ImagePath") ?>" width="100px" height="70px"></img>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="update" class="form-control" value="Update Slider" required>
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
}} else {
    echo "getSlider did not return a valid array.";
     }
if(isset($_POST['update'])){
    $SliderID = $_GET['slider_id'];
    $SliderName = $_POST['SliderName'];
    $StockItemID = $_POST['StockItemID'];
    $ImagePath = "Pub/Banner/".basename($_FILES['ImagePath']['name']);
    $temp_image = $_FILES['ImagePath']['tmp_name'];
    move_uploaded_file($temp_image, "$ImagePath");
    $UpdateSlider = updateSlider($SliderName, $ImagePath, $StockItemID, $SliderID, $databaseConnection);

    if($UpdateSlider){
        echo "<script>alert('Slider has been updated')</script>";
        echo "<script>window.open('/account.php?page=viewbanner', '_self')</script>"; 
    }
}