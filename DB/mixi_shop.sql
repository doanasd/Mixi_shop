-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th1 14, 2026 lúc 03:16 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `mixi_shop`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Trà Sữa'),
(2, 'Trà Hoa Quả'),
(3, 'Kem');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`id`, `username`, `content`, `created_at`) VALUES
(1, 'MixiGaming', 'Trà sữa ở đây rất ngon, tuyệt vời!', '2026-01-13 14:30:18'),
(2, 'Hải Triều', 'Trà sữa nướng ở đây đỉnh của chóp, vị rất đậm đà!', '2023-10-25 01:30:00'),
(3, 'Phương Ly', 'Mình thích kem dâu tây nhất, giá rẻ mà ngon xỉu.', '2023-10-26 02:15:00'),
(4, 'Tuấn Anh', 'Ship hàng hơi lâu một chút nhưng bù lại đóng gói cẩn thận.', '2023-10-26 03:45:00'),
(5, 'Khách ẩn danh', 'Quán có không gian đẹp, nhân viên thân thiện. 10 điểm!', '2023-10-27 07:20:00'),
(6, 'Bảo Ngọc', 'Cho mình hỏi quán mở cửa đến mấy giờ ạ? Tối qua 10h mình qua thấy đóng cửa.', '2023-10-28 12:00:00'),
(7, 'Minh Khang', 'Trân châu đường đen hơi ngọt so với khẩu vị của mình, lần sau sẽ giảm đường.', '2023-10-29 04:30:00'),
(8, 'Thảo Trang', 'Sẽ quay lại ủng hộ dài dài. Món trà hoa quả giải nhiệt rất tốt.', '2023-10-30 08:45:00'),
(9, 'Độ Mixi', 'Làm cốc trà sữa xong tỉnh cả người để stream tiếp. Uy tín nhé anh em!', '2023-11-01 15:10:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `short_description` text NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `news`
--

INSERT INTO `news` (`id`, `title`, `short_description`, `content`, `image`, `created_at`) VALUES
(1, 'Mixue khai trương cơ sở thứ 1000 tại Việt Nam', 'Sự kiện đánh dấu cột mốc quan trọng của Mixue trên hành trình chinh phục khách hàng Việt.', 'Nội dung chi tiết về sự kiện khai trương... Mixue cam kết mang lại những sản phẩm chất lượng giá rẻ...', 'img/banner-mixue-1.jpg', '2026-01-13 13:58:08'),
(2, 'Top 5 món đồ uống giải nhiệt mùa hè', 'Danh sách những món best-seller bạn không thể bỏ qua trong những ngày nắng nóng.', '1. Trà sữa nướng... 2. Kem dâu tây... Chi tiết cách pha chế và hương vị...', 'img/menu-do-uong-la-gi.jpg', '2026-01-13 13:58:08'),
(3, 'Khuyến mãi mua 1 tặng 1 nhân dịp lễ', 'Chương trình tri ân khách hàng lớn nhất trong năm diễn ra vào tháng tới.', 'Áp dụng cho toàn bộ menu trà hoa quả... Thời gian áp dụng từ ngày... đến ngày...', 'img/banner-footer.jpg', '2026-01-13 13:58:08');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `pages`
--

INSERT INTO `pages` (`id`, `name`) VALUES
(1, 'trang chủ'),
(2, 'giới thiệu'),
(3, 'menu'),
(4, 'tin tức'),
(5, 'liên hệ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `description`, `image`, `category_id`) VALUES
(1, 'Super Sundae Trân Châu Đường Đen', 25000, 'Kem sundae mát lạnh kết hợp trân châu đường đen dẻo dai.', 'img/aff79778ab172926274455f4c41ecd12-400x400.jpg', 3),
(2, 'Trà Sữa Bá Vương', 30000, 'Trà sữa đậm vị với đầy đủ topping trân châu, thạch dừa.', 'img/trasua4.jpg', 1),
(3, 'Trà Hoa Quả Nhiệt Đới', 25000, 'Giải nhiệt mùa hè với hương vị hoa quả tươi mát.', 'img/menueditor_item_49f7d2e096a7428ba42eac14f064e7d6_1647418765145013931-400x400.jpg', 2),
(4, 'Trà Sữa 3Q', 25000, 'Trà sữa truyền thống kết hợp trân châu 3Q giòn dai.', 'img/trasua3.jpg', 1),
(5, 'Kem Dâu Tây', 15000, 'Vị kem dâu ngọt ngào, mát lạnh.', 'img/menueditor_item_20b571169f7541b5b472409c2a943fbf_1624625080508277340-400x400.jpg', 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(110) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `location` varchar(200) NOT NULL,
  `avatars` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`ID`, `username`, `password`, `email`, `phone`, `fullname`, `location`, `avatars`, `role`) VALUES
(1, 'admin', '123', 'admin@gmail.com', '0378191400', '456', '123', 'download.jfif', 'admin'),
(6, 'carlos', '123', 'tam2@123.vn', '0123456489', '', '', '', 'user'),
(7, 'wiener', '123', 'vietpno3@gmail.com', '0123456489', '', '', '', 'user'),
(10, 'doanasd', '123', 'doan93155@gmail.com', '0378191400', 'Pham Thanh Doan', '', '', 'user');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
