<?php
require_once("../db_connect.php");

if (!isset($_GET["id"])) {
    $id = 1;
} else {
    $id = $_GET["id"];
}



$sql = "SELECT * FROM users WHERE id = $id AND valid=1";
// echo $sql;
$result = $conn->query($sql);
$row = $result->fetch_assoc();
// var_dump($row);

if ($result->num_rows > 0) {
    $userExit = true;
    $title = $row["id"];
} else {
    $userExit = false;
    $title = "使用者不存在";
}

?>
<!doctype html>
<html lang="en">

<head>
    <title><?= $row["username"] ?></title>
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
        <div class="container profile-container">
            <div class="py-4 d-flex justify-content-center">
                <div class="col-lg-6">
                    <a href="user.php?id=<?= $row["id"] ?>" class="btn btn-warning"><i class="fa-solid fa-arrow-left"></i> 回使用者</a>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="profile-card">
                        <div class="profile-info">
                            <div class="text-center">
                                <h2><?= $row["username"] ?>資料</h2>
                            </div>
                            <form action="doUpdateUser.php" method="post">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Id</th>
                                        <td name="id">
                                            <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                            <?= $row["id"] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Username</th>
                                        <td>
                                            <input type="text" class="form-control" name="username" value="<?= $row["username"] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Password</th>
                                        <td>
                                            <input type="text" class="form-control" name="password" value="<?= $row["password"] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>ID Number</th>
                                        <td>
                                            <input type="text" class="form-control" name="id_number" value="<?= $row["id_number"] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Birth Date</th>
                                        <td>
                                            <input type="text" class="form-control" name="birth_date" value="<?= $row["birth_date"] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td>
                                            <input type="text" class="form-control" name="phone" value="<?= $row["phone"] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>
                                            <input type="text" class="form-control" name="email" value="<?= $row["email"] ?>">
                                        </td>
                                    </tr>
                                </table>
                                <button class="btn btn-warning" type="submit">送出</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </main>

</body>

</html>