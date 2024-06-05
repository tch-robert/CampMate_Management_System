<?php
require_once("../db_connect.php");

// 查詢優惠券數據，按月份分組
$monthlyCouponsSql = "SELECT DATE_FORMAT(start_date, '%Y-%m') AS month, COUNT(*) AS count FROM coupon WHERE valid=1 GROUP BY month";
$monthlyCouponsResult = $conn->query($monthlyCouponsSql);
$monthlyCouponsData = [];
while ($row = $monthlyCouponsResult->fetch_assoc()) {
    $monthlyCouponsData[] = $row;
}
$monthlyCouponsJson = json_encode($monthlyCouponsData);
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
            <div class="row row-cols-2">
                <div class="col">
                    <canvas id="couponsChart"></canvas>
                    <p class="m-3"><i class="fa-solid fa-ticket me-2"></i>優惠券圖表</p>
                </div>
                <div class="col">

                </div>
                <div class="col">

                </div>
                <div class="col">

                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('couponsChart').getContext('2d');
            const monthlyCouponsData = <?php echo $monthlyCouponsJson; ?>;

            const labels = monthlyCouponsData.map(data => data.month);
            const data = monthlyCouponsData.map(data => data.count);

            // 定義顏色變數
            const backgroundColor = '#e3dcd3';
            const borderColor = '#ffffff';
            const gridColor = '#DACBB9';
            const tickColor = '#9ba45c';
            const legendColor = '#9ba45c';

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
    </script>
</body>

</html>