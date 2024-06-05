<?php
require_once("../db_connect.php");

$activity_id = $_GET['activity_id'];

// 獲取參加對應活動的用戶資訊
$sql = "SELECT users.username, users.email
        FROM activity_participants
        JOIN users ON activity_participants.user_id = users.id
        WHERE activity_participants.activity_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $activity_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include("../css.php") ?>
    <title>參加名單</title>
</head>

<body>
    <div class="container">
        <h1 class="mt-4">參加名單</h1>
        <div class="d-flex justify-content-between mb-3">
            <div>
            </div>
            <a href="activity_information.php?activity_id=<?= $activity_id; ?>" class="btn btn-secondary ms-2">
                <i class="fa-solid fa-door-open"></i> 返回揪團
            </a>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>團員名稱</th>
                    <th>團員 Email</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <?php include("../js.php") ?>
</body>

</html>

<?php
$conn->close();
?>