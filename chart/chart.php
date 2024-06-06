<?php
require_once("../db_connect.php");

// 獲取當前月份
$currentMonth = date('Y-m');

// 查詢用戶數據，按天分組
$dailyUsersSql = "SELECT DATE_FORMAT(created_at, '%Y-%m-%d') AS day, COUNT(*) AS count FROM users WHERE valid=1 AND DATE_FORMAT(created_at, '%Y-%m') = '$currentMonth' GROUP BY day";
$dailyUsersResult = $conn->query($dailyUsersSql);
$dailyUsersData = [];
while ($row = $dailyUsersResult->fetch_assoc()) {
    $dailyUsersData[] = $row;
}
$dailyUsersJson = json_encode($dailyUsersData);

// 查詢營地數據，按位置分組
$campgroundSql = "SELECT position, COUNT(*) AS count FROM campground_info GROUP BY position";
$campgroundResult = $conn->query($campgroundSql);
$campgroundData = [];
while ($row = $campgroundResult->fetch_assoc()) {
    $campgroundData[] = $row;
}
$campgroundJson = json_encode($campgroundData);

// 查詢產品數據，按上架狀態分組
$productStatusSql = "SELECT product_status, COUNT(*) AS count FROM product GROUP BY product_status";
$productStatusResult = $conn->query($productStatusSql);
$productStatusData = [];
while ($row = $productStatusResult->fetch_assoc()) {
    $productStatusData[] = $row;
}
$productStatusJson = json_encode($productStatusData);

// 查詢每個商品類別的產品數量
$productCategorySql = "
    SELECT pc.category_name, COUNT(pcr.product_id) AS count
    FROM product_category pc
    LEFT JOIN product_category_relate pcr ON pc.category_id = pcr.category_id
    GROUP BY pc.category_id, pc.category_name
";
$productCategoryResult = $conn->query($productCategorySql);
$productCategoryData = [];
while ($row = $productCategoryResult->fetch_assoc()) {
    $productCategoryData[] = $row;
}
$productCategoryJson = json_encode($productCategoryData);

// 獲取當前月份的第一天和最後一天
$currentMonthStart = date('Y-m-01');
$currentMonthEnd = date('Y-m-t');

// 查詢當月份每天的活動參加人數
$dailyParticipantsSql = "
    SELECT DATE_FORMAT(ap.joined_at, '%Y-%m-%d') AS day, COUNT(ap.user_id) AS count
    FROM activity_participants ap
    JOIN activities a ON ap.activity_id = a.activity_id
    WHERE a.valid = 1 AND ap.joined_at BETWEEN '$currentMonthStart' AND '$currentMonthEnd'
    GROUP BY day
";
$dailyParticipantsResult = $conn->query($dailyParticipantsSql);
$dailyParticipantsData = [];
while ($row = $dailyParticipantsResult->fetch_assoc()) {
    $dailyParticipantsData[] = $row;
}
$dailyParticipantsJson = json_encode($dailyParticipantsData);

// 查詢優惠券數據，按月份分組
$monthlyCouponsSql = "SELECT DATE_FORMAT(start_date, '%Y-%m') AS month, COUNT(*) AS count FROM coupon WHERE valid=1 GROUP BY month";
$monthlyCouponsResult = $conn->query($monthlyCouponsSql);
$monthlyCouponsData = [];
while ($row = $monthlyCouponsResult->fetch_assoc()) {
    $monthlyCouponsData[] = $row;
}
$monthlyCouponsJson = json_encode($monthlyCouponsData);

// 查詢客服務數據，按回覆狀態分組
$ticketStatusSql = "SELECT status, COUNT(*) AS count FROM ticket GROUP BY status";
$ticketStatusResult = $conn->query($ticketStatusSql);
$ticketStatusData = [];
while ($row = $ticketStatusResult->fetch_assoc()) {
    $ticketStatusData[] = $row;
}
$ticketStatusJson = json_encode($ticketStatusData);
?>

