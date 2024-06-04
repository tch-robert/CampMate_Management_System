<?php
require_once("../db_connect.php");

try {
    // Step 1: 刪除現有的外鍵約束
    // $sql1 = "ALTER TABLE `activities` DROP FOREIGN KEY `activities_ibfk_1`";
    // if ($conn->query($sql1) !== TRUE) {
    //     throw new Exception("Error dropping foreign key: " . $conn->error);
    // }

    // Step 2: 修改欄位
    // $sql2 = "ALTER TABLE `activities` CHANGE `organizer_id` `organizer_email` VARCHAR(30) NOT NULL";
    // if ($conn->query($sql2) !== TRUE) {
    //     throw new Exception("Error changing column: " . $conn->error);
    // }

    // Step 3: 新增外鍵約束
    $sql3 = "ALTER TABLE `activities` ADD CONSTRAINT `activities_ibfk_1` FOREIGN KEY (`organizer_email`) REFERENCES `users` (`email`)";
    if ($conn->query($sql3) !== TRUE) {
        throw new Exception("Error adding foreign key: " . $conn->error);
    }

    echo "成功修改資料表結構";
} catch (Exception $e) {
    echo "錯誤: " . $e->getMessage();
}

$conn->close();
