<?php
require_once("../db_connect.php");
$pageTitle = "優惠券管理";

// if (isset($_GET["id"])) {


$sql = "SELECT * FROM coupon WHERE valid=1";
$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);
// var_dump($rows);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>優惠券管理</title>
    <!-- css -->
    <?php include("../css.php") ?>
    <style>
        table {

            th,
            td {
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="py-3">
            <h1><?= $pageTitle ?></h1>
            <div class="d-flex justify-content-between py-3">
                <div>
                    <?php if (isset($_GET["search"])) : ?>
                        <a class="btn btn-primary" href="users.php">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="d-flex gap-3">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" disabled>
                            排序：
                        </button>
                        <button type="button" class="btn btn-primary">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        <button type="button" class="btn btn-primary">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        <button type="button" class="btn btn-primary">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                    <form action="">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search..." name="search">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </form>
                    <a class="btn btn-primary" href="create-coupon.php">
                        <i class="fa-solid fa-circle-plus"></i>
                    </a>
                </div>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr class="text-nowrap">
                        <th>ID</th>
                        <th>名稱</th>
                        <th>種類</th>
                        <th>折扣</th>
                        <th>使用低消金額</th>
                        <th>最高折抵金額</th>
                        <th>數量</th>
                        <th>起始日期</th>
                        <th>結束日期</th>
                        <th>狀態</th>
                        <th>功能</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $coupon) : ?>
                        <tr>
                            <td>
                                <?= $coupon["id"] ?>
                            </td>
                            <td>
                                <?= $coupon["coupon_name"] ?>
                            </td>
                            <td>
                                <?= $coupon["category"] ?>
                            </td>
                            <td>
                                <?php
                                if ($coupon["category"] === '%數折扣') {
                                    echo $coupon["discount"] * 100 . '%';
                                } else if ($coupon["category"] === '金額折抵') {
                                    echo floor($coupon["discount"]) . '元';
                                } else {
                                    echo 'Invalid discount type';
                                }
                                ?>
                            </td>
                            <td>
                                <?= number_format($coupon["min_cost"]) ?>
                            </td>
                            <td>
                                <?= number_format($coupon["max_discount_amount"]) ?>
                            </td>
                            <td>
                                <?= number_format($coupon["coupon_num"]) ?>
                            </td>
                            <td>
                                <?= $coupon["start_date"] ?>
                            </td>
                            <td>
                                <?= $coupon["end_date"] ?>
                            </td>
                            <td>
                                <?= $coupon["status"] ?>
                            </td>
                            <td>
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

</body>

</html>