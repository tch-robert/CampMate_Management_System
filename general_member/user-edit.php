<?php

if (isset($_GET["id"])) {
    $id = 1;
} else {
    $id = $_GET["id"];
}

require_once("../db_connect.php");

$sql = "SELECT * FROM users WHERE id = $id AND valid=1";
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
            <a href="user.php?id=<?= $row["id"] ?>" class="btn btn-success"><i class="fa-solid fa-angles-left"></i> 回使用者</a>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-6">
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
                            <th>Photo</th>
                            <td>
                                <div>
                                    <img src="../images/<?=$row["photo"]?>" alt="<?=$row["id"]?>" class="rounded mx-auto d-block" alt="">
                                </div>
                                <label for="formFile" class="form-label"></label>
                                <input class="form-control" type="file" id="formFile">
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
                    <button class="btn btn-success" type="submit">送出</button>
                </form>

            </div>
        </div>

    </div>
</body>
<script>
    var myModal = document.getElementById('myModal')
    var myInput = document.getElementById('myInput')

    myModal.addEventListener('shown.bs.modal', function() {
        myInput.focus()
    })
</script>

</html>