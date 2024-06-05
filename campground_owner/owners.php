<?php
require_once("../db_connect.php");

$sqlAll = "SELECT * FROM campground_owner WHERE valid = 1";
$resultAll = $conn->query($sqlAll);
$allOwnerCount = $resultAll->num_rows;

if (isset($_GET["search"])) {
    $search = $_GET["search"];
    $sql = "SELECT id, name, email, phone FROM campground_owner WHERE name LIKE '%$search%' AND valid = 1";
    $pageTitle = "$search 的搜尋結果";
} else if (isset($_GET["page"]) && isset($_GET["order"])) {
    $page = $_GET["page"];
    $perPage = 5;
    $firstItem = ($page - 1) * $perPage;
    $pageCount = ceil($allOwnerCount / $perPage);

    $order = $_GET["order"];

    switch ($order) {
        case 1:
            $orderClause = "ORDER BY id ASC";
            break;
        case 2:
            $orderClause = "ORDER BY id DESC";
            break;
        case 3:
            $orderClause = "ORDER BY name ASC";
            break;
        case 4:
            $orderClause = "ORDER BY name DESC";
            break;
    }
    $sql = "SELECT * FROM campground_owner WHERE valid=1
    $orderClause LIMIT $firstItem, $perPage";
    $pageTitle = "營地主列表 第 $page 頁";
} else {
    $sql = "SELECT id, name, email, phone FROM campground_owner WHERE valid = 1";
    $pageTitle = "營地主列表";
    header("location: owners.php?page=1&order=1");
}

$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);
$ownerCount = $result->num_rows;
if (isset($_GET["page"])) {
    $ownerCount = $allOwnerCount;
}

?>
<!doctype html>
<html lang="en">

<head>
    <title><?= $pageTitle ?></title>
    <!-- Required meta tags -->
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
        <!-- 這裡將顯示其他頁面的內容 -->
        <div class="container">
            <h1><?= $pageTitle ?></h1>
            <div class="py-2 mb-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <?php if (isset($_GET["search"])) : ?>
                            <a class="btn btn-warning" href="owners.php"><i class="fa-solid fa-arrow-left"></i></a>
                        <?php endif; ?>
                    </div>
                    <div class="d-flex gap-3">
                        <form action="">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search..." name="search">
                                <button class="btn btn-warning" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </form>
                        <a class="btn btn-warning" href="create-owner.php"><i class="fa-solid fa-user-plus"></i></a>
                    </div>
                </div>
            </div>
            <div class="pb-2 d-flex justify-content-between">
                <div>
                    共 <?= $ownerCount ?> 人
                </div>
                <?php if (isset($_GET["page"])) : ?>
                    <div>
                        排序:
                        <div class="btn-group">
                            <a href="?page=<?= $page ?>&order=1" class="btn btn-warning <?php if ($order == 1) echo "active"; ?>">id<i class="fa-solid fa-arrow-down-1-9"></i></a>

                            <a href="?page=<?= $page ?>&order=2" class="btn btn-warning <?php if ($order == 2) echo "active"; ?>">id<i class="fa-solid fa-arrow-up-1-9"></i></a>

                            <a href="?page=<?= $page ?>&order=3" class="btn btn-warning <?php if ($order == 3) echo "active"; ?>">姓名<i class="fa-solid fa-arrow-down-a-z"></i></a>

                            <a href="?page=<?= $page ?>&order=4" class="btn btn-warning <?php if ($order == 4) echo "active"; ?>">姓名<i class="fa-solid fa-arrow-up-a-z"></i></a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <?php if ($result->num_rows > 0) : ?>
                <table class="table table-custom table-hover">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>姓名</th>
                            <th>email</th>
                            <th>電話</th>
                            <th>檢視</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $user) : ?>
                            <tr>
                                <td scope="row"><?= $user["id"] ?></td>
                                <td><?= $user["name"] ?></td>
                                <td><?= $user["email"] ?></td>
                                <td><?= $user["phone"] ?></td>
                                <td><a class="btn btn-warning" href="owner.php?id=<?= $user["id"] ?>"><i class="fa-solid fa-eye"></i></a></td>
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
                沒有營地主
            <?php endif; ?>

        </div>
    </main>
    <!-- js -->
    <?php include("../js.php") ?>


</body>

</html>