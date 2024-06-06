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
$sqlCheckOwner = "SELECT * FROM campground_owner WHERE email = ?";
$stmtCheck = $conn->prepare($sqlCheckOwner);
$stmtCheck->bind_param("s", $email);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();

if ($resultCheck->num_rows > 0) {
    echo json_encode([
        "status" => 0,
        "message" => "此email已經有人註冊"
    ]);
    $stmtCheck->close();
    exit;
}
$stmtCheck->close();

// Validate required fields
if (empty($name)) {
    echo json_encode([
        "status" => 0,
        "message" => "請輸入姓名"
    ]);
    exit;
}

if (empty($email)) {
    echo json_encode([
        "status" => 0,
        "message" => "請輸入Email"
    ]);
    exit;
}

if (empty($phone)) {
    echo json_encode([
        "status" => 0,
        "message" => "請輸入電話"
    ]);
    exit;
}

if (empty($password)) {
    echo json_encode([
        "status" => 0,
        "message" => "請輸入密碼"
    ]);
    exit;
}

if (empty($pay_account)) {
    echo json_encode([
        "status" => 0,
        "message" => "請輸入收款帳號"
    ]);
    exit;
}

if (empty($address)) {
    echo json_encode([
        "status" => 0,
        "message" => "請輸入地址"
    ]);
    exit;
}

$password = md5($password);

$stmt = $conn->prepare("INSERT INTO campground_owner (name, email, phone, password, pay_account, address, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssisss", $name, $email, $phone, $password, $pay_account, $address, $now);

if ($stmt->execute()) {
    $last_id = $conn->insert_id;
    echo json_encode([
        "status" => 1,
        "message" => "新資料輸入成功， ID 為 $last_id"
    ]);
} else {
    echo json_encode([
        "status" => 0,
        "message" => "Error: " . $stmt->error
    ]);
}

$stmt->close();
$conn->close();

exit;
?>
