<?php
require_once("../db_connect.php");


$id=$_POST["id"];
$reply=$_POST["reply"];
$status=$_POST["status"];
$closetime=date('Y-m-d H:i:s');


if(empty($reply)){
    $data=[
        "status"=>0,
        "message"=>"請回覆客服內容"
    ];
    echo json_encode($data);
    exit;
}
if(empty($status)){
    $data=[
        "status"=>0,
        "message"=>"請點選回覆狀態"
    ];
    echo json_encode($data);
    exit;
}



$sql = "UPDATE ticket SET reply=?, status=?, closetime=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssi", $reply, $status, $closetime, $id);

if($stmt->execute()){
    $data = [
        "status" => 1,
        "message" => "已回覆 , 客服單 ID 為 $id"
    ];
}else{
    $data = [
        "status" => 0,
        "message" => "Error: " . $stmt->error
    ];
}

$stmt->close();
$conn->close();

echo json_encode($data);
exit;
