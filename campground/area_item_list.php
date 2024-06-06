<?php
include("session_check_login.php");
require_once("../db_connect.php");

$camp_id = $_GET["camp_id"];
$area_id = $_GET["area_id"];

$sqlAll="SELECT camp_area_item.*, area_item.item_name AS itemName, camp_area.area_name AS areaName FROM camp_area_item 
JOIN area_item ON camp_area_item.item_id = area_item.id 
JOIN camp_area ON camp_area_item.area_id = camp_area.id
WHERE camp_area_item.area_id = $area_id AND area_item.valid=1
";
$resultAll = $conn->query($sqlAll);
// $rowsAll = $resultAll->fetch_all(MYSQLI_ASSOC);
$allItemCount = $resultAll->num_rows;

if(isset($_GET["search"])){
    $search=$_GET["search"];
    $sql="SELECT camp_area_item.*, area_item.item_name AS itemName, area_item.price AS itemPrice, area_item.path AS itemPath, camp_area.area_name AS areaName FROM camp_area_item 
    JOIN area_item ON camp_area_item.item_id = area_item.id 
    JOIN camp_area ON camp_area_item.area_id = camp_area.id
    WHERE camp_area_item.area_id = $area_id AND area_item.valid=1 AND area_item.item_name LIKE '%$search%'
    ";
    $pageTitle="$search 的搜尋結果";
}else if(isset($_GET["page"]) && isset($_GET["order"])){
    $page=$_GET["page"];
    $perPage=5;
    $firstItem=($page-1)*$perPage;
    $pageCount = ceil($allItemCount/$perPage);

    $order=$_GET["order"];
    switch($order){
        case 1:// id ASC
            $orderClause= "ORDER BY itemPrice ASC";
            break;
        case 2:// id DESC
            $orderClause= "ORDER BY itemPrice DESC";
            break;
        case 3:// 名字 ASC
            $orderClause= "ORDER BY itemName ASC";
            break;
         case 4:// 名字 DESC
            $orderClause= "ORDER BY itemName DESC";
            break;
    }
    $sql="SELECT camp_area_item.*, area_item.item_name AS itemName, area_item.price AS itemPrice, area_item.path AS itemPath, camp_area.area_name AS areaName FROM camp_area_item 
    JOIN area_item ON camp_area_item.item_id = area_item.id 
    JOIN camp_area ON camp_area_item.area_id = camp_area.id
    WHERE camp_area_item.area_id = $area_id AND area_item.valid=1 
    $orderClause 
    LIMIT $firstItem, $perPage";

    $pageTitle="營地商品列表，第 $page 頁";
}else{
    $sql="SELECT camp_area_item.*, area_item.item_name AS itemName, area_item.price AS itemPrice, area_item.path AS itemPath, camp_area.area_name AS areaName FROM camp_area_item
    JOIN area_item ON camp_area_item.item_id = area_item.id 
    JOIN camp_area ON camp_area_item.area_id = camp_area.id
    WHERE camp_area_item.area_id = $area_id AND area_item.valid=1 ";
    $pageTitle="營地列表";
    header("location: area_item_list.php?camp_id=$camp_id&area_id=$area_id&page=1&order=1");
}

$result = $conn->query($sql);
$rows=$result->fetch_all(MYSQLI_ASSOC);
$itemCount = $result->num_rows;


?>



<!doctype html>
<html lang="en">
    <head>
        <title><?=$pageTitle ?></title>
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
                max-width: 50px; /* Replace with desired width */
                max-height: 50px; /* Replace with desired height */
                display: block; /* Ensure the image takes up the full width and height of its container */
                
                }
        </style>
    </head>

    <body>
        <?php include("title.php") ?>
        <div class="d-flex container-fluid">
            <?php include("sidebar.php") ?>
            <!-- 列表 -->
            
            <div class="container">
            
            <div class="card">
            <div class="card-body">
            <h4 class="mb-3"><?=$pageTitle?></h4>
            <hr>
            <div class="mb-3">
                    <?php if(isset($_GET["search"])): ?>
                        <a href="area_item_list.php?camp_id=<?=$camp_id?>&area_id=<?=$area_id?>" class="btn btn-primary">返回列表</a>
                    <?php else: ?>
                        <a href="camp_area_list.php?camp_id=<?=$camp_id?>" class="btn btn-primary">返回列表</a>
                    <?php endif; ?>
                    
                </div>
                <div class="mb-3">
                <a class="btn btn-primary" href="create_area_item.php?camp_id=<?=$camp_id?>&area_id=<?=$area_id?>">新增 <i class="fa-solid fa-plus"></i></a>
            </div>
            <?php if($result->num_rows > 0): ?>
            
            
            <div class="py-2 mb-3">
                <div class="d-flex justify-content-center gap-3 mb-2">
                    <form action="">
                        <div class="input-group">
                            <input type="hidden" value="<?=$camp_id?>" name="camp_id">
                            <input type="hidden" value="<?=$area_id?>" name="area_id">
                            <input type="text" class="form-control" placeholder="輸入營地名稱..." name="search">
                            <button class="btn btn-primary" type="submit">搜尋</button>
                        </div>
                        <div>
                    </div>
                    </form>
                </div>
                
            </div>
            <table class="table table-hover mb-3" >
                <thead>
                    <tr>
                        <th class="text-center">編號</th>
                        <th >商品名稱 <a href="?camp_id=<?=$camp_id?>&area_id=<?=$area_id?>&page=<?=$page?>&order=<?php if($order==3){echo "4";}else{echo "3";}?>"><i class="fa-solid fa-sort"></i></a></th>
                        <th>商品價格 <a href="?camp_id=<?=$camp_id?>&area_id=<?=$area_id?>&page=<?=$page?>&order=<?php if($order==1){echo "2";}else{echo "1";}?>"><i class="fa-solid fa-sort"></i></a></th>
                        <th>商品圖</th>
                        <th>商品狀態</th>
                        <th class="text-center">編輯</th>
                        <th class="text-center">其他圖片</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index=0; ?>
                    <?php foreach($rows as $item): ?>
                    <tr>
                        <td class="text-center"><?php $index+=1; echo $index; ?></td>
                        <td><?=$item["itemName"]?></td>
                        <td><?=$item["itemPrice"]?></td>
                        <td>
                            
                            <img class="object-fit-cover" src="<?=$item['itemPath']?>" alt="">
                            
                        </td>
                        <td><?=$item["status"]?></td>
                        
                        <td class="text-center">
                        <a href="edit_item.php?camp_id=<?=$camp_id?>&area_id=<?=$area_id?>&item_id=<?=$item["item_id"]?>" class="btn btn-primary">
                            編輯 <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        </td>
                        <td class="text-center"><a class="btn btn-primary" href="item_img_upload.php?camp_id=<?=$camp_id?>&area_id=<?=$area_id?>&item_id=<?=$item["item_id"]?>">進入 <i class="fa-solid fa-image"></i></a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: echo "沒有結果";  ?>
            <?php endif; ?>
            <?php if(isset($_GET["page"])):?>
                <div class="mt-3 d-flex justify-content-center">
                <nav aria-label="...">
                    <ul class="pagination">
                        <?php for($i=1; $i<=$pageCount; $i++):?>
                        <li class="page-item"><a class="page-link 
                        <?php if($i==$page)echo 'active'?>" href="?page=<?=$i?>&order=<?=$order?>"><?=$i?></a>
                        </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
                </div>
            <?php endif; ?>
        </div>
        </div> 
        </div>
        </div>  

        <?php include("../js.php"); ?>
        
    </body>
</html>

