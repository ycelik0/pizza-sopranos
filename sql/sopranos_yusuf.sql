-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2022 at 09:34 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sopranos_yusuf`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `img`) VALUES
(1, 'Vegetarisch', ''),
(2, 'Vlees', ''),
(3, 'Vis', '');

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20221010081534', '2022-10-10 10:16:14', 168),
('DoctrineMigrations\\Version20221010091508', '2022-10-10 11:15:14', 75),
('DoctrineMigrations\\Version20221010094600', '2022-10-10 11:46:07', 62),
('DoctrineMigrations\\Version20221010094856', '2022-10-10 11:49:00', 155),
('DoctrineMigrations\\Version20221011074326', '2022-10-11 09:43:34', 507),
('DoctrineMigrations\\Version20221011102250', '2022-10-11 12:22:54', 156),
('DoctrineMigrations\\Version20221017105721', '2022-10-17 12:57:25', 283),
('DoctrineMigrations\\Version20221020091307', '2022-11-07 09:34:24', 131),
('DoctrineMigrations\\Version20221020095828', '2022-11-07 09:34:24', 32),
('DoctrineMigrations\\Version20221020160309', '2022-11-07 09:34:24', 28),
('DoctrineMigrations\\Version20221107091728', '2022-11-08 08:45:03', 380),
('DoctrineMigrations\\Version20221108084455', '2022-11-08 09:45:19', 45),
('DoctrineMigrations\\Version20221108084811', '2022-11-08 09:48:14', 102),
('DoctrineMigrations\\Version20221108085602', '2022-11-08 09:56:14', 278),
('DoctrineMigrations\\Version20221108133750', '2022-11-08 14:37:58', 40),
('DoctrineMigrations\\Version20221108135215', '2022-11-08 14:52:17', 71),
('DoctrineMigrations\\Version20221108135305', '2022-11-08 14:53:17', 30),
('DoctrineMigrations\\Version20221108143825', '2022-11-08 15:38:27', 51),
('DoctrineMigrations\\Version20221108170959', '2022-11-08 18:10:02', 43),
('DoctrineMigrations\\Version20221108171250', '2022-11-08 18:12:52', 31),
('DoctrineMigrations\\Version20221109082736', '2022-11-09 09:27:41', 536),
('DoctrineMigrations\\Version20221109082814', '2022-11-09 09:28:17', 100),
('DoctrineMigrations\\Version20221114084250', '2022-11-14 09:42:53', 61),
('DoctrineMigrations\\Version20221115074602', '2022-11-15 08:46:05', 266),
('DoctrineMigrations\\Version20221116073829', '2022-11-16 08:38:41', 74),
('DoctrineMigrations\\Version20221116073917', '2022-11-16 08:39:21', 69),
('DoctrineMigrations\\Version20221116074623', '2022-11-16 08:46:27', 525);

-- --------------------------------------------------------

--
-- Table structure for table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `adress` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `order_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shoppingcart` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `adress`, `order_status`, `shoppingcart`) VALUES
(10, 1, '{\"streetName\":\"Jan ten Brinkstraat\",\"streetNumber\":\"163\",\"addition\":null,\"postalCode\":\"2522HX\"}', 'prepared', '{\"id\":23,\"pizza\":{\"id\":1,\"name\":\"Spicy BBQ Pulled Pork\",\"price\":\"14.99\",\"category\":{\"__initializer__\":[],\"__cloner__\":[],\"__isInitialized__\":false,\"id\":2,\"name\":\"Vlees\",\"img\":\"\"},\"image\":\"NL-PSPP-all-menu-9972-63482402880de.jpg\",\"__initializer__\":null,\"__cloner__\":null,\"__isInitialized__\":true},\"amount\":5,\"size\":\"35cm\",\"calzone\":true}#{\"id\":24,\"pizza\":{\"id\":6,\"name\":\"Greek Pizza\",\"price\":\"7.99\",\"category\":{\"__initializer__\":[],\"__cloner__\":[],\"__isInitialized__\":false,\"id\":1,\"name\":\"Vegetarisch\",\"img\":\"\"},\"image\":\"pizza-2-634538de17dd5.jpg\",\"__initializer__\":null,\"__cloner__\":null,\"__isInitialized__\":true},\"amount\":2,\"size\":\"25cm\",\"calzone\":false}#{\"id\":25,\"pizza\":{\"id\":8,\"name\":\"American Pizza\",\"price\":\"8.99\",\"category\":{\"__initializer__\":null,\"__cloner__\":null,\"__isInitialized__\":true,\"id\":1,\"name\":\"Vegetarisch\",\"img\":\"\"},\"image\":\"pizza-4-63453907cb9b7.jpg\",\"__initializer__\":null,\"__cloner__\":null,\"__isInitialized__\":true},\"amount\":1,\"size\":\"25cm\",\"calzone\":true}'),
(11, 1, '{\"streetName\":\"Van Mierisstraat\",\"streetNumber\":\"177\",\"addition\":\"A\",\"postalCode\":\"2526NR\"}', 'done', '{\"id\":26,\"pizza\":{\"id\":4,\"name\":\"Pizza Salami\",\"price\":\"10.99\",\"category\":{\"__initializer__\":[],\"__cloner__\":[],\"__isInitialized__\":false,\"id\":2,\"name\":\"Vlees\",\"img\":\"\"},\"image\":\"Salami-8050-634525f0c5224.png\",\"__initializer__\":null,\"__cloner__\":null,\"__isInitialized__\":true},\"amount\":3,\"size\":\"25cm\",\"calzone\":false}#{\"id\":27,\"pizza\":{\"id\":3,\"name\":\"Pepperoni Pizza\",\"price\":\"9.99\",\"category\":{\"__initializer__\":null,\"__cloner__\":null,\"__isInitialized__\":true,\"id\":2,\"name\":\"Vlees\",\"img\":\"\"},\"image\":\"double_Pepperoni-8056.png\",\"__initializer__\":null,\"__cloner__\":null,\"__isInitialized__\":true},\"amount\":2,\"size\":\"25cm\",\"calzone\":false}'),
(12, 1, '{\"streetName\":\"a\",\"streetNumber\":\"a\",\"addition\":\"a\",\"postalCode\":\"a\"}', 'done', '{\"id\":28,\"pizza\":{\"id\":7,\"name\":\"Caucasian Pizza\",\"price\":\"7.99\",\"category\":{\"__initializer__\":[],\"__cloner__\":[],\"__isInitialized__\":false,\"id\":1,\"name\":\"Vegetarisch\",\"img\":\"\"},\"image\":\"pizza-3-634538f5c999b.jpg\",\"__initializer__\":null,\"__cloner__\":null,\"__isInitialized__\":true},\"amount\":1,\"size\":\"25cm\",\"calzone\":false}');

-- --------------------------------------------------------

--
-- Table structure for table `pizza`
--

CREATE TABLE `pizza` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pizza`
--

