<?php
require_once("../db_connect.php");
$pageTitle = "優惠券管理";

// 獲取當前頁數，如果沒有指定則默認為第1頁
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$couponsPerPage = 10; // 每頁顯示的優惠券數量
$offset = ($page - 1) * $couponsPerPage;

// 獲取搜尋和篩選條件
$search = isset($_GET['search']) ? $_GET['search'] : "";
$order = isset($_GET['order']) ? $_GET['order'] : "";
$categoryFilter = isset($_GET['category']) ? $_GET['category'] : "";
$startDate = isset($_GET['start']) ? $_GET['start'] : "";
$endDate = isset($_GET['end']) ? $_GET['end'] : "";

// 查詢總數量
$totalCouponsSql = "SELECT COUNT(*) AS total FROM coupon WHERE valid=1";
if ($search) {
    $totalCouponsSql .= " AND (coupon_name LIKE '%$search%' OR category LIKE '%$search%' OR discount LIKE '%$search%' OR min_cost LIKE '%$search%' OR max_discount_amount LIKE '%$search%' OR coupon_num LIKE '%$search%' OR start_date LIKE '%$search%' OR end_date LIKE '%$search%' OR status LIKE '%$search%')";
}
if ($categoryFilter) {
    $totalCouponsSql .= " AND category='$categoryFilter'";
}
if ($startDate && $endDate) {
    $totalCouponsSql .= " AND start_date >= '$startDate' AND end_date <= '$endDate'";
}
$totalCouponsResult = $conn->query($totalCouponsSql);
$totalCoupons = $totalCouponsResult->fetch_assoc()['total'];
$totalPages = ceil($totalCoupons / $couponsPerPage);

