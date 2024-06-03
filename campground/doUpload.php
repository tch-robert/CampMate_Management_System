<?php

require_once("../db_connect.php");

if(!isset($_GET["camp_id"])){
    $data=[
        "status" => 0,
        "message"=> "請循正常管道進入"
    ];
    echo json_encode($data);
    exit;
}

// if(!isset($_POST["name"])){
//     echo "請循正常管道進入";
//     exit;
// }

$camp_id = $_GET["camp_id"];

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



$sql= "INSERT INTO images(campground_id, path) 
VALUES ('$camp_id', '$path')";

if ($conn->query($sql) === TRUE) {
    echo "id: $camp_id 營地的 $pic_name 輸入成功";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$conn->close();

header("location: cg_img_upload.php?camp_id=$camp_id");