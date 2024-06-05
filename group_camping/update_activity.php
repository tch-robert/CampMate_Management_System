<?php
require_once("../db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $activity_id = $_POST['activity_id'];
    $activity_name = $_POST['activity_name'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $sql = "UPDATE activities SET activity_name='$activity_name', description='$description', location='$location', start_date='$start_date', end_date='$end_date' WHERE activity_id=$activity_id";

    if ($conn->query($sql) === TRUE) {
        echo "活動更新成功";
    } else {
        echo "更新活動錯誤: " . $conn->error;
    }

    $conn->close();
    header("Location: index.php"); // 重定向回主頁
} else {
    $activity_id = $_GET['id'];
    $sql = "SELECT * FROM activities WHERE activity_id=$activity_id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
            <title>更新活動</title>
        </head>

        <body>
            <div class="container">
                <h1 class="mt-5">更新活動</h1>
                <form action="update_activity.php" method="post">
                    <input type="hidden" name="activity_id" value="<?php echo $activity_id; ?>">
                    <div class="form-group">
                        <label for="activity_name">活動名稱:</label>
                        <input type="text" class="form-control" id="activity_name" name="activity_name" value="<?php echo $row['activity_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="description">描述:</label>
                        <textarea class="form-control" id="description" name="description" required><?php echo $row['description']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="location">地點:</label>
                        <input type="text" class="form-control" id="location" name="location" value="<?php echo $row['location']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="start_date">開始日期:</label>
                        <input type="datetime-local" class="form-control" id="start_date" name="start_date" value="<?php echo date('Y-m-d\TH:i', strtotime($row['start_date'])); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="end_date">結束日期:</label>
                        <input type="datetime-local" class="form-control" id="end_date" name="end_date" value="<?php echo date('Y-m-d\TH:i', strtotime($row['end_date'])); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">更新活動</button>
                </form>
            </div>
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        </body>

        </html>
<?php
    } else {
        echo "找不到活動";
    }

    $conn->close();
}
?>