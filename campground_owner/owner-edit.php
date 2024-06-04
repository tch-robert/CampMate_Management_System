<?php
require_once("../db_connect.php");

if (!isset($_GET["id"])) {
    $id = 1;
} else {
    $id = $_GET["id"];
}

$sql = "SELECT * FROM campground_owner WHERE id = $id AND valid=1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($result->num_rows > 0) {
    $ownerExit = true;
    $title = $row["name"];
} else {
    $ownerExit = false;
    $title = "營地主不存在";
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
    <?php include("../css_neumorphic.php") ?>
    <style>
        :root {
            --aside-width: 250px;
            --header-height: 186px;
        }

        .main-header {
            width: var(--aside-width);
            background: var(--secondary-color);

            .logo,
            .text {
                margin-left: 30px;
                margin-right: 30px;
                margin-top: 20px;
                border-radius: 24px;
            }

            .logo {
                padding: 30px 20px;
                background: #9ba45c;
                box-shadow: 6px 6px 10px #798048,
                    -6px -6px 10px #bdc870;

                &:hover {
                    box-shadow: inset 6px 6px 10px #798048,
                        inset -6px -6px 10px #bdc870;
                }
            }

            .text {
                margin-bottom: 20px;
                text-align: center;
                padding: 9px;
                font-size: 14px;
                color: var(--primary-color);
                background: #9ba45c;
                box-shadow: inset 6px 6px 10px #798048,
                    inset -6px -6px 10px #bdc870;
            }
        }

        .aside-left {
            padding: var(--header-height) 20px 0 20px;
            width: var(--aside-width);
            top: 0;
            overflow: auto;
            background: var(--secondary-color);

            li {
                margin-bottom: 18px;

                a {
                    transition: 0.3s ease;
                    color: #fff;
                    letter-spacing: 1px;

                    &:hover {
                        transform: translate(-3px, -3px);

                        i {
                            color: #9ba45c;
                            background: linear-gradient(145deg, #ffefda, #d7c9b8);
                            box-shadow: 2px 2px 8px #baae9f,
                                -2px -2px 8px #fffff9;
                        }
                    }
                }

                i {
                    width: 48px;
                    height: 48px;
                    text-align: center;
                    transition: 0.3s ease;
                    padding: 15px;
                    margin-right: 10px;
                    border-radius: 16px;
                    background: linear-gradient(145deg, #a6af62, #8c9453);
                    box-shadow: 6px 6px 12px #848b4e,
                        -6px -6px 12px #b2bd6a;
                }

                span {
                    font-size: 12px;
                }

                .line {
                    margin: 0 16px;
                    border: none;
                    height: 1px;
                    background: var(--primary-color);
                }
            }
        }

        .main-content {
            margin-left: var(--aside-width);
            margin-top: 10px;
        }

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
    <header class="main-header d-flex flex-column fixed-top justify-content-center">
        <a href="" class="text-decoration-none logo">
            <img src="/campmate/images/logo.svg" alt="">
        </a>
        <div class="text">
            Hi, Admin
        </div>
    </header>
    <aside class="aside-left position-fixed vh-100">
        <ul class="list-unstyled mt-3 text-truncate">
            <li>
                <a class="d-block px-3 text-decoration-none" href="user-list.php">
                    <i class="fa-solid fa-user"></i> <span>一般會員</span>
                </a>
            </li>
            <li>
                <a class="d-block px-3 text-decoration-none" href="/campmate/campground_owner/owners.php">
                    <i class="fa-solid fa-user-tie"></i> <span>營地主系統</span>
                </a>
            </li>
            <li>
                <a class="d-block px-3 text-decoration-none" href="campground-management.php">
                    <i class="fa-solid fa-campground"></i> <span>營地訂位管理</span>
                </a>
            </li>
            <li>
                <a class="d-block px-3 text-decoration-none" href="equipment-rental.php">
                    <i class="fa-solid fa-person-hiking"></i> <span>露營用品租用管理</span>
                </a>
            </li>
            <li>
                <a class="d-block px-3 text-decoration-none" href="group-system.php">
                    <i class="fa-solid fa-people-roof"></i> <span>揪團系統</span>
                </a>
            </li>
            <li>
                <a class="d-block px-3 text-decoration-none" href="coupons/coupons-list.php">
                    <i class="fa-solid fa-ticket"></i> <span>優惠券</span>
                </a>
            </li>
            <li>
                <a class="d-block px-3 text-decoration-none" href="../customer_service/tickets.php">
                    <i class="fa-solid fa-headset"></i> <span>客服</span>
                </a>
            </li>
            <li>
                <div class="line"></div>
            </li>
            <li>
                <a class="d-block px-3 text-decoration-none" href="logout.php">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> <span>登出</span>
                </a>
            </li>
        </ul>
    </aside>
    <main class="main-content ">
        <!-- 這裡將顯示動態加載的內容 -->
        <div class="container profile-container">
            <div class="py-4 d-flex justify-content-center">
                <div class="col-lg-6">
                    <a href="owner.php?id=<?= $id ?>" class="btn btn-warning">
                        <i class="fa-solid fa-arrow-left"></i> 返回
                    </a>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="profile-card">
                        <div class="profile-info">
                            <div class="text-center">
                                <h2>編輯資料</h2>
                            </div>
                            <form action="doUpdateOwner.php" method="post">
                                <table class="table table-bordered">
                                    <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                    <tr>
                                        <th>id</th>
                                        <td>
                                            <?= $row["id"] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>*姓名</th>
                                        <td>
                                            <input type="text" class="form-control" name="name" value="<?= $row["name"] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>email</th>
                                        <td>
                                            <?= $row["email"] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>*電話</th>
                                        <td>
                                            <input type="text" class="form-control" name="phone" value="<?= $row["phone"] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>*收款帳號</th>
                                        <td>
                                            <input type="text" class="form-control" name="pay_account" value="<?= $row["pay_account"] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>*地址</th>
                                        <td>
                                            <input type="text" class="form-control" name="address" value="<?= $row["address"] ?>">
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
</body>

</html>