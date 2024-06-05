<?php
require_once("../db_connect.php");

if (!isset($_GET["id"])) {
    $id = 1;
} else {
    $id = $_GET["id"];
}

$sql = "SELECT * FROM ticket WHERE id = $id AND valid=1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($result->num_rows > 0) {
    $ticketExit = true;
    $title = $row["id"];
} else {
    $ticketExit = false;
    $title = "客服單不存在";
}

?>
<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("../css.php") ?>
    <?php include("../css_admin.php") ?>
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
    <?php include("../html_admin.php") ?>
    <main class="main-content ">
        <!-- 這裡將顯示動態加載的內容 -->
        <div class="container profile-container">
            <div class="py-4 d-flex justify-content-center">
                <div class="col-lg-6">
                    <a href="ticket.php?id=<?= $id ?>" class="btn btn-warning">
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
                            <form action="doUpdateTicket.php" method="post">
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
                                            <input type="text" class="form-control" name="reply" value="<?= $row["reply"] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>*狀態</th>
                                        <td>
                                            <form>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="status" id="已回覆" value="已回覆">
                                                    <label class="form-check-label" for="已回覆">
                                                        已回覆
                                                    </label>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>建立時間</th>
                                        <td>
                                            <?= $row["createtime"] ?>">
                                        </td>
                                    </tr>
                                </table>
                                <button class="btn btn-warning" type="submit">送出</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>




    <!-- Bootstrap JavaScript Libraries -->
    <?php include("../js.php") ?>
    <?php include("../js_admin.php")?>
</body>

</html>