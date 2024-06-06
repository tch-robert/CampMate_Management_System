<?php
require_once("../db_connect.php");
?>
<!doctype html>
<html lang="en">

<head>
    <title>新增會員帳號</title>
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
                    <a href="users.php" class="btn btn_color2"><i class="fa-solid fa-arrow-left"></i> 回使用者列表</a>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="profile-card">
                        <div class="profile-info">
                            <div class="text-center">
                                <h2>新增帳號</h2>
                            </div>
                            <form action="doCreateUser.php" method="post">
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
                                <button class="btn btn_color2" type="submit">送出</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
    <?php include("btn_css.php") ?>
</body>

</html>