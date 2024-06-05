<!doctype html>
<html lang="en">

<head>
    <title>營地主註冊</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <?php include("../css.php") ?>
    <style>
        body {
            background: url('https://via.placeholder.com/1920x1080') no-repeat center center fixed;
            background-size: cover;
        }

        .register-container {
            width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .logo {
            display: block;
            margin: 0 auto 20px;
            width: 200px;
            height: auto;
        }
    </style>

</head>

<body>
    <div class="container">
        <div class="row justify-content-center register-container">
            <div class="">
                <img src="../images/logo-search-grid-1x.png" alt="" class="logo">
                <h1 class="h2 mt-2 text-center">營地主註冊</h1>
                <form action="doSignUpOwner.php" method="post">
                    <div class="mb-2">
                        <label class="form-label" for="">*姓名</label>
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
                        <label class="form-label" for="">*密碼</label>
                        <input type="password" class="form-control" name="password">
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="">*確認密碼</label>
                        <input type="password" class="form-control" name="repassword">
                    </div>
                    <div class="mb-2">
                        <label for="" class="form-label">*收款帳號</label>
                        <input type="text" class="form-control" name="pay_account">
                    </div>
                    <div class="mb-4">
                        <label for="" class="form-label">*地址</label>
                        <input type="text" class="form-control" name="address">
                    </div>
                    <div class="mb-2 d-flex justify-content-between">
                        <a href="owner-signin.php" class="btn btn-secondary">
                            回登入頁面
                        </a>
                        <button type="submit" class="btn btn-warning">
                            送出
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>

</html>