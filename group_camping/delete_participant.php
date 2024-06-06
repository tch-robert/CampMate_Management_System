<?php
require_once("../db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") :
    $activity_id = $_POST['activity_id'];
    $user_id = $_POST['user_id'];

    $sql = "UPDATE activity_participants SET status = 'deleted' WHERE activity_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $activity_id, $user_id);

    if ($stmt->execute()) :
        echo "成功移除團員";
    else :
        echo "移除團員錯誤: " . $conn->error;
    endif;

    $stmt->close();
    $conn->close();

    header("Location: participant_list.php?activity_id=" . $activity_id);
    exit;
else :
    echo "ho";
endif;
