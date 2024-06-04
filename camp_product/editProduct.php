<?php
require_once("../db_connect.php");

// 取得從商品列表傳來的product_id值
$product_id = $_GET["product_id"];

//抓取product資料表中的所有資料
$productsql = "SELECT product.*, product_category_relate.category_id, product_category.category_name FROM product 
JOIN product_category_relate ON product.product_id = product_category_relate.product_id 
JOIN product_category ON product_category_relate.category_id = product_category.category_id 
WHERE product.product_id='$product_id'";
$productResult = $conn->query($productsql);
$productRow = $productResult->fetch_assoc();

//選取指定商品的images 並且以mainPic倒序 因此mainPic=1會被排列在第一個
$mainPicSql = "SELECT product_id, product_mainPic, path FROM images 
WHERE product_id='$product_id' 
ORDER BY product_mainPic DESC";
$mainPicResult = $conn->query($mainPicSql);
$mainPicRow = $mainPicResult->fetch_all(MYSQLI_ASSOC);



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
    <title>edit product</title>
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
            height: 150px;
            resize: none;
        }

        .deleteImg {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            margin: -15px;

            & i {
                font-size: 15px;
            }
        }

        .addImg {
            & i {
                font-size: 50px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="my-5">編輯商品</h1>
        <form class="mb-5" action="./doEditProduct.php?product_id=<?= $product_id ?>" method="post" enctype="multipart/form-data">
            <div>
                <!-- 新增商品的表單區域 -->
                <div class="row justify-content-end mb-4">
                    <h3>基本資訊</h3>
                    <div class="col-11">
                        <div class="mb-3">
                            <label for="mainPic" class="h6 form-label">商品主要行銷圖片</label>
                            <!-- 輸入新檔案 -->
                            <input id="mainPic" name="mainPic" class="form-control" type="file" accept=".jpg,.jpeg,.png,.avif,.webp">
                            <div class="form-text">若要更改行銷圖片，請上傳要更新的圖片（單張）</div>
                        </div>

                        <div class="mb-3">
                            <label for="normalPic" class="h6 form-label">商品圖片</label>
                            <!-- 輸入新檔案 -->
                            <input id="normalPic" name="normalPic[]" class="form-control" type="file" accept=".jpg,.jpeg,.png,.avif,.webp" multiple>
                            <div class="form-text">若要更改商品圖片，請上傳要更新的圖片（最多9張）</div>
                        </div>

                        <div class="mb-3">
                            <label for="productName" class="h6 form-label">商品名稱</label>
                            <input id="productName" name="productName" class="form-control" type="text" value="<?= $productRow["product_name"] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="productCate" class="h6 form-label">商品分類</label>
                            <select class="form-control" name="productCate" id="productCate">
                                <option value="" selected disabled hidden><?= $productRow["category_name"] ?></option>
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
                            <textarea id="productDes" name="productDes" class="textAreaDis form-control"><?= $productRow["product_description"] ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-end mb-4">
                    <h3>重點規格</h3>
                    <div class="col-11">
                        <div class="mb-3">
                            <label for="productBrief" class="h6 form-label">規格簡述</label>
                            <textarea class="textAreaBreif form-control" name="productBrief" id="productBrief"><?= $productRow["product_brief"] ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-end mb-4">
                    <h3>租賃資訊</h3>
                    <div class="col-11">
                        <div class="mb-3">
                            <label for="productPrice" class="h6 form-label">租賃單價（每日）</label>
                            <input id="productPrice" class="form-control" type="number" name="productPrice" value="<?= $productRow["product_price"] ?>">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3">
                    <a href="./camp_productList.php" class="btn btn-primary">取消</a>
                    <button type="submit" class="btn btn-primary" name="action" value="1">儲存編輯</button>
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