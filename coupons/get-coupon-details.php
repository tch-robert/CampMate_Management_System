<?php
require_once("../db_connect.php");

if (isset($_GET['id'])) {
    $couponId = (int)$_GET['id'];
    $sql = "SELECT * FROM coupon WHERE id = $couponId AND valid = 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $coupon = $result->fetch_assoc();
        echo "<tr><th>ID</th><td data-editable='false'>{$coupon['id']}</td></tr>";
        echo "<tr><th>名稱</th><td>{$coupon['coupon_name']}</td></tr>";
        echo "<tr><th>類別</th><td>{$coupon['category']}</td></tr>";
        echo "<tr><th>折扣</th><td>{$coupon['discount']}</td></tr>";
        echo "<tr><th>使用低消金額</th><td>{$coupon['min_cost']}</td></tr>";
        echo "<tr><th>最高折抵金額</th><td>{$coupon['max_discount_amount']}</td></tr>";
        echo "<tr><th>數量</th><td>{$coupon['coupon_num']}</td></tr>";
        echo "<tr><th>起始日期</th><td>{$coupon['start_date']}</td></tr>";
        echo "<tr><th>結束日期</th><td>{$coupon['end_date']}</td></tr>";
        echo "<tr><th>狀態</th><td>{$coupon['status']}</td></tr>";
    } else {
        echo "<tr><td colspan='2'>找不到優惠券資料</td></tr>";
    }
} else {
    echo "<tr><td colspan='2'>無效的優惠券ID</td></tr>";
}
