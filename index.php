<!doctype html>
<html lang="zh-Hant">

<head>
    <title>Dashboard</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- css -->
    <?php include ("css_neumorphic.php") ?>
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
            margin-top: 20px;
        }

        .aside-a-active {
            transform: translate(-3px, -3px);
        }

        .aside-i-active {
            color: #9ba45c;
            background: linear-gradient(145deg, #ffefda, #d7c9b8) !important;
            box-shadow: 2px 2px 8px #baae9f,
                -2px -2px 8px #fffff9 !important;
        }
    </style>
</head>

<body>
    <header class="main-header d-flex flex-column fixed-top justify-content-center">
        <a href="http://localhost/campmate/index.php" class="text-decoration-none logo">
            <img src="/campmate/images/logo.svg" alt="">
        </a>
        <div class="text">
            Hi, Admin
        </div>
    </header>
    <aside class="aside-left position-fixed vh-100">
        <ul class="list-unstyled mt-3">
            <li>
                <a class="d-block px-3 text-decoration-none" href="" data-id="link1">
                    <i class="fa-solid fa-user"></i> <span>一般會員</span>
                </a>
            </li>
            <li>

                <a class="d-block px-3 text-decoration-none" href="/campmate/campground_owner/owners.php">

                    <i class="fa-solid fa-user-tie"></i> <span>營地主系統</span>
                </a>
            </li>
            <li>
                <a class="d-block px-3 text-decoration-none" href="" data-id="link3">
                    <i class="fa-solid fa-campground"></i> <span>營地訂位管理</span>
                </a>
            </li>
            <li>
                <a class="d-block px-3 text-decoration-none" href="" data-id="link4">
                    <i class="fa-solid fa-person-hiking"></i> <span>露營用品租用管理</span>
                </a>
            </li>
            <li>
                <a class="d-block px-3 text-decoration-none" href="" data-id="link5">
                    <i class="fa-solid fa-people-roof"></i> <span>揪團系統</span>
                </a>
            </li>
            <li>
                <a class="d-block px-3 text-decoration-none" href="http://localhost/campmate/coupons/coupons-list.php"
                    data-id="link6">
                    <i class="fa-solid fa-ticket"></i> <span>優惠券</span>
                </a>
            </li>
            <li>
                <a class="d-block px-3 text-decoration-none" href="/campmate/customer_service/tickets.php">

                    <i class="fa-solid fa-headset"></i> <span>客服</span>
                </a>
            </li>
            <li>
                <div class="line"></div>
            </li>
            <li>
                <a class="d-block px-3 text-decoration-none" href="" data-id="link8">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> <span>登出</span>
                </a>
            </li>
        </ul>
    </aside>
    <main class="main-content">

        <!-- 這裡將顯示動態加載的內容 -->
    </main>
    <!-- js -->
    <?php include ("../js.php") ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // 檢查當前URL是否是首頁URL
            if (window.location.href === "http://localhost/campmate/index.php") {
                localStorage.removeItem("activeLinkId");
            }

            // 恢復上次點擊的active狀態
            var activeLinkId = localStorage.getItem("activeLinkId");
            if (activeLinkId) {
                var activeLink = document.querySelector(`a[data-id="${activeLinkId}"]`);
                if (activeLink) {
                    activeLink.classList.add("aside-a-active");
                    activeLink.querySelector("i").classList.add("aside-i-active");
                }
            }

            var listItems = document.querySelectorAll(".aside-left li");

            listItems.forEach(function (li) {
                li.addEventListener("click", function (event) {
                    // 移除所有鏈接和圖標的.active樣式
                    listItems.forEach(function (item) {
                        var link = item.querySelector("a");
                        var icon = item.querySelector("i");
                        if (link) {
                            link.classList.remove("aside-a-active");
                        }
                        if (icon) {
                            icon.classList.remove("aside-i-active");
                        }
                    });

                    // 為被點擊的鏈接和圖標添加.active樣式
                    var clickedLink = event.currentTarget.querySelector("a");
                    var clickedIcon = event.currentTarget.querySelector("i");
                    if (clickedLink) {
                        clickedLink.classList.add("aside-a-active");
                        clickedIcon.classList.add("aside-i-active");
                        // 保存active狀態到localStorage
                        localStorage.setItem("activeLinkId", clickedLink.getAttribute("data-id"));
                    }
                });
            });
        });
    </script>
</body>

</html>