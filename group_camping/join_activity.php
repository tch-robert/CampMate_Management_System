<?php
require_once("../db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") :
    $activity_id = $_POST['activity_id'];
    $user_email = $_POST['user_email'];

    $user_sql = "SELECT id FROM users WHERE email = '$user_email'";
    $user_result = $conn->query($user_sql);

    if ($user_result->num_rows > 0) {
        $user_row = $user_result->fetch_assoc();
        $user_id = $user_row['id'];

        $sql = "INSERT INTO activity_participants (activity_id, user_id, status) VALUES ($activity_id, $user_id, 'joined')";

        if ($conn->query($sql) === TRUE) {
            echo "成功參加揪團";
            header("Location: activity_information.php?activity_id=$activity_id");
            exit;
        } else {
            echo "參加揪團錯誤: " . $conn->error;
        }
    } else {
        echo "找不到對應的使用者 email: " . $user_email;
    }

    $conn->close();
// header("location: activities_list.php");
else :
    $activity_id = $_GET['activity_id'];
endif;
?>

<title>參加揪團</title>
<?php include("../index.php") ?>

<main class="main-content">

    <div class="container">
        <h1 class="mt-4">參加揪團</h1>
        <div class="d-flex justify-content-between mb-3">
            <div>
            </div>
            <a href="activity_information.php?activity_id=<?= $activity_id; ?>" class="btn btn-neumorphic ms-2">
                <i class="fa-solid fa-door-open"></i> 返回揪團
            </a>
        </div>

        <form action="join_activity.php" method="post">
            <input type="hidden" name="activity_id" value="<?= $activity_id; ?>">
            <div class="form-group mb-3">
                <label for="user_email">使用者 Email:</label>
                <input type="email" class="form-control" id="user_email" name="user_email" required>
            </div>

            <div class="modal neumorphic-modal fade" id="submitModal" tabindex="-1" aria-labelledby="submitModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="submitModalLabel">notification</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            確認要送出資料嗎?
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-neumorphic">確認</button>
                            <button type="button" class="btn btn-neumorphic" data-bs-dismiss="modal">取消</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->

            <button type="button" class="btn btn-neumorphic" data-bs-toggle="modal" data-bs-target="#submitModal">
                <i class="fa-solid fa-calendar-check"></i> 提交資料
            </button>
        </form>
    </div>
</main>