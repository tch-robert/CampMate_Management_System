<!doctype html>
<html lang="en">

<head>
    <title>Create Owner</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <?php include("../css.php") ?>
    <style>
        .profile-container {
            margin-top: 50px;
        }

        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            background-color: #ffffff;
            padding: 30px;
        }

        .profile-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
        }

        .profile-info table {
            width: 100%;
        }

        .profile-info th,
        .profile-info td {
            padding: 10px 15px;
        }

        .profile-info th {
            background-color: #f8f9fa;
            text-align: left;
            width: 30%;
        }

        .profile-info td {
            background-color: #ffffff;
            text-align: left;
        }
    </style>
</head>

<body>
    <?php include("../index.php") ?>
    <main class="main-content">
        <!-- 這裡將顯示動態加載的內容 -->
        <div class="modal fade" tabindex="-1" id="infoModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">訊息</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="infoMessage"><?= $infoMessage ?></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn_color2" data-bs-dismiss="modal">確認</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="container profile-container">
            <div class="py-4 d-flex justify-content-center">
                <div class="col-lg-6">
                    <a class="btn btn_color2" href="tickets.php"><i class="fa-solid fa-arrow-left"></i> 回客服單列表</a>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="profile-card">
                        <div class="profile-info">
                            <div class="text-center">
                                <h2>新增客服單</h2>
                            </div>
                            <form action="doCreateTicket.php" method="post">
                                <div class="mb-2">
                                    <label for="title" class="form-label">*標題</label>
                                    <select id="title" name="title" class="form-control w-100">
                                        <option value="營地相關">營地相關</option>
                                        <option value="用品租借相關">用品租借相關</option>
                                        <option value="網站操作相關">網站操作相關</option>
                                        <option value="費用相關">費用相關</option>
                                        <option value="其他">其他</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label for="" class="form-label">*描述</label>
                                    <input type="text" class="form-control" name="description" id="description">
                                </div>
                                <div class="mb-2">
                                    <label for="" class="form-label">*使用者id</label>
                                    <input type="text" class="form-control" name="user_id" id="user_id">
                                </div>
                                <div class="text-danger" id="error"></div>
                                <button id="send" class="btn btn_color2" type="button" >送出</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include("btn_css.php") ?>
    <?php include("../js.php") ?>
    <script>
        const send = document.querySelector("#send")
        const title = document.querySelector("#title")
        const description = document.querySelector("#description")
        const user_id = document.querySelector("#user_id")
        const error = document.querySelector("#error")

        const infoModal = new bootstrap.Modal('#infoModal')
        const infoMessage = document.querySelector('#infoMessage');

        send.addEventListener('click', function() {
            let titleValue = title.value;
            let descriptionValue = description.value;
            let user_idValue = user_id.value;


            $.ajax({
                    method: "POST", //or GET
                    url: "http://localhost/campmate/customer_service/doCreateTicket.php",
                    dataType: "json",
                    data: {
                        title: titleValue,
                        description: descriptionValue,
                        user_id: user_idValue
                    }
                })
                .done(function(response) {
                    error.textContent = "";
                    let status = response.status;

                    switch (status) {
                        case 0:
                            error.textContent = response.message;
                            break;
                        case 1:
                            infoMessage.
                            textContent = response.message;
                            infoModal.show();
                            break;
                    }
                }).fail(function(jqXHR, textStatus) {
                    console.log("Request failed: " + textStatus);
                });
        })
    </script>
</body>

</html>