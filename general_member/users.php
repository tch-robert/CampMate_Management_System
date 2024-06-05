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
    <title>Users</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("../css.php") ?>
    <style>
        .pagination{
            color: red;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="py-3 mb-1">
            <h3><?= $pageTitle ?></h3>
            <div class="d-flex justify-content-between gap-1">
                <div>
                    <?php if (isset($_GET["search"])) : ?>
                        <a class="btn btn-success" href="users.php"><i class="fa-solid fa-angles-left"></i></a>
                    <?php endif; ?>
                </div>
                <div class="d-flex gap-3">
                    <div style="font-size: 15pt;">共 <?= $usercount ?>人</div>
                    <form action="">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search..." name="search">
                            <button class="btn btn-success" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </form>
                    <a class="btn btn-success" href="create_users.php"><i class="fa-solid fa-user-plus"></i></a>
                </div>
            </div>
            <?php if (isset($_GET["page"])) : ?>
                <div>
                    排序:
                    <div class="btn-group">
                        <a href="?page=<?= $page ?>&order=1" class="btn btn-success">id<i class="fa-solid fa-arrow-down-short-wide"></i></a>
                        <a href="?page=<?= $page ?>&order=2" class="btn btn-success">id<i class="fa-solid fa-arrow-down-wide-short"></i></a>
                    </div>
                <?php endif; ?>
                </div>
        </div>
    </div>
    <?php if ($result->num_rows > 0) : ?>
        <table class="table table-success table-striped">
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
                                <a class="btn btn-primary" href="user.php?id=<?= $user["id"] ?>" title="預覽使用者"><i class="fa-regular fa-eye"></i></a>
                                <a href="user-delete.php?id=<?= $user["id"] ?>" class="btn btn-danger"><i class="fa-solid fa-trash" title="刪除使用者"></i></a>
                            </div>


                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php if (isset($_GET["page"])) : ?>
            <div>
                <nav aria-label="Page navigation example">
                    <ul class="pagination  mb-2">
                        <?php for ($i = 1; $i <= $pageCount; $i++) : ?>
                            <li class="page-item 
                        <?php if ($i == $page) echo "active" ?>
                        "><a class="page-link" href="?page=<?= $i?>&order=<?= $order ?>"><?= $i ?></a></li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </div>
            
        <?php endif; ?>
    <?php else : ?>
        沒有使用者資料
    <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>