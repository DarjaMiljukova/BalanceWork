-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Loomise aeg: Nov 11, 2024 kell 11:52 EL
-- Serveri versioon: 10.4.27-MariaDB
-- PHP versioon: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Andmebaas: `solshop`
--

-- --------------------------------------------------------

--
-- Tabeli struktuur tabelile `components`
--

CREATE TABLE `components` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Andmete tõmmistamine tabelile `components`
--

INSERT INTO `components` (`id`, `name`, `description`, `price`, `image_url`, `category`, `stock`, `created_at`) VALUES
(1, 'Intel Core i7-12700K', 'Процессор 12-го поколения Intel Core с 12 ядрами и 20 потоками.', '349.99', 'https://www.rde.ee/images/midi/b76017dc42f5c96221b69286c2dab294.jpg', 'Процессоры', 10, '2024-11-11 09:30:01'),
(2, 'AMD Ryzen 5 5600X', 'Высокопроизводительный процессор с 6 ядрами и 12 потоками для игр и работы.', '229.99', 'https://c.dns-shop.ru/thumb/st4/fit/500/500/5296b3df36b3381db456e085a92cebb5/cca2b331b0947fe2973ee287baea67acb2f568793792d5fe6c2451239a7a9ea0.jpg.webp', 'Процессоры', 15, '2024-11-11 09:30:01'),
(3, 'MSI GeForce RTX 3060', 'Игровая видеокарта с 12 ГБ GDDR6 памяти.', '399.99', 'https://ee2.pigugroup.eu/colours/151/677/09/15167709/msi-geforce-rtx-3060-ventus-2x-8g-264ce_reference.jpg', 'Видеокарты', 8, '2024-11-11 09:30:01'),
(4, 'Gigabyte GeForce GTX 1660 SUPER', 'Энергосберегающая видеокарта с 6 ГБ памяти для Full HD игр.', '249.99', 'https://images.hind.ee/5665/5/gigabyte-gv-n166soc-6gd.jpg', 'Видеокарты', 12, '2024-11-11 09:30:01'),
(5, 'Kingston FURY Beast 16GB', 'Модуль оперативной памяти DDR4 с тактовой частотой 3200 МГц.', '79.99', 'https://9zvc5qhbgl.eu.scalesta-cdn.com/2sXfHzTq-CtFLlekZ6NP-8TCNIE=/fit-in/600x600/filters:format(webp):fill(fff)/https%3A%2F%2Freshop.pro%2Fimages%2Fdetailed%2F2394%2F1490251.png', 'Оперативная память', 25, '2024-11-11 09:30:01'),
(6, 'Corsair Vengeance LPX 32GB', 'Комплект из двух модулей оперативной памяти DDR4 на 3200 МГц.', '159.99', 'https://www.rde.ee/images/midi/d80ff06000606a4f7f3bb3eb55857a53.jpg', 'Оперативная память', 20, '2024-11-11 09:30:01'),
(7, 'Samsung 970 EVO Plus 1TB', 'Высокоскоростной SSD с интерфейсом NVMe для ускорения системы.', '129.99', 'https://ee2.pigugroup.eu/colours/272/023/6/2720236/22f7fda00ba3bc1b66759c3b2beb7875_reference.jpg', 'SSD', 18, '2024-11-11 09:30:01'),
(8, 'WD Blue 1TB', 'Надежный жесткий диск для хранения данных.', '49.99', 'https://i.hinnavaatlus.ee/p/1200/b0/f6/abdc3910940c3910940.JPG', 'Жесткие диски', 30, '2024-11-11 09:30:01');

-- --------------------------------------------------------

--
-- Tabeli struktuur tabelile `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `delivery_address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Andmete tõmmistamine tabelile `orders`
--

INSERT INTO `orders` (`id`, `total_price`, `created_at`, `delivery_address`) VALUES
(1, '1049.97', '2024-11-11 10:04:48', ''),
(2, '699.98', '2024-11-11 10:41:42', 'Sõpruse pst 208');

-- --------------------------------------------------------

--
-- Tabeli struktuur tabelile `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `component_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price_per_item` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Andmete tõmmistamine tabelile `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `component_name`, `quantity`, `price_per_item`) VALUES
(1, 1, 'Intel Core i7-12700K', 3, '349.99'),
(2, 2, 'Intel Core i7-12700K', 2, '349.99');

-- --------------------------------------------------------

--
-- Tabeli struktuur tabelile `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `balance` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Andmete tõmmistamine tabelile `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `balance`) VALUES
(1, 'Max', 'Max@gmail.com', '$2y$10$WqHVxpbom2PwjQnyjtzcSeDjYHVVSipiegD945E48H4130rZFHBOC', '0.00');

--
-- Indeksid tõmmistatud tabelitele
--

--
-- Indeksid tabelile `components`
--
ALTER TABLE `components`
  ADD PRIMARY KEY (`id`);

--
-- Indeksid tabelile `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indeksid tabelile `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indeksid tabelile `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT tõmmistatud tabelitele
--

--
-- AUTO_INCREMENT tabelile `components`
--
ALTER TABLE `components`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT tabelile `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT tabelile `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT tabelile `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tõmmistatud tabelite piirangud
--

--
-- Piirangud tabelile `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
