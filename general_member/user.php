<?php

if (!isset($_GET["id"])) {
    $id = 1;
} else {
    $id = $_GET["id"];
}

require_once("../db_connect.php");
$sql = "SELECT * FROM users WHERE id = $id";
// echo $sql;
$result = $conn->query($sql);
$row = $result->fetch_assoc();
// var_dump($row);
?>
<!doctype html>
<html lang="en">

<head>
    <title><?= $row["username"] ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("../css.php") ?>
</head>

<body>
    <div class="container">
        <div class="py-2">
            <h3><?= $row["username"] ?>資料</h3>
            <a href="users.php" class="btn btn-success"><i class="fa-solid fa-angles-left"></i> 回使用者列表</a>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <table class="table table-success table-striped">
                    <tr>
                        <th>id</th>
                        <td><?= $row["id"] ?></td>
                    </tr>
                    <tr>
                        <th>photo</th>
                        <td><?= $row["photo"] ?></td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td><?= $row["username"] ?></td>
                    </tr>
                    <tr>
                        <th>Password</th>
                        <td><?= $row["password"] ?></td>
                    </tr>
                    <tr>
                        <th>ID Number</th>
                        <td><?= $row["password"] ?></td>
                    </tr>
                    <tr>
                        <th>Birth Date</th>
                        <td><?= $row["birth_date"] ?></td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td><?= $row["phone"] ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?= $row["email"] ?></td>
                    </tr>
                </table>
                <div class="py-2">
                    <a class="btn btn-success" href="user-edit.php?id=<?= $row["id"] ?>" title="編輯使用者"><i class="fa-solid fa-pen-to-square"></i></a>
                </div>
            </div>
        </div>

    </div>
</body>

</html>