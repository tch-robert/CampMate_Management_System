<?php
require_once("../db_connect.php");

//軟刪除商品 更改product的valid
if (isset($_POST["productId"]) && isset($_POST["softDelete"])) {
    $productId = $_POST["productId"];
    $softDelete = $_POST["softDelete"];

    $softDelSql = "UPDATE product SET product_valid='$softDelete' WHERE product_id=$productId";
    if ($conn->query($softDelSql) === TRUE) {
    } else {
        echo "刪除失敗" . $conn->error;
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
