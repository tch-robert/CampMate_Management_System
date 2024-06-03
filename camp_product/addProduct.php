<?php
require_once("../db_connect.php");

$L1Sql = "SELECT product_category.*, product_category_class.parent_id FROM product_category 
JOIN product_category_class ON product_category.category_id = product_category_class.category_id 
WHERE product_category_class.parent_id IS NULL 
ORDER BY product_category.category_id ASC";
$L1Result = $conn->query($L1Sql);
$L1Rows = $L1Result->fetch_all(MYSQLI_ASSOC);

$L2Sql = "SELECT product_category.*, product_category_class.parent_id FROM product_category 
JOIN product_category_class ON product_category.category_id = product_category_class.category_id 
WHERE product_category_class.parent_id IS NOT NULL  
ORDER BY product_category.category_id ASC";
$L2Result = $conn->query($L2Sql);
$L2Rows = $L2Result->fetch_all(MYSQLI_ASSOC);
?>

<!doctype html>
<html lang="en">

<head>
    <title>add product</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- 把共通的css叫入 -->
    <?php include("../css.php") ?>

    <style>
        .textAreaDis {
            height: 300px;
            resize: none;
        }

        .textAreaBreif {
            height: 100px;
            resize: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- 新增商品的流程標籤列 -->
        <div>
            <ul class="nav nav-underline my-3">
                <li class="nav-item">
                    <a class="nav-link active" href="#">基本資訊</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">規格</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">租賃資訊</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">取貨點 or 運送方式</a>
                </li>
            </ul>
        </div>

        <form action="doAddProduct.php" method="post" enctype="multipart/form-data">
            <div>
                <!-- 新增商品的表單區域 -->
                <div class="row justify-content-end">
                    <h3>基本資訊</h3>
                    <div class="col-11">
                        <div class="mb-2">
                            <label for="mainPic" class="form-label">商品主要行銷圖片</label>
                            <input id="mainPic" name="mainPic" class="form-control" type="file" accept=".jpg,.jpeg,.png,.avif,.webp" required>
                            <div id="mainPicPre"></div>
                        </div>
                        <div class="mb-2">
                            <label for="normalPic" class="form-label">商品圖片</label>
                            <input id="normalPic" name="normalPic[]" class="form-control" type="file" accept=".jpg,.jpeg,.png,.avif,.webp" multiple>
                        </div>
                        <div class="mb-2">
                            <label for="productName" class="h6 form-label">商品名稱</label>
                            <input id="productName" name="productName" class="form-control" type="text" required>
                        </div>
                        <div class="mb-2">
                            <label for="productCate" class="form-label">商品分類</label>
                            <select class="form-control" name="productCate" id="productCate" required>
                                <option value="" selected disabled hidden>請選擇分類</option>
                                <?php foreach ($L1Rows as $level1) : ?>
                                    <optgroup label="<?= $level1["category_name"] ?>">
                                        <?php foreach ($L2Rows as $level2) : ?>
                                            <option value="<?= $level2["category_name"] ?>">
                                                <?= $level2["category_name"] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="productDes" class="form-label">商品描述</label>
                            <textarea id="productDes" name="productDes" class="textAreaDis form-control" required></textarea>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-end">
                    <h3>規格</h3>
                    <div class="col-11">
                        <div class="mb-2">
                            <label for="productBrief" class="form-label">商品簡述</label>
                            <textarea class="textAreaBreif form-control" name="productBrief" id="productBrief" required></textarea>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-end">
                    <h3>租賃資訊</h3>
                    <div class="col-11">
                        <div class="mb-2">
                            <label for="productPrice" class="form-label">租賃單價（每日）</label>
                            <input id="productPrice" class="form-control" type="number" name="productPrice" required>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3 mb-5">
                    <button type="submit" class="btn btn-primary" name="action" value="0">取消</button>
                    <button type="submit" class="btn btn-primary" name="action" value="1">儲存並下架</button>
                    <button type="submit" class="btn btn-primary" name="action" value="2">儲存並上架</button>
                </div>
            </div>
        </form>
    </div>

    <!-- 把共通的js叫入 -->
    <?php include("../js.php") ?>

    <script>
        // 顯示圖片的縮圖 有空再弄
        // const mainPic = document.querySelector("#mainPic");
        // const normalPic = document.querySelector("#normalPic");

        // mainPic.addEventListener("change", function(event) {
        //     let mainPicPre = document.querySelector("#mainPicPre");
        //     mainPicPre.innerHTML = "";

        //     let files = event.target.files;

        //     console.log(files);
        //     console.log(Array.from(files));
        // })
    </script>
</body>

</html>