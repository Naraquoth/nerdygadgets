<?php
include __DIR__ . "/components/header.php";
?>
<style>
table tr th,
table tr td {
    padding: 10px;
    color: #fff;
}
.block {
      display: block;
      width: 30%;
      border: 1px solid #fff;
      color: #fff;
      padding: 14px 28px;
      font-size: 16px;
      cursor: pointer;
      text-align: center;
      margin: 0 auto;
}
    
</style>
<html>
<main>
<body>
<div class="row">
    <div class="col-md-12">
            <div class="panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                    <i class="fa-solid fa-money-bill search"> View Slider</i>
                    </h3>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <tr>
                            <td><b>Slider naam</b></td>
                            <td><b>Slider plaatje</b></td>
                            <td><b>Product ID</b></td>
                            <td><b>Edit</b></td>
                            <td><b>Delete</b></td>
                            

                        </tr>
                        <?php
                     $getSlider = getSlider($databaseConnection);
                     if (is_array($getSlider)) {
                         foreach ($getSlider as $row){
                            $SliderName = $row[3];
                            $ImagePath = $row[0];
                            $StockItemID = $row[2];
                            $SliderID = $row[1]; 
                        ?>
                          <tr>
                            <td><b><?php echo $SliderName?></b></td>
                            <td><img src=<?php echo $ImagePath?> width="100px" height="70px"></img></td>
                            <td><b><?php echo $StockItemID?></b></td>
                            <td><a href="editbanner.php?slider_id=<?php echo $SliderID?>"><i class="fa-solid fa-pencil search"></i></a></td>
                            <td><a href="viewbanner.php?slider_delete_id=<?php echo $SliderID?>"><i class="fa-solid fa-trash search"></i></a></td>
                            

                        </tr>
                         <?php }}
                         ?>
                    </table>
                    <a href="addbanner.php">
                    <button class="block"><b>Add slide</b></button>
                    </a>
                </div>
            </div>
        </div>
</div>
</body>
</main>
</html>
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

include __DIR__ . "/components/footer.php";
?>