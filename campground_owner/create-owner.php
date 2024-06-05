<!doctype html>
<html lang="en">

<head>
    <title>Create Owner</title>
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
        <div class="container profile-container">
            <div class="py-4 d-flex justify-content-center">
                <div class="col-lg-6">
                    <a class="btn btn-warning" href="owners.php"><i class="fa-solid fa-arrow-left"></i> 回營地主列表</a>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="profile-card">
                        <div class="profile-info">
                            <div class="text-center">
                                <h2>新增營地主</h2>
                            </div>
                            <form action="doCreateOwner.php" method="post">
                                <div class="mb-2">
                                    <label for="" class="form-label">*姓名</label>
                                    <input type="text" class="form-control" name="name">
                                </div>
                                <div class="mb-2">
                                    <label for="" class="form-label">*email</label>
                                    <input type="email" class="form-control" name="email">
                                </div>
                                <div class="mb-2">
                                    <label for="" class="form-label">*電話</label>
                                    <input type="tel" class="form-control" name="phone">
                                </div>
                                <div class="mb-2">
                                    <label for="" class="form-label">*密碼</label>
                                    <input type="password" class="form-control" name="password">
                                </div>
                                <div class="mb-2">
                                    <label for="" class="form-label">*收款帳號</label>
                                    <input type="text" class="form-control" name="pay_account">
                                </div>
                                <div class="mb-2">
                                    <label for="" class="form-label">*地址</label>
                                    <input type="text" class="form-control" name="address">
                                </div>
                                <button class="btn btn-warning" type="submit">送出</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include("../js.php") ?>
</body>

</html>