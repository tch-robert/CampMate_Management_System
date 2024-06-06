<?php
require_once("../db_connect.php");


// 每頁顯示的數量
$perPage = 5;

// 獲取搜索和篩選的條件
$search = isset($_GET["search"]) ? $_GET["search"] : '';
$category = isset($_GET["category"]) ? $_GET["category"] : '';

// 得到分頁和篩選的訊息
$page = isset($_GET["page"]) ? $_GET["page"] : 1;
$order = isset($_GET["order"]) ? $_GET["order"] : 1;
$firstItem = ($page - 1) * $perPage;
$pageTitle = "客服單列表 / 第 $page 頁";

// 排序條件
$orderClause = "ORDER BY id ASC";
switch ($order) {
    case 2:
        $orderClause = "ORDER BY id DESC";
        break;
    case 3:
        $orderClause = "ORDER BY status ASC";
        break;
    case 4:
        $orderClause = "ORDER BY status DESC";
        break;
}

// 搜索和篩選的條件
$searchClause = !empty($search) ? "AND (title LIKE '%$search%' OR description LIKE '%$search%')" : '';
$categoryClause = !empty($category) ? "AND title LIKE '%$category%'" : '';

// 取得所有符合條件的值
$sqlAll = "SELECT * FROM ticket WHERE valid = 1 $searchClause $categoryClause";
$resultAll = $conn->query($sqlAll);
$allTicketCount = $resultAll->num_rows;

// 計算總頁數
$pageCount = ceil($allTicketCount / $perPage);

// 获取当前页的客服单数据
$sql = "SELECT id, title, description, user_id, reply, createtime, closetime, status 
        FROM ticket 
        WHERE valid = 1 $searchClause $categoryClause 
        $orderClause 
        LIMIT $firstItem, $perPage";
$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);


$pageTitle = !empty($search) ? "$search 的搜尋結果" : $pageTitle;



?>

<!doctype html>
<html lang="zh-Hant">

<head>
    <title><?= $pageTitle ?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <?php include("../css.php") ?>
    <style>
        .aside-a-active {
            transform: translate(-3px, -3px);
        }

        .aside-i-active {
            color: #9ba45c;
            background: linear-gradient(145deg, #ffefda, #d7c9b8) !important;
            box-shadow: 2px 2px 8px #baae9f,
                -2px -2px 8px #fffff9 !important;
        }

        .table-custom {
            border-collapse: separate;
            border-spacing: 0 15px;
        }

        .table-custom thead th {
            border: none;
            background-color: #343a40;
            color: white;
        }

        .table-custom tbody tr {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table-custom tbody tr td {
            background-color: white;
            border: none;
        }

        .pagination-shadow {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination-shadow .page-item {
            margin: 0 5px;
        }

        .pagination-shadow .page-item .page-link {
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            color: #000;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s, color 0.3s;
        }

        .pagination-shadow .page-item .page-link:hover {
            color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            background-color: #007bff;
        }

        .pagination-shadow .page-item.active .page-link {
            color: white;
            background-color: #007bff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>
    <?php include("../index.php") ?>
    <main class="main-content">
        <div class="container">
            <h2><?= $pageTitle ?></h2>
            <div class="py-2 mb-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <?php if (!empty($search)) : ?>
                            <a class="btn btn-warning" href="tickets.php"><i class="fa-solid fa-arrow-left"></i></a>
                        <?php endif; ?>
                    </div>
                    <div class="d-flex gap-3">
                        <form action="" method="get">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search..." name="search" value="<?= $search ?>">
                                <button class="btn btn-warning" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </form>
                        <a class="btn btn-warning" href="create_ticket.php"><i class="fa-solid fa-plus"></i></a>
                    </div>
                </div>
            </div>
            <div class="pb-2 d-flex justify-content-between">
                <div>共 <?= $allTicketCount ?> 單</div>
                <div>
                    排序:
                    <div class="btn-group">
                        
                        <!-- <a href="?page=<?= $page ?>&order=2&search=<?= $search ?>&category=<?= $category ?>" class="btn btn-warning <?= $order == 2 ? 'active' : '' ?>">編號<i class="fa-solid fa-arrow-up-1-9"></i></a> -->
                        <a href="?page=<?= $page ?>&order=3&search=<?= $search ?>&category=<?= $category ?>" class="btn btn-warning <?= $order == 3 ? 'active' : '' ?>">尚未回覆</a>
                        <a href="?page=<?= $page ?>&order=4&search=<?= $search ?>&category=<?= $category ?>" class="btn btn-warning <?= $order == 4 ? 'active' : '' ?>">已回覆</a>
                        <a href="?page=<?= $page ?>&order=1&search=<?= $search ?>&category=<?= $category ?>" class="btn btn-warning <?= $order == 1 ? 'active' : '' ?>"><i class="fa-solid fa-arrows-rotate"></i></a>
                    </div>
                </div>
            </div>
            <div class="">
                <form id="categoryForm" action="" method="get" class="form-inline ">
                    <input type="hidden" name="page" value="<?= $page ?>">
                    <input type="hidden" name="order" value="<?= $order ?>">
                    <input type="hidden" name="search" value="<?= $search ?>">
                    <label class="text-nowrap">客服單分類：</label>
                    <select class="form-control" name="category" onchange="this.form.submit()">
                        <option value="">所有</option>
                        <option value="營地相關" <?= $category == '營地相關' ? 'selected' : '' ?>>營地相關</option>
                        <option value="租借用品相關" <?= $category == '租借用品相關' ? 'selected' : '' ?>>租借用品相關</option>
                        <option value="網站操作相關" <?= $category == '網站操作相關' ? 'selected' : '' ?>>網站操作相關</option>
                        <option value="費用相關" <?= $category == '費用相關' ? 'selected' : '' ?>>費用相關</option>
                        <option value="其他" <?= $category == '其他' ? 'selected' : '' ?>>其他</option>
                    </select>
                </form>
            </div>
            <?php if ($result->num_rows > 0) : ?>
                <table class="table table-custom table-hover">
                    <thead>
                        <tr class="text-truncate">
                            <th>編號</th>
                            <th>標題</th>
                            <th>描述</th>
                            <th>使用者id</th>
                            <th>回覆</th>
                            <th>狀態</th>
                            <th>建立時間</th>
                            <th>檢視</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $user) : ?>
                            <tr>
                                <td scope="row" class="text-center"><?= $user["id"] ?></td>
                                <td class="text-truncate"><?= $user["title"] ?></td>
                                <td><?= $user["description"] ?></td>
                                <td class="text-center"><?= $user["user_id"] ?></td>
                                <td><?= $user["reply"] ?></td>
                                <td class="text-truncate"><?= $user["status"] ?></td>
                                <td><?= $user["createtime"] ?></td>
                                <td><a class="btn btn-warning" href="ticket.php?id=<?= $user["id"] ?>"><i class="fa-solid fa-eye"></i></a></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
                <?php if ($pageCount > 1) : ?>
                    <nav aria-label="Page ">
                        <ul class="pagination pagination-shadow">
                            <?php for ($i = 1; $i <= $pageCount; $i++) : ?>
                                <li class="page-item <?= $i == $page ? 'active' : '' ?>"><a class="page-link" href="?page=<?= $i ?>&order=<?= $order ?>&search=<?= $search ?>&category=<?= $category ?>"><?= $i ?></a></li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            <?php else : ?>
                沒有相關客訴單
            <?php endif; ?>
        </div>
    </main>
    <?php include("../js.php") ?>
</body>

</html>
