<?php

echo "hi";

require_once("../db_connect.php");

// if (!isset($_GET["activity_id"]) || !isset($_GET["user_id"])) {
//     exit("請循正常管道進入此頁");
// }

// $activity_id = intval($_GET["activity_id"]);
// $user_id = intval($_GET["user_id"]);
// $sql = "UPDATE activity_participants SET status = 'deleted' WHERE activity_id = ? AND user_id = ?"; // 軟刪除
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("ii", $activity_id, $user_id);

// if ($conn->query($sql) === TRUE) :
//     echo "團員刪除成功";
// else :
//     echo "團員刪除錯誤" . $conn->error;
// endif;

// header("Location: participant_list.php?activity_id=" . $activity_id);


// if ($stmt->execute()) {
//     echo "團員刪除成功";
// } else {
//     echo "團員刪除錯誤: " . $conn->error;
// }

// $stmt->close();
// $conn->close();

// header("Location: participant_list.php?activity_id=" . $activity_id);
// exit();





require_once("../db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $activity_id = $_POST['activity_id'];
    $user_id = $_POST['user_id'];

    $sql = "UPDATE activity_participants SET status = 'deleted' WHERE activity_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $activity_id, $user_id);

    if ($stmt->execute()) {
        echo "成功移除團員";
    } else {
        echo "移除團員錯誤: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
    header("Location: participant_list.php?activity_id=" . $activity_id);
    exit();
}
