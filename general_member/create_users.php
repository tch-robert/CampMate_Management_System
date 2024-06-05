<?php
require_once("../db_connect.php");
?>
<!doctype html>
<html lang="en">

<head>
    <title>create user</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <?php include("../css.php") ?>
</head>

<body>
    <div class="container py-5">
        <div class="py-2">
            <a href="users.php" class="btn btn-success"><i class="fa-solid fa-angles-left"></i> 回使用者列表</a>
        </div>
        <form action="doCreateUser.php" method="post">
            <div class="mb-2">
                <div>
                    <img src="../images/25.png" class="rounded mx-auto d-block" alt="">
                </div>
                <label for="formFileSm" class="form-label">Photo</label>
                <input class="form-control form-control-sm" id="formFileSm" type="file" name="photo">
            </div>
            <div class="mb-2">
                <label for="" class="form-label">*Name</label>
                <input type="text" class="form-control" name="username">
            </div>
            <div class="mb-2">
                <label for="" class="form-label">*Password</label>
                <input type="password" class="form-control" name="password">
                <div class="form-text">請輸入4~20字元的密碼</div>
            </div>
            <div class="mb-2">
                <label for="" class="form-label">*ID Number</label>
                <input type="text" class="form-control" name="id_number">
            </div>
            <div class="mb-2">
                <label for="" class="form-label">Birth Date</label>
                <input type="text" class="form-control" name="birth_date">
            </div>
            <div class="mb-2">
                <label for="" class="form-label">*Phone</label>
                <input type="text" class="form-control" name="phone">
            </div>
            <div class="mb-2">
                <label for="" class="form-label">Email</label>
                <input type="text" class="form-control" name="email">
            </div>

            <button class="btn btn-success" type="submit">送出</button>
        </form>
    </div>
</body>

</html>