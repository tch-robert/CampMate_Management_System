<?php
include("session_check_login.php");
require_once("../db_connect.php");


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
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("../css.php") ?>
    <link rel="stylesheet" href="./style/sidebars.css">
        <script src="./style/sidebars.js"></script>
    <style>
        .profile-container {
            /* margin-top: 50px; */
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
        <div class="py-4 d-flex justify-content-center">
            <div class="col-lg-6">
                <a href="campground_list.php" class="btn btn-primary">
                    <i class="fa-solid fa-arrow-left"></i> 返回
                </a>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="profile-card">
                    <div class="profile-info">
                        <div class="text-center">
                            <h2>資料修改</h2>
                        </div>
                        <form action="../campground_owner/ownerDoUpdate.php" method="post">
                            <table class="table table-bordered">
                                <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                <tr>
                                    <th>id</th>
                                    <td>
                                        <input type="hidden" value="<?= $row["id"] ?>">
                                        <?= $row["id"] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>姓名</th>
                                    <td>
                                        <?= $row["name"] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>email</th>
                                    <td>
                                        <?= $row["email"] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>*密碼</th>
                                    <td>
                                        <input type="password" class="form-control" name="password" >
                                    </td>
                                </tr>
                                <tr>
                                    <th>*確認密碼</th>
                                    <td>
                                        <input type="password" class="form-control" name="repassword" value="">
                                    </td>
                                </tr>
                                <tr>
                                    <th>*電話</th>
                                    <td>
                                        <input type="text" class="form-control" name="phone" value="<?= $row["phone"] ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th>*收款帳號</th>
                                    <td>
                                        <input type="text" class="form-control" name="pay_account" value="<?= $row["pay_account"] ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th>*地址</th>
                                    <td>
                                        <input type="text" class="form-control" name="address" value="<?= $row["address"] ?>">
                                    </td>
                                </tr>
                            </table>
                            <button class="btn btn-primary" type="submit">送出</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
 



    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>