-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: pma
-- Время создания: Апр 01 2019 г., 18:01
-- Версия сервера: 8.0.15
-- Версия PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `geek_brains_shop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `baskets`
--

CREATE TABLE `baskets` (
  `id` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `productId` int(11) NOT NULL,
  `amount` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Дамп данных таблицы `baskets`
--

INSERT INTO `baskets` (`id`, `userId`, `productId`, `amount`) VALUES
(14, 1, 27, 1),
(15, 1, 48, 1),
(16, 1, 37, 1),
(17, 1, 34, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `dateCreate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `dateChange` timestamp NULL DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `parentId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `css`
--

CREATE TABLE `css` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `size` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `css`
--

INSERT INTO `css` (`id`, `name`, `url`, `size`) VALUES
(1, 'style', 'css/style.css', NULL),
(2, 'product', 'css/product.css', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `size` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `images`
--

INSERT INTO `images` (`id`, `url`, `views`, `title`, `size`) VALUES
(1, 'img/BMW_328_Hommage.jpg', 0, 'BMW 328-Hommage', NULL),
(2, 'img/BMW_M1_Hommage.jpg', 0, 'BMW M1-Hommage', NULL),
(3, 'img/Bugatti_Divo.jpg', 1, 'Bugatti Divo', 'NULL'),
(4, 'img/Ferrari_F12_TRS.jpg', 21, 'Ferrari F12-TRS', 'NULL'),
(5, 'img/Ford_Mustang_Hornicorn.jpg', 0, 'Ford Mustang-Hornicorn', NULL),
(6, 'img/Koenigsegg_Regera_R.jpg', 0, 'Koenigsegg Regera-R', NULL),
(7, 'img/Lamborghini_Centenario.jpg', 0, 'Lamborghini Centenario', NULL),
(8, 'img/Lexus_LFA.jpg', 0, 'Lexus LFA', NULL),
(9, 'img/Lykan_Hypersport.jpg', 1, 'Lykan Hypersport', 'NULL'),
(10, 'img/Maserati_GT.jpg', 0, 'Maserati GT', NULL),
(11, 'img/MClaren_P1.jpg', 0, 'MClaren P1', NULL),
(12, 'img/Pagani_Huayra.jpg', 1, 'Pagani Huayra', 'NULL'),
(13, 'img/Porsche_918_Spyder.jpg', 1, 'Porsche 918-Spyder', 'NULL'),
(14, 'img/SSC_Tuatara.jpg', 0, 'SSC Tuatara', 'NULL'),
(15, 'img/Tesla_Roadster.jpg', 0, 'Tesla Roadster', NULL),
(16, 'img/Zenvo_TSR_GT.jpg', 0, 'Zenvo TSR-GT', NULL),
(17, 'img/Acura_NSX.jpg', 1, 'Acura NSX', 'NULL'),
(18, 'img/Alfa_Romeo_8c_Spider.jpg', 2, 'Alfa-Romeo 8c-Spider', 'NULL'),
(19, 'img/Aston_Martin_DBS.jpg', 2, 'Aston-Martin DBS', 'NULL'),
(20, 'img/Audi_R8_LMS_GT3.jpg', 0, 'Audi R8-LMS-GT3', NULL),
(21, 'img/Audi_TT_RS.jpg', 0, 'Audi TT-RS', NULL),
(22, 'img/Bentley_Continental_GT.jpg', 1, 'Bentley Continental-GT', 'NULL'),
(23, 'img/BMW_I8.jpg', 4, 'BMW I8', 'NULL'),
(24, 'img/BMW_M3_GT3_RS.jpg', 2, 'BMW M3-GT3-RS', 'NULL'),
(25, 'img/BMW_M4_Performance.jpg', 1, 'BMW M4-Performance', 'NULL'),
(26, 'img/BMW_M6_GT3.jpg', 0, 'BMW M6-GT3', NULL),
(27, 'img/Chevrolet_Camaro_ZL1.jpg', 0, 'Chevrolet Camaro-ZL1', NULL),
(28, 'img/Chevrolet_Corvette_ZR1.jpg', 0, 'Chevrolet Corvette-ZR1', NULL),
(29, 'img/Dodge_Charger_SRT_Hellcat.jpg', 0, 'Dodge Charger-SRT-Hellcat', NULL),
(30, 'img/Dodge_Viper_ACR.jpg', 0, 'Dodge Viper-ACR', NULL),
(31, 'img/Ferrari_458_Italia.jpg', 1, 'Ferrari 458-Italia', 'NULL'),
(32, 'img/Ferrari_488_GTB.jpg', 0, 'Ferrari 488-GTB', NULL),
(33, 'img/Ferrari_California_T.jpg', 1, 'Ferrari California-T', 'NULL'),
(34, 'img/Ferrari_Enzo.jpg', 0, 'Ferrari Enzo', NULL),
(35, 'img/Ferrari_LaFerrari.jpg', 2, 'Ferrari LaFerrari', 'NULL'),
(36, 'img/Ford_GT.jpg', 1, 'Ford GT', 'NULL'),
(37, 'img/Ford_Mustang_RTR.jpg', 0, 'Ford Mustang-RTR', NULL),
(38, 'img/Gumpert_Apollo_S.jpg', 0, 'Gumpert Apollo S', NULL),
(39, 'img/Hennessey_Venom_GT_Spyder.jpg', 0, 'Hennessey Venom-GT-Spyder', NULL),
(40, 'img/Honda_Civic_Type_R.jpg', 0, 'Honda Civic-Type-R', NULL),
(41, 'img/Jaguar_F_Type.jpg', 1, 'Jaguar F-Type', NULL),
(42, 'img/Jaguar_XKR_S_GT.jpg', 1, 'Jaguar XKR-S-GT', 'NULL'),
(43, 'img/Lamborghini_Aventador_SC18.jpg', 1, 'Lamborghini Aventador-SC18', 'NULL'),
(44, 'img/Lamborghini_Elemento.jpg', 0, 'Lamborghini Elemento', NULL),
(45, 'img/Lamborghini_Veneno_Roadster.jpg', 1, 'Lamborghini Veneno-Roadster', 'NULL'),
(46, 'img/Lexus_LC500.jpg', 3, 'Lexus LC500', 'NULL'),
(47, 'img/Lotus_Evora_GT430.jpg', 0, 'Lotus Evora-GT430', NULL),
(48, 'img/Mazda_RX_7.jpg', 0, 'Mazda RX-7', NULL),
(49, 'img/MClaren_720S.jpg', 1, 'MClaren 720S', 'NULL'),
(50, 'img/Mercedes_SLS_AMG_GT.jpg', 0, 'Mercedes SLS-AMG-GT', NULL),
(51, 'img/Mitsubishi_Evo_X.jpg', 0, 'Mitsubishi Evo-X', NULL),
(52, 'img/Nissan_GT_R_Nismo_GT3.jpg', 0, 'Nissan GT-R-Nismo-GT3', NULL),
(53, 'img/Noble_M600.jpg', 0, 'Noble M600', NULL),
(54, 'img/Pontiac_Solstice.jpg', 0, 'Pontiac Solstice', NULL),
(55, 'img/Porsche_911_GT3_RS.jpg', 1, 'Porsche 911-GT3-RS', 'NULL'),
(56, 'img/Shelby_Cobra_1967.jpg', 1, 'Shelby Cobra-1967', 'NULL'),
(57, 'img/Subaru_BRZ_TS.jpg', 0, 'Subaru BRZ-TS', NULL),
(58, 'img/Toyota_Supra_GR.jpg', 0, 'Toyota Supra-GR', NULL),
(59, 'img/TVR_Griffith.jpg', 1, 'TVR Griffith', 'NULL'),
(60, 'img/TVR_Tuscan.jpg', 0, 'TVR Tuscan', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `js`
--

CREATE TABLE `js` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `size` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `js`
--

INSERT INTO `js` (`id`, `name`, `url`, `size`) VALUES
(1, 'jQuery', 'js/jquery-3.3.1.min.js', NULL),
(2, 'Gallery', 'js/Gallery.js', NULL),
(3, 'Main', 'js/main.js', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `orderproducts`
--

CREATE TABLE `orderproducts` (
  `id` int(11) NOT NULL,
  `orderId` int(11) DEFAULT NULL,
  `productId` int(11) NOT NULL,
  `price` float(11,2) NOT NULL DEFAULT '0.00',
  `dateCreate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `dateChange` timestamp NULL DEFAULT NULL,
  `amount` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1 - активен, 2 - неактивен, 3 - удален, 4 - подтвержден'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Дамп данных таблицы `orderproducts`
