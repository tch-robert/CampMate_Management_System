<?php

require_once("../db_connect.php");

if(!isset($_POST["campground_name"])){
    echo "請循正常管道進入此頁";
    exit;
}

$id=$_POST["id"];
$campground_name = $_POST["campground_name"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$address= $_POST["address"];
$altitude = $_POST["altitude"];
$position = $_POST["position"];
$latitude = $_POST["latitude"];
$longitude = $_POST["longitude"];
$introduction = $_POST["introduction"];

if(!empty($latitude) && !empty($longitude)){
    $geolocation = $longitude.",".$latitude;
}else{
    $geolocation = "";
}

$sql="UPDATE campground_info SET campground_name='$campground_name', email= '$email', phone= '$phone', address= '$address', altitude= '$altitude', position= '$position', geolocation= '$geolocation', campground_introduction= '$introduction' WHERE id=$id";

// echo $sql;

if($conn->query($sql)===TRUE){
    echo "更新成功";
}else {
    echo "更新資料錯誤: ".$conn->error;
}

header("location: campground.php?id=".$id);

$conn->close();