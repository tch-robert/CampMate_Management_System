<?php
require_once("../db_connect.php");

//選取商品類別level1階層選取
$L1Sql = "SELECT product_category.*, product_category_class.parent_id FROM product_category 
JOIN product_category_class ON product_category.category_id = product_category_class.category_id 
WHERE product_category_class.parent_id IS NULL 
ORDER BY product_category.category_id ASC";
$L1Result = $conn->query($L1Sql);
$L1Rows = $L1Result->fetch_all(MYSQLI_ASSOC);

//選取商品類別level2階層選取

$L2Sql = "SELECT product_category.*, product_category_class.parent_id FROM product_category 
JOIN product_category_class ON product_category.category_id = product_category_class.category_id 
WHERE product_category_class.parent_id IS NOT NULL 
ORDER BY product_category.category_id ASC";
$L2Result = $conn->query($L2Sql);
$L2Rows = $L2Result->fetch_all(MYSQLI_ASSOC);

// 將 L2Rows 依據 parent_id 分組
$L2Grouped = [];
foreach ($L2Rows as $row) {
    $parentId = $row['parent_id'];
    if (!isset($L2Grouped[$parentId])) {
        $L2Grouped[$parentId] = [];
    }
    $L2Grouped[$parentId][] = $row;
}

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

        <h1 class="my-5">新增商品</h1>
        <form class="mb-5" action="doAddProduct.php" method="post" enctype="multipart/form-data">
            <div>
                <!-- 新增商品的表單區域 -->
                <div class="row justify-content-end mb-4">
                    <h3>基本資訊</h3>
                    <div class="col-11">
                        <div class="mb-3">
                            <label for="mainPic" class="h6 form-label">商品主要行銷圖片</label>
                            <input id="mainPic" name="mainPic" class="form-control" type="file" accept=".jpg,.jpeg,.png,.avif,.webp" required>
                            <div id="mainPicPre"></div>
                        </div>
                        <div class="mb-3">
                            <label for="normalPic" class="h6 form-label">商品圖片</label>
                            <input id="normalPic" name="normalPic[]" class="form-control" type="file" accept=".jpg,.jpeg,.png,.avif,.webp" multiple>
                        </div>
                        <div class="mb-3">
                            <label for="productName" class="h6 form-label">商品名稱</label>
                            <input id="productName" name="productName" class="form-control" type="text" required>
                        </div>
                        <div class="mb-3">
                            <label for="productCate" class="h6 form-label">商品分類</label>
                            <select class="form-control" name="productCate" id="productCate" required>
                                <option value="" selected disabled hidden>請選擇分類</option>
                                <?php foreach ($L1Rows as $level1) : ?>
                                    <optgroup label="<?= $level1['category_name'] ?>">
                                        <?php
                                        $parentId = $level1['category_id'];
                                        if (isset($L2Grouped[$parentId])) {
                                            foreach ($L2Grouped[$parentId] as $level2) : ?>
                                                <option value="<?= $level2['category_name'] ?>">
                                                    <?= $level2['category_name'] ?>
                                                </option>
                                        <?php endforeach;
                                        } ?>
                                    </optgroup>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="h6" for="">商品款式</label>
                            <div id="stylesContainer">
                                <div class="form-text"></div>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="productStyles[]" placeholder="款式名">
                                    <button class="input-group-append btn btn-outline-primary deleteInput" type="button">刪除</button>
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-outline-primary add-style-btn" type="button">新增款式</button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="productDes" class="h6 form-label">商品描述</label>
                            <textarea id="productDes" name="productDes" class="textAreaDis form-control" required></textarea>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-end mb-4">
                    <h3>重點規格</h3>
                    <div class="col-11">
                        <div class="mb-2">
                            <label for="productBrief" class="h6 form-label">規格簡述</label>
                            <textarea class="textAreaBreif form-control" name="productBrief" id="productBrief" required></textarea>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-end mb-4">
                    <h3>租賃資訊</h3>
                    <div class="col-11">
                        <div class="">
                            <label for="productPrice" class="h6 form-label">租賃單價（每日）</label>
                            <input id="productPrice" class="form-control" type="number" name="productPrice" required>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3">
                    <a href="./camp_productList.php" class="btn btn-primary">取消</a>
                    <button type="submit" class="btn btn-primary" name="action" value="1">儲存並下架</button>
                    <button type="submit" class="btn btn-primary" name="action" value="2">儲存並上架</button>
                </div>
            </div>
        </form>
    </div>

    <!-- 把共通的js叫入 -->
    <?php include("../js.php") ?>

    <script>
        $(document).ready(function() {
            $(document).on('click', '.add-style-btn', function() {
                var newStyleInput = `
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="productStyles[]" placeholder="款式名">
                    <button class="input-group-append btn btn-outline-primary deleteInput" type="button">刪除</button>
                </div>`;
                $('#stylesContainer').append(newStyleInput);
            });

            $(document).on('click', '.deleteInput', function() {
                $(this).closest('.input-group').remove();
            });
        });
    </script>

</body>

</html>