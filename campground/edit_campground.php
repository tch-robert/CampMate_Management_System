<?php
include("session_check_login.php");
require_once("../db_connect.php");

if(!isset($_GET["id"])){
    $id=1;
}else{
    $id = $_GET["id"];
}

$sql = "SELECT * FROM campground_info WHERE id=$id";
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
        <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

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
            textarea {
            height: 0; /* 設置高度為 0 */
            line-height: 20px; /* 設置行高 */
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
            <div class="py-2">
                <a href="campground_list.php" class="btn btn-primary">
                <i class="fa-solid fa-backward"></i>
                    回營地列表
                </a>
            </div>
            <div class="row justified-content-center">
                <div class="col-lg-12">
                    <?php if($campExist):?>
                        <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-end">
                            <a class="btn btn-primary" title="編輯營地" href="cg_img_upload.php?camp_id=<?=$row['id']?>">營地圖片 <i class="fa-regular fa-image"></i></a>
                            </div>
                            <form action="doUpdateCamp.php" method="post">
                            <table class="table table-hover mb-3">
                                <input type="hidden" name="id" value="<?=$row["id"]?>">
                                <tr>
                                    <th>id</th>
                                    <td><?=$row["id"]; ?></td>
                                </tr>
                                <tr>
                                    <th>營地名稱</th>
                                    <td><input type="text" class="form-control" name="campground_name" value="<?=$row["campground_name"]; ?>"></td>
                                </tr>
                                <tr>
                                    <th>email</th>
                                    <td><input type="text" class="form-control" name="email" value="<?=$row["email"]?>"></td>
                                </tr>
                                <tr>
                                    <th>電話</th>
                                    <td><input type="text" class="form-control" name="phone" value="<?=$row["phone"]?>"></td>
                                </tr>
                                <tr>
                                    <th>地址</th>
                                    <td><input type="text" class="form-control" name="address" value="<?=$row["address"]?>"></td>
                                </tr>
                                <tr>
                                    <th>海拔</th>
                                    <td><input type="text" class="form-control" name="altitude" value="<?=$row["altitude"]?>"></td>
                                </tr>
                                <tr>
                                    <th>地區</th>
                                    <td>
                                        <select class="form-select" id="position" name="position">
                                        <option value="北部" <?php if($row["position"]=="北部"){echo "selected";} ?>>北部</option>
                                        <option value="中部" <?php if($row["position"]=="中部"){echo "selected";} ?>>中部</option>
                                        <option value="南部"  <?php if($row["position"]=="南部"){echo "selected";} ?>>南部</option>
                                        <option value="東部"  <?php if($row["position"]=="東部"){echo "selected";} ?>>東部</option>
                                        </select>
                                        </td>
                                </tr>
                                <tr>
                                    <th>經度</th>
                                    <td><input type="text" class="form-control" name="longitude" value="<?=$longitude?>"></td>
                                </tr>
                                <tr>
                                    <th>緯度</th>
                                    <td><input type="text" class="form-control" name="latitude" value="<?=$latitude?>"></td>
                                </tr>
                            </table>
                            <h5>營地介紹</h5>
                            <hr>
                            <div class="mb-3">
                            <textarea class="form-control" id="editor" name="introduction" ></textarea>
                            </div>

                            <button class="btn btn-primary" type="submit">修改完成</button>
                            </form>
                           
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
        <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
        <script src="https://cdn.ckeditor.com/ckeditor5/latest/builds/ckeditor.js"></script>
        <script>
            let editor;

            ClassicEditor
                .create( document.querySelector( '#editor' ) )
                .then( newEditor => {
                    editor = newEditor;
                    editor.setData( "<?= $row["campground_introduction"]?>" );
                } )
                .catch( error => {
                    console.error( error );
                } );

            

            CKEDITOR.replace('editor', {
                extraPlugins: 'autogrow',
                autoGrow_minHeight: 200,
                autoGrow_maxHeight: 600,
                autoGrow_bottomSpace: 50,
                removePlugins: 'resize',
                removeButtons: 'PasteFromWord'
            });
        </script>
    </body>
</html>