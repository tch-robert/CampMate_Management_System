<?php
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
        <?php include("../css.php"); ?>
        <link rel="stylesheet" href="./style/sidebars.css">
        <script src="./style/sidebars.js"></script>
    </head>

    <body>
        <div class="container">
        <h1>營地主後台</h1>
        <hr>
        <main class="d-flex ">
            <div class="p-3" style="width: 280px;">
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
                        <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">營地</a></li>
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


            <div class="container">
                <h4 class="mb-3">請填寫營地基本資料</h4>
                <form action="" method="post">
                <div class="row" style="margin-right: 0;">
                    <div class="col-12">
                    <label for="campground_name" class="form-label ">*營地名稱</label>
                    <input type="text" class="form-control mb-3" id="campground_name" name="campground_name">
                    </div>

                    <div class="col-12">
                    <label for="email" class="form-label">*Email</label>
                    <input type="email" class="form-control mb-3" id="email" name="email">
                    <div class="invalid-feedback">
                        Please enter a valid email address for shipping updates.
                    </div>
                    </div>

                    <div class="col-12">
                    <label for="address" class="form-label">*地址</label>
                    <input type="text" class="form-control mb-3" id="address" name="address">
                    <div class="invalid-feedback">
                        Please enter your shipping address.
                    </div>
                    </div>

                    <div class="col-12">
                    <label for="phone" class="form-label">*電話</label>
                    <input type="tel" class="form-control mb-3" id="phone" name="phone">
                    <div class="invalid-feedback">
                        Please enter your shipping address.
                    </div>
                    </div>

                    <div class="col-md-6">
                    <label for="position" class="form-label">營地所在區域</label>
                    <select class="form-select mb-3" id="position" name="position">
                        <option selected>*請選擇所在區域</option>
                        <option value="1">北部</option>
                        <option value="2">中部</option>
                        <option value="3">南部</option>
                        <option value="4">東部</option>
                    </select>
                    <div class="invalid-feedback">
                        Please select a valid country.
                    </div>
                    </div>

                    <div class="col-md-6">
                        <label for="altitude" class="form-label">海拔</label>
                        <input type="text" class="form-control mb-3" id="altitude" name="altitude">
                        <div class="invalid-feedback">
                            Please enter your shipping address.
                        </div>
                    </div>

                    <div class="col-md-6">
                    <label for="longitude" class="form-label">經度</label>
                    <input type="text" class="form-control mb-3" id="longitude" name="longitude">
                    <div class="invalid-feedback">
                        Name on card is required
                    </div>
                    </div>

                    <div class="col-md-6">
                    <label for="latitude" class="form-label">緯度</label>
                    <input type="text" class="form-control mb-3" id="latitude" name="latitude">
                    <div class="invalid-feedback">
                        Credit card number is required
                    </div>
                    </div>

                    <div class="col-12 mb-3">
                    <label for="formFileMultiple" class="form-label">Multiple files input example</label>
                    <input class="form-control" type="file" id="formFileMultiple" multiple>
                    </div>

                </div>


                <hr class="my-4">
                <div class="text-end">
                    <button class=" btn btn-primary btn-lg" type="submit">提交</button>
                </div>
                </form>
            </div>

        </main>
        </div>
        
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
