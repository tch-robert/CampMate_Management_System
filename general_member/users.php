<?php
require_once("../db_connect.php");

$sqlAll = "SELECT * FROM users WHERE valid = 1";
$resultAll = $conn->query($sqlAll);
$allUserCount = $resultAll->num_rows;
$sql = "";

if (isset($_GET["search"])) {
    $search = $_GET["search"];
    $sql = "SELECT * FROM users WHERE username LIKE '%$search%' AND valid = 1";
    $pageTitle = "$search 搜尋結果";
} else if (isset($_GET["page"]) && isset($_GET["order"])) {
    $page = $_GET["page"];
    $perPage = 8;
    $firstItem = ($page - 1) * $perPage;
    $pageCount = ceil($allUserCount / $perPage);

    $order = $_GET["order"];
    switch ($order) {
        case 1: // id ASC
            $sql = "SELECT * FROM users WHERE valid=1 
            ORDER BY id ASC LIMIT $firstItem, $perPage";
            break;
        case 2: // id DESC
            $sql = "SELECT * FROM users WHERE valid=1 
            ORDER BY id DESC LIMIT $firstItem, $perPage";
            break;
    }

    // $sql = "SELECT * FROM users WHERE valid=1 LIMIT $firstItem, $perPage";
    $pageTitle = "會員資料";
    // echo $sql;
} else {
    $sql = "SELECT id, username, phone, email,created_at FROM users WHERE valid = 1";
    $pageTitle = "會員資料";
    header("location: users.php?page=1&order=1");
}

$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);
$usercount = $result->num_rows;
if (isset($_GET["page"])) {
    $usercount = $allUserCount;
}

?>
<!doctype html>
<html lang="en">

<head>
    <title>會員資料</title>
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
            
        }

        .pagination-shadow .page-item.active .page-link {
            color: white;
            
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>
    <?php include("../index.php") ?>
    <main class="main-content">
        <div class="container">
            <h3><?= $pageTitle ?></h3>
            <div class="py-2 mb-3">
                <div class="d-flex justify-content-between ">
                    
                    <div>
                        <?php if (isset($_GET["search"])) : ?>
                            <a class="btn btn_color2" href="users.php"><i class="fa-solid fa-arrow-left"></i></a>
                        <?php endif; ?>
                    </div>
                    <div class="d-flex gap-3">
                        <form action="">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search..." name="search">
                                <button class="btn btn_color2" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </form>
                        <a class="btn btn_color2" href="create_users.php"><i class="fa-solid fa-user-plus"></i></a>
                    </div>
                </div>
            </div>
            <div class="pb-2 d-flex justify-content-between">
                <div>

                    共 <?= $usercount ?>人
                </div>
                <?php if (isset($_GET["page"])) : ?>
                    <div>
                        排序:
                        <div class="btn-group">
                            <a href="?page=<?= $page ?>&order=1" class="btn btn_color2">id<i class="fa-solid fa-arrow-down-1-9"></i></a>
                            <a href="?page=<?= $page ?>&order=2" class="btn btn_color2">id<i class="fa-solid fa-arrow-up-1-9"></i></a>
                        </div>
                    
                    </div>
                    <?php endif; ?>
            </div>
            <?php if ($result->num_rows > 0) : ?>
                <table class="table table-custom table-hover">
                    <thead>
                        <th scope="col">id</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Create Time</th>
                        <th scope="col"></th>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $user) : ?>
                            <tr>
                                <td scope="row"><?= $user["id"] ?></td>
                                <td scope="row"><?= $user["username"] ?></td>
                                <td scope="row"><?= $user["email"] ?></td>
                                <td scope="row"><?= $user["phone"] ?></td>
                                <td scope="row"><?= $user["created_at"] ?></td>
                                <td scope="row">
                                    <div class="py-1 ">
                                        <a class="btn btn_color2" href="user.php?id=<?= $user["id"] ?>" title="預覽使用者"><i class="fa-solid fa-eye"></i></a>
                                        <a href="user-delete.php?id=<?= $user["id"] ?>" class="btn btn-danger"><i class="fa-solid fa-trash" title="刪除使用者"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if (isset($_GET["page"])) : ?>
                    <div>
                        <nav aria-label="Page ">
                            <ul class="pagination  pagination-shadow">
                                <?php for ($i = 1; $i <= $pageCount; $i++) : ?>
                                    <li class="page-item 
                        <?php if ($i == $page) echo "active" ?>
                        "><a class="page-link" href="?page=<?= $i ?>&order=<?= $order ?>"><?= $i ?></a></li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    </div>

                <?php endif; ?>
            <?php else : ?>
                沒有使用者資料
            <?php endif; ?>
        </div>
    </main>



    <?php include("btn_css.php") ?>
    <?php include("../js.php") ?>
</body>

</html>