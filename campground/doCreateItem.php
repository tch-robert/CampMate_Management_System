<?php
require_once("../db_connect.php");

if(!isset($_POST["item_name"])){
    $data=[
        "status" => 0,
        "message"=> "請循正常管道進入"
    ];
    echo json_encode($data);
    exit;
}

$camp_id = $_GET["camp_id"];
$area_id = $_GET["area_id"];

$item_name = $_POST["item_name"];
$price = $_POST["price"];
$status = $_POST["status"];
$pic_name=$_FILES["file"]["name"];



if(empty($item_name)){
    $data=[
        "status" => 401,
        "message"=> "請輸入營區名稱"
    ];
    echo json_encode($data);
    exit;
}
if(empty($price)){
    $data=[
        "status" => 402,
        "message"=> "請選擇營地種類"
    ];
    echo json_encode($data);
    exit;
}

if(empty($pic_name)){
    $data=[
        "status" => 403,
        "message"=> "請上傳圖片"
    ];
    exit;
}

$path = "./upload/$pic_name";

if($_FILES["file"]["error"]==0){
    if(move_uploaded_file($_FILES["file"]["tmp_name"], "./upload/".$_FILES["file"]["name"])){
        echo "upload success";
    }else{
        echo "upload failed";
    }
}




$sql="INSERT INTO area_item ( item_name, price, path) 
VALUES ( '$item_name', '$price', '$path')";

// echo $sql;

if($conn->query($sql)===TRUE){
    $last_id = $conn->insert_id;
    $data=[
        "status"=>1,
        "message"=> "商品增加成功, id 為 $last_id",
    ];
    echo json_encode($data);
    // exit;
} else {
    $data=[
        "status"=>0,
        "message"=> "Error: " . $sql . "<br>" . $conn->error
    ];
    echo json_encode($data);
    exit;
}

$item_id = $last_id;

$sql="INSERT INTO camp_area_item ( item_id, area_id , status) 
VALUES ( '$item_id', '$area_id', '$status')";

if($conn->query($sql)===TRUE){
    // $last_id = $conn->insert_id;
    $data=[
        "status"=>1,
        "message"=> "商品狀態與關聯成功",
    ];
    echo json_encode($data);
    // exit;
} else {
    $data=[
        "status"=>0,
        "message"=> "Error: " . $sql . "<br>" . $conn->error
    ];
    echo json_encode($data);
    exit;
}

header("location: area_item_list.php?camp_id=$camp_id&area_id=$area_id");

$conn->close();