-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Апр 30 2023 г., 00:41
-- Версия сервера: 10.4.27-MariaDB
-- Версия PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `build`
--

-- --------------------------------------------------------

--
-- Структура таблицы `approve`
--

CREATE TABLE `approve` (
  `id` int(11) NOT NULL,
  `id_owner` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `id_const` int(11) NOT NULL,
  `id_flat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `approve`
--

INSERT INTO `approve` (`id`, `id_owner`, `id_client`, `id_const`, `id_flat`) VALUES
(3, 2, 2, 3, 1),
(4, 2, 1, 3, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `construction`
--

CREATE TABLE `construction` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `geoposition` text NOT NULL,
  `const_img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `construction`
--

INSERT INTO `construction` (`id`, `id_user`, `name`, `geoposition`, `const_img`) VALUES
(3, 2, 'Здание', 'Пушкино', 'upload/construction/1682798477Desert.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `flat`
--

CREATE TABLE `flat` (
  `id` int(11) NOT NULL,
  `id_const` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `descr` text NOT NULL,
  `square_meter` int(11) NOT NULL,
  `price` text NOT NULL,
  `flat_img` text NOT NULL,
  `free` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `flat`
--

INSERT INTO `flat` (`id`, `id_const`, `name`, `descr`, `square_meter`, `price`, `flat_img`, `free`) VALUES
(1, 3, 'Квартира 1', '<p><strong>Lorem Ipsum</strong>&nbsp;- это текст-\"рыба\", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной \"рыбой\" для текстов на латинице с начала XVI века. В то время некий безымянный печатник создал большую коллекцию размеров и форм шрифтов, используя Lorem Ipsum для распечатки образцов. Lorem Ipsum не только успешно пережил без заметных изменений пять веков, но и перешагнул в электронный дизайн. Его популяризации в новое время послужили публикация листов Letraset с образцами Lorem Ipsum в 60-х годах и, в более недавнее время, программы электронной вёрстки типа Aldus PageMaker, в шаблонах которых используется Lorem Ipsum.</p>', 78, '3.000.000 руб', 'upload/flat/1682799844Lighthouse.jpg', 1),
(3, 3, 'Квартира 2', '<p><strong>Lorem Ipsum</strong>&nbsp;- это текст-\"рыба\", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной \"рыбой\" для текстов на латинице с начала XVI века. В то время некий безымянный печатник создал большую коллекцию размеров и форм шрифтов, используя Lorem Ipsum для распечатки образцов. Lorem Ipsum не только успешно пережил без заметных изменений пять веков, но и перешагнул в электронный дизайн. Его популяризации в новое время послужили публикация листов Letraset с образцами Lorem Ipsum в 60-х годах и, в более недавнее время, программы электронной вёрстки типа Aldus PageMaker, в шаблонах которых используется Lorem Ipsum.</p>', 101, '6.000.000 руб', 'upload/flat/1682804130Jellyfish.jpg', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `idgroup` int(11) NOT NULL,
  `login` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL,
  `phone` text NOT NULL,
  `full_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `idgroup`, `login`, `password`, `email`, `phone`, `full_name`) VALUES
(1, 3, 'client', '$2y$10$Dv/2XT7f4Xj93iTywRGz6OQM7CDKXrOMwXMMBAKlZ/6IK50JG8ErO', 'client@client', '123', 'client'),
(2, 2, 'owner', '$2y$10$tgKX6H1I4MhhiKnNe8tpHOthAB08ekTPZTZJWuQJ.Ps3iBYC/VSt.', 'owner@owner', '123', 'owner'),
(3, 1, 'admin', '$2y$10$JABHCON9LvxQhZqVnJBHH.ubPT.3CKSIZuniBNcXoKtmqIoGd8Nxi', 'admin@admin', '123', 'admin'),
(4, 2, 'owner2', '$2y$10$Y8mo32vbYD8Z4eF9vBnXxePzXToWqkJrxIk1w.5DcDrpV.D83t9Ru', 'owner2@owner2', '123', 'owner2');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `approve`
--
ALTER TABLE `approve`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `construction`
--
ALTER TABLE `construction`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `flat`
--
ALTER TABLE `flat`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `approve`
--
ALTER TABLE `approve`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `construction`
--
ALTER TABLE `construction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `flat`
--
ALTER TABLE `flat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
