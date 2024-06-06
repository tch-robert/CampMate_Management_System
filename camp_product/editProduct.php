<?php
require_once("../db_connect.php");

// 取得從商品列表傳來的product_id值
$product_id = $_GET["product_id"];

$styleSql = "SELECT * FROM product_style WHERE product_id='$product_id'";
$styleResult = $conn->query($styleSql);
$styleRows = $styleResult->fetch_all(MYSQLI_ASSOC);

// print_r($styleRows);

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
        /* 商品列表頁面css */
        .textAreaDis {
            height: 300px;
            resize: none;
        }

        .textAreaBreif {
            height: 180px;
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
    <?php include("../index.php") ?>

    <main class="main-content row justify-content-center">
        <div class="col-lg-9">
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">新增分類</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="./doAddCategory.php?product_id=<?= $product_id ?>" method="post">
                            <div class="modal-body">
                                <div class="input-group mb-3">
                                    <select class="form-select" name="parent_name" id="" required>
                                        <option value="" selected disabled>選擇要新增到哪個類別中</option>
                                        <?php foreach ($L1Rows as $level1) : ?>
                                            <option value="<?= $level1['category_name'] ?>">
                                                <?= $level1['category_name'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="input-group">
                                    <div class="input-group-text" for="">分類名稱</div>
                                    <input class="form-control" type="text" name="category_name" placeholder="輸入分類名稱" required>
                                </div>


                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                                <button type="submit" class="btn btn-primary">確認新增</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="position-raletive">
                    <a class="btn btn-primary me-3 position-absolute left-0" href="./camp_productList.php"><i class="fa-solid fa-caret-left"></i> 商品列表</a>
                    <h1 class="my-5 text-center">編輯商品</h1>
                </div>
                <form class="mb-5" action="./doEditProduct.php?product_id=<?= $product_id ?>" method="post" enctype="multipart/form-data">
                    <div>
                        <!-- 新增商品的表單區域 -->
                        <div class="row justify-content-center mb-4 shadow rounded p-3 bg-light">
                            <h3 class="mb-3">基本資訊</h3>
                            <hr>
                            <div class="col-11">
                                <div class="mb-4">
                                    <label for="mainPic" class="minTitle h5 form-label">商品主要行銷圖片</label>
                                    <div class="row">
                                        <div class="col-2 position-relative border rounded mb-3 mt-2 p-0">
                                            <div class="ratio ratio-1x1">
                                                <img class="object-fit-contain" src="./product_image/<?= $mainPicRow[0]["path"] ?>" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- 輸入新檔案 -->
                                    <input id="mainPic" name="mainPic" class="form-control" type="file" accept=".jpg,.jpeg,.png,.avif,.webp">
                                    <div class="form-text">若要更改行銷圖片，請上傳要新的圖片替代（單張）</div>
                                </div>

                                <div class="mb-4">
                                    <label for="normalPic" class="minTitle h5 form-label">商品圖片</label>
                                    <div class="row gap-3">
                                        <!-- 其餘圖片的顯示 -->
                                        <?php if (count($mainPicRow) == 0) : ?>
                                        <?php else : ?>
                                            <?php for ($i = 1; $i < count($mainPicRow); $i++) : ?>
                                                <div class="col-2 position-relative border rounded mb-3 mt-2 p-0">
                                                    <div class="ratio ratio-1x1">
                                                        <img class="object-fit-contain" src="./product_image/<?= $mainPicRow[$i]["path"] ?>" alt="">
                                                    </div>
                                                </div>
                                            <?php endfor; ?>
                                        <?php endif; ?>
                                    </div>
                                    <!-- 輸入新檔案 -->
                                    <input id="normalPic" name="normalPic[]" class="form-control" type="file" accept=".jpg,.jpeg,.png,.avif,.webp" multiple max="2">
                                    <div class="form-text">若要更改商品圖片，請上傳要新的圖片替代</div>
                                </div>

                                <div class="mb-4">
                                    <label for="productName" class="minTitle h5 form-label">商品名稱</label>
                                    <input id="productName" name="productName" class="form-control" type="text" value="<?= $productRow["product_name"] ?>">
                                </div>
                                <div class="mb-4">
                                    <div class="d-flex gap-2">
                                        <label for="productCate" class="minTitle h5 form-label">商品分類</label>
                                        <a class="cateBtn btn btn-primary align-self-center mb-2" style="--bs-btn-padding-y: .1rem; --bs-btn-padding-x: .3rem; --bs-btn-font-size: .75rem;" href="">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                            管理
                                        </a>
                                    </div>
                                    <div class="input-group">
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
                                        <button type="button" class="btn btn-outline-primary input-group-" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            <i class="fa-solid fa-circle-plus"></i>
                                            新增分類
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="minTitle h5" for="">商品款式</label>
                                    <div id="stylesContainer">
                                        <?php foreach ($styleRows as $style) : ?>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" name="productStyles[]" placeholder="<?= $style["style_name"] ?>" value="<?= $style["style_name"] ?>">
                                                <button class="input-group-append btn btn-outline-primary deleteInput" type="button">刪除</button>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <div>
                                        <button class="btn btn-outline-primary add-style-btn" type="button"><i class="fa-solid fa-plus"></i> 新增款式</button>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="productDes" class="minTitle h5 form-label">商品描述</label>
                                    <textarea id="productDes" name="productDes" class="textAreaDis form-control"><?= $productRow["product_description"] ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center mb-4 shadow rounded p-3 bg-light">
                            <h3 class="mb-3">詳細規格</h3>
                            <hr>
                            <div class="col-11">
                                <div class="mb-4">
                                    <label for="productBrief" class="minTitle h5 form-label">規格</label>
                                    <textarea class="textAreaBreif form-control" name="productSpec" id="productSpec"><?= $productRow["product_specifications"] ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center mb-4 shadow rounded p-3 bg-light">
                            <h3 class="mb-3">租賃資訊</h3>
                            <hr>
                            <div class="col-11">
                                <div class="mb-4">
                                    <label for="productPrice" class="minTitle h5 form-label">租賃單價（每日）</label>
                                    <input id="productPrice" class="form-control" type="number" name="productPrice" value="<?= $productRow["product_price"] ?>">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <a href="./camp_productList.php" class="btn btn-danger">取消</a>
                            <button type="submit" class="btn btn-primary" name="action" value="1">儲存編輯</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- 這裡將顯示動態加載的內容 -->
    </main>

    <script>
        $(document).ready(function() {
            $(document).on('click', '.add-style-btn', function() {
                var newStyleInput = `
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="productStyles[]" placeholder="新增款式名">
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