<?php
require_once("../db-connect.php");

if(!isset($_POST["email"])){
    $data=[
        "status" => 0,
        "message"=> "請循正常管道進入"
    ];
    echo json_encode($data);
    exit;
}
$email = $_POST["email"];
$address= $_POST["addrress"];
$phone = $_POST["phone"];
$campground_name = $_POST["campground_name"];
$altitude = $_POST["altitude"];
$position = $_POST["position"];
$latitude = $_POST["latitude"];
$longitude = $_POST["longitude"];

$geolocation = $latitude.",".$longitude;

$pic_name=$_FILES["file"]["name"];

if(empty($email)){
    $data=[
        "status" => 0,
        "message"=> "請輸入Email"
    ];
    echo json_encode($data);
    exit;
}

if(empty($phone)){
    $data=[
        "status" => 0,
        "message"=> "請輸入電話號碼"
    ];
    echo json_encode($data);
    exit;
}

if(empty($campground_name)){
    $data=[
        "status" => 0,
        "message"=> "請輸入營地名稱"
    ];
    echo json_encode($data);
    exit;
}

// 經緯度不是必須

if(empty($position)){
    $data=[
        "status" => 0,
        "message"=> "請選擇所在區域"
    ];
    echo json_encode($data);
    exit;
}




$sql="INSERT INTO users (name, phone, email, created_at) VALUES ('$name', '$phone', '$email', '$now')";

echo $sql;



// $sql = "INSERT INTO users (name, phone, email, created_at)
// 	VALUES ('Scott', '123', 'asdad@example.com', '$now')";
 	 
if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    	echo "新資料輸入成功, id 為 $last_id";
} else {
    	echo "Error: " . $sql . "<br>" . $conn->error;
}


// 上傳檔案用

if($_FILES["file"]["error"]==0){
    if(move_uploaded_file($_FILES["file"]["tmp_name"], "../upload/".$_FILES["file"]["name"])){
        echo "upload success";
    }else{
        echo "upload failed";
    }
}

$sql= "INSERT INTO images(name, pic_name) 
VALUES ('$name', '$pic_name')";

if ($conn->query($sql) === TRUE) {
    echo "$name 的 $pic_name 輸入成功";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$conn->close();