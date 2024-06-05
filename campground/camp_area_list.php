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
$sqlCamp = "SELECT id, campground_name FROM campground_info WHERE id=$camp_id";
$resultCamp=$conn->query($sqlCamp);
$rowCamp=$resultCamp->fetch_assoc();
$camp_name=$rowCamp["campground_name"];



$sqlAll="SELECT * FROM camp_area WHERE campground_id = $camp_id";
$resultAll = $conn->query($sqlAll);
$allCampAreaCount = $resultAll->num_rows;

if(isset($_GET["search"])){
    $search=$_GET["search"];
    $sql="SELECT id, campground_id, area_name , area_category, price_per_day FROM camp_area WHERE campground_id=$camp_id AND area_name LIKE '%$search%'";
    $pageTitle="$search 的搜尋結果";
}else if(isset($_GET["page"]) && isset($_GET["order"])){
    $page=$_GET["page"];
    $perPage=5;
    $firstItem=($page-1)*$perPage;
    $pageCount = ceil($allCampAreaCount/$perPage);

    $order=$_GET["order"];
    switch($order){
        case 1:// 名字 ASC
            $orderClause= "ORDER BY area_name ASC";
            break;
         case 2:// 名字 DESC
            $orderClause= "ORDER BY area_name DESC";
            break;
    }
    $sql="SELECT * FROM camp_area WHERE campground_id=$camp_id $orderClause  LIMIT $firstItem, $perPage";

    $pageTitle="$camp_name 營區列表，第 $page 頁";
}else{
    $sql="SELECT * FROM camp_area WHERE campground_id=$camp_id";
    $pageTitle="$camp_name 營區列表";
    header("location: camp_area_list.php?camp_id=$camp_id&page=1&order=1");
}

$result = $conn->query($sql);
$rows=$result->fetch_all(MYSQLI_ASSOC);
$campCount = $result->num_rows;


?>

<!doctype html>
<html lang="en">
    <head>
        <title><?=$camp_name?>的營地</title>
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

        <?php include("title.php") ?>
        <div class="d-flex">
            <?php include("sidebar.php") ?>
            <div class="container">
            
            <div class="card">
            <div class="card-body">
            <h4 class="mb-3"><?=$pageTitle?></h4>
                <div class="mb-3">
                    <a href="camp_area_search.php" class="btn btn-primary">返回營區列表</a>
                </div>
                <div class="mb-3">
                <a class="btn btn-primary" href="create_camp_area.php?camp_id=<?=$camp_id?>">新增 <i class="fa-solid fa-plus"></i></a>
                </div>
            <?php if($result->num_rows > 0): ?>
            
            <?php if(isset($_GET["search"])): ?>
                        <a href="camp_area_list.php?camp_id=<?=$camp_id?>" class="btn btn-primary">返回</a>
                        <?php endif; ?>
            <div class="py-2 mb-3">
                <div class="d-flex justify-content-center gap-3 mb-2">
                    <form action="">
                        <div class="input-group">
                            <input type="hidden" value="<?=$camp_id?>" name="camp_id">
                            <input type="text" class="form-control" placeholder="輸入營地名稱..." name="search">
                            <button class="btn btn-primary" type="submit">搜尋</button>
                        </div>
                        
                    </form>
                </div>
                <hr>
            </div>
            <table class="table table-hover mb-3" >
                <thead>
                    <tr>
                        <th class="text-center">營區編號 </th>
                        <th >營區名稱 <a href="?camp_id=<?=$camp_id?>&page=<?=$page?>&order=<?php if($order==1){echo "2";}else{echo "1";}?>"><i class="fa-solid fa-sort"></i></a></th>
                        <th>營區種類</th>
                        <th>價格/日</th>
                        <th class="text-center">商品</th>
                        <th class="text-center">詳細</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $key = 1;?>
                    <?php foreach($rows as $area): ?>
                    <tr>
                        <td class="text-center"><?php  echo $key; $key+=1?></td>
                        <td><?=$area["area_name"]?></td>
                        <td><?=$area["area_category"]?></td>
                        <td><?=$area["price_per_day"]?></td>
                        <td class="text-center"><a class="btn btn-primary" href="area_item_list.php?camp_id=<?=$camp_id?>&area_id=<?=$area["id"]?>"><i class="fa-solid fa-shop"></i></a></td>
                        <td class="text-center"><a class="btn btn-primary" href="camp_area.php?camp_id=<?=$camp_id?>&area_id=<?=$area["id"]?>"><i class="fa-solid fa-magnifying-glass"></i></a></td>
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

