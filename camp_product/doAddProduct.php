<?php
require_once("../db_connect.php");

//抓取button的value判斷要怎麼作動
$buttonAct = $_POST["action"];
//如果是0 就代表是取消按鈕 所以取消並且exit
if ($buttonAct == 0) {
    echo "取消新增商品";
    header("location: ./camp_productList.php");
    exit;
}
//判斷如果button回傳的值是1 那就將status設定為0 代表式儲存後下架
$product_status = ($buttonAct == 1) ? 0 : 1;

//抓取表單內容
$product_name = $_POST["productName"];
$product_category = $_POST["productCate"];
$product_description = $_POST["productDes"];
$product_brief = $_POST["productBrief"];
$product_price = $_POST["productPrice"];
$product_specifications = $_POST["productBrief"];
//因為儲存就是新增了 所以會讓他顯示
$product_valid = 1;
//設定新增商品的時間點
$now = date('Y-m-d H:i:s');

// 輸出表單數據進行調試
// echo "Product Name: $product_name<br>";
// echo "Product Category: $product_category<br>";
// echo "Product Description: $product_description<br>";
// echo "Product Brief: $product_brief<br>";
// echo "Product Price: $product_price<br>";
// echo "Product Status: $product_status<br>";
// echo "Now: $now<br>";

$productSql = "INSERT INTO product (product_name, product_description, product_brief, product_price, product_specifications, product_status, create_date, product_valid) VALUES ('$product_name', '$product_description', '$product_brief', '$product_price', '$product_specifications', '$product_status', '$now', '$product_valid')";
// echo "SQL Query: $$productSql<br>";

if ($conn->query($productSql) === TRUE) {
    echo "資料寫入product成功 <br>";
} else {
    echo "資料寫入product失敗: <br>" . $conn->error;
}
$product_id = $conn->insert_id;

$searchCateSql = "SELECT * FROM product_category WHERE category_name='$product_category'";
$searchCateResult = $conn->query($searchCateSql);
$searchCateRow = $searchCateResult->fetch_assoc();
print_r($searchCateRow);
echo "<br>";
$category_id = $searchCateRow["category_id"];
echo $category_id . "<br>";

$cateSql = "INSERT INTO product_category_relate (product_id, category_id) VALUES ('$product_id', '$category_id')";

if ($conn->query($cateSql) === TRUE) {
    echo "category關聯表寫入成功 <br>";
} else {
    echo "category關聯表寫入失敗 <br>";
}

$mainPic = $_FILES["mainPic"];
$normalPic = $_FILES["normalPic"];

if ($mainPic["error"] == 0) {
    $mainPic_num = 1;
    $mainPic_name = $mainPic["name"];
    if (move_uploaded_file($mainPic["tmp_name"], "product_image/" . $mainPic["name"])) {
        echo "upload mainPic success <br>";
    } else {
        echo "upload mainPic failed <br>";
    }

    // echo $product_id, $pic_num, $mainPic_name;
    // exit;
    $mainPicSql = "INSERT INTO images (product_id, product_mainPic, path) 
    VALUES ('$product_id', '$mainPic_num', '$mainPic_name')";
    if ($conn->query($mainPicSql) === TRUE) {
        echo "mainPic資訊寫入成功 <br>";
    } else {
        echo "mainPic資訊寫入失敗 <br>";
    }
} else {
    echo "取得上傳 mainPic 錯誤 <br>";
}


$normalPicArr = [];
foreach ($normalPic["error"] as $value) {
    $normalPicArr[] = "$value";
}
if (!in_array(1, $normalPic)) {
    $mainPic_num = 0;
    foreach ($normalPic["name"] as $key => $value) {
        if (move_uploaded_file($normalPic["tmp_name"][$key], "product_image/" . $value)) {
            echo "upload normalPic success <br>";
        } else {
            echo "upload normalPic failed <br>";
        }
        // echo $product_id, $mainPic_num, $value;

        $normalPicSql = "INSERT INTO images (product_id, product_mainPic, path) 
        VALUES ('$product_id', '$mainPic_num', '$value')";

        if ($conn->query($normalPicSql) === TRUE) {
            echo $value . "normalPic資訊寫入成功 <br>";
        } else {
            echo $value . "normalPic資訊寫入失敗 <br>";
        }
    }
} else {
    echo "取得上傳 multifile 錯誤 <br>";
}

header("location: ./camp_productList.php");

$conn->close();
