<?php
require_once("../db_connect.php");
if(!isset($_POST["username"])){
    echo "請從正常管道進入";
    exit;
}

$photo=$_POST["photo"];
$username=$_POST["username"];
$password=$_POST["password"];
$id_number=$_POST["id_number"];
$birth_date=$_POST["birth_date"];
$phone=$_POST["phone"];
$email=$_POST["email"];

$sqlCheckUser="SELECT * FROM users WHERE username = '$username'";
$resultCheck=$conn->query($sqlCheckUser);
if($resultCheck->num_rows>0){
    echo "此帳號已經有人註冊";
    exit;
}

if(empty($username)){
    echo "請填入使用者名稱";
    exit;
}
if(empty($password)){
    echo "請填入密碼";
    exit;
}
$passwordLength=strlen($password);
if($passwordLength<4 || $passwordLength>20){
    echo "請輸入4~20字元的密碼";
    exit;
}

if(empty($id_number)){
    echo "請填入身分證字號";
    exit;
}
if(empty($phone)){
    echo "請填入可連絡電話";
    exit;
}


$now=date('Y-m-d H:i:s');

$sql="INSERT INTO users (photo, username, password, id_number, birth_date, phone, email,created_at,valid)
VALUES ('$photo','$username','$password','$id_number', '$birth_date','$phone','$email', '$now', 1)";
// echo $sql;

// 做一個註冊成功的彈窗

if ($conn->query($sql) ===TRUE) { 
    $last_id = $conn->insert_id;
    echo "新資料輸入成功, id 為 $last_id";
}else{
    echo "Error:" .$sql . "<br>" . $conn->error;
}

$conn->close();
header("laction: users.php");