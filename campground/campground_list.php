<?php
require_once("../db_connect.php");

$sql="SELECT * FROM campground_info";

$result = $conn->query($sql);
$rows=$result->fetch_all(MYSQLI_ASSOC);



?>
<pre>
    <?php print_r($rows); ?>
</pre>

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

        <?php include("../css.php"); ?>
        <link rel="stylesheet" href="./style/sidebars.css">
        <script src="./style/sidebars.js"></script>
    </head>

    <body>
        <h1>營地主後台</h1>
        <hr>
        <div class="d-flex">
            <div class="sidebar p-3" style="width: 280px;">
                <a href="#" class="d-flex align-items-center pb-3 mb-3 link-body-emphasis text-decoration-none border-bottom">
                <svg class="bi pe-none me-2" width="30" height="24"><use xlink:href="#bootstrap"></use></svg>
                <span class="fs-5 fw-semibold">CAMPMATE</span>
                </a>
                <ul class="list-unstyled ps-0">
                <li class="mb-1">
                    <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="true">
                    個人營地管理
                    </button>
                    <div class="collapse show" id="home-collapse" >
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="create_campground_info.php" class="link-body-emphasis d-inline-flex text-decoration-none rounded">營地</a></li>
                        <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">營區</a></li>
                    </ul>
                    </div>
                </li>
                <li class="mb-1">
                    <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
                    訂單管理
                    </button>
                    <div class="collapse" id="dashboard-collapse" style="">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">自家訂單</a></li>
                        <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">營地主訂單</a></li>
                    </ul>
                    </div>
                </li>
                </ul>
            </div>
        </div>   
        <?php include("../js.php"); ?>
    </body>
</html>
