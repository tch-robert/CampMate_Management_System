<?php
require_once("../db_connect.php");

$activity_id = $_GET['id'];
$sql = "SELECT * FROM activities WHERE activity_id=$activity_id";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
} else {
    echo "找不到活動";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include("../css.php") ?>
    <title>揪團詳細資訊</title>
</head>

<body>
    <div class="container">
        <h1 class="mt-4">揪團資訊</h1>
        <table class='table table-bordered'>
            <tbody>
                <tr>
                    <th class="text-nowrap">活動名稱</th>
                    <td><?php echo $row['activity_name']; ?></td>
                </tr>
                <tr>
                    <th>描述</th>
                    <td><?php echo $row['description']; ?></td>
                </tr>
                <tr>
                    <th>地點</th>
                    <td><?php echo $row['location']; ?></td>
                </tr>
                <tr>
                    <th>開始日期</th>
                    <td><?php echo $row['end_date']; ?></td>
                </tr>
                <tr>
                    <th>結束日期</th>
                    <td><?php echo $row['start_date']; ?></td>
                </tr>
            </tbody>
        </table>
        <a href="join_activity.php?id=<?php echo $row['activity_id']; ?>" class="btn btn-primary">
            <i class="fa-solid fa-user-plus"></i> 參加揪團
        </a>
        <a href="activities_list.php" class="btn btn-secondary ms-2">
            <i class="fa-solid fa-door-open"></i> 返回列表
        </a>
    </div>
    <?php include("../js.php") ?>
</body>

</html>