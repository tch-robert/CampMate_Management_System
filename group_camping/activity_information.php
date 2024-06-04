<?php
require_once("../db_connect.php");

$activity_id = $_GET['id'];

$sql = "SELECT * FROM activities WHERE activity_id=$activity_id";
$sql = "SELECT a.*, u.username, u.email 
        FROM activities a 
        JOIN users u ON a.organizer_id = u.id 
        WHERE a.activity_id=$activity_id";

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
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteModalLabel">Warning!</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    確認要刪除揪團資訊嗎?
                </div>
                <div class="modal-footer">
                    <a href="delete_activity.php?id=<?= $row["activity_id"] ?>" class="btn btn-danger">確認</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->

    <div class="container">
        <h1 class="mt-4">揪團資訊</h1>
        <div class="d-flex justify-content-between mb-3">
            <div>
            </div>
            <a href="activities_list.php" class="btn btn-primary">
                <i class="fa-solid fa-door-open"></i>返回列表
            </a>
        </div>
        <table class='table table-bordered'>
            <tbody>
                <tr>
                    <th class="text-nowrap">揪團 ID</th>
                    <td><?php echo $row['activity_id']; ?></td>
                </tr>
                <tr>
                    <th class="text-nowrap">建立時間</th>
                    <td><?php echo $row['created_at']; ?></td>
                </tr>
                <tr>
                    <th class="text-nowrap">團主</th>
                    <td><?php echo $row['username']; ?></td>
                </tr>
                <tr>
                    <th class="text-nowrap">團主 Email</th>
                    <td><?php echo $row['email']; ?></td>
                </tr>
                <tr>
                    <th class="text-nowrap">揪團名稱</th>
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
        <div class="d-flex justify-content-between">
            <div>
                <a href="join_activity.php?id=<?php echo $row['activity_id']; ?>" class="btn btn-primary">
                    <i class="fa-solid fa-user-plus"></i> 參加揪團
                </a>
                <a href="activities_list.php" class="btn btn-secondary ms-2">
                    <i class="fa-solid fa-door-open"></i> 編輯揪團
                </a>
            </div>
            <div>
                <button class="btn btn-danger" title="刪除揪團" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="fa-solid fa-trash-can"></i> 刪除揪團
                </button>
            </div>
        </div>
    </div>
    <?php include("../js.php") ?>
</body>

</html>