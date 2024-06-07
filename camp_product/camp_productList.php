<?php
require_once("../db_connect.php");
$eachPageCount = 12;
if (!isset($_GET["page"])) {
    $page = 1;
    $start = ($page - 1) * $eachPageCount;
} else {
    $page = $_GET["page"];
    $start = ($page - 1) * $eachPageCount;
}
// echo $page, $start, $eachPageCount;

// 抓取相同的$_GET value避免頁面的檢視方式或者上下架區塊跑掉
$sameUrl = "";
if (isset($_GET["viewMode"]) || isset($_GET["statusPage"]) || isset($_GET["search"]) && !isset($_GET["page"])) {
    $sameUrl = $sameUrl . "?";
} else if (isset($_GET["viewMode"]) || isset($_GET["statusPage"]) || isset($_GET["search"]) && isset($_GET["page"])) {
    $sameUrl = $sameUrl . "&";
}
if (isset($_GET["viewMode"])) {
    $sameUrl = $sameUrl . "viewMode=" . $_GET["viewMode"];
}
if (isset($_GET["statusPage"])) {
    $sameUrl = $sameUrl . "&statusPage=" . $_GET["statusPage"];
}
if (isset($_GET["search"])) {
    $sameUrl = $sameUrl . "&search=" . urlencode($_GET["search"]);
}


//確認有沒有收到viewMode的參數 沒有就賦予 有就抓下來
if (!isset($_GET["viewMode"])) {
    $viewMode = 1;
} else {
    $viewMode = $_GET["viewMode"];
}

//確認有沒有收到statusPage的參數 沒有就賦予 有就抓下來
if (!isset($_GET["statusPage"])) {
    $status_page_id = 2;
} else {
    $status_page_id = $_GET["statusPage"];
}


if (isset($_GET["search"])) {
    $search = $_GET["search"];
    $AllSql = "SELECT * FROM product WHERE product_name Like '%$search%' AND product_valid=1";
    if (isset($_GET["filter"])) {
        $filter = $_GET["filter"];

        switch ($filter) {
            case 1:
                $sql = "SELECT * FROM product WHERE product_name Like '%$search%' AND product_valid=1  
                ORDER BY product_price ASC 
                LIMIT $start,$eachPageCount";
                break;
            case 2:
                $sql = "SELECT * FROM product WHERE product_name Like '%$search%' AND product_valid=1  
                ORDER BY product_price DESC 
                LIMIT $start,$eachPageCount";
                break;
        }
    } else {
        $sql = "SELECT * FROM product WHERE product_name Like '%$search%' AND product_valid=1 LIMIT $start,$eachPageCount";
    }
} else if (isset($_GET["statusPage"])) {
    //依據status page篩選不同的內容
    switch ($status_page_id) {
        case 0:
            $AllSql = "SELECT * FROM product WHERE product_valid=1 AND product_status=0 ORDER BY product_status DESC, create_date DESC";
            if (isset($_GET["filter"])) {
                $filter = $_GET["filter"];

                switch ($filter) {
                    case 1:
                        $sql = "SELECT * FROM product WHERE product_status=0 AND product_valid=1 ORDER BY product_price ASC 
                        LIMIT $start,$eachPageCount";
                        echo "hi";
                        break;
                    case 2:
                        $sql = "SELECT * FROM product WHERE product_status=0 AND product_valid=1 ORDER BY product_price DESC 
                        LIMIT $start,$eachPageCount";
                        break;
                }
                break;
            } else {
                $sql = "SELECT * FROM product WHERE product_status=0 AND product_valid=1 ORDER BY create_date DESC 
                LIMIT $start,$eachPageCount";
            }

            break;
        case 1:
            $AllSql = "SELECT * FROM product WHERE product_valid=1 AND product_status=1 ORDER BY product_status DESC, create_date DESC";
            if (isset($_GET["filter"])) {
                $filter = $_GET["filter"];

                switch ($filter) {
                    case 1:
                        $sql = "SELECT * FROM product WHERE product_status=1 AND product_valid=1 ORDER BY product_price ASC 
                        LIMIT $start,$eachPageCount";
                        break;
                    case 2:
                        $sql = "SELECT * FROM product WHERE product_status=1 AND product_valid=1 ORDER BY product_price DESC 
                        LIMIT $start,$eachPageCount";
                        break;
                }
                break;
            } else {
                $sql = "SELECT * FROM product WHERE product_status=1 AND product_valid=1 ORDER BY create_date DESC 
                LIMIT $start,$eachPageCount";
            }

            break;
        case 2:
            //抓取product資料表的資料 限制在valid是1列
            $AllSql = "SELECT * FROM product WHERE product_valid=1 ORDER BY product_status DESC, create_date DESC";
            if (isset($_GET["filter"])) {
                $filter = $_GET["filter"];

                switch ($filter) {
                    case 1:
                        $sql = "SELECT * FROM product WHERE product_valid=1 ORDER BY  product_price ASC 
                        LIMIT $start,$eachPageCount";
                        break;
                    case 2:
                        $sql = "SELECT * FROM product WHERE product_valid=1 ORDER BY  product_price DESC 
                        LIMIT $start,$eachPageCount";
                        break;
                }
                break;
            } else {
                $sql = "SELECT * FROM product WHERE product_valid=1 ORDER BY product_status DESC, create_date DESC 
                LIMIT $start,$eachPageCount";
            }

            break;
    }
} else {
    $AllSql = "SELECT * FROM product WHERE product_valid=1 ORDER BY product_status DESC, create_date DESC";
    if (isset($_GET["filter"])) {
        $filter = $_GET["filter"];

        switch ($filter) {
            case 1:
                $sql = "SELECT * FROM product WHERE product_valid=1 ORDER BY product_status DESC, create_date DESC 
                ORDER BY product_price ASC 
                LIMIT $start,$eachPageCount";
                break;
            case 2:
                $sql = "SELECT * FROM product WHERE product_valid=1 ORDER BY product_status DESC, create_date DESC 
                ORDER BY product_price DESC 
                LIMIT $start,$eachPageCount";
                break;
        }
    } else {
        $sql = "SELECT * FROM product WHERE product_valid=1 ORDER BY product_status DESC, create_date DESC
        LIMIT $start,$eachPageCount";
    }
}
$allResult = $conn->query($AllSql);
$allRows = $allResult->fetch_all(MYSQLI_ASSOC);
$countRows = count($allRows);
$pageNum = ceil($countRows / $eachPageCount);
$lastPageNum = $countRows % $eachPageCount;

