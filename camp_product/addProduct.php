<!doctype html>
<html lang="en">

<head>
    <title>add product</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- 把共通的css叫入 -->
    <?php include("../css.php") ?>

    <style>
        .textAreaDis {
            height: 300px;
            resize: none;
        }

        .textAreaBreif {
            height: 100px;
            resize: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div>
            <ul class="nav nav-underline my-3">
                <li class="nav-item">
                    <a class="nav-link active" href="#">基本資訊</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">規格</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">租賃資訊</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">取貨點 or 運送方式</a>
                </li>
            </ul>
        </div>

        <form action="" method="post">
            <div>

                <div class="row justify-content-end">
                    <h3>基本資訊</h3>
                    <div class="col-11">
                        <div class="mb-2">
                            <label class="form-label">商品圖片</label>
                            <input class="form-control" type="file" multiple>
                        </div>
                        <div class="mb-2">
                            <label class="h6 form-label">商品名稱</label>
                            <input class="form-control" type="text">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">商品分類</label>
                            <input class="form-control" type="text">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">商品描述</label>
                            <textarea class="textAreaDis form-control" name="" id=""></textarea>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-end">
                    <h3>規格</h3>
                    <div class="col-11">
                        <div class="mb-2">
                            <label class="form-label">商品簡述</label>
                            <textarea class="textAreaBreif form-control" name="" id=""></textarea>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-end">
                    <h3>租賃資訊</h3>
                    <div class="col-11">
                        <div class="mb-2">
                            <label class="form-label">商品簡述</label>
                            <textarea class="textAreaBreif form-control" name="" id=""></textarea>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-end">
                    <h3>取貨點</h3>
                    <div class="col-11">
                        <div class="mb-2">
                            <label class="form-label">商品簡述</label>
                            <textarea class="textAreaBreif form-control" name="" id=""></textarea>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3 mb-5">
                    <button type="submit" class="btn btn-primary">取消</button>
                    <button type="submit" class="btn btn-primary">儲存並下架</button>
                    <button type="submit" class="btn btn-primary">儲存並上架</button>
                </div>
            </div>
        </form>
    </div>

    <!-- 把共通的js叫入 -->
    <?php include("../js.php") ?>
</body>

</html>