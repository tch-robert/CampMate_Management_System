<?php
require_once("../db_connect.php");
session_start();

if(!isset($_POST["username"])){
    echo "請循正常管道進入此頁";
    exit;
}

$username=$_POST["username"];
$password=$_POST["password"];




if(empty($username)){
    $errorMsg="請輸入使用者帳號";
    $_SESSION["errorMsg"]=$errorMsg;
    // echo $errorMsg;
    // exit;
    header("location: sign_in.php");
    exit;

}
if(empty($password)){
    $errorMsg="請輸入密碼";
    $_SESSION["errorMsg"]=$errorMsg;
    // echo $errorMsg;
    // exit;
    header("location: sign_in.php");
    exit;
}

// echo "$username, $password";

$sql="SELECT * FROM users WHERE valid=1 AND username = '$username'  AND password='$password'";
$result = $conn->query($sql);


// $sql="SELECT * FROM users WHERE username = '$username' AND password = '$password' WHERE valid=1";
// $result=$conn->query($sql);
$userCount=$result->num_rows;
// echo $sql;

if($userCount==0){
    $errorMsg="帳號或密碼錯誤";
    if(!isset($_SESSION["errorTimes"])){
        $_SESSION["errorTimes"]=1;
    }else{
        $_SESSION["errorTimes"]++;
    }
    $_SESSION["errorMsg"]=$errorMsg;
    header("location: sign_in.php");
    exit;
}
$row=$result->fetch_assoc();
// var_dump($row);

header("location: ../chart/chart.php");