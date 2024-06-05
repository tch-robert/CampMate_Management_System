<?php
require_once("../db_connect.php");

$sql = "INSERT INTO images (product_id, product_mainPic, path) 
VALUES ('2', '0', 'abc.jpg')";

if ($conn->query($sql) === TRUE) {
    echo "mainPic資訊寫入成功";
} else {
    echo "mainPic資訊寫入失敗";
}
