<?php

require_once("../db_connect.php");

if(!isset($_GET["area_id"])){
    $data=[
        "status" => 0,
        "message"=> "請循正常管道進入"
    ];
    echo json_encode($data);
    exit;
}



$camp_id = $_GET["camp_id"];
$area_id = $_GET["area_id"];
$now = date('Y-m-d-H:i:s');

// $name=$_POST["name"];
$pic_name=$_FILES["file"]["name"];
$path = "./upload/$pic_name";

if($_FILES["file"]["error"]==0){
    if(move_uploaded_file($_FILES["file"]["tmp_name"], "./upload/".$_FILES["file"]["name"])){
        echo "upload success";
    }else{
        echo "upload failed";
    }
}



$sql= "INSERT INTO images(id, camp_area_id, path) 
VALUES ('$now','$area_id', '$path')";

if ($conn->query($sql) === TRUE) {
    echo "id: $area_id 營區 $pic_name 輸入成功";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$conn->close();

header("location: area_img_upload.php?camp_id=$camp_id&area_id=$area_id");