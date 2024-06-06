<?php
require_once("../db_connect.php");

if (isset($_GET["search"])) :
    $search = $_GET["search"];
    $sql = "SELECT a.activity_id, a.activity_name, a.description, a.location, a.start_date, a.end_date,
            COUNT(ap.user_id) AS participant_count
            FROM activities a
            LEFT JOIN activity_participants ap ON a.activity_id = ap.activity_id
            WHERE location LIKE '%$search%'
            AND a.valid = 1
            GROUP BY a.activity_id";
    // $result = $conn->query($sql);
    $pageTitle = "有關 \"" . $search . "\" 的結果";
else :
    // $sql = "SELECT * FROM activities WHERE valid = 1";
    $sql = "SELECT a.activity_id, a.activity_name, a.description, a.location, a.start_date, a.end_date,
            COUNT(ap.user_id) AS participant_count
            FROM activities a
            LEFT JOIN activity_participants ap ON a.activity_id = ap.activity_id
            WHERE a.valid = 1
            GROUP BY a.activity_id";
    // $result = $conn->query($sql);
    $pageTitle = "揪團列表";
endif;
$result = $conn->query($sql);
// $rows = $result->fetch_all(MYSQLI_ASSOC); // 將資料轉為關聯式陣列
$userCount = $result->num_rows;

?>

<title>揪團列表</title>
<?php include("../index.php") ?>

<main class="main-content">
    <div class="container">
        <h1 class="mt-4"><?= $pageTitle ?></h1>
        <div class="d-flex justify-content-between">
            <div class="d-flex justify-content-start gap-3 mb-3">
                <form action="" class="m-0">
                    <div class="input-group">
                        <input type="text" class="form-control-neumorphic" placeholder="Search" name="search">
                        <button class="btn btn-neumorphic" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>

                <?php if (isset($_GET["search"])) : ?>
                    <a href="activities_list.php" class="btn btn-neumorphic">
                        <i class="fa-solid fa-right-from-bracket"></i> 返回列表
                    </a>
                <?php else : ?>
                    <a href="create_activity.php" class="btn btn-neumorphic">
                        <i class="fa-solid fa-hand"></i> 我要揪團
                    </a>
                <?php endif; ?>
            </div>
            <div>
                <div class="d-flex justify-content-between mb-3">
                    <div class="mt-2 mx-2">
                        共 <?= $userCount ?> 個揪團
                    </div>
                    <?php if (!isset($_GET["search"])) : ?>
                        <!-- <a href=" my_activities.php" class="btn btn-primary">
                        <i class="fa-solid fa-calendar-check"></i> 我的揪團
                        </a> -->
                    <?php else : ?>
                    <?php endif; ?>
                    <div>
                    </div>
                    <a href="../index.php" class="btn btn-neumorphic">
                        <i class="fa-solid fa-house"></i> 返回首頁
                    </a>


                </div>

            </div>
        </div>
        <!-- 搜尋、建立揪團 -->

        <?php if ($result->num_rows > 0) : ?>
            <table class='table table-bordered table-wrap'>
                <thead class='thead-light text-nowrap'>
                    <tr class="text-center">
                        <th>揪團 ID</th>
                        <th>活動名稱</th>
                        <th>描述</th>
                        <th>地點</th>
                        <th>開始日期</th>
                        <th>結束日期</th>
                        <th>參加人數</th>
                        <th>了解更多</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td class="text-center"><?= $row["activity_id"] ?></td>
                            <td><?= $row["activity_name"] ?></td>
                            <td><?= $row["description"] ?></td>
                            <td><?= $row["location"] ?></td>
                            <td><?= $row["start_date"] ?></td>
                            <td><?= $row["end_date"] ?></td>
                            <td class="text-center">有 <?= $row["participant_count"] ?> 個人參加!</td>
                            <td class="">
                                <a href='activity_information.php?activity_id=<?= $row["activity_id"] ?>' class='btn btn-neumorphic'>
                                    <i class='fa-solid fa-circle-info'></i>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            <?php else : ?>
                沒有關於<?= $search ?>的活動
            <?php endif; ?>
            </table>
    </div>
    <?php $conn->close(); ?>
</main>