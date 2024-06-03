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

</head>

<body>
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
            <?php if(isset($_GET["page"])): ?>
            <div>
                排序:
                <div class="btn-group">
                    <a href="?page=<?= $page ?>&order=1" class="btn btn-warning <?php if ($order == 1) echo "active"; ?>">id<i class="fa-solid fa-arrow-down-short-wide"></i></i></a>

                    <a href="?page=<?= $page ?>&order=2" class="btn btn-warning <?php if ($order == 2) echo "active"; ?>">id<i class="fa-solid fa-arrow-down-wide-short"></i></i></a>

                    <a href="?page=<?= $page ?>&order=3" class="btn btn-warning <?php if ($order == 3) echo "active"; ?>">姓名<i class="fa-solid fa-arrow-down-short-wide"></i></i></a>

                    <a href="?page=<?= $page ?>&order=4" class="btn btn-warning <?php if ($order == 4) echo "active"; ?>">姓名<i class="fa-solid fa-arrow-down-wide-short"></i></i></a>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php if ($result->num_rows > 0) : ?>
        <table class="table table-bordered">
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
                        <td><?= $user["id"] ?></td>
                        <td><?= $user["name"] ?></td>
                        <td><?= $user["email"] ?></td>
                        <td><?= $user["phone"] ?></td>
                        <td><a class="btn btn-warning" href="owner.php?id=<?= $user["id"] ?>"><i class="fa-solid fa-eye"></i></a></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <?php if (isset($_GET["page"])) : ?>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <?php for ($i = 1; $i <= $pageCount; $i++) : ?>
                        <li class="page-item"><a class="page-link" href="?page=<?= $i ?>&order=<?= $order ?>"><?= $i ?></a></li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>
        <?php else: ?>
            沒有營地主
        <?php endif; ?>

    </div>


    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>