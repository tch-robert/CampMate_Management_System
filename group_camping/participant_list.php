<?php
require_once("../db_connect.php");

$activity_id = $_GET['activity_id'];

// 獲取參加對應活動的用戶資訊
$sql = "SELECT users.id AS user_id, users.username, users.email, activity_participants.joined_at
        FROM activity_participants
        JOIN users ON activity_participants.user_id = users.id
        WHERE activity_participants.activity_id = ?
        AND activity_participants.status = 'joined'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $activity_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<title>參加名單</title>
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
                    確認要移除該團員嗎?
                </div>
                <div class="modal-footer">
                    <a href="delete_activity.php?activity_id=<?= $activity_id ?>" class="btn btn-neumorphic">確認</a>
                    <button type="button" class="btn btn-neumorphic" data-bs-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal -->
    <div class="container">
        <h1 class="mt-4">參加名單</h1>
        <div class="d-flex justify-content-between mb-3">
            <div>
            </div>
            <a href="activity_information.php?activity_id=<?= $activity_id; ?>" class="btn btn-neumorphic ms-2">
                <i class="fa-solid fa-door-open"></i> 返回揪團
            </a>
        </div>
        <table class="table table-bordered table-wrapper">
            <thead>
                <tr>
                    <th>項次</th>
                    <th>團員名稱</th>
                    <th>團員 Email</th>
                    <th>加入時間</th>
                    <th>移除團員</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                while ($row = $result->fetch_assoc()) :
                ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $row['username'] ?></td>
                        <td><?= $row['email'] ?></td>
                        <td><?= $row['joined_at'] ?></td>
                        <td>
                            <form action="delete_participant.php" method="post" class="d-flex justify-content-center align-items-center">
                                <input type="hidden" name="activity_id" value="<?= $activity_id ?>">
                                <input type="hidden" name="user_id" value="<?= $row['user_id'] ?>">
                                <!-- <button type="submit" class="btn btn-neumorphic">
                                    <i class="fa-solid fa-user-minus"></i>
                                </button> -->
                                <button type="button" class="btn btn-neumorphic" title="刪除揪團" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="fa-solid fa-user-minus"></i> 移除團員
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div class="d-flex justify-content-start">
            <a href="join_activity.php?activity_id=<?= $activity_id ?>" class="btn btn-neumorphic">
                <i class="fa-solid fa-user-plus"></i> 我要參加
            </a>
        </div>
    </div>
</main>

<?php $conn->close() ?>