<?php
require_once("../db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $activity_id = $_POST['activity_id'];
    $user_id = $_POST['user_id'];

    $sql = "INSERT INTO participants (activity_id, user_id, status) VALUES ($activity_id, $user_id, 'pending')";

    if ($conn->query($sql) === TRUE) {
        echo "成功參加揪團";
    } else {
        echo "參加揪團錯誤: " . $conn->error;
    }

    $conn->close();
    header("Location: activities_list.php"); // 重定向回列表頁面
} else {
    $activity_id = $_GET['id'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include("../css.php") ?>
    <title>參加揪團</title>
</head>

<body>
    <div class="container">
        <h1 class="mt-4">參加揪團</h1>
        <div class="d-flex justify-content-between mb-3">
            <div>
            </div>
            <a href="activity_information.php?id=<?= $activity_id; ?>" class="btn btn-secondary ms-2">
                <i class="fa-solid fa-door-open"></i>返回揪團
            </a>
        </div>

        <form action="join_activity.php" method="post">
            <input type="hidden" name="activity_id" value="<?= $activity_id; ?>">
            <div class="form-group mb-3">
                <label for="user_id">使用者 ID:</label>
                <input type="number" class="form-control" id="user_id" name="user_id" required>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-calendar-check"></i> 提交資料
            </button>
        </form>

    </div>

    <?php include("../js.php") ?>
</body>

</html>