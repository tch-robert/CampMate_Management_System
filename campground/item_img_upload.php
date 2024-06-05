<?php
include("session_check_login.php");
require_once("../db_connect.php");

if(!isset($_GET["item_id"])){
    $data=[
        "status" => 0,
        "message"=> "請循正常管道進入"
    ];
    echo json_encode($data);
    exit;
}

$camp_id = $_GET["camp_id"];
$area_id = $_GET["area_id"];
$item_id = $_GET["item_id"];

$sql="SELECT * FROM images WHERE area_item_id=$item_id ORDER BY id DESC";
$result = $conn->query($sql);
$rows=$result->fetch_all(MYSQLI_ASSOC);

$sqlCamp= "SELECT * FROM campground_info WHERE id=$camp_id ";
$resultCamp=$conn->query($sqlCamp);
$rowCamp=$resultCamp->fetch_assoc();

$sqlArea= "SELECT * FROM camp_area WHERE id=$area_id ";
$resultArea=$conn->query($sqlArea);
$rowArea=$resultArea->fetch_assoc();

$sqlItem= "SELECT * FROM area_item WHERE id=$item_id ";
$resultItem=$conn->query($sqlItem);
$rowItem=$resultItem->fetch_assoc();


$pageTitle=$rowCamp["campground_name"]." > ".$rowArea["area_name"]." > ".$rowItem["item_name"]." > "."圖片";

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

        <?php include("title.php") ?>
        <div class="d-flex">
            <?php include("sidebar.php") ?>


            <div class="container">
                
                <div class="row">
                <div class="col-12 mb-3">
                <div class="card">
                <div class="card-body">
                <h4 class="mb-3"><?=$pageTitle?></h4>
                <hr>
                <div class="mb-3">
                    <a href="area_item_list.php?camp_id=<?=$camp_id?>&area_id=<?=$area_id?>" class="btn btn-primary">返回列表</a>
                </div>

                    <form action="doUploadItem.php?camp_id=<?=$camp_id?>&area_id=<?=$area_id?>&item_id=<?=$item_id?>" method="post"  enctype="multipart/form-data">

                    
                        <input type="hidden" class="form-control" name="name">
                    

                        <div class="mb-3">
                        <label for="form-label" class="form-label">上傳商品照片</label>
                        <input class="form-control" type="file" name="file">
                        </div>
                    
                    <div class="mb-3">
                        <button class="btn btn-primary" type="submit">送出</button>
                    </div>
                    </form>
                    
                        <div class="row g-4">
                        <?php foreach($rows as $image): ?>
                            <div class="col-lg-2 col-md-3">
                                <div class="ratio ratio-1x1 mb-3">
                                    <img class="object-fit-cover c_img" src="<?=$image['path']?>" alt="">
                                </div>
                                <div class="d-flex justify-content-center">
                                    <a href="item_img_delete.php?camp_id=<?=$camp_id?>&area_id=<?=$area_id?>&item_id=<?=$item_id?>&img_id=<?=$image["id"]?>" title="刪除圖片" class="btn btn-danger" >Delete <i class="fa-solid fa-trash-can"></i></a>
                                </div>
                            </div>

                            <!-- Modal -->
                            
                        <?php endforeach ?>
                        </div>
                  
                </div>
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