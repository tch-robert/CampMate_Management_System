<?php
require_once("../db_connect.php");

$buttonAct = $_POST["action"];
if ($buttonAct == 0) {
    echo "取消新增商品";
    header("location: ./camp_productList.php");
    exit;
}

if ($buttonAct == 1) {
    $product_status = 0;
} else if ($buttonAct == 2) {
    $product_status = 1;
}

if ($buttonAct == 1 || $buttonAct == 2) {
    $product_name = $_POST["productName"];
    $product_category = $_POST["productCate"];
    $product_description = $_POST["productDes"];
    $product_brief = $_POST["productBrief"];
    $product_price = $_POST["productPrice"];

    // echo $product_name, $product_category, $product_description, $product_brief, $product_price, $product_status;

    $mainPic = $_FILES["mainPic"];
    $normalPic = $_FILES["normalPic"];

    $Psql = "INSERT INTO product (product_name, product_description, product_brief, product_price, product_status, product_valid) 
    VALUES ('$product_name', '$product_description', '$product_brief', '$product_price', '$product_status', 1)"; //這邊有錯誤

    // echo $Psql;
    // exit;

    if ($conn->query($Psql) === TRUE) {
        $last_id = $conn->insert_id;
        //取得於資料表欄位中的id
        echo "新資料輸入成功,id為$last_id";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    exit;
    // $getPidSql = "SELECT product_id FROM product WHERE prouduct_name='$product_name'";
    // $getPidResult = $conn->query($getPidSql);
    // $getPidRow = $getPidResult->fetch_assoc();
    // $getProduct_id = $getPidRow["product_id"];

    if ($mainPic["error"] == 0) {
        $mainPic_name = $mainPic["name"];
        if (move_uploaded_file($mainPic["tmp_name"], "product_upload/" . $mainPic["name"])) {
            echo "upload mainPic success <br>";
        } else {
            echo "upload mainPic failed <br>";
        }
        // $mainPicSql = "INSERT INTO images (product_id, product_mainPic, path) 
        // VALUES ('$getProduct_id', 1, $mainPic_name)";
        // if ($conn->query($mainPicSql) === TRUE) {
        //     echo "mainPic資訊寫入成功";
        // } else {
        //     echo "mainPic資訊寫入失敗";
        // }
    }


    $normalPicArr = [];
    foreach ($normalPic["error"] as $value) {
        $normalPicArr[] = "$value";
    }
    if (!in_array(1, $normalPic)) {
        foreach ($normalPic["name"] as $key => $value) {
            if (move_uploaded_file($normalPic["tmp_name"][$key], "product_upload/" . $value)) {
                echo "upload normalPic success <br>";
            } else {
                echo "upload normalPic failed <br>";
            }
        }
    } else {
        echo "get multifile error";
    }
}
?>

<pre>
    <?php print_r($normalPic); ?>
</pre>