--

INSERT INTO `orderproducts` (`id`, `orderId`, `productId`, `price`, `dateChange`, `amount`, `status`) VALUES
(1, 9, 3, 0.00, NULL, 2, 1),
(2, 9, 4, 0.00, NULL, 1, 1),
(3, 9, 7, 0.00, NULL, 1, 1),
(4, 10, 6, 0.00, NULL, 1, 1),
(5, 10, 1, 0.00, NULL, 2, 1),
(6, 11, 2, 0.00, NULL, 1, 1),
(7, 11, 5, 0.00, NULL, 1, 1),
(8, 12, 4, 0.00, NULL, 1, 1),
(9, 12, 5, 0.00, NULL, 1, 1),
(10, 12, 2, 0.00, NULL, 1, 1),
(85, 52, 10, 170000.00, NULL, 1, 1),
(86, 53, 27, 1400000.00, NULL, 1, 1),
(87, 53, 11, 320000.00, NULL, 1, 1),
(88, 53, 28, 325000.00, NULL, 1, 1),
(89, 54, 35, 325000.00, NULL, 1, 1),
(90, 54, 48, 750000.00, NULL, 1, 1),
(91, 55, 11, 320000.00, NULL, 1, 1),
(92, 55, 12, 415000.00, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `dateCreate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateChange` timestamp NULL DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1 - активен, 2 - неактивен, 3- оплачен, 4 - доставлен'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `userId`, `address`, `dateChange`, `status`) VALUES
(9, 1, '', '2019-04-01 15:17:41', 1),
(10, 3, '', '2019-04-01 14:57:00', 1),
(11, 1, NULL, NULL, 4),
(12, 3, '', '2019-04-01 14:57:04', 3),
(52, 3, '', NULL, 1),
(53, 3, '', NULL, 1),
(54, 3, '', NULL, 1),
(55, 3, '', NULL, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `price` float(11,2) DEFAULT '0.00',
  `image` varchar(255) NOT NULL,
  `dateCreate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `dateChange` timestamp NULL DEFAULT NULL,
  `isActive` tinyint(4) NOT NULL DEFAULT '1',
  `categoryId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `dateChange`, `isActive`, `categoryId`) VALUES
(1, 'BMW 328-Hommage', 'BMW 328-Hommage Concept', 200000.00, 'img/BMW_328_Hommage.jpg', '2019-03-31 14:08:22', 1, 0),
(2, 'Bugatti Divo', 'Latest model of Bugatti', 1500000.00, 'img/Bugatti_Divo.jpg', NULL, 1, 0),
(3, 'Ferrari F12-TRS', 'The best of Ferrari', 1000000.00, 'img/Ferrari_F12_TRS.jpg', NULL, 1, 0),
(4, 'Koenigsegg Regera-R', 'Amazing hypercar by Koenigsegg', 700000.00, 'img/Koenigsegg_Regera_R.jpg', NULL, 1, 0),
(5, 'Lexus LFA', 'Supercar by LEXUS', 300000.00, 'img/Lexus_LFA.jpg', NULL, 1, 0),
(6, 'MClaren P1', 'Just MClaren', 800000.00, 'img/MClaren_P1.jpg', NULL, 1, 0),
(7, 'Pagani Huayra', 'Pagani 2018 model', 800000.00, 'img/Pagani_Huayra.jpg', NULL, 1, 0),
(8, 'Zenvo TSR-GT', 'Zenvo hypersport', 1200000.00, 'img/Zenvo_TSR_GT.jpg', NULL, 1, 0),
(9, 'Acura NSX', 'New Acura NSX', 120000.00, 'img/Acura_NSX.jpg', NULL, 1, 0),
(10, 'Alfa-Romeo 8c-Spider', '8c-Spider by Alfa-Romeo ', 170000.00, 'img/Alfa_Romeo_8c_Spider.jpg', NULL, 1, 0),
(11, 'Aston-Martin DBS', 'Just Aston', 320000.00, 'img/Aston_Martin_DBS.jpg', NULL, 1, 0),
(12, 'Audi R8-LMS-GT3', 'R8 Le Mans edition', 415000.00, 'img/Audi_R8_LMS_GT3.jpg', NULL, 1, 0),
(13, 'Audi TT-RS', 'Fastest TT of 2018', 130000.00, 'img/Audi_TT_RS.jpg', NULL, 1, 0),
(14, 'Bentley Continental-GT', 'Bentley Continental an amazing Gran Turismo', 340000.00, 'img/Bentley_Continental_GT.jpg', NULL, 1, 0),
(15, 'BMW I8', 'Electric sports car by BMW', 1500000.00, 'img/BMW_I8.jpg', NULL, 1, 0),
(16, 'BMW M3-GT3-RS', 'Most powerful M3', 110000.00, 'img/BMW_M3_GT3_RS.jpg', NULL, 1, 0),
(17, 'BMW M4-Performance', 'Amazing Performance of BMW', 125000.00, 'img/BMW_M4_Performance.jpg', NULL, 1, 0),
(18, 'BMW M6-GT3', 'BMW M6-GT3', 170000.00, 'img/BMW_M6_GT3.jpg', NULL, 1, 0),
(19, 'Chevrolet Camaro-ZL1', 'Chevrolet Camaro-ZL1', 190000.00, 'img/Chevrolet_Camaro_ZL1.jpg', NULL, 1, 0),
(20, 'Chevrolet Corvette-ZR1', 'Chevrolet Corvette-ZR1', 230000.00, 'img/Chevrolet_Corvette_ZR1.jpg', NULL, 1, 0),
(21, 'Dodge Charger-SRT-Hellcat', 'Dodge Charger-SRT-Hellcat', 127000.00, 'img/Dodge_Charger_SRT_Hellcat.jpg', NULL, 1, 0),
(22, 'Dodge Viper-ACR', 'Dodge Viper-ACR', 140000.00, 'img/Dodge_Viper_ACR.jpg', NULL, 1, 0),
(23, 'Ferrari 458-Italia', 'Ferrari 458-Italia', 290000.00, 'img/Ferrari_458_Italia.jpg', NULL, 1, 0),
(24, 'Ferrari 488-GTB', 'Ferrari 488-GTB', 570000.00, 'img/Ferrari_488_GTB.jpg', NULL, 1, 0),
(25, 'Ferrari California-T', 'Ferrari California-T', 370000.00, 'img/Ferrari_California_T.jpg', NULL, 1, 0),
(26, 'Ferrari Enzo', 'Ferrari Enzo', 990000.00, 'img/Ferrari_Enzo.jpg', NULL, 1, 0),
(27, 'Ferrari LaFerrari', 'Ferrari LaFerrari', 1400000.00, 'img/Ferrari_LaFerrari.jpg', NULL, 1, 0),
(28, 'Ford GT', 'Ford GT', 325000.00, 'img/Ford_GT.jpg', NULL, 1, 0),
(29, 'Ford Mustang-RTR', 'Ford Mustang-RTR', 105000.00, 'img/Ford_Mustang_RTR.jpg', NULL, 1, 0),
(30, 'Gumpert Apollo S', 'Gumpert Apollo S', 850000.00, 'img/Gumpert_Apollo_S.jpg', NULL, 1, 0),
(31, 'Hennessey Venom-GT-Spyder', 'Hennessey Venom-GT-Spyder', 1550000.00, 'img/Hennessey_Venom_GT_Spyder.jpg', NULL, 1, 0),
(32, 'Honda Civic-Type-R', 'Honda Civic-Type-R', 100000.00, 'img/Honda_Civic_Type_R.jpg', NULL, 1, 0),
(33, 'Jaguar F-Type', 'Jaguar F-Type', 85000.00, 'img/Jaguar_F_Type.jpg', NULL, 1, 0),
(34, 'Jaguar XKR-S-GT', 'Jaguar XKR-S-GT', 135000.00, 'img/Jaguar_XKR_S_GT.jpg', NULL, 1, 0),
(35, 'Lamborghini Aventador-SC18', 'Lamborghini Aventador-SC18', 325000.00, 'img/Lamborghini_Aventador_SC18.jpg', NULL, 1, 0),
(36, 'Lamborghini Elemento', 'Lamborghini Elemento', 450000.00, 'img/Lamborghini_Elemento.jpg', NULL, 1, 0),
(37, 'Lamborghini Veneno-Roadster', 'Lamborghini Veneno-Roadster', 540000.00, 'img/Lamborghini_Veneno_Roadster.jpg', NULL, 1, 0),
(38, 'Lexus LC500', 'Lexus LC500', 80000.00, 'img/Lexus_LC500.jpg', NULL, 1, 0),
(39, 'Lotus Evora-GT430', 'Lotus Evora-GT430', 70000.00, 'img/Lotus_Evora_GT430.jpg', NULL, 1, 0),
(40, 'Mazda RX-7', 'Mazda RX-7', 50000.00, 'img/Mazda_RX_7.jpg', NULL, 1, 0),
(41, 'MClaren 720S', 'MClaren 720S', 420000.00, 'img/MClaren_720S.jpg', NULL, 1, 0),
(42, 'Mercedes SLS-AMG-GT', 'Mercedes SLS-AMG-GT', 335000.00, 'img/Mercedes_SLS_AMG_GT.jpg', NULL, 1, 0),
(43, 'Mitsubishi Evo-X', 'Mitsubishi Evo-X', 50000.00, 'img/Mitsubishi_Evo_X.jpg', NULL, 1, 0),
(44, 'Nissan GT-R-Nismo-GT3', 'Nissan GT-R-Nismo-GT3', 70000.00, 'img/Nissan_GT_R_Nismo_GT3.jpg', NULL, 1, 0),
(45, 'Noble M600', 'Noble M600', 55000.00, 'img/Noble_M600.jpg', NULL, 1, 0),
(46, 'Pontiac Solstice', 'Pontiac Solstice', 115000.00, 'img/Pontiac_Solstice.jpg', NULL, 1, 0),
(47, 'Porsche 911-GT3-RS', 'Porsche 911-GT3-RS', 330000.00, 'img/Porsche_911_GT3_RS.jpg', NULL, 1, 0),
(48, 'Shelby Cobra-1967', 'Shelby Cobra-1967', 750000.00, 'img/Shelby_Cobra_1967.jpg', NULL, 1, 0),
(49, 'Subaru BRZ-TS', 'Subaru BRZ-TS', 45000.00, 'img/Subaru_BRZ_TS.jpg', NULL, 1, 0),
(50, 'Toyota Supra-GR', 'Toyota Supra-GR', 60000.00, 'img/Toyota_Supra_GR.jpg', NULL, 1, 0),
(51, 'TVR Griffith', 'TVR Griffith', 80000.00, 'img/TVR_Griffith.jpg', NULL, 1, 0),
(52, 'TVR Tuscan', 'TVR Tuscan', 90000.00, 'img/TVR_Tuscan.jpg', NULL, 1, 0),
(53, 'Lykan Hypersport', 'Lykan Hypersport', 2500000.00, 'img/Lykan_Hypersport.jpg', NULL, 1, 0),
(54, 'Maserati GT', 'Maserati GT', 155000.00, 'img/Maserati_GT.jpg', NULL, 1, 0),
(55, 'MClaren P1', 'MClaren P1', 340000.00, 'img/MClaren_P1.jpg', NULL, 1, 0),
(56, 'Pagani Huayra', 'Pagani Huayra', 980000.00, 'img/Pagani_Huayra.jpg', NULL, 1, 0),
(57, 'Porsche 918-Spyder', 'Porsche 918-Spyder', 570000.00, 'img/Porsche_918_Spyder.jpg', NULL, 1, 0),
(58, 'SSC Tuatara', 'SSC Tuatara', 3000000.00, 'img/SSC_Tuatara.jpg', NULL, 1, 0),
(59, 'Tesla Roadster', 'Tesla Roadster', 380000.00, 'img/Tesla_Roadster.jpg', NULL, 1, 0),
(60, 'Zenvo TSR-GT', 'Zenvo TSR-GT', 1700000.00, 'img/Zenvo_TSR_GT.jpg', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `stocks`
--

CREATE TABLE `stocks` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `discount` int(11) NOT NULL COMMENT 'percent',
  `active` int(11) NOT NULL DEFAULT '0' COMMENT '0 - no, 1 - yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `stocks`
--

INSERT INTO `stocks` (`id`, `name`, `discount`, `active`) VALUES
(1, 'hot offer of march', 15, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(11) NOT NULL DEFAULT '0' COMMENT '0 - user, 1 - admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `login`, `password`, `role`) VALUES
(1, 'admin', 'admin@admin.ru', '4297f44b13955235245b2497399d7a93', 1),
(3, 'user', 'user@user.ru', '4297f44b13955235245b2497399d7a93', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `baskets`
--
ALTER TABLE `baskets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cart_user_id` (`userId`),
  ADD KEY `fk_cart_product_id` (`productId`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `isActive` (`isActive`),
  ADD KEY `parentId` (`parentId`);

--
-- Индексы таблицы `css`
--
ALTER TABLE `css`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Индексы таблицы `js`
--
ALTER TABLE `js`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orderproducts`
--
ALTER TABLE `orderproducts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usord_order_id` (`orderId`) USING BTREE,
  ADD KEY `productId` (`productId`),
  ADD KEY `orderId` (`orderId`,`productId`) USING BTREE;

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `user_id` (`userId`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `baskets`
--
ALTER TABLE `baskets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `css`
--
ALTER TABLE `css`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT для таблицы `js`
--
ALTER TABLE `js`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `orderproducts`
--
ALTER TABLE `orderproducts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT для таблицы `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `orderproducts`
--
ALTER TABLE `orderproducts`
  ADD CONSTRAINT `fk_ordsProds_order_id` FOREIGN KEY (`orderId`) REFERENCES `orders` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_ordsProds_product_id` FOREIGN KEY (`productId`) REFERENCES `products` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_user_id` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
