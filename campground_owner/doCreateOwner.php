<?php
require_once("../db_connect.php");

if (!isset($_POST["name"])) {
    echo json_encode([
        "status" => 0,
        "message" => "請循正常管道進入此頁"
    ]);
    exit;
}

$name = $_POST["name"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$password = $_POST["password"];
$pay_account = $_POST["pay_account"];
$address = $_POST["address"];
$now = date('Y-m-d H:i:s');

// Check if email already exists
$sqlCheckOwner = "SELECT * FROM campground_owner WHERE email = '$email'";
$resultCheck = $conn->query($sqlCheckOwner);

if ($resultCheck->num_rows > 0) {
    echo json_encode([
        "status" => 0,
        "message" => "此email已經有人註冊"
    ]);
    exit;
}

// Validate required fields
if (empty($name) || empty($email) || empty($phone) || empty($password) || empty($pay_account) || empty($address)) {
    echo json_encode([
        "status" => 0,
        "message" => "請填入必要欄位"
    ]);
    exit;
}

$password = md5($password);

$sql = "INSERT INTO campground_owner (name, email, phone, password, pay_account, address, created_at)
VALUES ('$name', '$email', '$phone', '$password', '$pay_account', '$address', '$now')";

if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    echo json_encode([
        "status" => 1,
        "message" => "新資料輸入成功， ID 為 $last_id"
    ]);
} else {
    echo json_encode([
        "status" => 0,
        "message" => "Error: " . $sql . "<br>" . $conn->error
    ]);
}

$conn->close();

exit;
?>

