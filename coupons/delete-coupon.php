<?php
require_once("../db_connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // 軟刪除優惠券
        $sql = "UPDATE coupon SET valid = 0 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "刪除成功";
        } else {
            echo "刪除失敗：" . $conn->error;
        }

        $stmt->close();
    } else {
        echo "缺少優惠券ID";
    }
} else {
    echo "無效的請求方法";
}

$conn->close();
