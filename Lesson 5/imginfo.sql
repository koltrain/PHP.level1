-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Фев 20 2018 г., 23:39
-- Версия сервера: 10.1.29-MariaDB
-- Версия PHP: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `imginfo`
--

-- --------------------------------------------------------

--
-- Структура таблицы `info`
--

CREATE TABLE `info` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `size` int(255) NOT NULL,
  `adress` varchar(255) NOT NULL,
  `pushed` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `info`
--

INSERT INTO `info` (`id`, `name`, `size`, `adress`, `pushed`) VALUES
(1, 'ebec56d5c7a4b0f5e450af0661af7d2c', 92633, 'C:/xampp/htdocs/test.roman/img/', 16),
(2, '73ef7f964f979c09dd0489631e2b3848', 68290, 'C:/xampp/htdocs/test.roman/img/', 8),
(3, '1923b9c682d7f84ad8300d17a7e4b098', 71666, 'C:/xampp/htdocs/test.roman/img/', 2),
(4, '68558b32df2786f5ef94c0ade8f02e68', 100461, 'C:/xampp/htdocs/test.roman/img/', 2),
(5, 'd5eedd05aebc494219f3880624f70802', 94509, 'C:/xampp/htdocs/test.roman/img/', 2),
(6, '92c6560f91a655e733f15ce76930216a', 80158, 'C:/xampp/htdocs/test.roman/img/', 3),
(7, 'd71886c01a071fb8933c19c2d3b05551', 62112, 'C:/xampp/htdocs/test.roman/img/', 1),
(8, '6a0de0e9146face6a6b2185f941ae5d6', 51866, 'C:/xampp/htdocs/test.roman/img/', 6),
(9, '943f2b0aa171125a8fa14703ebe05ac9', 152741, 'C:/xampp/htdocs/test.roman/img/', 1),
(10, '9c01bedc7a5eb7a6bd810e910c0495d9', 247095, 'C:/xampp/htdocs/test.roman/img/', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `info`
--
ALTER TABLE `info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `info`
--
ALTER TABLE `info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
