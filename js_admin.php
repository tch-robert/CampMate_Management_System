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