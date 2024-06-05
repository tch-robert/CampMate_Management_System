<?php
require_once("../db_connect.php");

if(!isset($_POST["phone"])){
    echo "請循正常管道進入此頁";
    exit;
}

$id=$_POST["id"];
// $name=$_POST["name"];
// $email=$_POST["email"];
$password=$_POST["password"];
$repassword=$_POST["repassword"];
$phone=$_POST["phone"];
$pay_account=$_POST["pay_account"];
$address=$_POST["address"];

$sqlCheckOwner="SELECT * FROM campground_owner WHERE id = '$id'";
$resultCheck=$conn->query($sqlCheckOwner);
// if($resultCheck->num_rows>0){
//     echo "此email已經有人註冊";
//     exit;
// }
// if(empty($name)){
//     echo "請輸入姓名";
//     exit;
// }
if(empty($password)){
    echo "請輸入密碼";
    exit;
}
if($password!=$repassword){
    echo "前後密碼不一致";
    exit;
}

$password=md5($password);

$sql="UPDATE campground_owner SET  password='$password', phone='$phone', address='$address', pay_account='$pay_account'  WHERE id=$id";

if($conn->query($sql) === TRUE){
    echo "更新成功";
}else {
    echo "更新資料錯誤: " . $conn->error;
}
header("location: ../campground/owner-data.php");

$conn->close();