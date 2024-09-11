<?php
require_once("../db_connect.php");


//取得從商品列表傳來的product_id值
$product_id = $_GET["product_id"];


//依據product_id 指定我們要搜尋的商品款式
$styleSql = "SELECT * FROM product_style WHERE product_id='$product_id'";
$styleResult = $conn->query($styleSql);
$styleRows = $styleResult->fetch_all(MYSQLI_ASSOC);


//抓取product資料表中的所有資料
//並且join product_category_relate & product_category_class 兩個表單
//為了取得product_category_relate中 與product_id對應的category_id
//依據caategory_id 去取得product_category中 對應的category_name
//依據前一行取得的category_id 去取得product_category_class中 對應的parent_id
//依據前一行取得的parent_id 去取得product_category中 對應的category_name
//由於我們的product_category被引用了兩次 所以在第二次引用的時候 建議給他一個別名 這邊給他parent_category作為別名 **同時記得SELECT的選取也要修改成別名**
$productsql = "SELECT product.*, 
product_category_relate.category_id, 
product_category.category_name,
product_category_class.parent_id, 
parent_category.category_name AS parent_name
FROM product 
JOIN product_category_relate ON product.product_id = product_category_relate.product_id 
JOIN product_category ON product_category_relate.category_id = product_category.category_id 
JOIN product_category_class ON product_category_relate.category_id = product_category_class.category_id 
LEFT JOIN product_category AS parent_category ON product_category_class.parent_id = parent_category.category_id 
WHERE product.product_id='$product_id'
";
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
ORDER BY product_category.category_id ASC
";
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
    <?php include("../index.php") ?>

    <main class="main-content row justify-content-center">
        <div class="col-lg-9">


            <div class="container">
                <div class="position-raletive my-4">
                    <a class="btn btn-primary me-3 position-absolute left-0" href="./camp_productList.php"><i class="fa-solid fa-caret-left"></i> 商品列表</a>
                    <h1 class="text-center">商品資訊</h1>
                </div>
                <form class="mb-5" action="./doEditProduct.php?product_id=<?= $product_id ?>" method="post" enctype="multipart/form-data">
                    <div>
                        <!-- 新增商品的表單區域 -->
                        <div class="row justify-content-center mb-4 shadow rounded p-3 bg-light">
                            <div class="d-flex justify-content-between align-items-center my-3">
                                <h3 class="m-0">基本資訊</h3>
                                <a href="./editProduct.php?product_id=<?= $product_id ?>" class="btn btn-primary btn-lg align-self-center">
                                    <i class="fa-solid fa-file-pen"></i>
                                    編輯
                                </a>
                            </div>
                            <hr>
                            <div class="col-11">
                                <div class="mb-5">
                                    <label for="mainPic" class="minTitle h5 form-label">商品主要行銷圖片</label>
                                    <div class="row">
                                        <div class="col-2 position-relative border rounded mb-3 mt-2 bg-white p-0">
                                            <div class="ratio ratio-1x1">
                                                <img class="object-fit-contain" src="./product_image/<?= $mainPicRow[0]["path"] ?>" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-5">
                                    <label for="normalPic" class="minTitle h5 form-label">商品圖片</label>

                                    <!-- 其餘圖片的顯示 -->
                                    <?php if (count($mainPicRow) == 1) : ?>
                                        <div class="fs-5 border rounded p-2">
                                            此商品無商品圖片。
                                        </div>
                                    <?php else : ?>
                                        <div class="row gap-3">
                                            <?php for ($i = 1; $i < count($mainPicRow); $i++) : ?>
                                                <div class="col-2 position-relative border rounded mb-3 mt-2 bg-white p-0">
                                                    <div class="ratio ratio-1x1">
                                                        <img class="object-fit-contain" src="./product_image/<?= $mainPicRow[$i]["path"] ?>" alt="">
                                                    </div>
                                                </div>
                                            <?php endfor; ?>
                                        </div>
                                    <?php endif; ?>

                                </div>

                                <div class="mb-5">
                                    <label for="productName" class="minTitle h5 form-label">商品名稱</label>
                                    <div class="fs-5 border rounded p-2">
                                        <?= $productRow["product_name"] ?>
                                    </div>
                                </div>
                                <div class="mb-5">
                                    <label for="productPrice" class="minTitle h5 form-label">租賃單價（每日）</label>
                                    <div class="fs-5 border rounded p-2">
                                        NT. <?= $productRow["product_price"] ?>
                                    </div>
                                </div>
                                <div class="mb-5">
                                    <div class="d-flex gap-2 mb-2">
                                        <label for="productCate" class="minTitle h5 form-label">商品分類</label>
                                        <button type="button" class="d-none cateBtn btn btn-primary align-self-center mb-2" style="--bs-btn-padding-y: .1rem; --bs-btn-padding-x: .3rem; --bs-btn-font-size: .75rem;" data-bs-toggle="modal" data-bs-target="#manageCateModal">
                                            <i class="d-none fa-regular fa-pen-to-square"></i>
                                            管理
                                        </button>
                                    </div>
                                    <div class=" border rounded p-3">
                                        <div class="fs-5">
                                            <span class="border rounded p-2">
                                                <?= $productRow["parent_name"] ?>
                                            </span>
                                            <i class="fa-solid fa-angles-right"></i>
                                            <?= $productRow["category_name"] ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-5">
                                    <label class="minTitle h5" for="">商品款式</label>
                                    <div id="stylesContainer">
                                        <?php
                                        if (count($styleRows) == 0) : ?>
                                            <div class="fs-5 border rounded p-2">
                                                此商品沒有區分款式
                                            </div>
                                        <?php else : ?>
                                            <?php
                                            $styleNum = 1;
                                            foreach ($styleRows as $style) :
                                            ?>
                                                <div class="fs-5 border rounded p-2">
                                                    <?= $styleNum . ". " . $style["style_name"] ?>
                                                </div>
                                            <?php $styleNum++;
                                            endforeach; ?>

                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="mb-5">
                                    <label for="productDes" class="minTitle h5 form-label">商品描述＆規格</label>
                                    <?php
                                    $description_with_breaks = nl2br($productRow["product_description"]);
                                    $specifications_with_breaks = nl2br($productRow["product_specifications"]);
                                    ?>
                                    <div class="fs-5 border rounded p-3">
                                        <span class="border rounded p-1">商品描述- </span><br>
                                        <?= $description_with_breaks ?>
                                        <hr>
                                        <span class="border rounded p-1">規格- </span><br>
                                        <?= $specifications_with_breaks ?>
                                    </div>
                                </div>
                            </div>
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