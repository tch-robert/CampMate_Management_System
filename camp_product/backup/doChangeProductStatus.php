<?php
require_once("../db_connect.php");

//上下架的功能 更改資料表中的product_status 去改變上下架狀態
if (isset($_POST["productId"]) && isset($_POST["changeSta"])) {
    $productId = $_POST["productId"];
    $changeSta = $_POST["changeSta"];
    $changeStaSql = "UPDATE product SET product_status='$changeSta' WHERE product_id=$productId";
    if ($conn->query($changeStaSql) === TRUE) {
    } else {
        echo "更新錯誤" . $conn->error;
    }

    //確保頁面的樣式不要變
    $sameUrl = "";
    if (isset($_GET["viewMode"]) || isset($_GET["statusPage"]) || isset($_GET["search"])) {
        $sameUrl = $sameUrl . "?";
    }
    if (isset($_GET["viewMode"])) {
        $sameUrl = $sameUrl . "viewMode=" . $_GET["viewMode"];
    }
    if (isset($_GET["statusPage"])) {
        $sameUrl = $sameUrl . "&statusPage=" . $_GET["statusPage"];
    }
    if (isset($_GET["search"])) {
        $sameUrl = $sameUrl . "&search=" . $_GET["search"];
    }
    // echo $sameUrl;
    header("location: ./camp_productList.php$sameUrl");
}

$conn->close();
