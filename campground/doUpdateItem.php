<?php
require_once("../db_connect.php");

if(!isset($_POST["item_id"])){
    echo "請循正常管道進入此頁";
    exit;
}

$camp_id = $_GET["camp_id"];
$area_id = $_GET["area_id"];
$item_id = $_GET["item_id"];

$item_name = $_POST["item_name"];
$status = $_POST["status"];
$itemPrice = $_POST["itemPrice"];
$pic_name = $_FILES["file"]["name"];

// 檢查是否上傳了新的圖片
if(!empty($pic_name)) {
    $path = "./upload/$pic_name";

    // 如果有上傳新的圖片，執行上傳操作
    if($_FILES["file"]["error"] == 0) {
        if(move_uploaded_file($_FILES["file"]["tmp_name"], "./upload/".$_FILES["file"]["name"])){
            echo "upload success";
        } else {
            echo "upload failed";
        }
    }
} else {
    // 如果沒有上傳新的圖片，則保留原始圖片路徑不變
    $sql = "SELECT path FROM area_item WHERE id=$item_id";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $path = $row["path"];
    }
}

// 更新商品資料
$sql = "UPDATE area_item SET item_name='$item_name', price='$itemPrice', path='$path' WHERE id=$item_id";
if($conn->query($sql) === TRUE){
    echo "商品資料更新成功";
} else {
    echo "更新資料錯誤: " . $conn->error;
}

// 更新商品狀態
$sql = "UPDATE camp_area_item SET status='$status' WHERE item_id=$item_id";
if($conn->query($sql) === TRUE){
    echo "商品狀態更新成功";
} else {
    echo "更新資料錯誤: " . $conn->error;
}

$conn->close();

header("location: edit_item.php?camp_id=$camp_id&area_id=$area_id&item_id=$item_id");
?>