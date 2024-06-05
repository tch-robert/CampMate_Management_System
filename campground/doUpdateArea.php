<?php

require_once("../db_connect.php");

if(!isset($_POST["area_name"])){
    echo "請循正常管道進入此頁";
    exit;
}

$camp_id = $_GET["camp_id"];

$area_id = $_POST["area_id"];
$area_name = $_POST["area_name"];
$area_category = $_POST["area_category"];
$price_per_day = $_POST["price_per_day"];



$sql="UPDATE camp_area SET area_name='$area_name', area_category= '$area_category', price_per_day= '$price_per_day' WHERE id=$area_id";

// echo $sql;

if($conn->query($sql)===TRUE){
    echo "更新成功";
}else {
    echo "更新資料錯誤: ".$conn->error;
}

header("location: camp_area.php?camp_id=".$camp_id."&area_id=".$area_id);

$conn->close();