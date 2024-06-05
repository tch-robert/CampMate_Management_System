<?php
include("session_check_login.php");
require_once("../db_connect.php");

if(!isset($_GET["id"])){
    $id=1;
}else{
    $id = $_GET["id"];
}

$sql = "SELECT * FROM campground_info WHERE id=$id AND campground_owner_id=$owner_id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if($result->num_rows > 0){
    $campExist=true;
    $title=$row["campground_name"];
}else{
    $campExist=false;
    $title="營地不存在";
}

$geoloaction = $row["geolocation"];
if(!empty($geoloaction)){
    $geoArr = preg_split("/[\s,]+/", $geoloaction);
    $longitude = $geoArr[0];
    $latitude = $geoArr[1];
}else{
    $longitude = "";
    $latitude = "";
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
                確認刪除營地?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                <a href="campground_delete.php?id=<?= $row["id"]?>" class="btn btn-danger">確認</a>
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
                    <?php if($campExist):?>
                        <div class="card">
                        <div class="card-body">
                        <div class="mb-2">
                            <a href="campground_list.php" class="btn btn-primary">
                            <i class="fa-solid fa-backward"></i>
                                回營地列表
                            </a>
                        </div>
                            <div class="d-flex justify-content-end">
                            <a class="btn btn-primary" title="編輯營地" href="cg_img_upload.php?camp_id=<?=$row['id']?>">營地圖片 <i class="fa-regular fa-image"></i></a>
                            </div>
                        
                            <table class="table table-hover mb-3">
                                <tr>
                                    <th>id</th>
                                    <td><?=$row["id"]; ?></td>
                                </tr>
                                <tr>
                                    <th>營地名稱</th>
                                    <td><?=$row["campground_name"]; ?></td>
                                </tr>
                                <tr>
                                    <th>email</th>
                                    <td><?=$row["email"]; ?></td>
                                </tr>
                                <tr>
                                    <th>電話</th>
                                    <td><?=$row["phone"]; ?></td>
                                </tr>
                                <tr>
                                    <th>地址</th>
                                    <td><?=$row["address"]; ?></td>
                                </tr>
                                <tr>
                                    <th>海拔</th>
                                    <td><?=$row["altitude"]; ?></td>
                                </tr>
                                <tr>
                                    <th>地區</th>
                                    <td><?=$row["position"]; ?></td>
                                </tr>
                                <tr>
                                    <th>經度</th>
                                    <td><?=$longitude; ?></td>
                                </tr>
                                <tr>
                                    <th>緯度</th>
                                    <td><?=$latitude; ?></td>
                                </tr>
                            </table>

                            <h5>營地介紹</h5>
                            <hr>
                            <?php echo $row["campground_introduction"] ?>
                            <div class="py-3 d-flex justify-content-around">
                                <div class="d-flex justify-content-start gap-3">
                                    
                                    <a class="btn btn-warning" title="編輯營地" href="edit_campground.php?id=<?=$row['id']?>">Edit <i class="fa-solid fa-pen-to-square"></i></a>
                                    
                                </div>
                                <button href="" title="刪除營地" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                >刪除營地 <i class="fa-solid fa-trash-can"></i></button>
                            </div>
                        </div>
                        </div>
                
                
                <?php else : ?>
                    <h1>營地不存在</h1>
                <?php endif ?>
                </div>
            </div>
        </div>

        </div>


        <?php include("../js.php")?>
    </body>
</html>
