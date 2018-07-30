-- MySQL dump 10.14  Distrib 5.5.56-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: shop
-- ------------------------------------------------------
-- Server version	5.5.56-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `position` tinyint(4) DEFAULT '1',
  `is_visible` tinyint(1) DEFAULT '0',
  `image_name` varchar(100) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Первая категория',5,1,'f195ee0fe20e8f6ae729fa1e5a3e329b_1519585466.jpg',1519585466,1519587662,1),(2,'Вторая категория',1,1,'bc07dc9f4719c1837245d17b86629fd6_1519585476.jpg',1519585476,1519589966,1),(3,'Третья категория',1,1,'a7d05bd156f0eae3b8661bf8c24bfdd6_1519587780.jpg',1519585485,1519587780,1),(4,'Смартфоны',1,1,'0d1405a792948e46f849f318525e5c09_1519590065.jpg',1519590065,1519836290,0),(5,'Планшеты',2,1,'f828abc97a851ded67a597e5dbba60f9_1519590194.jpg',1519590194,NULL,0),(6,'Ноутбуки',3,1,'f3ccdd27d2000e3f9255a7e3e2c48800_1519590282.jpg',1519590282,NULL,0),(7,'Новая категория',10,1,'8c0819963422f5ae511e40a0bf0a62f4_1519820033.png',1519820033,1519820047,1),(8,'123123',1,1,'453859528b76397a5a12a9d2f36ba702_1519843890.jpg',1519843890,NULL,1);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feedbacks`
--

DROP TABLE IF EXISTS `feedbacks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feedbacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(100) NOT NULL,
  `module_id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `feedback` varchar(2000) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feedbacks`
--

LOCK TABLES `feedbacks` WRITE;
/*!40000 ALTER TABLE `feedbacks` DISABLE KEYS */;
INSERT INTO `feedbacks` VALUES (1,'items',1,'Павел','pavelsholoh@yandex.ru','Первый отзыв',1519634253),(2,'items',1,'Сергей','malblsh69@gmail.com','Второй отзыв',1519634262);
/*!40000 ALTER TABLE `feedbacks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_images`
--

DROP TABLE IF EXISTS `item_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `origin_name` varchar(256) NOT NULL,
  `local_name` varchar(100) NOT NULL,
  `cteated_at` int(11) NOT NULL,
  `is_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_images`
--

LOCK TABLES `item_images` WRITE;
/*!40000 ALTER TABLE `item_images` DISABLE KEYS */;
/*!40000 ALTER TABLE `item_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `cost` int(11) DEFAULT '0',
  `descriptions` text,
  `category_id` int(11) NOT NULL,
  `position` tinyint(4) DEFAULT '1',
  `views` int(11) DEFAULT '0',
  `is_visible` tinyint(1) DEFAULT '0',
  `image_name` varchar(100) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `is_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (1,'Samsung Note 8',69990,'Непотопляемый стилус\r\nСтилус S Pen &mdash; отличительная черта линейки Galaxy Note. Перо распознает 4096 степеней нажатия и легко скользит по экрану. Нет ощущения, что скребешь по стеклу: движения естественные и плавные.\r\n\r\nЗачем нужен S Pen? Рисовать, записывать напоминания, делать пометки на фото. Пером рисовать быстрее и удобнее, чем пальцем.\r\n\r\nЕще можно рисовать заметки на заблокированном экране. Достаем S Pen, нажимаем на кнопочку сбоку и быстро пишем &laquo;Покормить Барсика&raquo;. Напоминание улетает в заметки, либо остается на экране блокировки &mdash; чтобы вы не забывали о Барсике.\r\n\r\nИ нет, стилус не застрянет, если вставить в смартфон обратной стороной. И да, следуя трендам, S Pen не боится воды. Вдруг приспичит написать заметку в бассейне или под дождем?\r\n\r\nНовые функции S Pen &mdash; &laquo;Живые сообщения&raquo; и &laquo;Перевод&raquo;.',4,1,0,1,'eda7dd80f88687dbd17f345be1b0742b_1519593369.jpg',1519593369,1519853498,0),(2,'IPhone 8',55000,'iPhone 8 &mdash; смартфон нового поколения от Apple, имеющий стеклянный корпус, поддержку беспроводной зарядки по стандарту Qi, 4,7-дюймовый дисплей с поддержкой технологии True Tone, шестиядерный процессор A11 Bionic. Выход iPhone 8 состоялся 22 сентября. В России iPhone 8 и iPhone 8 Plus выйдут 29 сентября. Цена iPhone 8 в России составляет 56 990 руб от за модель с 64 ГБ памяти и 68 990 руб за модель с 256 ГБ памяти. Предлагаем вашему вниманию первый обзор iPhone 8.',4,2,0,1,'e19c8f2216e9b0ce3998b79e89b2bc2e_1519635346.jpeg',1519635346,1519853516,0),(3,'IPad 3',0,'Планшет получил улучшенный процессор Apple A5X, специально созданный под дисплей Retina. Процессор содержит 2 основных ядра ARM Cortex A9 и 4 графических ядра (PowerVR SGX543MP4) и, по словам Шиллера, вчетверо опережает по скорости графических вычислений 4-ядерный чип Nvidia Tegra 3. Также планшет получил новую 5-МП камеру, способную снимать видео в Full HD 1080p. В новом iPad появилась ожидаемая поддержка 4G-технологии LTE.',5,1,0,1,'f4a0efbff9d0309516f6467f06028943_1519635521.jpeg',1519635521,0,1),(4,'Samsung TAB 10 ',15000,'Galaxy Tab 10.1 оснащен 10,1-дюймовым ЖК-дисплеем с разрешением 1280 x 800 пикселей, двухъядерным процессором с частотой 1 ГГц, поддержкой Wi-Fi 802.11 a/b/g/n, Bluetooth 2.1+EDR, HSPA+ (21 Мбит/с) и GPRS/EDGE и работает под управлением Android 3.1. С помощью встроенной в Galaxy Tab 10.1 3-МП камеры можно снимать Full HD-видео и тут же воспроизводить его на планшете со скоростью 30 кадров в секунду. Разрешение фронтальной камеры составляет 2 МП.',5,3,0,1,'ea839ddcef60fd14c173e8cf1f83910a_1519635612.jpg',1519635612,1519858062,0),(5,'Цветочки цветуёчки',0,'123123213213123',4,3,0,1,'453859528b76397a5a12a9d2f36ba702_1519843921.jpg',1519843921,1519844554,1),(6,'Nokia 1100',850,'Нокиа 1100 &mdash; стильный телефон, оснащенный дисплеем, отображающим до монохромный. \r\nОснащен относительно слабым аккумулятором на 850 mAh, который позволяет аппарату работать до 100 часов в режиме ожидания и до 2 в режиме разговора. Для коммуникации может предложить: Web-браузер и т.д.',4,3,0,1,'9a95d33ff1022309f953618ba8d81c9a_1519881910.jpg',1519881910,0,0);
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` char(60) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'pavel@vltele.com','$2a$08$MWQ1NDBmZWI0N2NlZTE2M.7/UctqQaAfvEcjVKwL.FAoto87jjH6e',1519848033,0),(3,'pavelsholoh@yandex.ru','$2a$08$YTRiYjE3MzlmYzRkMDZlN.nX2gq1b0w9fqNZdLoQ5JUP7q7YXDmJy',1519848132,0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-03-01  8:27:18
