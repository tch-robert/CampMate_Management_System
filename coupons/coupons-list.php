<?php
require_once("../db_connect.php");
$pageTitle = "優惠券管理";

// 獲取當前頁數，如果沒有指定則默認為第1頁
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$couponsPerPage = 12; // 每頁顯示的優惠券數量
$offset = ($page - 1) * $couponsPerPage;

// 獲取搜尋和篩選條件
$search = isset($_GET['search']) ? $_GET['search'] : "";
$order = isset($_GET['order']) ? $_GET['order'] : "";
$categoryFilter = isset($_GET['category']) ? $_GET['category'] : "";
$startDate = isset($_GET['start']) ? $_GET['start'] : "";
$endDate = isset($_GET['end']) ? $_GET['end'] : "";
$statusFilter = isset($_GET['status']) ? $_GET['status'] : "";

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
if ($statusFilter) {
    $totalCouponsSql .= " AND status='$statusFilter'";
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
if ($statusFilter) {
    $sql .= " AND status='$statusFilter'";
}
if ($order == 'name_asc') {
    $sql .= " ORDER BY coupon_name ASC";
} elseif ($order == 'name_desc') {
    $sql .= " ORDER BY coupon_name DESC";
} elseif ($order == 'id_asc') {
    $sql .= " ORDER BY id ASC";
} elseif ($order == 'id_desc') {
    $sql .= " ORDER BY id DESC";
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
    <!-- css -->
    <?php include("../css_neumorphic.php") ?>
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .container {
            color: var(--secondary-color);
        }

        table {

            th.id-col,
            td.id-col {
                width: 5%;
                font-weight: 700;
                color: var(--secondary-color);
            }

            th.func-col,
            td.func-col {
                width: 15%;
            }

        }

        .breadcrumb {

            .breadcrumb-item,
            span {
                color: var(--secondary-color);
                font-size: 14px;
                letter-spacing: 1px;
                font-weight: 600;
            }

            a {
                color: var(--secondary-color);
                text-decoration: none;
            }
        }

        .filter-font {
            font-size: 12px;
            letter-spacing: 1px;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <?php include("../index.php") ?>
    <main class="main-content">
        <div class="container">
            <!-- 索引 -->
            <div class="px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="http://localhost/campmate/index.php" class="text-decoration-none">
                                首頁
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="http://localhost/campmate/coupons/coupons-list.php" class="text-decoration-none">
                                <?= $pageTitle ?>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <span>第 <?= $page ?> 頁</span>
                        </li>
                    </ol>
                </nav>
            </div>
            <h1 class="d-none"><?= $pageTitle ?></h1>
            <!-- 篩選器 -->
            <div class="d-flex justify-content-between align-items-center pb-3">
                <div>
                    <?php if ($search || $order || $categoryFilter || ($startDate && $endDate) || $statusFilter) : ?>
                        <a class="btn btn-neumorphic btn-circle me-2" href="coupons-list.php">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                    <?php endif; ?>
                </div>
                <form action="" class="flex-fill">
                    <div class="input-group-neumorphic">
                        <input type="text" class="form-control-neumorphic" placeholder="搜尋..." name="search" value="<?= htmlspecialchars($search) ?>">
                        <button class="btn btn-neumorphic btn-circle" type="submit">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
                <button type="button" class="btn btn-neumorphic btn-circle ms-2" data-bs-toggle="modal" data-bs-target="#addCouponModal">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </div>
            <div class="d-flex justify-content-between align-items-center pb-5">
                <div class="filter-font px-3">
                    共 <?= $totalCoupons ?> 張
                </div>
                <div class="d-flex justify-content-center align-items-center gap-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="filter-font">
                            ID :
                        </div>
                        <a href="?<?= http_build_query(array_merge($_GET, ['order' => 'id_asc'])) ?>" class="btn btn-neumorphic btn-circle <?= ($order == 'id_asc') ? 'active' : '' ?>">
                            <i class="fa-solid fa-arrow-down-1-9"></i>
                        </a>
                        <a href="?<?= http_build_query(array_merge($_GET, ['order' => 'id_desc'])) ?>" class="btn btn-neumorphic btn-circle <?= ($order == 'id_desc') ? 'active' : '' ?>">
                            <i class="fa-solid fa-arrow-up-9-1"></i>
                        </a>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="filter-font">
                            名稱 :
                        </div>
                        <a href="?<?= http_build_query(array_merge($_GET, ['order' => 'name_asc'])) ?>" class="btn btn-neumorphic btn-circle <?= ($order == 'name_asc') ? 'active' : '' ?>">
                            <i class="fa-solid fa-arrow-down-a-z"></i>
                        </a>
                        <a href="?<?= http_build_query(array_merge($_GET, ['order' => 'name_desc'])) ?>" class="btn btn-neumorphic btn-circle <?= ($order == 'name_desc') ? 'active' : '' ?>">
                            <i class="fa-solid fa-arrow-up-z-a"></i>
                        </a>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="filter-font">
                            類別 :
                        </div>
                        <a href="?<?= http_build_query(array_merge($_GET, ['category' => '%數折扣'])) ?>" class="btn btn-neumorphic btn-circle <?= ($categoryFilter == '%數折扣') ? 'active' : '' ?>">
                            <i class="fa-solid fa-percent"></i>
                        </a>
                        <a href="?<?= http_build_query(array_merge($_GET, ['category' => '金額折抵'])) ?>" class="btn btn-neumorphic btn-circle <?= ($categoryFilter == '金額折抵') ? 'active' : '' ?>">
                            <i class="fa-solid fa-dollar-sign"></i>
                        </a>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="filter-font">
                            期限 :
                        </div>
                        <form action="" class="d-flex align-items-center">
                            <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">
                            <input type="hidden" name="order" value="<?= htmlspecialchars($order) ?>">
                            <input type="hidden" name="category" value="<?= htmlspecialchars($categoryFilter) ?>">
                            <div class="col-auto">
                                <input type="date" placeholder="年 / 月 / 日" aria-label="年 / 月 / 日" id="start-date" class="form-control-neumorphic form-control-sm flatpickr" name="start" value="<?= htmlspecialchars($startDate) ?>">
                            </div>
                            <div class="col-auto">
                                <input type="date" placeholder="年 / 月 / 日" aria-label="年 / 月 / 日" id="end-date" class="form-control-neumorphic form-control-sm flatpickr" name="end" value="<?= htmlspecialchars($endDate) ?>">
                            </div>
                            <button type="submit" class="btn btn-neumorphic btn-circle">
                                <i class="fa-solid fa-calendar-check"></i>
                            </button>
                        </form>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="filter-font">
                            狀態 :
                        </div>
                        <a href="?<?= http_build_query(array_merge($_GET, ['status' => '可使用'])) ?>" class="btn btn-neumorphic btn-circle <?= ($statusFilter == '可使用') ? 'active' : '' ?>">
                            <i class="fa-solid fa-check"></i>
                        </a>
                        <a href="?<?= http_build_query(array_merge($_GET, ['status' => '已停用'])) ?>" class="btn btn-neumorphic btn-circle <?= ($statusFilter == '已停用') ? 'active' : '' ?>">
                            <i class="fa-solid fa-ban"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- 優惠券管理列表 -->
            <div class="table-wrapper">
                <table class="table table-bordered table-fixed neumorphic-table">
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
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <button type="button" class="btn btn-neumorphic btn-circle" onclick="showCouponDetails(<?= $coupon['id'] ?>)">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-neumorphic btn-circle" onclick="showEditModal(<?= $coupon['id'] ?>)">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-neumorphic btn-circle" onclick="showDeleteModal(<?= $coupon['id'] ?>)">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
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
    </main>
    <!-- Add Coupon Modal -->
    <div class="modal fade coupon-modal" id="addCouponModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addCouponModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCouponModalLabel">新增優惠券</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCouponForm">
                        <table class="table table-bordered">
                            <tr>
                                <th>名稱 : </th>
                                <td>
                                    <input type="text" class="form-control" id="addCouponName" name="coupon_name" required>
                                </td>
                            </tr>
                            <tr>
                                <th>類別 : </th>
                                <td>
                                    <select class="form-select" id="addCouponCategory" name="category" required>
                                        <option value="%數折扣">%數折扣</option>
                                        <option value="金額折抵">金額折抵</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>折扣 : </th>
                                <td>
                                    <input type="text" class="form-control" id="addCouponDiscount" name="discount" required>
                                </td>
                            </tr>
                            <tr>
                                <th>使用低消金額 : </th>
                                <td>
                                    <input type="text" class="form-control" id="addCouponMinCost" name="min_cost" required>
                                </td>
                            </tr>
                            <tr>
                                <th>最高折抵金額 : </th>
                                <td>
                                    <input type="text" class="form-control" id="addCouponMaxDiscountAmount" name="max_discount_amount" required>
                                </td>
                            </tr>
                            <tr>
                                <th>數量 : </th>
                                <td>
                                    <input type="text" class="form-control" id="addCouponNum" name="coupon_num" required>
                                </td>
                            </tr>
                            <tr>
                                <th>起始日期 : </th>
                                <td>
                                    <input type="date" class="form-control flatpickr" id="addCouponStartDate" placeholder="年 / 月 / 日" aria-label="年 / 月 / 日" name="start_date" required>
                                </td>
                            </tr>
                            <tr>
                                <th>結束日期 : </th>
                                <td>
                                    <input type="date" class="form-control flatpickr" id="addCouponEndDate" placeholder="年 / 月 / 日" aria-label="年 / 月 / 日" name="end_date" required>
                                </td>
                            </tr>
                            <tr>
                                <th>狀態 : </th>
                                <td>
                                    <select class="form-select" id="addCouponStatus" name="status" required>
                                        <option value="可使用">可使用</option>
                                        <option value="已停用">已停用</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-neumorphic" onclick="addCoupon()">
                        <span class="px-2 py-1"><i class="fa-solid fa-circle-check me-2"></i>確認新增</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--Show Details Modal -->
    <div class="modal fade coupon-modal" id="couponModal" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" tabindex="-1" aria-labelledby="couponModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="couponModalLabel">優惠券詳情</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody id="couponDetails">
                            <!-- 優惠券詳情將在這裡顯示 -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Modal -->
    <div class="modal fade coupon-modal" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">編輯優惠券</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCouponForm">
                        <table class="table table-bordered">
                            <input type="hidden" name="id" id="editCouponId">
                            <tr>
                                <th>ID</th>
                                <td id="displayCouponId" class="text-center"></td>
                            </tr>
                            <tr>
                                <th>名稱</th>
                                <td>
                                    <input type="text" class="form-control" id="editCouponName" name="coupon_name" required>
                                </td>
                            </tr>
                            <tr>
                                <th>類別</th>
                                <td>
                                    <select class="form-select" id="editCouponCategory" name="category" required>
                                        <option value="%數折扣">%數折扣</option>
                                        <option value="金額折抵">金額折抵</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>折扣</th>
                                <td>
                                    <input type="text" class="form-control" id="editCouponDiscount" name="discount" required>
                                </td>
                            </tr>
                            <tr>
                                <th>使用低消金額</th>
                                <td>
                                    <input type="text" class="form-control" id="editCouponMinCost" name="min_cost" required>
                                </td>
                            </tr>
                            <tr>
                                <th>最高折抵金額</th>
                                <td>
                                    <input type="text" class="form-control" id="editCouponMaxDiscountAmount" name="max_discount_amount" required>
                                </td>
                            </tr>
                            <tr>
                                <th>數量</th>
                                <td>
                                    <input type="text" class="form-control" id="editCouponNum" name="coupon_num" required>
                                </td>
                            </tr>
                            <tr>
                                <th>起始日期</th>
                                <td>
                                    <input type="date" class="form-control flatpickr" id="editCouponStartDate" name="start_date" required>
                                </td>
                            </tr>
                            <tr>
                                <th>結束日期</th>
                                <td>
                                    <input type="date" class="form-control flatpickr" id="editCouponEndDate" name="end_date" required>
                                </td>
                            </tr>
                            <tr>
                                <th>狀態</th>
                                <td>
                                    <select class="form-select" id="editCouponStatus" name="status" required>
                                        <option value="可使用">可使用</option>
                                        <option value="已停用">已停用</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-neumorphic" onclick="updateCoupon()">
                        <span class="px-2 py-1"><i class="fa-solid fa-circle-check me-2"></i>確認修改</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete Modal -->
    <div class="modal fade coupon-modal" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">刪除優惠券</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody id="deleteCouponDetails">
                            <!-- 優惠券詳情將在這裡顯示 -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-neumorphic" id="confirmDeleteButton" onclick="deleteCoupon()">
                        <span class="px-2 py-1"><i class="fa-solid fa-circle-check me-2"></i>確認刪除</span>
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- js -->
    <?php include("../js.php") ?>
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr(".flatpickr", {
                dateFormat: "Y-m-d"
            });
        });

        function showCouponDetails(couponId) {
            $.ajax({
                url: 'get-coupon-details.php',
                type: 'GET',
                data: {
                    id: couponId
                },
                success: function(response) {
                    $('#couponDetails').html(response);
                    $('#couponModal').modal('show');
                }
            });
        }

        function showEditModal(couponId) {
            $.ajax({
                url: 'edit-coupon-details.php',
                type: 'GET',
                data: {
                    id: couponId
                },
                success: function(response) {
                    let coupon = JSON.parse(response);
                    $('#editCouponId').val(coupon.id);
                    $('#displayCouponId').text(coupon.id);
                    $('#editCouponName').val(coupon.coupon_name);
                    $('#editCouponCategory').val(coupon.category);
                    $('#editCouponDiscount').val(coupon.discount);
                    $('#editCouponMinCost').val(coupon.min_cost);
                    $('#editCouponMaxDiscountAmount').val(coupon.max_discount_amount);
                    $('#editCouponNum').val(coupon.coupon_num);
                    $('#editCouponStartDate').val(coupon.start_date);
                    $('#editCouponEndDate').val(coupon.end_date);
                    $('#editCouponStatus').val(coupon.status);
                    $('#editModal').modal('show');
                }
            });
        }

        function showDeleteModal(couponId) {
            $.ajax({
                url: 'get-coupon-details.php',
                type: 'GET',
                data: {
                    id: couponId
                },
                success: function(response) {
                    $('#deleteCouponDetails').html(response);
                    $('#confirmDeleteButton').attr('data-id', couponId);
                    $('#deleteModal').modal('show');
                }
            });
        }

        function deleteCoupon() {
            let couponId = $('#confirmDeleteButton').attr('data-id');
            $.ajax({
                url: 'delete-coupon.php',
                type: 'POST',
                data: {
                    id: couponId
                },
                success: function(response) {
                    // alert('刪除成功');
                    location.reload();
                },
                error: function() {
                    alert('刪除失敗');
                }
            });
        }

        // 輸入驗證
        function validateCouponForm(form) {
            const discount = form.discount;
            const minCost = form.min_cost;
            const maxDiscountAmount = form.max_discount_amount;
            const couponNum = form.coupon_num;

            let isValid = true;

            // 重置所有自定義錯誤訊息
            discount.setCustomValidity("");
            minCost.setCustomValidity("");
            maxDiscountAmount.setCustomValidity("");
            couponNum.setCustomValidity("");

            // 檢查折扣是否為數字且最多兩位小數
            if (!/^\d+(\.\d{1,2})?$/.test(discount.value)) {
                discount.setCustomValidity('折扣必須是數字且最多兩位小數');
                isValid = false;
            }

            // 檢查使用低消金額、最高折抵金額、數量是否為正整數
            if (!/^\d+$/.test(minCost.value) || minCost.value <= 0) {
                minCost.setCustomValidity('使用低消金額必須是正整數');
                isValid = false;
            }
            if (!/^\d+$/.test(maxDiscountAmount.value) || maxDiscountAmount.value <= 0) {
                maxDiscountAmount.setCustomValidity('最高折抵金額必須是正整數');
                isValid = false;
            }
            if (!/^\d+$/.test(couponNum.value) || couponNum.value <= 0) {
                couponNum.setCustomValidity('數量必須是正整數');
                isValid = false;
            }

            // 如果有任何一個欄位無效，則回傳 false
            return isValid;
        }

        function addCoupon() {
            const form = document.getElementById('addCouponForm');
            if (validateCouponForm(form)) {
                let formData = $('#addCouponForm').serialize();
                $.ajax({
                    url: 'add-coupon.php',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        // alert('新增成功');
                        location.reload();
                    },
                    error: function() {
                        alert('新增失敗');
                    }
                });
            } else {
                form.reportValidity(); // 顯示錯誤訊息
            }
        }

        function updateCoupon() {
            const form = document.getElementById('editCouponForm');
            if (validateCouponForm(form)) {
                let formData = $('#editCouponForm').serialize();
                $.ajax({
                    url: 'update-coupon.php',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        // alert('更新成功');
                        location.reload();
                    },
                    error: function() {
                        alert('更新失敗');
                    }
                });
            } else {
                form.reportValidity(); // 顯示錯誤訊息
            }
        }
    </script>
</body>

</html>