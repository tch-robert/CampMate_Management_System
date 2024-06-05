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
        :root {
            --primary-color: #e3dcd3;
            --secondary-color: #9ba45c;
            --shadow-color: #9a968f;
            --highlight-color: #ffffff;
            --font-color: #2d2d2d;
            --input-padding: 10px;
            --border-radius: 36px;
            --aside-width: 250px;
            --header-height: 186px;
        }

        body {
            font-family: "Montserrat", "Noto Sans TC";
            background: var(--primary-color);
            color: var(--font-color);
        }

        .main-header {
            width: var(--aside-width);
            background: var(--secondary-color);

            .logo,
            .text {
                margin-left: 30px;
                margin-right: 30px;
                margin-top: 20px;
                border-radius: 24px;
            }

            .logo {
                padding: 30px 20px;
                background: #9ba45c;
                box-shadow: 6px 6px 10px #798048,
                    -6px -6px 10px #bdc870;

                &:hover {
                    box-shadow: inset 6px 6px 10px #798048,
                        inset -6px -6px 10px #bdc870;
                }
            }

            .text {
                margin-bottom: 20px;
                text-align: center;
                padding: 9px;
                font-size: 14px;
                color: var(--primary-color);
                background: #9ba45c;
                box-shadow: inset 6px 6px 10px #798048,
                    inset -6px -6px 10px #bdc870;
            }
        }

        .aside-left {
            padding: var(--header-height) 20px 0 20px;
            width: var(--aside-width);
            top: 0;
            overflow: auto;
            background: var(--secondary-color);

            li {
                margin-bottom: 18px;

                a {
                    transition: 0.3s ease;
                    color: #fff;
                    letter-spacing: 1px;

                    &:hover {
                        transform: translate(-3px, -3px);

                        i {
                            color: #9ba45c;
                            background: linear-gradient(145deg, #ffefda, #d7c9b8);
                            box-shadow: 2px 2px 8px #baae9f,
                                -2px -2px 8px #fffff9;
                        }
                    }
                }

                i {
                    width: 48px;
                    height: 48px;
                    text-align: center;
                    transition: 0.3s ease;
                    padding: 15px;
                    margin-right: 10px;
                    border-radius: 16px;
                    background: linear-gradient(145deg, #a6af62, #8c9453);
                    box-shadow: 6px 6px 12px #848b4e,
                        -6px -6px 12px #b2bd6a;
                }

                span {
                    font-size: 12px;
                }

                .line {
                    margin: 0 16px;
                    border: none;
                    height: 1px;
                    background: var(--primary-color);
                }
            }
        }

        .main-content {
            margin-left: var(--aside-width);
            margin-top: 20px;
        }

        .aside-a-active {
            transform: translate(-3px, -3px);
        }

        .aside-i-active {
            color: #9ba45c;
            background: linear-gradient(145deg, #ffefda, #d7c9b8) !important;
            box-shadow: 2px 2px 8px #baae9f,
                -2px -2px 8px #fffff9 !important;
        }

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
    <header class="main-header d-flex flex-column fixed-top justify-content-center">
        <a href="http://localhost/campmate/index.php" class="text-decoration-none logo">
            <img src="/campmate/images/logo.svg" alt="">
        </a>
        <div class="text">
            Hi, Admin
        </div>
    </header>
    <aside class="aside-left position-fixed vh-100">
        <ul class="list-unstyled mt-3">
            <li>
                <a class="d-block px-3 text-decoration-none" href="" data-id="link1">
                    <i class="fa-solid fa-user"></i> <span>一般會員</span>
                </a>
            </li>
            <li>

                <a class="d-block px-3 text-decoration-none" href="/campmate/campground_owner/owners.php">

                    <i class="fa-solid fa-user-tie"></i> <span>營地主系統</span>
                </a>
            </li>
            <li>
                <a class="d-block px-3 text-decoration-none" href="" data-id="link3">
                    <i class="fa-solid fa-campground"></i> <span>營地訂位管理</span>
                </a>
            </li>
            <li>
                <a class="d-block px-3 text-decoration-none" href="http://localhost/campmate/camp_product/camp_productList.php" data-id="link4">
                    <i class="fa-solid fa-person-hiking"></i> <span>露營用品租用管理</span>
                </a>
            </li>
            <li>
                <a class="d-block px-3 text-decoration-none" href="" data-id="link5">
                    <i class="fa-solid fa-people-roof"></i> <span>揪團系統</span>
                </a>
            </li>
            <li>
                <a class="d-block px-3 text-decoration-none" href="http://localhost/campmate/coupons/coupons-list.php" data-id="link6">
                    <i class="fa-solid fa-ticket"></i> <span>優惠券</span>
                </a>
            </li>
            <li>
                <a class="d-block px-3 text-decoration-none" href="/campmate/customer_service/tickets.php">

                    <i class="fa-solid fa-headset"></i> <span>客服</span>
                </a>
            </li>
            <li>
                <div class="line"></div>
            </li>
            <li>
                <a class="d-block px-3 text-decoration-none" href="" data-id="link8">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> <span>登出</span>
                </a>
            </li>
        </ul>
    </aside>
    <main class="main-content">
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
            <h1 class="my-5">編輯商品</h1>
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
                                    <div class="col-2 position-relative border rounded mb-3 mt-2">
                                        <div class="ratio ratio-1x1">
                                            <img src="./product_image/<?= $mainPicRow[0]["path"] ?>" alt="">
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
                                            <div class="col-2 position-relative border rounded mb-3 mt-2">
                                                <div class="ratio ratio-1x1">
                                                    <img src="./product_image/<?= $mainPicRow[$i]["path"] ?>" alt="">
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
                                <label for="productCate" class="minTitle h5 form-label">商品分類</label>
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

        <!-- 這裡將顯示動態加載的內容 -->
    </main>
    <!-- js -->
    <?php include("../js.php") ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // 檢查當前URL是否是首頁URL
            if (window.location.href === "http://localhost/campmate/index.php") {
                localStorage.removeItem("activeLinkId");
            }

            // 恢復上次點擊的active狀態
            var activeLinkId = localStorage.getItem("activeLinkId");
            if (activeLinkId) {
                var activeLink = document.querySelector(`a[data-id="${activeLinkId}"]`);
                if (activeLink) {
                    activeLink.classList.add("aside-a-active");
                    activeLink.querySelector("i").classList.add("aside-i-active");
                }
            }

            var listItems = document.querySelectorAll(".aside-left li");

            listItems.forEach(function(li) {
                li.addEventListener("click", function(event) {
                    // 移除所有鏈接和圖標的.active樣式
                    listItems.forEach(function(item) {
                        var link = item.querySelector("a");
                        var icon = item.querySelector("i");
                        if (link) {
                            link.classList.remove("aside-a-active");
                        }
                        if (icon) {
                            icon.classList.remove("aside-i-active");
                        }
                    });

                    // 為被點擊的鏈接和圖標添加.active樣式
                    var clickedLink = event.currentTarget.querySelector("a");
                    var clickedIcon = event.currentTarget.querySelector("i");
                    if (clickedLink) {
                        clickedLink.classList.add("aside-a-active");
                        clickedIcon.classList.add("aside-i-active");
                        // 保存active狀態到localStorage
                        localStorage.setItem("activeLinkId", clickedLink.getAttribute("data-id"));
                    }
                });
            });
        });

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