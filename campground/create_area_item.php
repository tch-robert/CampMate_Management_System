<?php
require_once("../db_connect.php");
include("session_check_login.php");

if(!isset($_GET["area_id"])){
    $data=[
        "status" => 0,
        "message"=> "請循正常管道進入"
    ];
    echo json_encode($data);
    exit;
}

$camp_id = $_GET["camp_id"];
$area_id = $_GET["area_id"];
?>


<!doctype html>
<html lang="en">
    <head>
        <title>新增營地</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />
        <?php include("../css.php"); ?>
        <link rel="stylesheet" href="./style/sidebars.css">
        <script src="./style/sidebars.js"></script>
        <style>
           
        </style>
    </head>

    <body>
    <div class="modal fade" tabindex="-1" id="infoModal">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">新建商品成功</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">取消</button>
            </div>
            <div class="modal-body">
                <p id="infoMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">確認</button>
            </div>
            </div>
        </div>
        </div>
        

        <?php include("title.php") ?>
        <div class="d-flex">
            <?php include("sidebar.php") ?>
            <div class="container  ms-5">
                <h4 class="mb-3">請輸入商品資料</h4>
                <form action="doCreateItem.php?camp_id=<?=$camp_id?>&area_id=<?=$area_id?>" method="post" enctype="multipart/form-data">
                <div class="row p-4" style="" >
                
                        <div class="col-12 mb-3">
                        
                        <label for="item_name" class="form-label ">*商品名稱</label>
                        <input type="text" class="form-control" id="item_name" name="item_name">
                        
                        </div>

                        
    
                        <div class="col-md-6 mb-3">

                            <label for="price" class="form-label">價格/日</label>
                            <input type="text" class="form-control" id="price" name="price">
                           
                        </div>

                        <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">營地類型</label>
                        <select class="form-select" id="status" name="status">
                            <option selected>*請選擇商品狀態</option>
                            <option value="上架中">上架中</option>
                            <option value="下架中">下架中</option>
                            <option value="維修中">維修中</option>
                        </select>
                        </div>

                        <div class="col-md-6 mb-3">

                        <label for="file" class="form-label">商品主要圖片</label>
                        <input type="file" class="form-control" id="file" name="file">

                        </div>


                        <div class="col-md-12 d-flex justify-content-between">
                            <a class=" btn btn-primary btn-lg" href="area_item_list.php?camp_id=<?=$camp_id?>&area_id=<?=$area_id?>">返回商品列表</a>
                            <button class=" btn btn-primary btn-lg" type="submit">送出</button>
                        </div>

                </div>
                </form>
            </div>

        
        </div>

        
        <?php include("../js.php") ?>
        <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
        <script src="https://cdn.ckeditor.com/ckeditor5/latest/builds/ckeditor.js"></script>

        <script>


        </script>
    </body>
</html>