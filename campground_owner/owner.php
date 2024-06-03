<?php
require_once("../db_connect.php");

if (!isset($_GET["id"])) {
    $id = 1;
} else {
    $id = $_GET["id"];
}

$sql = "SELECT * FROM campground_owner WHERE id = $id AND valid=1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($result->num_rows > 0) {
    $ownerExit = true;
    $title = $row["name"];
} else {
    $ownerExit = false;
    $title = "營地主不存在";
}

function formatPayAccount($pay_account) {
    if (strlen($pay_account) > 3) {
        return substr($pay_account, 0, 3) . '-' . substr($pay_account, 3);
    }
    return $pay_account;
}

?>
<!doctype html>
<html lang="en">
    <head>
        <title><?= $title ?></title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <?php include("../css.php") ?>

    </head>

    <body>
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLable" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteModalLable">確認刪除</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    確認刪除營地主?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                    <a href="owner-delete.php?id=<?= $row["id"] ?>" class="btn btn-danger">確認</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="py-2">
            <a class="btn btn-warning" href="owners.php"><i class="fa-solid fa-arrow-left"></i> 回營地主列表</a>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <?php if ($ownerExit) : ?>
                    <table class="table table-bordered">
                        <tr>
                            <th>id</th>
                            <td><?= $row["id"] ?></td>
                        </tr>
                        <tr>
                            <th>name</th>
                            <td><?= $row["name"] ?></td>
                        </tr>
                        <tr>
                            <th>email</th>
                            <td><?= $row["email"] ?></td>
                        </tr>
                        <tr>
                            <th>phone</th>
                            <td><?= $row["phone"] ?></td>
                        </tr>
                        <tr>
                            <th>pay_account</th>
                            <td><?= $row["pay_account"] ?></td>
                        </tr>
                        <tr>
                            <th>address</th>
                            <td><?= $row["address"] ?></td>
                        </tr>
                        <tr>
                            <th>create time</th>
                            <td><?= $row["created_at"] ?></td>
                        </tr>
                    </table>
                    <div class="py-2 d-flex justify-content-between">
                        <a class="btn btn-warning" href="owner-edit.php?id=<?= $row["id"] ?>" title="編輯營地主"><i class="fa-solid fa-pen-to-square"></i></a>

                        <button class="btn btn-danger" title="刪除營地主"
                        data-bs-toggle="modal" data-bs-target="#deleteModal"
                        ><i class="fa-solid fa-trash-can"></i></button>
                    </div>
                <?php else : ?>
                    <h1>營地主不存在</h1>
                <?php endif; ?>
            </div>
        </div>
    </div>

        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
