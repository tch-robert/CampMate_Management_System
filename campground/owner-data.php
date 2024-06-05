<?php
include("session_check_login.php");
require_once("../db_connect.php");

// if (!isset($_GET["id"])) {
//     $id = 1;
// } else {
//     $id = $_GET["id"];
// }

$sql = "SELECT * FROM campground_owner WHERE id = $owner_id AND valid=1";
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
    <link rel="stylesheet" href="./style/sidebars.css">
        <script src="./style/sidebars.js"></script>
    
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
    <?php include("title.php") ?>
    <div class="d-flex">
    <?php include("sidebar.php") ?>
    <div class="container profile-container">
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
                                    <th>姓名</th>
                                    <td><?= $row["name"] ?></td>
                                </tr>
                                <tr>
                                    <th>email</th>
                                    <td><?= $row["email"] ?></td>
                                </tr>
                                <tr>
                                    <th>電話</th>
                                    <td><?= $row["phone"] ?></td>
                                </tr>
                                <tr>
                                    <th>收款帳號</th>
                                    <td><?= $row["pay_account"] ?></td>
                                </tr>
                                <tr>
                                    <th>地址</th>
                                    <td><?= $row["address"] ?></td>
                                </tr>
                                <tr>
                                    <th>建立時間</th>
                                    <td><?= $row["created_at"] ?></td>
                                </tr>
                            </table>
                            <div class="py-2 d-flex justify-content-between">
                                <a class="btn btn-primary" href="owner-update.php" title="編輯營地主">編輯 <i class="fa-solid fa-pen-to-square"></i></a>
                            </div>
                        <?php else : ?>
                            <h1>營地主不存在</h1>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <?php include("../js.php") ?>
</body>

</html>