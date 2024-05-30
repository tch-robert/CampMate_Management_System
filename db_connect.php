<?php
//**麻煩第二組同學建立table的時候按照下列內容設定**
$servername = "localhost";
$username = "admin"; //要在php myAdmin設定的帳號
$password = "abc123"; //要在php myAdmin設定的密碼
$dbname = "campmate_db"; //要在php myAdmin新增的資料庫名稱

//創建連結
$conn = new mysqli($servername, $username, $password, $dbname);

//檢查連線是否成功
if ($conn->connect_error) {
    //如果顯示這個麻煩檢查一下前面有沒有設定錯誤的地方
    die("連線失敗: " . $conn->connect_error);
} else {
    //echo "水啦!!!連線成功~~";
};
