<?php
require_once("../../db_connect.php");

if(!isset($_POST["email"])){
    $data=[
        "status" => 0,
        "message"=> "請循正常管道進入"
    ];
    echo json_encode($data);
    exit;
}
$email = $_POST["email"];
$address= $_POST["address"];
$phone = $_POST["phone"];
$campground_name = $_POST["campground_name"];
$altitude = $_POST["altitude"];
$position = $_POST["position"];
$latitude = $_POST["latitude"];
$longitude = $_POST["longitude"];
$introduction = $_POST["introduction"];

if(!empty($latitude) && !empty($longitude)){
    $geolocation = $latitude.",".$longitude;
}else{
    $geolocation = "";
}


if(empty($campground_name)){
    $data=[
        "status" => 401,
        "message"=> "請輸入營地名稱"
    ];
    echo json_encode($data);
    exit;
}
if(empty($email)){
    $data=[
        "status" => 402,
        "message"=> "請輸入Email"
    ];
    echo json_encode($data);
    exit;
}

if(empty($address)){
    $data=[
        "status" => 403,
        "message"=> "請輸入地址"
    ];
    echo json_encode($data);
    exit;
}
if(empty($phone)){
    $data=[
        "status" => 404,
        "message"=> "請輸入電話號碼"
    ];
    echo json_encode($data);
    exit;
}


// 經緯度不是必須

if($position === "*請選擇所在區域"){
    $data=[
        "status" => 405,
        "message"=> "請選擇所在區域"
    ];
    echo json_encode($data);
    exit;
}

if(empty($introduction)){
    $data=[
        "status" => 406,
        "message"=> "請輸入營地介紹"
    ];
    echo json_encode($data);
    exit;
}



$sql="INSERT INTO campground_info (campground_name, email, address, phone, campground_introduction, altitude, position, geolocation ) 
VALUES ('$campground_name', '$email', '$address', '$phone', '$introduction','$altitude', '$position', '$geolocation')";

// echo $sql;

if($conn->query($sql)===TRUE){
    $last_id = $conn->insert_id;
    $data=[
        "status"=>1,
        "message"=> "新資料輸入成功, id 為 $last_id"
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


$conn->close();