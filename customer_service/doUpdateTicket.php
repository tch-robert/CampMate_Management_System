<?php
require_once("../db_connect.php");

if(!isset($_POST["id"])){
    echo "請循正常管道進入此頁";
    exit;
}

$id=$_POST["id"];
$title=$_POST["title"];
$description=$_POST["description"];
$user_id=$_POST["user_id"];
$reply=$_POST["reply"];
$status=$_POST["status"];
$createtime=$_POST["createtime"];
$closetime=date('Y-m-d H:i:s');


if(empty($reply) || empty($status)){
    echo "請填入必要欄位";
    exit;
}


$sql="UPDATE ticket SET reply='$reply', status='$status', closetime='$closetime' WHERE id=$id";

if($conn->query($sql) === TRUE){
    $last_id = $conn->insert_id;
    echo "新資料輸入成功， ID 為 $last_id";
}else{
    echo"Error: " . $sql . "<br>" . $conn->error;
}
if($conn->query($sql) === TRUE){
    echo "更新成功";
}else {
    echo "更新資料錯誤: " . $conn->error;
}
header("location: ticket.php?id=".$id);

$conn->close();
