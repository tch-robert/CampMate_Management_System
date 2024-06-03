<?php
session_start();
if (isset($_SESSION["owner"])) {
    header("location: .php");
    exit;
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
    <style>
        body {
            background: url('https://via.placeholder.com/1920x1080') no-repeat center center fixed;
            background-size: cover;
        }
        .login-panel {
            width: 400px;
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
    <div class="vh-100 d-flex justify-content-center align-items-center">
        <div class="login-panel">
            <img src="../images/logo-search-grid-1x.png" alt="" class="logo">
            <h1 class="h2 mt-2 text-center">營地主登入</h1>
            <form action="doLogin.php" method="post">
                <div class="input-area">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="floatingEamil" placeholder="" name="email">
                        <label for="floatingEamil">Email</label>
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
                <?php unset($_SESSION["errorMsg"]);
                endif; ?>
                <div class="form-check my-3">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked >
                    <label class="form-check-label" for="flexCheckChecked">
                        記住我
                    </label>
                </div>
                <div class="d-grid mb-2">
                    <a class="btn btn-warning" type="submit">登入</a>
                </div>
                <div class="d-grid mb-2">
                    <a class="btn btn-warning" href="owner-signup.php"><i class="fa-solid fa-user-plus"></i> 註冊</a>
                </div>
            </form>
        </div>
    </div>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>