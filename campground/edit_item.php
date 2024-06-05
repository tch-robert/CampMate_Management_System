<?php
include("session_check_login.php");
require_once("../db_connect.php");

if(!isset($_GET["item_id"])){
    echo "請循正常管道進入";
    exit;
}

$camp_id = $_GET["camp_id"];
$area_id = $_GET["area_id"];
$item_id = $_GET["item_id"];

$sql = "SELECT camp_area_item.*, area_item.item_name AS itemName, area_item.price AS itemPrice, area_item.path AS itemPath, camp_area.area_name AS areaName FROM camp_area_item
JOIN area_item ON camp_area_item.item_id = area_item.id 
JOIN camp_area ON camp_area_item.area_id = camp_area.id
WHERE camp_area_item.item_id = $item_id AND area_item.valid=1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();


$sqlCamp =  "SELECT campground_info.*, camp_area.area_name AS areaName FROM campground_info 
JOIN camp_area ON campground_info.id = camp_area.campground_id 
WHERE camp_area.id=$area_id";

$resultCamp = $conn->query($sqlCamp);
$rowCamp = $resultCamp->fetch_assoc();
$camp_name = $rowCamp["campground_name"];
$area_name = $rowCamp["areaName"];


if($result->num_rows > 0){
    $areaExist=true;
    $title=$camp_name." > ".$area_name;
}else{
    $areaExist=false;
    $title="商品不存在";
}


?>
<!doctype html>
<html lang="en">
    <head>
        <title>商品編輯</title>
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
            img {
                max-width: 150px; /* Replace with desired width */
                max-height: 150px; /* Replace with desired height */
                display: block; /* Ensure the image takes up the full width and height of its container */
                
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
                            <a href="area_item_list.php?camp_id=<?=$camp_id?>&area_id=<?=$area_id?>" class="btn btn-primary">
                            <i class="fa-solid fa-backward"></i>
                                回商品列表
                            </a>
                        </div>
                            <div class="d-flex justify-content-end">
                            <a class="btn btn-primary" title="商品圖片" href="item_img_upload.php?camp_id=<?=$camp_id?>&area_id=<?=$row['id']?>">上傳商品圖片 <i class="fa-regular fa-image"></i></a>
                            </div>

                            <form action="doUpdateItem.php?camp_id=<?=$camp_id?>&area_id=<?=$area_id?>&item_id=<?=$item_id?>" method="post" enctype="multipart/form-data">
                            <table class="table table-hover mb-3">
                                <tr>
                                    <th>所屬營區</th>
                                    <td><?=$area_name ?><input type="hidden" name="item_id" value="<?=$row["item_id"]; ?>"></td>
                                    
                                </tr>
                                <tr>
                                    <th>商品名稱</th>
                                    <td><input type="text" class="form-control"  name="item_name" value="<?=$row["itemName"]; ?>"></td>
                                </tr>
                                <tr>
                                    <th>商品狀態</th>
                                    <td>
                                    <select class="form-select" name="status">
                                        <option value="上架中" <?php if($row["status"]=="上架中"){echo "selected";} ?>>上架中</option>
                                        <option value="下架中" <?php if($row["status"]=="下架中"){echo "selected";} ?>>下架中</option>
                                        <option value="維修中" <?php if($row["status"]=="維修中"){echo "selected";} ?>>維修中</option>
                                    </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>價格/日</th>
                                    <td><input type="text" class="form-control" name="itemPrice" value="<?=$row["itemPrice"]; ?>"></td>
                                </tr>
                                <tr>
                                    <th>商品圖片</th>
                                    <td>
                                        <?php if(!empty($row["itemPath"])):?>
                                        <img src="<?=$row["itemPath"]?>" alt="" class="mb-3"> 

                                        <div class="d-flex ms-4">
                                        <a href="doDeleteItemPic.php?camp_id=<?=$camp_id?>&area_id=<?=$area_id?>&item_id=<?=$item_id?>" title="刪除圖片" class="btn btn-danger">Delete <i class="fa-solid fa-trash-can"></i></a>
                                        </div>
                                    
                                        <?php else:?>
                                        <input type="file" class="form-control" name="file" >
                                        <?php endif; ?>
                                    </td>
                                </tr>

                            </table>
                            <button class="btn btn-primary" type="submit">修改完成</button>
                            </form>
                           
                            <?php else : ?>
                                <h1>商品不存在</h1>
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