INSERT INTO `pizza` (`id`, `name`, `price`, `category_id`, `image`) VALUES
(1, 'Spicy BBQ Pulled Pork', '14.99', 2, 'NL-PSPP-all-menu-9972-63482402880de.jpg'),
(2, 'Hawaian Pizza', '11.99', 1, 'Hawaii-8059.png'),
(3, 'Pepperoni Pizza', '9.99', 2, 'double_Pepperoni-8056.png'),
(4, 'Pizza Salami', '10.99', 2, 'Salami-8050-634525f0c5224.png'),
(5, 'Italian Pizza', '7.99', 1, 'pizza-1-6345384383151.jpg'),
(6, 'Greek Pizza', '7.99', 1, 'pizza-2-634538de17dd5.jpg'),
(7, 'Caucasian Pizza', '7.99', 1, 'pizza-3-634538f5c999b.jpg'),
(8, 'American Pizza', '8.99', 1, 'pizza-4-63453907cb9b7.jpg'),
(9, 'Tomatoe Pie', '8.99', 1, 'pizza-5-63453918b3d9f.jpg'),
(10, 'Margherita Pizza', '9.99', 1, 'pizza-6-6345392eef63b.jpg'),
(11, 'Sweet Smokey Chicken Pizza', '14.99', 2, 'NL-PSSC-all-menu-6347f1e2773d9.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `shoppingcart_pizza`
--

CREATE TABLE `shoppingcart_pizza` (
  `id` int(11) NOT NULL,
  `pizza_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `size` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `calzone` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `firstname`, `lastname`) VALUES
(1, 'admin@admin.nl', '[\"ROLE_USER\",\"ROLE_ADMIN\"]', '$2y$13$2pbgD1v5Un1XmsrwojxvTu4IfkoSpuYhc5PDfnR4RXOjCrd2ixfkq', 'Admin', 'Admin'),
(2, 'test1@test.nl', '[\"ROLE_USER\"]', '$2y$13$VxKQdN.HYB4mK1I8FJlGLu4FLCB49CZkFQ/4ji5Cbvc6pcxMFRICm', 'Yusuf', 'Celik'),
(3, 'test2@test.nl', '[\"ROLE_USER\"]', '$2y$13$B.SYFtmPiVyMxkiUTa9Rcu9RHDteYu0RuPGPl5SPC4X2sYpo7aklG', 'Yusuf', 'Celik');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E52FFDEEA76ED395` (`user_id`);

--
-- Indexes for table `pizza`
--
ALTER TABLE `pizza`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_CFDD826FC53D045F` (`image`),
  ADD KEY `IDX_CFDD826F12469DE2` (`category_id`);

--
-- Indexes for table `shoppingcart_pizza`
--
ALTER TABLE `shoppingcart_pizza`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C8CF76A9D41D1D42` (`pizza_id`),
  ADD KEY `IDX_C8CF76A9A76ED395` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pizza`
--
ALTER TABLE `pizza`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `shoppingcart_pizza`
--
ALTER TABLE `shoppingcart_pizza`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `FK_E52FFDEEA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `pizza`
--
ALTER TABLE `pizza`
  ADD CONSTRAINT `FK_CFDD826F12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Constraints for table `shoppingcart_pizza`
--
ALTER TABLE `shoppingcart_pizza`
  ADD CONSTRAINT `FK_C8CF76A9A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_C8CF76A9D41D1D42` FOREIGN KEY (`pizza_id`) REFERENCES `pizza` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
