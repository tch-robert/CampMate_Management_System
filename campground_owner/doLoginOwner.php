<?php
require_once("../db_connect.php");
session_start();

if(!isset($_POST["email"])){
    echo "請循正常管道進入此頁";
    exit;
}

$email=$_POST["email"];
$password=$_POST["password"];

if(empty($email)){
    $errorMsg="請輸入Email";
    $_SESSION["errorMsg"]=$errorMsg;
    header("location: owner-signin.php");
    exit;
}
if(empty($password)){
    $errorMsg="請輸入密碼";
    $_SESSION["errorMsg"]=$errorMsg;
    header("location: owner-signin.php");
    exit;
}


$password=md5($password);

$sql="SELECT * FROM campground_owner WHERE email = '$email' AND password = '$password' AND valid=1";
$result=$conn->query($sql);
$ownerCount=$result->num_rows;

if($ownerCount==0){
    $errorMsg="Email或密碼錯誤";
    if(!isset($_SESSION["errorTimes"])){
        $_SESSION["errorTimes"]=1;
    }else{
        $_SESSION["errorTimes"]++;
    }
    $_SESSION["errorMsg"]=$errorMsg;
    header("location: owner-signin.php");
    exit;
}

$row=$result->fetch_assoc();
// var_dump($row);
unset($_SESSION["errorMsg"]);
unset($_SESSION["errorTimes"]);

$_SESSION["owner"]=[
    "name"=>$row["name"],
    "email"=>$row["email"],
    "phone"=>$row["phone"]
];

header("location: owners.php");