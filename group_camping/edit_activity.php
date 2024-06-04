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
// session_start();

// if (!isset($_SESSION["user_id"])) {
//     header("Location: login.php");
//     exit();
// }

// $user_id = $_SESSION["user_id"];
// $activity_id = $_GET["id"];

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $activity_name = $_POST["activity_name"];
//     $description = $_POST["description"];
//     $location = $_POST["location"];
//     $start_date = $_POST["start_date"];
//     $end_date = $_POST["end_date"];

//     $sql = "UPDATE activities SET activity_name=?, description=?, location=?, start_date=?, end_date=? WHERE activity_id=? AND user_id=?";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("ssssssi", $activity_name, $description, $location, $start_date, $end_date, $activity_id, $user_id);
//     $stmt->execute();

//     header("Location: my_activities.php");
//     exit();
// } else {
//     $sql = "SELECT * FROM activities WHERE activity_id=? AND user_id=?";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("ii", $activity_id, $user_id);
//     $stmt->execute();
//     $result = $stmt->get_result();
//     $activity = $result->fetch_assoc();
// }
?>
<!doctype html>
<html lang="en">

<head>
    <title>編輯揪團</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <?php include("../css.php") ?>
</head>

<body>
    <div class="container">
        <h1 class="mt-4">編輯揪團</h1>
        <form action="" method="post">
            <table class='table table-bordered'>
                <tbody>
                    <tr>
                        <th>揪團 ID</th>
                        <td><?php echo $row['activity_id']; ?></td>
                    </tr>
                    <tr>
                        <th>建立時間</th>
                        <td><?php echo $row['created_at']; ?></td>
                    </tr>
                    <tr>
                        <th>團主</th>
                        <td><?php echo $row['username']; ?></td>
                    </tr>
                    <tr>
                        <th>團主 Email</th>
                        <td><?php echo $row['email']; ?></td>
                    </tr>
                    <tr>
                        <th>揪團名稱</th>
                        <td>
                            <input type="text" class="form-control" name="activity_name" value="<?= $row['activity_name'] ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>描述</th>
                        <td>
                            <input type="textarea" class="form-control" name="description" value="<?= $row['description'] ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>地點</th>
                        <td>
                            <input type="text" class="form-control" name="location" value="<?= $row['location'] ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>開始日期</th>
                        <td>
                            <input type="datetime-local" class="form-control" name="start_date" value="<?= $row['start_date'] ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>結束日期</th>
                        <td>
                        <input type="datetime-local" class="form-control" name="end_date" value="<?= $row['end_date'] ?>">
                    </td>
                    </tr>
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-pen-to-square"></i> 確認變更
            </button>
            <a href="activities_list.php" class="btn btn-secondary ms-2">
                <i class="fa-solid fa-xmark"></i> 取消變更
            </a>
        </form>
    </div>

    <?php include("../js.php") ?>
</body>

</html>