<?php
require_once("../db_connect.php");
session_start();

if(!isset($_POST["username"])){
    echo "請循正常管道進入此頁";
    exit;
}

$username=$_POST["username"];
$password=$_POST["password"];

if(empty($usernsme)){
    $errorMsg="請輸入使用者帳號";
    $_SESSION["errorMsg"]=$errorMsg;
    header("location: signin.php");
    exit;
}
if(empty($password)){
    $errorMsg="請輸入密碼";
    $_SESSION["errorMsg"]=$errorMsg;
    header("location: signin.php");
    exit;
}


$password=md5($password);
echo $usernsme;
echo $password."<br>";

$sql="SELECT * FROM users WHERE username='$username' AND password = '$password' AND valid=1";
$result=$conn->query($sql);
$ownerCount=$result->num_rows;
echo $sql;

if($userCount==0){
    $errorMsg="帳號或密碼錯誤";
    if(!isset($_SESSION["errorTimes"])){
        $_SESSION["errorTimes"]=1;
    }else{
        $_SESSION["errorTimes"]++;
    }
    $_SESSION["errorMsg"]=$errorMsg;
    header("location: signin.php");
    exit;
}

$row=$result->fetch_assoc();
// var_dump($row);
unset($_SESSION["errorMsg"]);
unset($_SESSION["errorTimes"]);

$_SESSION["users"]=[
    "id"=>$row["id"],
    "name"=>$row["name"],
    "email"=>$row["email"],
    "phone"=>$row["phone"]
];

header("location:../general_member/users.php");