$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);






//抓取iamges資料表的特定資料 限制在mainPic為1的列
$sqlImg = "SELECT id,product_id,product_mainPic,path FROM images WHERE product_mainPic=1";
$resultImg = $conn->query($sqlImg);
$imgRows = $resultImg->fetch_all(MYSQLI_ASSOC);


//將images內的path 塞進product抓下來的關聯式陣列
$pathArr = [];
foreach ($imgRows as $images) {
    $pathArr[$images["product_id"]] = $images["path"];
}
for ($i = 0; $i < count($rows); $i++) {
    $rows[$i]["mainImg_path"] = $pathArr[$rows[$i]["product_id"]];
}

//抓取product_status的資料
$sqlSta = "SELECT * FROM product_status";
$resultSta = $conn->query($sqlSta);
$staRows = $resultSta->fetch_all(MYSQLI_ASSOC);

//將product_status的p_status_name 塞入product的關聯式陣列
$staArr = [];
foreach ($staRows as $status) {
    $staArr[$status["p_status_id"]] = $status["p_status_name"];
}
for ($i = 0; $i < count($rows); $i++) {
    $rows[$i]["p_status_name"] = $staArr[$rows[$i]["product_status"]];
}
?>


<!doctype html>
<html lang="en">

<head>
    <title>camp_productList</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- 把共通的css叫入 -->
    <?php include("../css_neumorphic.php") ?>
    <?php include("../index_modular/index_css.php") ?>

    <style>
        /* 商品列表頁面css */
        .nav-tabs .nav-link {
            opacity: 60%;
            color: var(--font-color);
        }

        /* 自訂active標籤的背景顏色 */
        .nav-tabs .nav-link.active {
            opacity: 100%;
            color: var(--font-color);
        }

        .addP {
            height: 40px;
        }

        .imgBox {
            width: 120px;
            height: 120px;
        }

        .product_status {
            font-size: 12px;
            /* background: #DBDBDB; */
            border-radius: 10%;
        }

        .productImg {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .infoBox {
            max-width: 600px;
        }

        .productInfo {
            height: 120px;
        }

        .productBox {
            height: 100%;
        }

        .caretIcon {
            & a {
                height: 10px;
            }

            & i {
                /* height: 10px; */
                /* line-height: 10px; */
                font-size: 20px;
            }

            & div {

                height: 10px;
            }
        }

        .imgTable {
            width: 130px;
        }
    </style>
</head>

<body>
    <?php include("../index_modular/index_header_aside.php") ?>
    <main class="main-content row justify-content-center">
        <div class="col-lg-10">
            <!-- 頁面大標題＆新增商品 -->
            <div class="d-flex justify-content-between align-items-center my-4">
                <h1 class="">我的商品</h1>
                <a href="./addProduct.php" class="addP btn btn-primary shadow">
                    <i class="fa-solid fa-plus"></i> 新增商品
                </a>
            </div>

            <!-- 商品狀態標籤列 -->
            <nav>
                <ul class="nav nav-tabs">
                    <?php if (isset($_GET["viewMode"])) {
                        switch ($viewMode) {
                            case 1:
                                $viewNum = "viewMode=1";
                                break;
                            case 2:
                                $viewNum = "viewMode=2";
                                break;
                        }
                    } else {
                        $viewNum = "viewMode=1";
                    } ?>
                    <li class="nav-item px-1 m-0">
                        <a class="bg-light nav-link 
                    <?php if (!isset($_GET["statusPage"]) || $_GET["statusPage"] == 2) echo "active" ?>
                    " href="./camp_productList.php?statusPage=2&<?= $viewNum ?>">所有商品</a>
                    </li>

                    <!-- 用for迴圈讓status可以倒序地跑出來 -->
                    <?php for ($i = count($staRows) - 1; $i >= 0; $i--) : ?>
                        <li class="nav-item px-1 m-0">
                            <a class="bg-light nav-link 
                        <?php if (isset($_GET["statusPage"]) && $_GET["statusPage"] == $staRows[$i]["p_status_id"]) echo "active"; ?>
                        " href="./camp_productList.php?statusPage=<?= $staRows[$i]["p_status_id"] ?>&<?= $viewNum ?>">
                                <?= $staRows[$i]["p_status_name"] ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>

            <div class="bg-light border border-top-0 rounded-bottom p-4 pb-5 m-0">
                <!-- 搜尋功能 -->
                <div class="row justify-content-end">
                    <div class="col-4">
                        <form action="">
                            <div class="d-flex mb-3 input-group">
                                <input class="form-control" type="text" placeholder="搜尋商品" name="search">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- 商品數量＆檢視方式 -->
                <div class="d-flex justify-content-between mb-3">
                    <h4>
                        <?php if (isset($_GET["search"]) && !empty($search)) echo "<span class=\"fs-3\">$search</span> 的搜尋結果，" ?>
                        總共 <?= $countRows ?> 件商品
                        <span class="fs-5">
                            <?php if ($countRows > $eachPageCount) echo ", 此頁顯示" . count($rows) . "件"; ?>
                        </span>
                    </h4>

                    <?php
                    $statusNum = isset($_GET["statusPage"]) ? "&statusPage=" . $status_page_id : "&statusPage=2";

                    $searchQuery = isset($_GET["search"]) ? "&search=" . urlencode($_GET["search"]) : "";

                    $viewModeNum = isset($_GET["viewMode"]) ? "&viewMode=" . $viewMode : "&viewMode=1";

                    $pageQuery = isset($_GET["page"]) ? "&page=" . $page : "&page=1";

                    $filterQuery = isset($_GET["filter"]) ? "&filter=" . $filter : "";

                    if (isset($_GET["search"])) {
                        $filterUrl = $viewModeNum . $searchQuery;
                    } else {
                        $filterUrl = $statusNum . $viewModeNum;
                    }
                    ?>

                    <div class="d-flex">
                        <div class="dropdown me-3">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-sort"></i>
                                排序
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="./camp_productList.php?filter=1<?= $filterUrl ?>
                                    ">
                                        <i class="fa-solid fa-angles-up"></i> 價格
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="./camp_productList.php?filter=2<?= $filterUrl ?>">
                                        <i class="fa-solid fa-angles-down"></i> 價格
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="btn-group">
                            <a href="./camp_productList.php?viewMode=1<?= $statusNum . $pageQuery . $searchQuery . $filterQuery ?>" class="btn btn-outline-primary <?php if ($viewMode == 1) echo "active" ?>">
                                <i class="fa-solid fa-bars"></i>
                            </a>

                            <a href="./camp_productList.php?viewMode=2<?= $statusNum . $pageQuery . $searchQuery . $filterQuery ?>" class="btn btn-outline-primary <?php if ($viewMode == 2) echo "active" ?>">
                                <i class=" fa-solid fa-grip"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 商品列表 表單區域 -->

                <!-- 商品列表-表單檢視方式 -->
                <?php if ($viewMode == 1) : ?>
                    <!-- 列表表頭 -->
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>圖片</th>
                                <th>商品資訊</th>
                                <th>已租出（數量）</th>
                                <th>租賃單價</th>
                                <th>操作</th>
                            </tr>
                        </thead>

                        <tbody class="">
                            <!-- 商品列表的html -->
                            <?php foreach ($rows as $product) : ?>
                                <tr>
                                    <!-- 圖片 -->
                                    <td class="imgTable viewP" data-id="<?= $product["product_id"] ?>">
                                        <div class="imgBox ratio ratio-1x1">
                                            <img class="productImg" src="./product_image/<?= $product["mainImg_path"] ?>" alt="">
                                        </div>
                                    </td>

                                    <td class="infoBox px-3 viewP" data-id="<?= $product["product_id"] ?>">
                                        <div class="productInfo d-flex flex-column justify-content-between">
                                            <div>
                                                <!-- 商品狀態 -->
                                                <div class="d-flex mb-2">
                                                    <div class="product_status p-1 
                                                <?php if ($product["product_status"] == 0) {
                                                    echo "bg-info";
                                                } else {
                                                    echo "bg-warning";
                                                } ?>">
                                                        <?= $product["p_status_name"] ?>
                                                    </div>
                                                </div>

                                                <!-- 商品名稱 -->
                                                <div>
                                                    商品名稱：<?= $product["product_name"] ?>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-between">

                                                <!-- 商品被瀏覽次數 -->
                                                <div>
                                                    <i class="fa-regular fa-eye"></i>113
                                                </div>

                                                <!-- 商品被收藏次數 -->
                                                <div>
                                                    <i class="fa-regular fa-heart"></i>25
                                                </div>
                                            </div>
                                        </div>

                                    </td>

                                    <td class="px-3 viewP" data-id="<?= $product["product_id"] ?>">
                                        10
                                    </td>

                                    <td class="px-3 viewP" data-id="<?= $product["product_id"] ?>">
                                        <?= $product["product_price"] ?>
                                    </td>

                                    <!-- 商品編輯、上架or下架、刪除 -->
                                    <td>

                                        <div class="d-flex flex-column gap-2">
                                            <a href="./editProduct.php?product_id=<?= $product["product_id"] ?>" class="btn btn-primary">
                                                <i class="fa-solid fa-pen-to-square"></i> 編輯
                                            </a>

                                            <form action="./doChangeProductStatus.php<?= $sameUrl ?>" method="post">
                                                <input class="d-none" type="number" name="productId" value="<?= $product["product_id"] ?>">
                                                <?php if ($product["product_status"] == 0) : ?>
                                                    <input class="d-none" type="number" name="changeSta" value="1">
                                                    <button type="submit" class="btn btn-primary w-100">
                                                        <i class="fa-solid fa-arrow-up"></i> 上架
                                                    </button>
                                                <?php elseif ($product["product_status"] == 1) : ?>
                                                    <input class="d-none" type="number" name="changeSta" value="0">
                                                    <button type="submit" class="btn btn-primary w-100">
                                                        <i class="fa-solid fa-arrow-down"></i> 下架
                                                    </button>
                                                <?php endif; ?>
                                            </form>

                                            <form action="./doProductSoftDelete.php<?= $sameUrl ?>" method="post">
                                                <input class="d-none" type="number" name="productId" value="<?= $product["product_id"] ?>">
                                                <input class="d-none" type="number" name="softDelete" value="0">
                                                <button type="submit" class="btn btn-danger w-100">
                                                    <i class="fa-solid fa-trash"></i> 刪除
                                                </button>
                                            </form>
                                        </div>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php if (count($rows) == 0) echo "沒有符合的結果。" ?>
                    <!-- ------------------------------------------------------------------------------------- -->

                <?php elseif ($viewMode == 2) : ?>
                    <!-- 商品列表-圖磚檢視方式 -->
                    <div class="row">
                        <?php foreach ($rows as $product) : ?>
                            <div class="col-3 g-3">
                                <div class="bg-white p-3 shadow-sm productBox d-flex flex-column justify-content-between rounded">
                                    <!-- 圖片 -->
                                    <div class="flex-grow-1 viewP" data-id="<?= $product["product_id"] ?>">
                                        <div class="ratio ratio-1x1">
                                            <img class="productImg object-fit-contain" src="./product_image/<?= $product["mainImg_path"] ?>" alt="">
                                        </div>
                                        <!-- 商品狀態 -->
                                        <div class="d-flex my-2">
                                            <div class="product_status p-1 
                                <?php if ($product["product_status"] == 0) {
                                    echo "bg-body-secondary";
                                } else {
                                    echo "bg-warning";
                                } ?>
                                    ">
                                                <?= $product["p_status_name"] ?>
                                            </div>
                                        </div>

                                        <!-- 商品名稱 -->
                                        <div class="mb-3">
                                            商品名稱：<br>
                                            <?= $product["product_name"] ?>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-column justify-content-end ">
                                        <!-- 租賃價格 -->
                                        <div class="text-end mb-3 viewP" data-id="<?= $product["product_id"] ?>">
                                            <?= $product["product_price"] ?>
                                        </div>

                                        <div class="d-flex justify-content-between mb-3 viewP" data-id="<?= $product["product_id"] ?>">
                                            <!-- 商品被瀏覽次數 -->
                                            <div class="viewP" data-id="<?= $product["product_id"] ?>">
                                                <i class="fa-regular fa-eye"></i>113
                                            </div>
                                            <!-- 商品被收藏次數 -->
                                            <div class="viewP" data-id="<?= $product["product_id"] ?>">
                                                <i class="fa-regular fa-heart"></i>25
                                            </div>
                                        </div>


                                        <!-- 商品編輯、上架or下架、刪除 -->

                                        <div class="d-flex justify-content-between">
                                            <a href="./editProduct.php?product_id=<?= $product["product_id"] ?>" class="btn btn-outline-primary">
                                                <i class="fa-solid fa-pen-to-square"></i> 編輯
                                            </a>

                                            <form action="./doChangeProductStatus.php<?= $sameUrl ?>" method="post">
                                                <input class="d-none" type="number" name="productId" value="<?= $product["product_id"] ?>">
                                                <?php if ($product["product_status"] == 0) : ?>
                                                    <input class="d-none" type="number" name="changeSta" value="1">
                                                    <button type="submit" class="btn btn-outline-primary">
                                                        <i class="fa-solid fa-arrow-up"></i> 上架
                                                    </button>
                                                <?php elseif ($product["product_status"] == 1) : ?>
                                                    <input class="d-none" type="number" name="changeSta" value="0">
                                                    <button type="submit" class="btn btn-outline-primary">
                                                        <i class="fa-solid fa-arrow-down"></i> 下架
                                                    </button>
                                                <?php endif; ?>
                                            </form>

                                            <form action="./doProductSoftDelete.php<?= $sameUrl ?>" method="post">
                                                <input class="d-none" type="number" name="productId" value="<?= $product["product_id"] ?>">
                                                <input class="d-none" type="number" name="softDelete" value="0">
                                                <button type="submit" class="btn btn-outline-danger w-100">
                                                    <i class="fa-solid fa-trash"></i> 刪除
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <nav aria-label="Page navigation example">
                <ul class="pagination my-4">
                    <li class="page-item">
                        <a class="page-link" href="
                    <?= $page > 1 ? "./camp_productList.php?page=" . ($page - 1) . $statusNum . $viewModeNum  . $filterQuery . $searchQuery : '#' ?>
                    " aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php for ($i = 1; $i <= $pageNum; $i++) : ?>
                        <li class="page-item"><a class="page-link" href="./camp_productList.php?page=<?= $i . $statusNum . $viewModeNum  . $filterQuery . $searchQuery ?>">
                                <?= $i ?>
                            </a></li>
                    <?php endfor; ?>
                    <li class="page-item">
                        <a class="page-link" href="
                    <?= ($page < $pageNum) ? "./camp_productList.php?page=" . ($page + 1) . $statusNum . $viewModeNum  . $filterQuery . $searchQuery : '#' ?>
                    " aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <!-- 這裡將顯示動態加載的內容 -->
    </main>

    <!-- 把共通的js叫入 -->
    <?php include("../js.php") ?>

    <?php include("../index_modular/index_js.php") ?>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const viewP = document.querySelectorAll(".viewP");
            viewP.forEach(element => {
                element.addEventListener("click", function() {
                    const productId = this.getAttribute("data-id");
                    if (productId) {
                        window.location.href = "./product_detail.php?product_id=" + productId;
                    }
                });
            });
        })
    </script>

</body>

</html>