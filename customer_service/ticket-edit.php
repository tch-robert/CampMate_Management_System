<?php
require_once("../db_connect.php");

$id = isset($_GET["id"]) ? $_GET["id"] : 1;

$sql = "SELECT * FROM ticket WHERE id = ? AND valid=1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($result->num_rows > 0) {
    $ticketExist = true;
    $title = $row["title"];
} else {
    $ticketExist = false;
    $title = "客服單不存在";
}

$stmt->close();
$conn->close();
?>
<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
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
    <main class="main-content ">
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
                    <a href="ticket.php?id=<?= $id ?>" class="btn btn_color2">
                        <i class="fa-solid fa-arrow-left"></i> 返回
                    </a>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="profile-card">
                        <div class="profile-info">
                            <div class="text-center">
                                <h2>回覆客服單</h2>
                            </div>
                            <form id="updateForm">
                                <table class="table table-bordered">
                                    <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                    <tr>
                                        <th>id</th>
                                        <td>
                                            <?= $row["id"] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>標題</th>
                                        <td>
                                            <?= $row["title"] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>描述</th>
                                        <td>
                                            <?= $row["description"] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>使用者id</th>
                                        <td>
                                            <?= $row["user_id"] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>*回覆</th>
                                        <td>
                                            <input type="text" class="form-control" name="reply" id="reply" value="<?= $row["reply"] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>*狀態</th>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status" id="status_replied" value="已回覆">
                                                <label class="form-check-label" for="status_replied">
                                                    已回覆
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status" id="status_pending" value="待處理">
                                                <label class="form-check-label" for="status_pending">
                                                    待處理
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>建立時間</th>
                                        <td>
                                            <?= $row["createtime"] ?>
                                        </td>
                                    </tr>
                                </table>
                                <div class="text-danger" id="error"></div>
                                <button class="btn btn_color2" type="button" id="send">送出</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <?php include("btn_css.php") ?>

    <!-- Bootstrap JavaScript Libraries -->
    <?php include("../js.php") ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const send = document.querySelector("#send");
            const error = document.querySelector("#error");
            const infoModalElement = document.querySelector('#infoModal');
            const infoModal = new bootstrap.Modal(infoModalElement);
            const infoMessage = document.querySelector('#infoMessage');

            send.addEventListener('click', function() {
                const formData = new FormData(document.querySelector('#updateForm'));
                const data = {
                    id: formData.get('id'),
                    reply: formData.get('reply'),
                    status: formData.get('status')
                };

                $.ajax({
                        method: "POST",
                        url: "http://localhost/campmate/customer_service/doUpdateTicket.php",
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