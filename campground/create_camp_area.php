<?php
include("session_check_login.php");
if(!isset($_GET["camp_id"])){
    $data=[
        "status" => 0,
        "message"=> "請循正常管道進入"
    ];
    echo json_encode($data);
    exit;
}

$camp_id = $_GET["camp_id"];
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
                <h5 class="modal-title">是否新建營區</h5>
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
        

        <h1>營地主後台</h1>
        <hr>
        <div class="d-flex">
            <?php include("sidebar.php") ?>
            <div class="container">
                <h4 class="mb-3">請輸入營區資料</h4>

                <div class="row" style="" >
                <!-- 第一頁 -->
                        <div class="col-12 mb-3">
                        <label for="area_name" class="form-label ">*營區名稱</label>
                        <input type="text" class="form-control" id="area_name" name="area_name">
                        <div class="text-danger" id="error1"></div>
                        </div>

                        
                        <div class="col-md-6 mb-3">
                        <label for="area_category" class="form-label">營地類型</label>
                        <select class="form-select" id="area_category" name="area_category">
                            <option selected>*請選擇營地類型</option>
                            <option value="草地型地面">草地型地面</option>
                            <option value="碎石型地面">碎石型地面</option>
                            <option value="棧板型地面">棧板型地面</option>
                            <option value="水泥型地面">水泥型地面</option>
                            <option value="雨棚區">雨棚區</option>
                            <option value="森林區">森林區</option>
                            <option value="泥土區">泥土區</option>
                        </select>
                        <div class="text-danger" id="error2"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="price_per_day" class="form-label">價格/日</label>
                            <input type="text" class="form-control" id="price_per_day" name="price_per_day">
                            <div class="text-danger" id="error3"></div>
                        </div>


                        <div class="col-md-12 d-flex justify-content-between">
                            <a class=" btn btn-primary btn-lg" href="camp_area_list.php?camp_id=<?=$camp_id?>">返回營區列表</a>
                            <a class=" btn btn-primary btn-lg" id="send">送出</a>
                        </div>

                </div>
            </div>

        
        </div>

        
        <?php include("../js.php") ?>
        <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
        <script src="https://cdn.ckeditor.com/ckeditor5/latest/builds/ckeditor.js"></script>

        <script>


            const send = document.querySelector("#send");
            const area_name = document.querySelector("#area_name");
            const area_category = document.querySelector("#area_category");
            const price_per_day = document.querySelector("#price_per_day");
            
            //error
            const error1 = document.querySelector("#error1");
            const error2 = document.querySelector("#error2");
            const error3 = document.querySelector("#error3");

            // Modal
            const infoModal = new bootstrap.Modal(document.getElementById('infoModal'))
            const infoMessage = document.querySelector("#infoMessage");


            send.addEventListener("click", function(){
                console.log("click");
                let area_name_value= area_name.value;
                let area_category_value = area_category.value;
                let price_per_day_value = price_per_day.value;
                
                $.ajax({
            	method: "POST",  //or GET
            	url:  "http://localhost/campmate/campground/api/doAreaCreate.php",
            	dataType: "json",
                data:{
                    campground_id:<?=$camp_id?>,
                    area_name:area_name_value,
                    area_category:area_category_value,
                    price_per_day:price_per_day_value,
                }
            	})
            	.done(function( response ) {
                    error1.textContent = ""
                    error2.textContent = ""
                    error3.textContent = ""

                    let status=response.status;
                    switch(status){
                        case 1:
                            // alert(response.message);
                            infoMessage.textContent=response.message;
                            infoModal.show();
                    
                            break;
                        case 401:
                            error1.textContent = response.message;
                            break;
                        case 402:
                            error2.textContent = response.message;
                            break;
                        case 403:
                            error3.textContent = response.message;
                            break;
                    }
                   
            	}).fail(function( jqXHR, textStatus ) {
                	console.log( "Request failed: " + textStatus );
            	});


            })


        </script>
    </body>
</html>