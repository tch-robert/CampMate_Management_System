<?php
include("session_check_login.php");
require_once("../db_connect.php");

if(!isset($_GET["camp_id"])){
    $data=[
        "status" => 0,
        "message"=> "請循正常管道進入"
    ];
    echo json_encode($data);
    exit;
}

$camp_id = $_GET["camp_id"];

$sql="SELECT * FROM images WHERE campground_id=$camp_id ORDER BY id DESC";
$result = $conn->query($sql);
$rows=$result->fetch_all(MYSQLI_ASSOC);

$sqlCamp= "SELECT * FROM campground_info WHERE id=$camp_id ";
$resultCamp=$conn->query($sqlCamp);
$rowCamp=$resultCamp->fetch_assoc();



$pageTitle=$rowCamp["campground_name"];

?>

<!doctype html>
<html lang="en">
    <head>
        <title><?=$pageTitle?></title>
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
            .c_img{
                border-radius: 10px;
            }
        </style>
    </head>

    <body>

        <h1>營地主後台</h1>
        <hr>
        <div class="d-flex">
            <?php include("sidebar.php") ?>


            <div class="container">
                <h4 class="mb-3"><?=$pageTitle?></h4>
                <div class="row">
                    <form action="doUpload.php?camp_id=<?=$camp_id?>" method="post" id="first_page" enctype="multipart/form-data">

                    <div class="col-12 mb-3">
                        <input type="hidden" class="form-control" name="name">
                    </div>

                    <div class="col-12 mb-3">
                        <label for="form-label" class="form-label">上傳營地照片</label>
                        <input class="form-control" type="file" name="file">
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary" type="submit">送出</button>
                    </div>
                    </form>
                
                    <div class="col-lg-12">
                        <div class="row g-4">
                        <?php foreach($rows as $image): ?>
                            <div class="col-lg-2 col-md-3">
                                <div class="ratio ratio-1x1 mb-3">
                                    <img class="object-fit-cover c_img" src="<?=$image['path']?>" alt="">
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button href="" title="刪除圖片" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                    >Delete <i class="fa-solid fa-trash-can"></i></button>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="deleteModalLabel">確認刪除</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    確認刪除圖片?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                                    <a href="cg_img_delete.php?camp_id=<?=$camp_id?>&img_id=<?= $image["id"]?>" class="btn btn-danger">確認</a>
                                </div>
                                </div>
                            </div>
                            </div>
                        <?php endforeach ?>
                        </div>
                    </div>

                </div>
            </div>
            

        </div>

        
        <?php include("../js.php") ?>
        <script>
            
        </script>
    </body>
</html>