<!doctype html>
<html lang="en">

<head>
    <title>Dashboard</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- css -->
    <?php include ("css.php") ?>
    <style>
        .main-header {
            width: var(--aside-width);
            background: var(--primary-color);

            .logo,
            .text {
                margin-left: 30px;
                margin-right: 30px;
                margin-top: 20px;
                border-radius: 16px;
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
                color: var(--secondary-color);
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
            background: var(--primary-color);

            li {
                margin-bottom: 30px;

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
                    font-size: 15px;
                }

                .line {
                    margin: 0 16px;
                    border: none;
                    height: 1px;
                    background: var(--secondary-color);
                }
            }
        }

        .main-content {
            margin: var(--header-height) 0 0 var(--aside-width);
        }
    </style>
</head>

<body>
    <header class="main-header d-flex flex-column fixed-top justify-content-center">
        <a href="" class="text-decoration-none logo">
            <img src="images/logo.svg" alt="">
        </a>
        <div class="text">
            Hi, Admin
        </div>
    </header>
    <aside class="aside-left position-fixed vh-100">
        <ul class="list-unstyled mt-3">
            <li>
                <a class="d-block px-3 text-decoration-none" href="">
                    <i class="fa-solid fa-user"></i> <span>一般會員</span>
                </a>
            </li>
            <li>
                <a class="d-block px-3 text-decoration-none" href="">
                    <i class="fa-solid fa-user-tie"></i> <span>營地主系統</span>
                </a>
            </li>
            <li>
                <a class="d-block px-3 text-decoration-none" href="">
                    <i class="fa-solid fa-campground"></i> <span>營地訂位管理</span>
                </a>
            </li>
            <li>
                <a class="d-block px-3 text-decoration-none" href="">
                    <i class="fa-solid fa-person-hiking"></i> <span>露營用品租用管理</span>
                </a>
            </li>
            <li>
                <a class="d-block px-3 text-decoration-none" href="">
                    <i class="fa-solid fa-people-roof"></i> <span>揪團系統</span>
                </a>
            </li>
            <li>
                <a class="d-block px-3 text-decoration-none" href="">
                    <i class="fa-solid fa-ticket"></i> <span>優惠券</span>
                </a>
            </li>
            <li>
                <a class="d-block px-3 text-decoration-none" href="">
                    <i class="fa-solid fa-headset"></i> <span>客服</span>
                </a>
            </li>
            <li>
                <div class="line"></div>
            </li>
            <li>
                <a class="d-block px-3 text-decoration-none" href="">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> <span>登出</span>
                </a>
            </li>
        </ul>
    </aside>
    <main class="main-content p-3">

    </main>
</body>

</html>