<?php
require_once("../db_connect.php");

// 針對揪團功能建立 3 個資料表

// 建立活動資料表
$sql_activities = "CREATE TABLE activities (
    activity_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    activity_name VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    location VARCHAR(100) NOT NULL,
    start_date DATETIME NOT NULL,
    end_date DATETIME NOT NULL,
    organizer_id INT(6) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (organizer_id) REFERENCES users(id)
)";

if ($conn->query($sql_activities) === TRUE) {
    echo "資料表 activities 建立完成<br>";
} else {
    echo "建立資料表 activities 錯誤: " . $conn->error . "<br>";
}

// 建立參加人資料表
$sql_participants = "CREATE TABLE participants (
    participant_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    activity_id INT(6) UNSIGNED NOT NULL,
    user_id INT(6) NOT NULL,
    status VARCHAR(10) DEFAULT 'pending',
    joined_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (activity_id) REFERENCES activities(activity_id),
    FOREIGN KEY (user_id) REFERENCES users(id)
)";

if ($conn->query($sql_participants) === TRUE) {
    echo "資料表 participants 建立完成<br>";
} else {
    echo "建立資料表 participants 錯誤: " . $conn->error . "<br>";
}
// 建立評論資料表
$sql_reviews = "CREATE TABLE reviews (
    review_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    activity_id INT(6) UNSIGNED NOT NULL,
    user_id INT(6) NOT NULL,
    rating INT CHECK (rating >= 1 AND rating <= 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (activity_id) REFERENCES activities(activity_id),
    FOREIGN KEY (user_id) REFERENCES users(id)
)";

if ($conn->query($sql_reviews) === TRUE) {
    echo "資料表 reviews 建立完成<br>";
} else {
    echo "建立資料表 reviews 錯誤: " . $conn->error . "<br>";
}

$conn->close(); // 關閉資料庫連結
