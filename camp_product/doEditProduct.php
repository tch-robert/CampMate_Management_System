<?php
require_once("../db_connect.php");

//抓取button的value判斷要怎麼作動
$buttonAct = $_POST["action"];
$productId = $_GET["product_id"];

//如果是0 就代表是取消按鈕 所以取消並且exit
if ($buttonAct == 0) {
    echo "取消新增商品";
    header("location: ./camp_productList.php");
    exit;
}
if ($buttonAct == 1) {
    if (isset($_POST["productName"])) {
        $product_name = $_POST["productName"];
        // echo $product_name, $productId;
        $editNameSql = "UPDATE product SET product_name='$product_name' WHERE product_id='$productId'";
        if ($conn->query($editNameSql) === TRUE) {
            echo "商品名稱更新成功 <br>";
        } else {
            echo "商品名稱更新失敗" . $conn->error . "<br>";
        }
    }

    if (isset($_POST["productCate"])) {
        $product_category = $_POST["productCate"];
        $findCateIdSql = "SELECT category_id FROM product_category WHERE category_name='$product_category'";
        $findCateIdResult = $conn->query($findCateIdSql);
        $findCateIdRow = $findCateIdResult->fetch_assoc();
        $category_id = $findCateIdRow["category_id"];

        $editCateRelateSql = "UPDATE product_category_relate SET category_id='$category_id' WHERE product_id='$productId'";
        if ($conn->query($editCateRelateSql) === TRUE) {
            echo "類別名稱更新成功 <br>";
        } else {
            echo "類別名稱更新失敗 <br>";
        }
    }

    if (isset($_POST["productDes"])) {
        $product_description = $_POST["productDes"];
        $editDesSql = "UPDATE product SET product_description='$product_description' WHERE product_id='$productId'";
        if ($conn->query($editDesSql) === TRUE) {
            echo "商品描述更新完成 <br>";
        } else {
            echo "商品描述更新失敗 <br>";
        }
    }

    if (isset($_POST["productBrief"])) {
        $product_brief = $_POST["productBrief"];
        $product_specifications = $_POST["productBrief"];
        $editBriefSql = "UPDATE product SET product_brief='$product_brief',product_specifications='$product_specifications' WHERE product_id='$productId'";
        if ($conn->query($editBriefSql) === TRUE) {
            echo "規格&簡述更新完成 <br>";
        } else {
            echo "規格&簡述更新失敗 <br>";
        }
    }

    if (isset($_POST["productPrice"])) {
        $product_price = $_POST["productPrice"];
        $editPriceSql = "UPDATE product SET product_price='$product_price' WHERE product_id='$productId'";
        if ($conn->query($editPriceSql) === TRUE) {
            echo "租賃價格更新成功 <br>";
        } else {
            echo "租賃價格更新失敗 <br>";
        }
    }

    //抓取圖片檔案
    $mainPic = $_FILES["mainPic"];
    $normalPic = $_FILES["normalPic"];

    //判斷主圖片有沒有進來
    if ($mainPic["error"] == 0) {
        $mainPic = $_FILES["mainPic"];
        $mainPic_num = 1;
        $mainPic_name = $mainPic["name"];
        if (move_uploaded_file($mainPic["tmp_name"], "product_image/" . $mainPic["name"])) {
            echo "upload mainPic success <br>";
        } else {
            echo "upload mainPic failed <br>";
        }

        $delMainPicSql = "DELETE FROM images WHERE product_id='$productId' AND product_mainPic='$mainPic_num'";
        if ($conn->query($delMainPicSql) === TRUE) {
            echo "舊mainPic資訊刪除成功 <br>";
        } else {
            echo "舊mainPic資訊刪除失敗 <br>";
        }

        $mainPicSql = "INSERT INTO images (product_id, product_mainPic, path) 
    VALUES ('$productId', '$mainPic_num', '$mainPic_name')";
        if ($conn->query($mainPicSql) === TRUE) {
            echo "新mainPic資訊寫入成功 <br>";
        } else {
            echo "新mainPic資訊寫入失敗 <br>";
        }
    } else {
        echo "沒有要更新mainPic <br>";
    }

    //判斷檔案是否有進來前的陣列製作
    $normalPicArr = [];
    foreach ($normalPic["error"] as $value) {
        $normalPicArr[] = "$value";
    }

    //先判斷陣列中是不是沒有1
    if (!in_array(1, $normalPic)) {
        //刪除舊的 normalPic 資訊
        $delNormalPicSql = "DELETE FROM images WHERE product_id='$productId' AND product_mainPic=0";
        if ($conn->query($delNormalPicSql) === TRUE) {
            echo "舊normalPic資訊刪除成功 <br>";
        } else {
            echo "舊normalPic資訊刪除失敗 <br>";
        }

        $mainPic_num = 0;
        foreach ($normalPic["name"] as $key => $value) {
            if (move_uploaded_file($normalPic["tmp_name"][$key], "product_image/" . $value)) {
                echo "upload normalPic success <br>";
            } else {
                echo "upload normalPic failed <br>";
            }
            // echo $product_id, $mainPic_num, $value;

            $normalPicSql = "INSERT INTO images (product_id, product_mainPic, path) 
        VALUES ('$productId', '$mainPic_num', '$value')";

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
}
