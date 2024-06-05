<!doctype html>
<html lang="en">
    <head>
        <title>後台Sign-in</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <?php include("../css.php") ?>
        <style>
            body{
                background-image:url("../images/desc_Fezzn6PPHHyHdj.jpg");
                background-size: cover;
                background-repeat: no-repeat;
            }
            form{
                color: #fff;
            }
        </style>
    </head>

    <body>
        <div class="vh-100 d-flex justify-content-center align-items-center">
            <form action="">
                <div class="input-area">
                    <div class="from-floating">
                        <label for="" class="form-label word">帳號</label>
                        <input type="text" class="form-control" name="account">
                    </div>
                    <div class="from-floating">
                        <label for="floatingInput"class="form-label word">密碼</label>
                        <input type="password" class="form-control" name="password">
                    </div>
                </div>
                <div class="form-check my-3 text-white">
                    <input class="form-check-input" type="checkbox" value="">
                    <label class="form-check-label" for="flexCheckChecked">
                        Remember me
                    </label>
                </div>
                <div>
                    <button class="btn btn-success" type="submit">登入</button>
                </div>
            </form>
        </div>
        <!-- Bootstrap JavaScript Libraries -->
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
