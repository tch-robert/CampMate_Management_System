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


?>
<!doctype html>
<html lang="en">

<head>
    <title><?= $title ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("../css.php") ?>

    <style>
        .profile-container {
            margin-top: 50px;
        }

        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            background-color: #ffffff;
            padding: 30px;
        }

        .profile-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
        }

        .profile-info table {
            width: 100%;
        }

        .profile-info th,
        .profile-info td {
            padding: 10px 15px;
        }

        .profile-info th {
            background-color: #f8f9fa;
            text-align: left;
            width: 30%;
        }

        .profile-info td {
            background-color: #ffffff;
            text-align: left;
        }
    </style>

</head>

<body>
    <?php include("../index.php") ?>
    <main class="main-content">
        <!-- 這裡將顯示動態加載的內容 -->
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

        <div class="container profile-container">
            <div class="py-4 d-flex justify-content-center">
                <div class="col-lg-6">
                    <a class="btn btn_color2" href="owners.php"><i class="fa-solid fa-arrow-left"></i> 回營地主列表</a>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="profile-card">
                        <div class="profile-info">
                            <div class="text-center">
                                <h2>營地主資料</h2>
                            </div>
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
                                    <a class="btn btn_color2" href="owner-edit.php?id=<?= $row["id"] ?>" title="編輯營地主">編輯 <i class="fa-solid fa-pen-to-square"></i></a>

                                    <button class="btn btn-danger" title="刪除營地主" data-bs-toggle="modal" data-bs-target="#deleteModal">刪除 <i class="fa-solid fa-trash-can"></i></button>
                                </div>
                            <?php else : ?>
                                <h1>營地主不存在</h1>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <!-- button的css -->
    <?php include("btn_css.php"); ?>

    <?php include("../js.php") ?>
</body>

</html>