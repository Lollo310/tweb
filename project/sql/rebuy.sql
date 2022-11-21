-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Set 02, 2022 alle 18:58
-- Versione del server: 10.4.22-MariaDB
-- Versione PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rebuy`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `orders`
--

CREATE TABLE `orders` (
  `no` bigint(20) UNSIGNED NOT NULL,
  `date_of_purchase` date NOT NULL,
  `buyer` bigint(20) UNSIGNED NOT NULL,
  `address` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `brand` varchar(32) NOT NULL,
  `name` varchar(64) NOT NULL,
  `model` varchar(32) NOT NULL,
  `year_of_production` char(4) NOT NULL,
  `img` varchar(128) NOT NULL,
  `size` varchar(16) NOT NULL,
  `seller` bigint(20) UNSIGNED NOT NULL,
  `condition` varchar(16) NOT NULL,
  `price` varchar(16) NOT NULL,
  `order` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `products`
--

INSERT INTO `products` (`id`, `brand`, `name`, `model`, `year_of_production`, `img`, `size`, `seller`, `condition`, `price`, `order`) VALUES
(48, 'Samsung', 'S21', 'NKJ4536JX', '2018', 'images/products/Samsung_S21.png', '6/128', 9, 'Very Good', '699.00', NULL),
(50, 'OnePlus', '10T', 'NH5738KS', '2022', 'images/products/10T-Green-L.png', '8/128', 9, 'Like New', '620.50', NULL),
(51, 'Apple', 'iPhone 12 Pro', 'IP120RO', '2021', 'images/products/12-pro.jpg', '3/64', 9, 'Very Good', '1099.99', NULL),
(52, 'Huawei', 'Mate 30 Pro', 'MA303RO', '2020', 'images/products/HuaweiMate30Pro__1_.jpg', '12/256', 9, 'Acceptable', '499.00', NULL),
(53, 'OnePlus', 'Nord 2 5G', 'NO256DG', '2019', 'images/products/4_zu_3_OnePlus_Nord_2_5G.jpg', '6/128', 9, 'Good', '256.00', NULL),
(54, 'Samsung', 'A53 5G', 'A535G', '2018', 'images/products/it-galaxy-a53-5g.png', '4/128', 9, 'Acceptable', '200.00', NULL),
(55, 'Xiaomi', 'Mi 11T Pro', 'MI11RO', '2020', 'images/products/11T-pro.png', '6/128', 9, 'Very Good', '749.99', NULL),
(56, 'Xiaomi', 'Mi 12 5G', 'MI125G', '2021', 'images/products/L3_Xiaomi12_5g.png', '8/128', 9, 'Like New', '529.79', NULL),
(57, 'Xiaomi', 'Mi 11 Lite', 'MI115TE', '2020', 'images/products/mi_11_lite.png', '6/128', 9, 'Very Good', '229.49', NULL),
(58, 'Xiaomi', 'Mi 9 Lite', 'MI9LITE', '2018', 'images/products/mi-9-lite.jpg', '4/64', 25, 'Acceptable', '129.00', NULL),
(59, 'Xiaomi', 'Mi 12 Pro', 'MI12PRO', '2022', 'images/products/mi-12-pro.jpg', '12/256', 25, 'Like New', '999.99', NULL),
(60, 'Xiaomi', 'Mi 12 Pro', 'MI12PROGR', '2022', 'images/products/mi-12-pro_gray.jpg', '8/128', 25, 'Like New', '899.99', NULL),
(61, 'Huawei', '50', 'HO50OR', '2021', 'images/products/50.jpg', '8/128', 25, 'Very Good', '500.50', NULL),
(62, 'Huawei', '50 Lite', 'HO50TE', '2021', 'images/products/50-lite.jpg', '6/128', 25, 'Very Good', '399.50', NULL),
(63, 'Huawei', '50', 'HO50DA', '2021', 'images/products/honor-50-dark.jpg', '8/128', 25, 'Very Good', '499.50', NULL),
(64, 'Apple', 'iPhone 13', 'IP13ONE', '2022', 'images/products/13.jpg', '4/64', 25, 'Like New', '1299.99', NULL),
(65, 'Apple', 'iPhone 13 Pro', 'IP13PRO', '2022', 'images/products/13-pro.jpg', '6/128', 25, 'Like New', '1599.99', NULL),
(66, 'Apple', 'iPhone SE', 'IPHONSE', '2018', 'images/products/s-iphone-se-black.jpg', '3/32', 25, 'Acceptable', '299.99', NULL),
(67, 'Oppo', 'A16', 'OPA16PO', '2018', 'images/products/a16.jpg', '4/64', 26, 'Acceptable', '200.00', NULL),
(68, 'Oppo', 'Find X3 Pro', 'FINX3RO', '2019', 'images/products/find-x3-pro.jpg', '6/128', 26, 'Good', '299.00', NULL),
(69, 'Oppo', 'A3s', 'OPA3SPO', '2019', 'images/products/OppoA3s.jpg', '4/64', 26, 'Good', '199.00', NULL),
(70, 'Oppo', 'A53', 'OPA53PO', '2019', 'images/products/oppo-a53.jpg', '4/64', 26, 'Very Good', '249.00', NULL),
(71, 'Oppo', 'Reno 2z', 'REN2ZOO', '2020', 'images/products/reno-2z.jpg', '6/128', 26, 'Very Good', '399.00', NULL),
(72, 'Oppo', 'Reno 6 Pro', 'OP6PRPO', '2019', 'images/products/Reno-6pro.jpg', '6/128', 26, 'Good', '299.00', NULL),
(73, 'Realme', '6', 'REA6LME', '2017', 'images/products/6.jpg', '4/64', 26, 'Acceptable', '199.99', NULL),
(74, 'Realme', '8 Pro', 'REA8PRO', '2019', 'images/products/8-pro.jpg', '4/64', 26, 'Good', '299.99', NULL),
(75, 'Realme', '9 Pro', 'REA9PRO', '2020', 'images/products/9-pro.jpg', '4/64', 26, 'Very Good', '319.99', NULL),
(76, 'Realme', 'C21y', 'REC21YE', '2017', 'images/products/c21y.jpg', '3/64', 26, 'Acceptable', '129.99', NULL),
(77, 'Realme', 'C35', 'REC35ME', '2018', 'images/products/realme_C35.jpg', '3/64', 26, 'Good', '159.99', NULL),
(78, 'Realme', 'GT', 'REGTLME', '2021', 'images/products/realme-gt.jpg', '6/128', 26, 'Very Good', '399.99', NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(60) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `birthday` date NOT NULL,
  `gender` char(1) NOT NULL,
  `email` varchar(132) NOT NULL,
  `phone_number` varchar(13) NOT NULL,
  `seller` tinyint(1) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `birthday`, `gender`, `email`, `phone_number`, `seller`, `password`) VALUES
(9, 'Michele', 'Lorenzo', '2000-01-03', 'M', 'michele.lorenzo@gmail.com', '3803413905', 1, '$2y$10$Jrpm2.stVqmnkK31FJvX4.E7esMn2E3Rd2c/Bm9XlxZv/nRImQL9u'),
(15, 'Aldo', 'Pietromatera', '2000-04-06', 'M', 'aldo.pietromatera@gmail.com', '380380380', 0, '$2y$10$FxwzsKeI7aPlsyaP7dPi3OzmhypDCs4i98VpA.piREwbTdn55ByxG'),
(25, 'Erika', 'Cifarelli', '2001-01-11', 'F', 'erika.cifarelli@gmail.com', '3253145965', 1, '$2y$10$9VC4gu/JsHFhpt2pr8EI4.7tb47RZU/00YqT0gyD42qXInjodyjrq'),
(26, 'Mateusz', 'Moddelsee', '1999-11-21', 'M', 'mateusz.moddelsee@gmail.com', '3336028251', 1, '$2y$10$bjPgJwYpixK0evddMWlBDuSV9OdqAqwUAYqfJb980/9Xbu8PKWkHG');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`no`),
  ADD KEY `FK_orders_users` (`buyer`);

--
-- Indici per le tabelle `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `FK_products_users` (`seller`),
  ADD KEY `FK_products_orders` (`order`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `UNIQUE_Email_Seller` (`email`,`seller`) USING BTREE;

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `orders`
--
ALTER TABLE `orders`
  MODIFY `no` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT per la tabella `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `FK_orders_users` FOREIGN KEY (`buyer`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `FK_products_orders` FOREIGN KEY (`order`) REFERENCES `orders` (`no`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_products_users` FOREIGN KEY (`seller`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
