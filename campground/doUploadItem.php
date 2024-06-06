<?php

require_once("../db_connect.php");

if(!isset($_POST["name"])){
    $data=[
        "status" => 0,
        "message"=> "請循正常管道進入"
    ];
    echo json_encode($data);
    exit;
}



$camp_id = $_GET["camp_id"];
$area_id = $_GET["area_id"];
$item_id = $_GET["item_id"];

// $name=$_POST["name"];
$pic_name=$_FILES["file"]["name"];
$path = "./upload/$pic_name";

if(empty($pic_name)){
    echo "請上傳圖片";
    header("location: item_img_upload.php?camp_id=$camp_id&area_id=$area_id");
    exit;
}

if($_FILES["file"]["error"]==0){
    if(move_uploaded_file($_FILES["file"]["tmp_name"], "./upload/".$_FILES["file"]["name"])){
        echo "upload success";
    }else{
        echo "upload failed";
    }
}



$sql= "INSERT INTO images( area_item_id, path) 
VALUES ('$item_id', '$path')";

if ($conn->query($sql) === TRUE) {
    echo "id: $item_id 營區 $pic_name 輸入成功";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$conn->close();

header("location: item_img_upload.php?camp_id=$camp_id&area_id=$area_id&item_id=$item_id");