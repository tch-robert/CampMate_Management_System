<?php
require_once("../db_connect.php");

// 上架下架 更改資料庫的product_status
if (isset($_POST["productId"]) && isset($_POST["changeSta"])) {
    $productId = $_POST["productId"];
    $changeSta = $_POST["changeSta"];
    $changeStaSql = "UPDATE product SET product_status='$changeSta' WHERE product_id=$productId";
    if ($conn->query($changeStaSql) === TRUE) {
    } else {
        echo "更新錯誤" . $conn->error;
    }
    $sameUrl = "";
    if (isset($_GET["viewMode"]) || isset($_GET["statusPage"]) || isset($_GET["search"])) {
        $sameUrl = $sameUrl . "?";
    }
    if (isset($_GET["viewMode"])) {
        $sameUrl = $sameUrl . "viewMode=" . $_GET["viewMode"];
    }
    if (isset($_GET["statusPage"])) {
        $sameUrl = $sameUrl . "&statusPage=" . $_GET["statusPage"];
    }
    if (isset($_GET["search"])) {
        $sameUrl = $sameUrl . "&search=" . $_GET["search"];
    }
    // echo $sameUrl;
    header("location: ./camp_product.php$sameUrl");
}

//軟刪除商品 更改product的valid
if (isset($_POST["productId"]) && isset($_POST["softDelete"])) {
    $productId = $_POST["productId"];
    $softDelete = $_POST["softDelete"];

    $softDelSql = "UPDATE product SET product_valid='$softDelete' WHERE product_id=$productId";
    if ($conn->query($softDelSql) === TRUE) {
    } else {
        echo "刪除失敗" . $conn->error;
    }
    $sameUrl = "";
    if (isset($_GET["viewMode"]) || isset($_GET["statusPage"]) || isset($_GET["search"])) {
        $sameUrl = $sameUrl . "?";
    }
    if (isset($_GET["viewMode"])) {
        $sameUrl = $sameUrl . "viewMode=" . $_GET["viewMode"];
    }
    if (isset($_GET["statusPage"])) {
        $sameUrl = $sameUrl . "&statusPage=" . $_GET["statusPage"];
    }
    if (isset($_GET["search"])) {
        $sameUrl = $sameUrl . "&search=" . $_GET["search"];
    }
    // echo $sameUrl;
    header("location: ./camp_product.php$sameUrl");
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

if (isset($_GET["statusPage"])) {
    //依據page篩選不同的內容
    switch ($status_page_id) {
        case 0:
            $sql = "SELECT * FROM product WHERE product_status=0 AND product_valid=1 ORDER BY create_date DESC";
            break;
        case 1:
            $sql = "SELECT * FROM product WHERE product_status=1 AND product_valid=1 ORDER BY create_date DESC";
            break;
        case 2:
            //抓取product資料表的資料 限制在valid是1列
            $sql = "SELECT * FROM product WHERE product_valid=1 ORDER BY product_status DESC, create_date DESC";
            break;
    }
} else if (isset($_GET["search"])) {
    $search = $_GET["search"];
    $sql = "SELECT * FROM product WHERE product_name Like '%$search%' AND product_valid=1";
} else {
    $sql = "SELECT * FROM product WHERE product_valid=1 ORDER BY product_status DESC, create_date DESC";
}
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

<!-- <pre> -->
<?php
// print_r($rows);
?>
<!-- </pre> -->


<!doctype html>
<html lang="en">

<head>
    <title>camp_productList</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- 把共通的css叫入 -->
    <?php include("../css.php") ?>

    <style>
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
    </style>
</head>

<body>
    <div class="container">
        <!-- 頁面大標題＆新增商品 -->
        <div class="d-flex justify-content-between align-items-center my-4">
            <h1>我的商品</h1>
            <a class="addP btn btn-primary">
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
                <li class="nav-item">
                    <a class="nav-link 
                    <?php if (!isset($_GET["statusPage"]) || $_GET["statusPage"] == 2) echo "active" ?>
                    " href="./camp_product.php?statusPage=2&<?= $viewNum ?>">所有商品</a>
                </li>

                <!-- 用for迴圈讓status可以倒序地跑出來 -->
                <?php for ($i = count($staRows) - 1; $i >= 0; $i--) : ?>
                    <li class="nav-item">
                        <a class="nav-link 
                        <?php if (isset($_GET["statusPage"]) && $_GET["statusPage"] == $staRows[$i]["p_status_id"]) echo "active"; ?>
                        " href="./camp_product.php?statusPage=<?= $staRows[$i]["p_status_id"] ?>&<?= $viewNum ?>">
                            <?= $staRows[$i]["p_status_name"] ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>

        <div class="bg-white border border-top-0 rounded-bottom p-4">
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
                    共 <?= count($rows) ?> 件商品
                </h4>

                <!-- 檢視方式切換 -->
                <?php if (isset($_GET["statusPage"])) {
                    switch ($status_page_id) {
                        case 2:
                            $statusNum = "statusPage=2";
                            break;
                        case 1:
                            $statusNum = "statusPage=1";
                            break;
                        case 0:
                            $statusNum = "statusPage=0";
                            break;
                    }
                } else {
                    $statusNum = "statusPage=2";
                } ?>

                <div class="btn-group">
                    <a href="./camp_product.php?
                <?php if (isset($_GET["search"])) {
                } else {
                    echo "$statusNum&";
                }  ?>
                viewMode=1
                <?php if (isset($_GET["search"])) echo "&search=$search" ?>
                " class="btn btn-outline-primary 
                <?php if ($viewMode == 1) echo "active" ?>
                ">
                        <i class="fa-solid fa-bars"></i>
                    </a>

                    <a href="./camp_product.php?
                <?php if (isset($_GET["search"])) {
                } else {
                    echo "$statusNum&";
                }  ?>
                viewMode=2
                <?php if (isset($_GET["search"])) echo "&search=$search" ?>
                " class="btn btn-outline-primary 
                <?php if ($viewMode == 2) echo "active" ?>
                ">
                        <i class=" fa-solid fa-grip"></i>
                    </a>
                </div>
            </div>

            <!-- 商品列表 表單區域 -->

            <!-- 商品列表-表單檢視方式 -->
            <?php if ($viewMode == 1) : ?>
                <!-- 列表表頭 -->
                <table class="table teble-bordered">
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
                                <td>
                                    <div class="imgBox ratio ratio-1x1">
                                        <img class="productImg object-fit-cover" src="./product_image/<?= $product["mainImg_path"] ?>" alt="">
                                    </div>
                                </td>

                                <td class="px-3">
                                    <div class="d-flex flex-column justify-content-between">
                                        <ul class="list-unstyled">

                                            <!-- 商品狀態 -->
                                            <li class="d-flex mb-2">
                                                <div class="product_status p-1 
                                        <?php if ($product["product_status"] == 0) {
                                            echo "bg-body-secondary";
                                        } else {
                                            echo "bg-warning";
                                        } ?>
                                        ">
                                                    <?= $product["p_status_name"] ?>
                                                </div>
                                            </li>

                                            <!-- 商品名稱 -->
                                            <li>商品名稱：<?= $product["product_name"] ?></li>
                                        </ul>

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
                                <td class="px-3">10</td>
                                <td class="px-3"><?= $product["product_price"] ?></td>

                                <!-- 商品編輯、上架or下架、刪除 -->
                                <td>

                                    <div class="d-flex flex-column gap-2">
                                        <a href="" class="btn btn-primary">
                                            <i class="fa-solid fa-pen-to-square"></i> 編輯
                                        </a>

                                        <form action="" method="post">
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

                                        <form action="" method="post">
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
                            <div class="bg-white p-3 shadow-sm">
                                <!-- 圖片 -->
                                <div class="ratio ratio-1x1">
                                    <img class="object-fit-cover" src="./product_image/<?= $product["mainImg_path"] ?>" alt="">
                                </div>
                                <!-- 商品狀態 -->
                                <div class="d-flex mb-2">
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
                                <!-- 租賃價格 -->
                                <div class="text-end mb-3">
                                    <?= $product["product_price"] ?>
                                </div>

                                <div class="d-flex justify-content-between mb-3">
                                    <!-- 商品被瀏覽次數 -->
                                    <div>
                                        <i class="fa-regular fa-eye"></i>113
                                    </div>
                                    <!-- 商品被收藏次數 -->
                                    <div>
                                        <i class="fa-regular fa-heart"></i>25
                                    </div>
                                </div>

                                <!-- 商品編輯、上架or下架、刪除 -->

                                <div class="d-flex justify-content-between">
                                    <a href="" class="btn btn-outline-primary">
                                        <i class="fa-solid fa-pen-to-square"></i> 編輯
                                    </a>

                                    <form action="" method="post">
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

                                    <form action="" method="post">
                                        <input class="d-none" type="number" name="productId" value="<?= $product["product_id"] ?>">
                                        <input class="d-none" type="number" name="softDelete" value="0">
                                        <button type="submit" class="btn btn-outline-danger w-100">
                                            <i class="fa-solid fa-trash"></i> 刪除
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- 把共通的js叫入 -->
    <?php include("../js.php") ?>

    <script>

    </script>
</body>

</html>