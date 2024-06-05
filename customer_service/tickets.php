<?php
require_once("../db_connect.php");

$sqlAll = "SELECT * FROM ticket WHERE valid = 1";
$resultAll = $conn->query($sqlAll);
$allTicketCount = $resultAll->num_rows;

if (isset($_GET["search"])) {
    $search = $_GET["search"];
    $sql = "SELECT id, title, description, user_id, reply, createtime, closetime, status FROM ticket WHERE title LIKE '%$search%' AND valid = 1";
    $pageTitle = "$search 的搜尋結果";
} else if (isset($_GET["page"]) && isset($_GET["order"])) {
    $page = $_GET["page"];
    $perPage = 5;
    $firstItem = ($page - 1) * $perPage;
    $pageCount = ceil($allTicketCount / $perPage);

    $order = $_GET["order"];

    switch ($order) {
        case 1:
            $orderClause = "ORDER BY id ASC";
            break;
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
    $sql = "SELECT * FROM ticket WHERE valid=1
    $orderClause LIMIT $firstItem, $perPage";
    $pageTitle = "客服單列表 第 $page 頁";
} else {
    $sql = "SELECT id, title, description, user_id, reply, createtime, closetime, status FROM ticket WHERE valid = 1";
    $pageTitle = "客服單列表";
    header("location: tickets.php?page=1&order=1");
}

$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);
$ticketCount = $result->num_rows;
if (isset($_GET["page"])) {
    $ticketCount = $allTicketCount;
}

// //處理表單提交的數據顯示
// if($_SERVER["REQUEST_METHOD"] == "POST"){
//     $selectCategory = $_POST["category"];

//     //根據標題的分類篩選
//     if ($selectCategory) {
//         $sql = "SELECT id, title, description, user_id, reply, createtime, status FROM ticket WHERE title LIKE ? AND valid = 1";
//         $stmt = $conn->prepare($sql);
//         $searchTerm = '%' . $selectCategory . '%';
//         $stmt->bind_param("s", $searchTerm);
//     } else {
//         $sql = "SELECT id, title, description, user_id, reply, createtime, status FROM ticket WHERE valid = 1";
//         $stmt = $conn->prepare($sql);
//     }

//     $stmt->execute();
//     $result = $stmt->get_result();
//     $rows = $result->fetch_all(MYSQLI_ASSOC);
//     $ticketCount = $result->num_rows;
//     $stmt->close();
//     $conn->close();
// }

?>
<!doctype html>
<html lang="zh-Hant">

<head>
    <title><?= $pageTitle ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- css -->
    <?php include("../css.php") ?>
    <?php include("../css_admin.php") ?>
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
    <?php include("../html_admin.php") ?>
    <main class="main-content">
        <!-- 這裡將顯示動態加載的內容 -->
        <div class="container">
            <h1><?= $pageTitle ?></h1>
            <div class="py-2 mb-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <?php if (isset($_GET["search"])) : ?>
                            <a class="btn btn-warning" href="tickets.php"><i class="fa-solid fa-arrow-left"></i></a>
                        <?php endif; ?>
                    </div>
                    <div class="d-flex gap-3">
                        <form action="">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search..." name="search">
                                <button class="btn btn-warning" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </form>
                        <a class="btn btn-warning" href="create_ticket.php"><i class="fa-solid fa-plus"></i></a>
                    </div>
                </div>
            </div>
            <div class="pb-2 d-flex justify-content-between">
                <div>
                    共 <?= $ticketCount ?> 單
                </div>
                <?php if (isset($_GET["page"])) : ?>
                    <div>
                        排序:
                        <div class="btn-group">
                            <a href="?page=<?= $page ?>&order=1" class="btn btn-warning <?php if ($order == 1) echo "active"; ?>">編號<i class="fa-solid fa-arrow-down-1-9"></i></a>

                            <a href="?page=<?= $page ?>&order=2" class="btn btn-warning <?php if ($order == 2) echo "active"; ?>">編號<i class="fa-solid fa-arrow-up-1-9"></i></a>

                            <a href="?page=<?= $page ?>&order=3" class="btn btn-warning <?php if ($order == 3) echo "active"; ?>">尚未回覆</a>

                            <a href="?page=<?= $page ?>&order=4" class="btn btn-warning <?php if ($order == 4) echo "active"; ?>">已回覆</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <!-- <form method="POST" action="" id="filterForm">
                <label for="category">客服分類:</label>
                <select name="category" id="category" onchange="submitForm()">
                    <option value="" href="tickets.php" <?= $selectCategory == '' ? 'selected' : '' ?>>所有分類</option>
                    <option value="營地相關" <?= $selectCategory == '營地相關' ? 'selected' : '' ?>>營地相關</option>
                    <option value="用品租借相關" <?= $selectCategory == '用品租借相關' ? 'selected' : '' ?>>用品租借相關</option>
                    <option value="網站操作相關" <?= $selectCategory == '網站操作相關' ? 'selected' : '' ?>>網站操作相關</option>
                    <option value="費用相關" <?= $selectCategory == '費用相關' ? 'selected' : '' ?>>費用相關</option>
                    <option value="其他" <?= $selectCategory == '其他' ? 'selected' : '' ?>>其他</option>
                </select>
            </form> -->
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
                <?php if (isset($_GET["page"])) : ?>
                    <nav aria-label="Page ">
                        <ul class="pagination pagination-shadow">
                            <?php for ($i = 1; $i <= $pageCount; $i++) : ?>
                                <li class="page-item"><a class="page-link" href="?page=<?= $i ?>&order=<?= $order ?>"><?= $i ?></a></li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            <?php else : ?>
                沒有客訴單
            <?php endif; ?>

        </div>
    </main>
    <!-- js -->
    <?php include("../js.php") ?>
    <?php include("../js_admin.php")?>
    <!-- <script>
        // 用於自動篩選
        function submitForm() {
            document.getElementById('filterForm').submit();
        }
    </script> -->
</body>

</html>