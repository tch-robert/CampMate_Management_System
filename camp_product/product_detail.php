<?php
require_once("../db_connect.php");

$product_id = $_GET["product_id"];

$sql = "SELECT * FROM product WHERE product_id='$product_id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
// print_r($row);
// echo "<br>";

$cateSql = "SELECT product.* , product_category_relate.category_id, product_category.category_name 
FROM product 
JOIN product_category_relate ON product.product_id = product_category_relate.product_id 
JOIN product_category ON product_category_relate.category_id = product_category.category_id 
WHERE product.product_id = '$product_id'
";
$cateResult = $conn->query($cateSql);
$cateRow = $cateResult->fetch_assoc();
// print_r($cateRow);
?>

<!doctype html>
<html lang="en">

<head>
    <title>Product_detail</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />


    <?php include("../css.php") ?>
</head>

<body>

    <?php include("../js.php") ?>
</body>

</html>