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
        <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="infoModalLabel">訊息</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="infoMessage">
                        <!-- 這裡將顯示訊息 -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="container profile-container">
            <div class="py-4 d-flex justify-content-center">
                <div class="col-lg-6">
                    <a class="btn btn_color2" href="owners.php"><i class="fa-solid fa-arrow-left"></i> 回營地主列表</a>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="profile-card">
                        <div class="profile-info">
                            <div class="text-center">
                                <h2>新增營地主</h2>
                            </div>
                            <form id="createForm" method="post">
                                <div class="mb-2">
                                    <label for="name" class="form-label">*姓名</label>
                                    <input type="text" class="form-control" name="name" id="name" required>
                                </div>
                                <div class="mb-2">
                                    <label for="email" class="form-label">*email</label>
                                    <input type="email" class="form-control" name="email" id="email" required>
                                </div>
                                <div class="mb-2">
                                    <label for="phone" class="form-label">*電話</label>
                                    <input type="tel" class="form-control" name="phone" id="phone" required>
                                </div>
                                <div class="mb-2">
                                    <label for="password" class="form-label">*密碼</label>
                                    <input type="password" class="form-control" name="password" id="password" required>
                                </div>
                                <div class="mb-2">
                                    <label for="pay_account" class="form-label">*收款帳號</label>
                                    <input type="text" class="form-control" name="pay_account" id="pay_account" required>
                                </div>
                                <div class="mb-2">
                                    <label for="address" class="form-label">*地址</label>
                                    <input type="text" class="form-control" name="address" id="address" required>
                                </div>
                                <div id="error" class="text-danger"></div>
                                <button class="btn btn_color2 mt-3" type="button" id="send">送出</button>
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
        document.addEventListener('DOMContentLoaded', function() {
            const send = document.querySelector("#send");
            const name = document.querySelector("#name");
            const email = document.querySelector("#email");
            const phone = document.querySelector("#phone");
            const password = document.querySelector("#password");
            const pay_account = document.querySelector("#pay_account");
            const address = document.querySelector("#address");
            const error = document.querySelector("#error");

            const infoModalElement = document.querySelector('#infoModal');
            const infoModal = new bootstrap.Modal(infoModalElement);
            const infoMessage = document.querySelector('#infoMessage');

            send.addEventListener('click', function() {
                const data = {
                    name: name.value,
                    email: email.value,
                    phone: phone.value,
                    password: password.value,
                    pay_account: pay_account.value,
                    address: address.value
                };

                $.ajax({
                    method: "POST",
                    url: "http://localhost/campmate/campground_owner/doCreateOwner.php",
                    dataType: "json",
                    data: data
                })
                .done(function(response) {
                    error.textContent = "";
                    if (response.status === 0) {
                        error.textContent = response.message;
                    } else {
                        infoMessage.textContent = response.message;
                        infoModal.show();
                    }
                })
                .fail(function(jqXHR, textStatus) {
                    console.log("Request failed: " + textStatus);
                });
            });
        });
    </script>

</body>

</html>