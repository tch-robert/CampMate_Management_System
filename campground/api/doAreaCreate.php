<?php
include("../session_check_login.php");
require_once("../../db_connect.php");

if(!isset($_POST["area_name"])){
    $data=[
        "status" => 0,
        "message"=> "請循正常管道進入"
    ];
    echo json_encode($data);
    exit;
}

$campground_id = $_POST["campground_id"];
$area_name = $_POST["area_name"];
$area_category= $_POST["area_category"];
$price_per_day = $_POST["price_per_day"];


if(empty($area_name)){
    $data=[
        "status" => 401,
        "message"=> "請輸入營區名稱"
    ];
    echo json_encode($data);
    exit;
}
if(empty($area_category)){
    $data=[
        "status" => 402,
        "message"=> "請選擇營地種類"
    ];
    echo json_encode($data);
    exit;
}

// if(empty($price_per_day)){
//     $data=[
//         "status" => 403,
//         "message"=> "請輸入價格"
//     ];
//     echo json_encode($data);
//     exit;
// }



$sql="INSERT INTO camp_area (campground_id, area_name, area_category, price_per_day) 
VALUES ('$campground_id', '$area_name', '$area_category', '$price_per_day')";

// echo $sql;

if($conn->query($sql)===TRUE){
    $last_id = $conn->insert_id;
    $data=[
        "status"=>1,
        "message"=> "營地增加成功, id 為 $last_id",
    ];
    echo json_encode($data);
    exit;
} else {
    $data=[
        "status"=>0,
        "message"=> "Error: " . $sql . "<br>" . $conn->error
    ];
    echo json_encode($data);
    exit;
}

// $_SESSION["campground_id"] = $last_id;

$conn->close();