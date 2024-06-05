<?php
require_once ("../db_connect.php");

$today = date('Y-m-d');

// 更新所有優惠券狀態
$sql = "UPDATE coupon SET status = CASE
            WHEN start_date <= '$today' AND end_date >= '$today' THEN '可使用'
            ELSE '已停用'
        END
        WHERE valid = 1";

if ($conn->query($sql) === TRUE) {
    echo "所有優惠券狀態已更新";
} else {
    echo "更新失敗: " . $conn->error;
}

$conn->close();
?>