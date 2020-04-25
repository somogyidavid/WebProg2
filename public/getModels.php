<?php
include "brandConfig.php";

$brandid = $_POST['brand'];

$sql = "SELECT id,model_name FROM models WHERE brandId=".$brandid;

$result = mysqli_query($con,$sql);

$models_arr = array();

while( $row = mysqli_fetch_array($result) ){
    $modelid = $row['id'];
    $model_name = $row['model_name'];

    $models_arr[] = array("id" => $modelid, "model_name" => $model_name);
}

echo json_encode($models_arr);
?>