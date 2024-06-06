<?php
require_once("../db_connect.php");

if(isset($_POST["username"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $id_number = $_POST["id_number"];
    $birth_date = $_POST["birth_date"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];

    // 輸入驗證
    if(empty($username) || empty($password) || empty($id_number) || empty($phone)) {
        echo "請填入所有必填欄位";
        exit;
    }

    if(strlen($password) < 4 || strlen($password) > 20) {
        echo "請輸入4~20字元的密碼";
        exit;
    }

    // 執行 SQL 語句前，對使用者輸入進行適當的處理以防止 SQL 注入攻擊
    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);
    $id_number = $conn->real_escape_string($id_number);
    $birth_date = $conn->real_escape_string($birth_date);
    $phone = $conn->real_escape_string($phone);
    $email = $conn->real_escape_string($email);

    // 檢查是否有重複的使用者名稱
    $sqlCheckUser = "SELECT * FROM users WHERE username = '$username' AND valid=1";
    $resultCheck = $conn->query($sqlCheckUser);

    if($resultCheck->num_rows > 0) {
        echo "此帳號已經有人註冊";
        exit;
    }

    $now = date('Y-m-d H:i:s');

    // 插入資料庫
    $sql = "INSERT INTO users (username, password, id_number, birth_date, phone, email, created_at, valid)
            VALUES ('$username', '$password', '$id_number', '$birth_date', '$phone', '$email', '$now', 1)";

    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
        echo "新資料輸入成功, id 為 $last_id";
        header("location: user.php?id=$last_id"); // 重定向到該使用者的資訊頁面
        exit;
    } else {
        echo "Error:" . $sql . "<br>" . $conn->error;
    }
}