<?php
require_once("../db_connect.php");

?>

<!doctype html>
<html lang="en">
    <head>
        <title>Title</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
    </head>

    <body>
       <div class="container">
            <form>
                <div class="mb-2">
                    <label for="" class="form-label">帳號</label>
                    <input type="text" class="form-control">
                </div>
                <div class="mb-2">
                    <label for="" class="form-label">Email</label>
                    <input type="text" class="form-control">
                </div>
                <div class="mb-2">
                    <label for="" class="form-label">密碼</label>
                    <input type="password" class="form-control">
                </div>
                <button class="btn btn-primary" type="submit">送出</button>
            </form>
       </div>
    </body>
</html>
