<?php
session_start()
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
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                <h4 class="mb-3">請填寫營地基本資料</h4>

                <div class="row" style="" >
                <!-- 第一頁 -->
                        <div class="col-12 mb-3">
                        <label for="campground_name" class="form-label ">*營地名稱</label>
                        <input type="text" class="form-control" id="campground_name" name="campground_name">
                        <div class="text-danger" id="error1"></div>
                        </div>

                        <div class="col-12 mb-3">
                        <label for="email" class="form-label">*Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                        <div class="text-danger" id="error2"></div>
                        </div>

                        <div class="col-12 mb-3">
                        <label for="address" class="form-label">*地址</label>
                        <input type="text" class="form-control" id="address" name="address">
                        <div class="text-danger" id="error3"></div>
                        </div>

                        <div class="col-12 mb-3">
                        <label for="phone" class="form-label">*電話</label>
                        <input type="tel" class="form-control" id="phone" name="phone">
                        <div class="text-danger" id="error4"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                        <label for="position" class="form-label">營地所在區域</label>
                        <select class="form-select" id="position" name="position">
                            <option selected>*請選擇所在區域</option>
                            <option value="北部">北部</option>
                            <option value="中部">中部</option>
                            <option value="南部">南部</option>
                            <option value="東部">東部</option>
                        </select>
                        <div class="text-danger" id="error5"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="altitude" class="form-label">海拔</label>
                            <input type="text" class="form-control" id="altitude" name="altitude">
                        </div>

                        <div class="col-md-6 mb-3">
                        <label for="longitude" class="form-label">經度</label>
                        <input type="text" class="form-control" id="longitude" name="longitude">                  
                        </div>

                        <div class="col-md-6 mb-3">
                        <label for="latitude" class="form-label">緯度</label>
                        <input type="text" class="form-control" id="latitude" name="latitude">
                        </div>

                        <div class="col-md-12 mb-3">
                        <label for="intorduction" class="form-label">營地介紹</label>
                        <textarea class="form-control" id="editor" rows="12" name=intorduction></textarea>
                        <div class="text-danger" id="error6"></div>
                        </div>


                        <div class="col-md-12 d-flex justify-content-between">
                            <a class=" btn btn-primary btn-lg" href="campground_list.php">返回營地列表</a>
                            <a class=" btn btn-primary btn-lg" id="next_page">下一頁</a>
                        </div>

                </div>
            </div>

        
        </div>

        
        <?php include("../js.php") ?>
        <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
        <script src="https://cdn.ckeditor.com/ckeditor5/latest/builds/ckeditor.js"></script>

        <script>
            let editor;

            ClassicEditor
                .create( document.querySelector( '#editor' ) )
                .then( newEditor => {
                    editor = newEditor;
                } )
                .catch( error => {
                    console.error( error );
                } );


            const next_page = document.querySelector("#next_page");
            const campground_name = document.querySelector("#campground_name");
            const email = document.querySelector("#email");
            const address = document.querySelector("#address");
            const phone = document.querySelector("#phone");
            const position = document.querySelector("#position");
            const altitude = document.querySelector("#altitude");
            const longitude = document.querySelector("#longitude");
            const latitude = document.querySelector("#latitude");
            // const introduction = document.querySelector("#editor");

            //error
            const error1 = document.querySelector("#error1");
            const error2 = document.querySelector("#error2");
            const error3 = document.querySelector("#error3");
            const error4 = document.querySelector("#error4");
            const error5 = document.querySelector("#error5");
            const error6 = document.querySelector("#error6");

            // Modal
            const infoModal = new bootstrap.Modal(document.getElementById('infoModal'))
            const infoMessage = document.querySelector("#infoMessage");


            next_page.addEventListener("click", function(){
                console.log("click");
                let campground_name_value= campground_name.value;
                let email_value = email.value;
                let address_value = address.value;
                let phone_value = phone.value;
                let position_value = position.value;
                let altitude_value = altitude.value;
                let longitude_value = longitude.value;
                let latitude_value = latitude.value;
                let introduction_value = editor.getData();
                console.log(campground_name_value, introduction_value);
                $.ajax({
            	method: "POST",  //or GET
            	url:  "http://localhost/campmate/campground/api/doCampgroundInfoCreate.php",
            	dataType: "json",
                data:{
                    campground_name:campground_name_value,
                    email:email_value,
                    address:address_value,
                    phone:phone_value,
                    position:position_value,
                    altitude:altitude_value,
                    longitude:longitude_value,
                    latitude:latitude_value,
                    introduction: introduction_value
                }
            	})
            	.done(function( response ) {
                    error1.textContent = ""
                    error2.textContent = ""
                    error3.textContent = ""
                    error4.textContent = ""
                    error5.textContent = ""
                    error6.textContent = ""
                    let status=response.status;
                    switch(status){
                        case 1:
                            // alert(response.message);
                            infoMessage.textContent=response.message;
                            infoModal.show();
                            window.location.assign(`http://localhost/campmate/campground/cg_img_upload.php?camp_id=${response.id}`);
                    
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
                        case 404:
                            error4.textContent = response.message;
                            break;
                        case 405:
                            error5.textContent = response.message;
                            break;
                        case 406:
                            error6.textContent = response.message;
                            break;
                    }
                   
            	}).fail(function( jqXHR, textStatus ) {
                	console.log( "Request failed: " + textStatus );
            	});


            })


        </script>
    </body>
</html>
