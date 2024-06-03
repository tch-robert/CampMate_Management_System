<?php
require_once("../db_connect.php");

if(!isset($_POST["name"])){
    echo "請循正常管道進入此頁";
    exit;
}

$id=$_POST["id"];
$name=$_POST["name"];

$phone=$_POST["phone"];
$pay_account=$_POST["pay_account"];
$address=$_POST["address"];



$sql="UPDATE campground_owner SET name='$name', phone='$phone', address='$address', pay_account='$pay_account'  WHERE id=$id";

if($conn->query($sql) === TRUE){
    echo "更新成功";
}else {
    echo "更新資料錯誤: " . $conn->error;
}
header("location: owner.php?id=".$id);

$conn->close();