<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- 引入 Chart.js 的 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- css -->
    <?php include("../css_neumorphic.php") ?>
    <style>
        canvas {
            background: #F0EDED;
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: inset 5px 5px 10px var(--shadow-color), inset -5px -5px 10px var(--highlight-color);
        }

        .container {
            padding-top: 105px;
            color: var(--secondary-color);
            font-weight: 500;
            letter-spacing: 1px;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>

<body>
    <?php include("../index.php") ?>
    <main class="main-content">
        <div class="container text-center">
            <div class="row row-cols-4">
                <div class="col">
                    <canvas id="ticketStatusChart"></canvas>
                    <p class="m-3"><i class="fa-solid fa-headset me-2"></i>客服回覆狀態圖表</p>
                </div>
                <div class="col">
                    <canvas id="campgroundChart"></canvas>
                    <p class="m-3"><i class="fa-solid fa-campground me-2"></i>營地位置分布比例圖表</p>
                </div>
                <div class="col">
                    <canvas id="productStatusChart"></canvas>
                    <p class="m-3"><i class="fa-solid fa-boxes-stacked me-2"></i>產品上架狀態圖表</p>
                </div>
                <div class="col">
                    <canvas id="productCategoryChart"></canvas>
                    <p class="m-3"><i class="fa-solid fa-boxes-stacked me-2"></i>商品類別比例圖表</p>
                </div>
            </div>
            <div class="row row-cols-3">
                <div class="col">
                    <canvas id="usersChart"></canvas>
                    <p class="m-3"><i class="fa-solid fa-user-plus me-2"></i>每日加入會員人數圖表</p>
                </div>
                <div class="col">
                    <canvas id="activityParticipantsChart"></canvas>
                    <p class="m-3"><i class="fa-solid fa-users me-2"></i>活動參加人數圖表</p>
                </div>
                <div class="col">
                    <canvas id="couponsChart"></canvas>
                    <p class="m-3"><i class="fa-solid fa-ticket me-2"></i>每月優惠券數量圖表</p>
                </div>
            </div>
        </div>

    </main>

    <script>
        // 定義顏色變數
        const backgroundColor = '#e3dcd3';
        const borderColor = '#9ba45c';
        const gridColor = '#DACBB9';
        const tickColor = '#9ba45c';
        const legendColor = '#9ba45c';
        const pointColor = '#9ba45c';
        const pointBackgroundColor = '#e3dcd3';
        // 會員
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('usersChart').getContext('2d');
            const dailyUsersData = <?php echo $dailyUsersJson; ?>;
            const labels = dailyUsersData.map(data => data.day);
            const data = dailyUsersData.map(data => data.count);

            const chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: '會員人數',
                        data: data,
                        backgroundColor: backgroundColor,
                        borderColor: borderColor,
                        borderWidth: 1,
                        borderRadius: 4, // 圓角效果
                        borderSkipped: false, // 移除邊框跳過效果
                        pointBackgroundColor: pointColor
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: gridColor,
                                borderDash: [2, 2],
                            },
                            ticks: {
                                color: tickColor
                            }
                        },
                        x: {
                            grid: {
                                color: gridColor,
                                borderDash: [2, 2],
                            },
                            ticks: {
                                color: tickColor
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: legendColor
                            }
                        }
                    }
                }
            });
        });
        // 營地位置分布
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('campgroundChart').getContext('2d');
            const campgroundData = <?php echo $campgroundJson; ?>;
            const labels = campgroundData.map(data => data.position);
            const data = campgroundData.map(data => data.count);
            // 定義顏色變數
            const backgroundColors = ['#9ba45c', '#F2C6C2', '#e3dcd3'];
            const borderColor = '#ffffff';
            const chart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        label: '營地數量',
                        data: data,
                        backgroundColor: backgroundColors,
                        borderColor: borderColor,
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            labels: {
                                color: '#9ba45c'
                            }
                        }
                    }
                }
            });
        });
        // 產品
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('productStatusChart').getContext('2d');
            const productStatusData = <?php echo $productStatusJson; ?>;
            const labels = productStatusData.map(data => data.product_status == 1 ? '已上架' : '未上架');
            const data = productStatusData.map(data => data.count);
            // 定義顏色變數
            const backgroundColors = ['#F2C6C2', '#9ba45c'];
            const borderColor = '#ffffff';
            const chart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        label: '產品數量',
                        data: data,
                        backgroundColor: backgroundColors,
                        borderColor: borderColor,
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            labels: {
                                color: legendColor
                            }
                        }
                    }
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('productCategoryChart').getContext('2d');
            const productCategoryData = <?php echo $productCategoryJson; ?>;
            const labels = productCategoryData.map(data => data.category_name);
            const data = productCategoryData.map(data => data.count);

            const chart = new Chart(ctx, {
                type: 'radar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: '商品數量',
                        data: data,
                        backgroundColor: backgroundColor,
                        borderColor: borderColor,
                        pointBackgroundColor: pointBackgroundColor,
                        borderWidth: 2
                    }]
                },
                options: {
                    scales: {
                        r: {
                            beginAtZero: true,
                            grid: {
                                color: gridColor,
                                borderDash: [2, 2],
                            },
                            ticks: {
                                color: tickColor
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: legendColor
                            }
                        }
                    }
                }
            });
        });
        // 揪團
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('activityParticipantsChart').getContext('2d');
            const dailyParticipantsData = <?php echo $dailyParticipantsJson; ?>;
            const labels = dailyParticipantsData.map(data => data.day);
            const data = dailyParticipantsData.map(data => data.count);

            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: '參加人數',
                        data: data,
                        backgroundColor: backgroundColor,
                        borderColor: borderColor,
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: gridColor,
                                borderDash: [2, 2],
                            },
                            ticks: {
                                color: tickColor
                            }
                        },
                        x: {
                            grid: {
                                color: gridColor,
                                borderDash: [2, 2],
                            },
                            ticks: {
                                color: tickColor
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: legendColor
                            }
                        }
                    }
                }
            });
        });
        // 優惠券
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('couponsChart').getContext('2d');
            const monthlyCouponsData = <?php echo $monthlyCouponsJson; ?>;
            const labels = monthlyCouponsData.map(data => data.month);
            const data = monthlyCouponsData.map(data => data.count);

            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: '優惠券數量',
                        data: data,
                        backgroundColor: backgroundColor,
                        borderColor: borderColor,
                        borderWidth: 1,
                        borderRadius: 4, // 圓角效果
                        borderSkipped: false // 移除邊框跳過效果
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: gridColor,
                                borderDash: [2, 2],
                            },
                            ticks: {
                                color: tickColor
                            }
                        },
                        x: {
                            grid: {
                                color: gridColor,
                                borderDash: [2, 2],
                            },
                            ticks: {
                                color: tickColor
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: legendColor
                            }
                        }
                    }
                }
            });
        });
        // 客服
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('ticketStatusChart').getContext('2d');
            const ticketStatusData = <?php echo $ticketStatusJson; ?>;
            const labels = ticketStatusData.map(data => data.status);
            const data = ticketStatusData.map(data => data.count);
            // 定義顏色變數
            const backgroundColors = ['#F2C6C2', '#9ba45c'];
            const borderColor = '#ffffff';
            const chart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        label: '票務數量',
                        data: data,
                        backgroundColor: backgroundColors,
                        borderColor: borderColor,
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            labels: {
                                color: '#9ba45c'
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>