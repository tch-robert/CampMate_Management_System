<?php
require_once("../db_connect.php");


$title=$_POST["title"];
$description=$_POST["description"];
$user_id=$_POST["user_id"];



// if(empty($title) || empty($description) || empty($user_id)){
//     echo "請填入必要欄位";
//     exit;
// }
if(empty($title)){
    $data=[
        "status"=>0,
        "message"=>"請選擇類別"
    ];
    echo json_encode($data);
    exit;
}
if(empty($description)){
    $data=[
        "status"=>0,
        "message"=>"請簡述相關問題"
    ];
    echo json_encode($data);
    exit;
}
if(empty($user_id)){
    $data=[
        "status"=>0,
        "message"=>"請輸入使用者"
    ];
    echo json_encode($data);
    exit;
}

$now=date('Y-m-d H:i:s');
$stmt = $conn->prepare("INSERT INTO ticket (title, description, user_id, createtime) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssis", $title, $description, $user_id, $now);

if ($stmt->execute()) {
    $last_id = $stmt->insert_id;
    $data = [
        "status" => 1,
        "message" => "新客服單輸入成功, id 為 $last_id"
    ];
} else {
    $data = [
        "status" => 0,
        "message" => "Error: " . $stmt->error
    ];
}

$stmt->close();
$conn->close();

echo json_encode($data);
exit;