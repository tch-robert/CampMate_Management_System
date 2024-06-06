<?php
require_once("../db_connect.php");

$activity_id = $_GET['activity_id'];

$sql = "SELECT a.*, u.username, u.email 
        FROM activities a 
        JOIN users u ON a.organizer_email = u.email 
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

<title>揪團資訊</title>
<?php include("../index.php") ?>

<main class="main-content">
    <div class="modal neumorphic-modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
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
                    <a href="delete_activity.php?activity_id=<?= $row["activity_id"] ?>" class="btn btn-neumorphic">確認</a>
                    <button type="button" class="btn btn-neumorphic" data-bs-dismiss="modal">取消</button>
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
            <a href="activities_list.php" class="btn btn-neumorphic">
                <i class="fa-solid fa-door-open"></i> 返回列表
            </a>
        </div>
        <table class='table table-bordered table-wrapper '>
            <tbody>
                <tr>
                    <th class="text-nowrap">揪團 ID</th>
                    <td><?= $row['activity_id']; ?></td>
                </tr>
                <tr>
                    <th class="text-nowrap">建立時間</th>
                    <td><?= $row['created_at']; ?></td>
                </tr>
                <tr>
                    <th class="text-nowrap">團主</th>
                    <td><?= $row['username']; ?></td>
                </tr>
                <tr>
                    <th class="text-nowrap">團主 Email</th>
                    <td><?= $row['email']; ?></td>
                </tr>
                <tr>
                    <th class="text-nowrap">揪團名稱</th>
                    <td><?= $row['activity_name']; ?></td>
                </tr>
                <tr>
                    <th>描述</th>
                    <td><?= $row['description']; ?></td>
                </tr>
                <tr>
                    <th>地點</th>
                    <td><?= $row['location']; ?></td>
                </tr>
                <tr>
                    <th>開始日期</th>
                    <td><?= $row['start_date']; ?></td>
                </tr>
                <tr>
                    <th>結束日期</th>
                    <td><?= $row['end_date']; ?></td>
                </tr>
            </tbody>
        </table>
        <div class="d-flex justify-content-between">
            <div class="d-flex gap-2">
                <a href="join_activity.php?activity_id=<?= $row['activity_id']; ?>" class="btn btn-neumorphic">
                    <i class="fa-solid fa-user-plus"></i> 我要參加
                </a>
                <a href="participant_list.php?activity_id=<?= $activity_id ?>" class="btn btn-neumorphic">
                    <i class="fa-solid fa-address-book"></i> 參加名單
                </a>
            </div>
            <div class="d-flex gap-2">
                <a href="edit_activity.php?activity_id=<?= $row['activity_id'] ?>" class="btn btn-neumorphic">
                    <i class="fa-solid fa-pen-to-square"></i> 編輯揪團
                </a>
                <button class="btn btn-neumorphic" title="刪除揪團" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="fa-solid fa-trash-can"></i> 刪除揪團
                </button>
            </div>
        </div>
    </div>
</main>