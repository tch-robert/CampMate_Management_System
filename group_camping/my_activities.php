<?php
require_once("../db_connect.php");
session_start();

// 檢查使用者是否已登入，否則重定向到登入頁面
// if (!isset($_SESSION["user_id"])) {
//     header("Location: login.php");
//     exit();
// }

// $user_id = $_SESSION["user_id"];

// $sql = "SELECT * FROM activities WHERE user_id = ?";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("i", $user_id);
// $stmt->execute();
// $result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>我的揪團</title>
    <?php include("../css.php") ?>

</head>

<body>
    <div class="container">
        <h1 class="mt-4">我的揪團</h1>
        <div class="d-flex justify-content-between">
            <div>

            </div>
            <a href="activities_list.php" class="btn btn-primary">
                <i class="fa-solid fa-door-open"></i>返回列表
            </a>
        </div>
        <?php if ($result->num_rows > 0) : ?>
            <table class='table table-bordered'>
                <thead class='thead-light text-nowrap'>
                    <tr>
                        <th>活動名稱</th>
                        <th>描述</th>
                        <th>地點</th>
                        <th>開始日期</th>
                        <th>結束日期</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row["activity_name"] ?></td>
                            <td><?php echo $row["description"] ?></td>
                            <td><?php echo $row["location"] ?></td>
                            <td><?php echo $row["start_date"] ?></td>
                            <td><?php echo $row["end_date"] ?></td>
                            <td>
                                <a href='edit_activity.php?id=<?php echo $row["activity_id"] ?>' class='btn btn-warning btn-sm'>
                                    <i class='fa-solid fa-edit'></i> 編輯
                                </a>
                                <a href='delete_activity.php?id=<?php echo $row["activity_id"] ?>' class='btn btn-danger btn-sm' onclick="return confirm('確定要刪除這個活動嗎？');">
                                    <i class='fa-solid fa-trash'></i> 刪除
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            <?php else : ?>
                <p>您尚未創建任何活動</p>
            <?php endif; ?>

            <?php $conn->close(); ?>
            </table>
    </div>
    <?php include("../js.php") ?>
</body>

</html>