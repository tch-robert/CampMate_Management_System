<?php
session_start();
?>
<!doctype html>
<html lang="en">

<head>
    <title>後台系統登入</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("../css.php") ?>
    <style>
        body {
            background-image: url("../images/desc_Fezzn6PPHHyHdj.jpg");
            background-size: cover;
            background-repeat: no-repeat;
        }

        .login-panel {
            width: 400px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .logo {
            display: block;
            margin: 0 auto 20px;
            width: 200px;
            height: auto;
        }

        .form-signin .form-floating:focus-within {
            z-index: 2;
        }

        .form-signin input[type="username"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
    </style>
</head>

<body>
    <div class="vh-100 d-flex justify-content-center align-items-center">
        <div class="login-panel">
            <img src="../images/logo-search-grid-1x.png" alt="" class="logo">
            <h3 class="h4 mt-2 text-center">會員登入</h3>
            <?php if (isset($_SESSION["errorTimes"]) && $_SESSION["errorTimes"] >= 5) : ?>
                <div class="text text-red text-center h3 my-3">登入次數過多 請稍後再試</div>
            <?php else : ?>
                <form action="doLoginUser.php" method="post">
                    <div class="input-area form-signin">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="floatingEamil" placeholder="" name="username">
                            <label for="floatingEamil">Username</label>
                        </div>
                        <div class="form-floating">
                            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
                            <label for="floatingPassword">密碼</label>
                        </div>
                    </div>
                    <?php if (isset($_SESSION["errorMsg"])) : ?>
                        <div class="text-danger">
                            <?= $_SESSION["errorMsg"] ?>
                        </div>
                    <?php
                        unset($_SESSION["errorMsg"]);
                    endif; ?>
                    <div class="form-check my-3">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                        <label class="form-check-label" for="flexCheckChecked">
                            記住我
                        </label>
                    </div>
                    <div class="d-grid mb-2">
                        <button class="btn btn-warning" type="submit">登入</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>

    </div>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>