// 查詢當前頁面顯示的優惠券
$sql = "SELECT * FROM coupon WHERE valid=1";
if ($search) {
    $sql .= " AND (coupon_name LIKE '%$search%' OR category LIKE '%$search%' OR discount LIKE '%$search%' OR min_cost LIKE '%$search%' OR max_discount_amount LIKE '%$search%' OR coupon_num LIKE '%$search%' OR start_date LIKE '%$search%' OR end_date LIKE '%$search%' OR status LIKE '%$search%')";
}
if ($categoryFilter) {
    $sql .= " AND category='$categoryFilter'";
}
if ($startDate && $endDate) {
    $sql .= " AND start_date >= '$startDate' AND end_date <= '$endDate'";
}
if ($order == 'name_asc') {
    $sql .= " ORDER BY coupon_name ASC";
} elseif ($order == 'name_desc') {
    $sql .= " ORDER BY coupon_name DESC";
}
$sql .= " LIMIT $couponsPerPage OFFSET $offset";
$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>優惠券管理</title>
    <?php include("../css.php") ?>
    <style>
        .container {
            min-height: 100vh;
            /* 設置容器的最小高度 */
            overflow-x: hidden;
            /* 隱藏水平滾動條 */
        }

        table {
            width: 100%;
            table-layout: fixed;

            /* 固定表格佈局 */
            th,
            td {
                text-align: center;
                word-wrap: break-word;
                /* 允許單詞換行 */
            }

            th.id-col,
            td.id-col {
                width: 5%;
                /* 縮小ID列的寬度 */
            }

            th.func-col,
            td.func-col {
                width: 15%;
                /* 加大功能列的寬度 */
            }

            .btn.active {
                background-color: #0056b3;
                color: white;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="pt-4"><?= $pageTitle ?></h1>
        <div class="d-flex justify-content-between align-items-center py-3">
            <div>
                <?php if ($search || $order || $categoryFilter || ($startDate && $endDate)) : ?>
                    <a class="btn btn-primary me-3" href="coupons-list.php">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                <?php endif; ?>
            </div>
            <form action="" class="flex-fill">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="搜尋..." name="search" value="<?= htmlspecialchars($search) ?>">
                    <button class="btn btn-primary" type="submit">
                        <i class="fa-solid fa-magnifying-glass"></i> 搜尋
                    </button>
                </div>
            </form>
            <a class="btn btn-primary ms-3" href="create-coupon.php">
                <i class="fa-solid fa-circle-plus"></i>
            </a>
        </div>
        <div class="d-flex justify-content-between align-items-center pb-5">
            <div>
                共 <?= $totalCoupons ?> 張
            </div>
            <div class="d-flex justify-content-center align-items-stretch gap-3">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary" disabled>
                        名稱
                    </button>
                    <a href="?<?= http_build_query(array_merge($_GET, ['order' => 'name_asc'])) ?>" class="btn btn-primary <?= ($order == 'name_asc') ? 'active' : '' ?>">
                        <i class="fa-solid fa-arrow-down-wide-short mt-2"></i>
                    </a>
                    <a href="?<?= http_build_query(array_merge($_GET, ['order' => 'name_desc'])) ?>" class="btn btn-primary <?= ($order == 'name_desc') ? 'active' : '' ?>">
                        <i class="fa-solid fa-arrow-down-short-wide mt-2"></i>
                    </a>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-primary" disabled>
                        類別
                    </button>
                    <a href="?<?= http_build_query(array_merge($_GET, ['category' => '%數折扣'])) ?>" class="btn btn-primary <?= ($categoryFilter == '%數折扣') ? 'active' : '' ?>">
                        <i class="fa-solid fa-percent mt-2"></i>
                    </a>
                    <a href="?<?= http_build_query(array_merge($_GET, ['category' => '金額折抵'])) ?>" class="btn btn-primary <?= ($categoryFilter == '金額折抵') ? 'active' : '' ?>">
                        <i class="fa-solid fa-dollar-sign mt-2"></i>
                    </a>
                </div>
                <!-- <div class="btn-group">
                    <button type="button" class="btn btn-primary" disabled>
                        期限
                    </button>
                    <form action="" method="get">
                        <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">
                        <input type="hidden" name="order" value="<?= htmlspecialchars($order) ?>">
                        <input type="hidden" name="category" value="<?= htmlspecialchars($categoryFilter) ?>">
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <input type="date" class="form-control form-control-sm" name="start" value="<?= htmlspecialchars($startDate) ?>">
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-arrow-right-long"></i>
                            </div>
                            <div class="col-auto">
                                <input type="date" class="form-control form-control-sm" name="end" value="<?= htmlspecialchars($endDate) ?>">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-calendar-check"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div> -->
                <div class="btn-group">
                    <button type="button" class="btn btn-primary" disabled>
                        期限
                    </button>
                    <button type="button" class="btn btn-primary">
                        <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">
                        <input type="hidden" name="order" value="<?= htmlspecialchars($order) ?>">
                        <input type="hidden" name="category" value="<?= htmlspecialchars($categoryFilter) ?>">
                        <form action="">
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <input type="date" class="form-control form-control-sm" name="start" value="<?= htmlspecialchars($startDate) ?>">
                                </div>
                                <div class="col-auto">
                                    <i class="fa-solid fa-arrow-right-long"></i>
                                </div>
                                <div class="col-auto">
                                    <input type="date" class="form-control form-control-sm" name="end" value="<?= htmlspecialchars($endDate) ?>">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-calendar-check"></i>
                            </button>
                        </form>
                    </button>
                </div>
            </div>
        </div>
        <table class="table table-bordered table-fixed">
            <thead>
                <tr class="text-nowrap">
                    <th class="id-col">ID</th>
                    <th>名稱</th>
                    <th>類別</th>
                    <th>折扣</th>
                    <th>使用低消金額</th>
                    <th>最高折抵金額</th>
                    <th>數量</th>
                    <th>起始日期</th>
                    <th>結束日期</th>
                    <th>狀態</th>
                    <th class="func-col">功能</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $coupon) : ?>
                    <tr>
                        <td class="id-col"><?= htmlspecialchars($coupon["id"]) ?></td>
                        <td><?= htmlspecialchars($coupon["coupon_name"]) ?></td>
                        <td><?= htmlspecialchars($coupon["category"]) ?></td>
                        <td>
                            <?php
                            if ($coupon["category"] === '%數折扣') {
                                echo htmlspecialchars($coupon["discount"] * 100) . '%';
                            } else if ($coupon["category"] === '金額折抵') {
                                echo htmlspecialchars(floor($coupon["discount"])) . '元';
                            } else {
                                echo 'Invalid discount type';
                            }
                            ?>
                        </td>
                        <td><?= number_format($coupon["min_cost"]) ?></td>
                        <td><?= number_format($coupon["max_discount_amount"]) ?></td>
                        <td><?= number_format($coupon["coupon_num"]) ?></td>
                        <td><?= htmlspecialchars($coupon["start_date"]) ?></td>
                        <td><?= htmlspecialchars($coupon["end_date"]) ?></td>
                        <td><?= htmlspecialchars($coupon["status"]) ?></td>
                        <td class="func-col">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-success">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button type="button" class="btn btn-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- 分頁按鈕 -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
    </div>
</body>

</html>