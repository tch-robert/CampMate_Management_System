<?php
require_once("../db_connect.php");

if (!isset($_POST["category_name"]) || !isset($_POST["parent_name"])) {
    echo "請循正常管道進入";
    exit;
}

$process = $_POST["process"];
$product_id = $_POST["product_id"];
$parent_name = $_POST["parent_name"];
$category_name = $_POST["category_name"];


// echo $parent_name, $category_name;

$findSql = "SELECT * FROM product_category WHERE category_name='$parent_name'";
$findResult = $conn->query($findSql);
$findRow = $findResult->fetch_assoc();
$parent_id = $findRow["category_id"];

// echo $parent_id;
// exit;


$sql = "INSERT INTO product_category (category_name) VALUES ('$category_name')";

if ($conn->query($sql) === TRUE) {
    echo "分類寫入成功 <br>";
} else {
    echo "分類寫入失敗 <br>";
}
// exit;
$category_id = $conn->insert_id;

$classSql = "INSERT INTO product_category_class (parent_id, category_id, level) 
VALUES ('$parent_id','$category_id',2)";

if ($conn->query($classSql) === TRUE) {
    echo "分類關聯表 寫入成功 <br>";
} else {
    echo "分類關聯表 寫入失敗 <br>";
}

switch ($process) {
    case 1:
        header("location: ./addProduct.php");

        break;
    case 2:
        header("location: ./editProduct.php?product_id=$product_id");
        break;
}

$conn->close();
