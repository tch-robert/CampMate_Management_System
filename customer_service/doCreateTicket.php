<?php
require_once("../db_connect.php");

$id=$_POST["id"];
$title=$_POST["title"];
$description=$_POST["description"];
$user_id=$_POST["user_id"];
$now=date('Y-m-d H:i:s');


if(empty($title) || empty($description) || empty($user_id)){
    echo "請填入必要欄位";
    exit;
}


$sql="INSERT INTO ticket (title, description, user_id, createtime)
VALUES ('$title', '$description', '$user_id', '$now')";

if($conn->query($sql) === TRUE){
    $last_id = $conn->insert_id;
    echo "新資料輸入成功， ID 為 $last_id";
}else{
    echo"Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
header("location: tickets.php");