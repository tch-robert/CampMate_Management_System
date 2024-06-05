<?php
include("session_check_login.php");
require_once("../db_connect.php");

if(!isset($_GET["area_id"])){
    echo "請循正常管道進入";
    exit;
}

$camp_id = $_GET["camp_id"];
$area_id = $_GET["area_id"];

$sql = "SELECT * FROM camp_area WHERE id=$area_id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();


$sqlCamp =  "SELECT * FROM campground_info WHERE id=$camp_id";
$resultCamp = $conn->query($sqlCamp);
$rowCamp = $resultCamp->fetch_assoc();
$camp_name = $rowCamp["campground_name"];

if($result->num_rows > 0){
    $areaExist=true;
    $title=$camp_name." > ".$row["area_name"];
}else{
    $areaExist=false;
    $title="營區不存在";
}


?>
<!doctype html>
<html lang="en">
    <head>
        <title><?=$title?></title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <?php include("../css.php")?>
        <link rel="stylesheet" href="./style/sidebars.css">
        <script src="./style/sidebars.js"></script>

        <style>
            table td,
            table th {
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
            }

            .card {
            border-radius: .5rem;
            }
        </style>
    </head>

    <body>
        <!-- Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteModalLabel">確認刪除</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                確認刪除營區?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                <a href="camp_area_delete.php?camp_id=<?=$camp_id?>&area_id=<?=$row["id"]?>" class="btn btn-danger">確認</a>
            </div>
            </div>
        </div>
        </div>
        <?php include("title.php") ?>
        <div class="d-flex">
            <?php include("sidebar.php") ?>

            <div class="container">
            
            <div class="row justified-content-center">
                <div class="col-lg-12">
                    <?php if($areaExist):?>
                        <div class="card">
                        <div class="card-body">
                        <h4 class="mb-3"><?=$title?></h4>
                        <div class="py-2">
                            <a href="camp_area_list.php?camp_id=<?=$camp_id?>" class="btn btn-primary">
                            <i class="fa-solid fa-backward"></i>
                                回營區列表
                            </a>
                        </div>
                            <div class="d-flex justify-content-end">
                            <a class="btn btn-primary" title="營區圖片" href="area_img_upload.php?camp_id=<?=$camp_id?>&area_id=<?=$row['id']?>">營區圖片 <i class="fa-regular fa-image"></i></a>
                            </div>
                        
                            <table class="table table-hover mb-3">
                                <tr>
                                    <th>所屬營地</th>
                                    <td><?=$camp_name ?></td>
                                </tr>
                                <tr>
                                    <th>營區名稱</th>
                                    <td><?=$row["area_name"]; ?></td>
                                </tr>
                                <tr>
                                    <th>營地類型</th>
                                    <td><?=$row["area_category"]; ?></td>
                                </tr>
                                <tr>
                                    <th>價格/日</th>
                                    <td><?=$row["price_per_day"]; ?></td>
                                </tr>
                        
                            </table>

                            <div class="py-3 d-flex justify-content-around">
                            <div class="d-flex justify-content-start gap-3">
                                
                                <a class="btn btn-warning" title="編輯營地" href="edit_camp_area.php?camp_id=<?=$camp_id?>&area_id=<?= $row["id"]?>">Edit <i class="fa-solid fa-pen-to-square"></i></a>
                                
                            </div>
                                <button href="" title="刪除營區" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                >刪除營區 <i class="fa-solid fa-trash-can"></i></button>
                            </div>
                            <?php else : ?>
                                <h1>營區不存在</h1>
                            <?php endif ?>
                        </div>
                        </div>
                
            
                </div>
            </div>
        </div>

        </div>


        <?php include("../js.php")?>
    </body>
</html>
