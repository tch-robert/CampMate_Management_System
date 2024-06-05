-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2024-06-04 21:52:25
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `campmate_db`
--

-- --------------------------------------------------------

--
-- 資料表結構 `activities`
--

CREATE TABLE `activities` (
  `activity_id` int(6) UNSIGNED NOT NULL,
  `activity_name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(100) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `organizer_email` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `valid` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `activities`
--

INSERT INTO `activities` (`activity_id`, `activity_name`, `description`, `location`, `start_date`, `end_date`, `organizer_email`, `created_at`, `valid`) VALUES
(1, '墾丁海的小嶼渡假旅店資料更新1', '每天8小時，原則9:30~16:30 ，月休8日(時間可議)\r\n民宿房務(含打掃房間、協助客人辦理入住、整理床單及被單、其他交辦事務等)', '墾丁路330-12號', '2024-06-26 08:00:00', '2024-06-22 11:41:00', 'jack@test.com', '2024-06-03 03:41:43', 1),
(2, '龍捲風', '*早上9點工作，工作2小時。\r\n■主要工作是如何當一個禮貌客人，另一個工作是如何待人接物，接待客人，學習當一個會接待的主人。\r\n■次要的才是部落農事砍草、搬木頭、部落社區服務打掃、農活雜事。及接待沙發衝浪客，帶體驗生活的人去玩，宿舍打掃清潔整理及掃廁所。', '台東縣-金峰山屋-都蘭', '2024-06-07 08:00:00', '2024-06-09 17:00:00', 'may@test.com', '2024-06-02 08:45:09', 1),
(3, '琉球谷民宿', '🧹客人退房後，協助民宿房務阿姨整理房間\r\n🧹客人進房後，整理民宿客廳、廁所等環境清潔\r\n🧹若剛好遇到老闆在忙，請幫忙招呼客人\r\n🧹老闆偶爾一些小雜事交辦', '屏東縣-琉球鄉(小琉球)', '2024-06-14 10:00:00', '2024-06-15 16:00:00', 'paul@test.com', '2024-06-02 08:45:09', 1),
(4, 'Wu賀家牛排館', '快樂吃肉肉、接待帶位、介紹環境、整理環境、送餐服務、內場餐點製作協助、把員工餐吃光光不浪費…等\r\n※平均每日工作5-6小時\r\n※排班制度午/晚', '台東縣-綠島', '2024-06-11 06:00:00', '2024-06-14 17:00:00', 'peter@test.com', '2024-06-02 09:06:20', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `area_item`
--

CREATE TABLE `area_item` (
  `id` int(6) NOT NULL,
  `item_name` varchar(30) NOT NULL,
  `price` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `article`
--

CREATE TABLE `article` (
  `id` int(3) NOT NULL,
  `title` varchar(30) NOT NULL,
  `category` varchar(30) NOT NULL,
  `img` varchar(30) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `campground_info`
--

CREATE TABLE `campground_info` (
  `id` int(11) NOT NULL,
  `email` varchar(30) NOT NULL,
  `address` varchar(30) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `campground_name` varchar(20) NOT NULL,
  `campground_introduction` text NOT NULL,
  `altitude` int(11) NOT NULL,
  `position` varchar(20) NOT NULL,
  `geolocation` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `campground_owner`
--

CREATE TABLE `campground_owner` (
  `id` int(3) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `pay_account` varchar(20) NOT NULL,
  `address` varchar(20) NOT NULL,
  `phone` int(11) NOT NULL,
  `valid` int(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `camp_area`
--

CREATE TABLE `camp_area` (
  `id` int(6) NOT NULL,
  `campground_id` int(11) NOT NULL,
  `area_name` varchar(30) NOT NULL,
  `area_category` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `camp_area_item`
--

CREATE TABLE `camp_area_item` (
  `id` int(6) NOT NULL,
  `category_id` int(3) NOT NULL,
  `area_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `coupon`
--

CREATE TABLE `coupon` (
  `id` int(3) NOT NULL,
  `coupon_name` varchar(30) NOT NULL,
  `coupon_num` varchar(20) NOT NULL,
  `category` varchar(20) NOT NULL,
  `discount` int(11) NOT NULL,
  `min_cost` int(11) NOT NULL,
  `max_discount_amount` int(11) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `images`
--

CREATE TABLE `images` (
  `id` int(6) NOT NULL,
  `user_id` int(6) DEFAULT NULL,
  `campground_owner_id` int(3) DEFAULT NULL,
  `product_id` int(3) DEFAULT NULL,
  `campground_id` int(3) DEFAULT NULL,
  `camp_area_id` int(3) DEFAULT NULL,
  `area_item_id` int(3) DEFAULT NULL,
  `path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `participants`
--

CREATE TABLE `participants` (
  `participant_id` int(6) UNSIGNED NOT NULL,
  `activity_id` int(6) UNSIGNED NOT NULL,
  `user_id` int(6) NOT NULL,
  `status` varchar(10) DEFAULT 'pending',
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `participants`
--

INSERT INTO `participants` (`participant_id`, `activity_id`, `user_id`, `status`, `joined_at`) VALUES
(1, 2, 3, 'pending', '2024-06-02 09:11:21'),
(2, 1, 1, 'pending', '2024-06-03 06:06:05');

-- --------------------------------------------------------

--
-- 資料表結構 `poduct_post`
--

CREATE TABLE `poduct_post` (
  `id` int(3) NOT NULL,
  `user_id` int(3) NOT NULL,
  `product_id` int(3) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `product`
--

CREATE TABLE `product` (
  `id` int(3) NOT NULL,
  `product_name` varchar(20) NOT NULL,
  `product_introduction` text NOT NULL,
  `price` int(6) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `product_color`
--

CREATE TABLE `product_color` (
  `id` int(3) NOT NULL,
  `color` varchar(20) NOT NULL,
  `product_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `product_orderlist`
--

CREATE TABLE `product_orderlist` (
  `id` int(3) NOT NULL,
  `user_id` int(3) NOT NULL,
  `rent_start_date` datetime NOT NULL,
  `rent_end_date` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `product_orderlist_relate`
--

CREATE TABLE `product_orderlist_relate` (
  `id` int(3) NOT NULL,
  `p_order_id` int(3) NOT NULL,
  `product_id` int(3) NOT NULL,
  `amount` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `product_size`
--

CREATE TABLE `product_size` (
  `id` int(3) NOT NULL,
  `size_name` varchar(20) NOT NULL,
  `product_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(6) UNSIGNED NOT NULL,
  `activity_id` int(6) UNSIGNED NOT NULL,
  `user_id` int(6) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE `users` (
  `id` int(6) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `vip_rank` int(3) NOT NULL DEFAULT 0,
  `valid` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `vip_rank`, `valid`) VALUES
(1, 'Jack', 'jack@test.com', '12345', 0, 1),
(2, 'May', 'may@test.com', '12345', 0, 1),
(3, 'Paul', 'paul@test.com', '12345', 0, 1),
(4, 'Peter', 'peter@test.com', '12345', 0, 1),
(5, 'Nick', 'nick@test.com', '12345', 0, 1);

-- --------------------------------------------------------

--
-- 資料表結構 `user_like`
--

CREATE TABLE `user_like` (
  `id` int(11) NOT NULL,
  `user_id` int(3) NOT NULL,
  `product_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`activity_id`),
  ADD UNIQUE KEY `organizer_email` (`organizer_email`);

--
-- 資料表索引 `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `campground_info`
--
ALTER TABLE `campground_info`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `campground_owner`
--
ALTER TABLE `campground_owner`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `camp_area`
--
ALTER TABLE `camp_area`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `camp_area_item`
--
ALTER TABLE `camp_area_item`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`participant_id`),
  ADD KEY `activity_id` (`activity_id`),
  ADD KEY `user_id` (`user_id`);

--
-- 資料表索引 `poduct_post`
--
ALTER TABLE `poduct_post`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `product_color`
--
ALTER TABLE `product_color`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `product_orderlist`
--
ALTER TABLE `product_orderlist`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `product_orderlist_relate`
--
ALTER TABLE `product_orderlist_relate`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `product_size`
--
ALTER TABLE `product_size`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `activity_id` (`activity_id`),
  ADD KEY `user_id` (`user_id`);

--
-- 資料表索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `activities`
--
ALTER TABLE `activities`
  MODIFY `activity_id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `article`
--
ALTER TABLE `article`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `campground_info`
--
ALTER TABLE `campground_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `campground_owner`
--
ALTER TABLE `campground_owner`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `camp_area`
--
ALTER TABLE `camp_area`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `camp_area_item`
--
ALTER TABLE `camp_area_item`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `coupon`
--
ALTER TABLE `coupon`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `images`
--
ALTER TABLE `images`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `participants`
--
ALTER TABLE `participants`
  MODIFY `participant_id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `poduct_post`
--
ALTER TABLE `poduct_post`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product`
--
ALTER TABLE `product`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product_color`
--
ALTER TABLE `product_color`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product_orderlist`
--
ALTER TABLE `product_orderlist`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product_orderlist_relate`
--
ALTER TABLE `product_orderlist_relate`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product_size`
--
ALTER TABLE `product_size`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `users`
--
ALTER TABLE `users`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_ibfk_1` FOREIGN KEY (`organizer_email`) REFERENCES `users` (`email`);

--
-- 資料表的限制式 `participants`
--
ALTER TABLE `participants`
  ADD CONSTRAINT `participants_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`activity_id`),
  ADD CONSTRAINT `participants_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- 資料表的限制式 `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`activity_id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
