<!doctype html>
<html lang="en">

<head>
    <title>營地主註冊</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <?php include("../css.php") ?>
  
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4">
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
                    <div class="mb-2">
                        <label for="" class="form-label">*地址</label>
                        <input type="text" class="form-control" name="address">
                    </div>
                    <button type="submit" class="btn btn-warning">
                        送出
                    </button>

                </form>
            </div>
        </div>
    </div>
</body>

</html>