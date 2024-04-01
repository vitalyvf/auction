-- MySQL dump 10.13  Distrib 8.0.36, for Linux (x86_64)
--
-- Host: localhost    Database: auction
-- ------------------------------------------------------
-- Server version	8.0.36-0ubuntu0.20.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `vf_bid`
--

DROP TABLE IF EXISTS `vf_bid`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vf_bid` (
  `bid_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `lot_id` int NOT NULL,
  `bid_time` int NOT NULL,
  `price` float(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`bid_id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vf_bid`
--

LOCK TABLES `vf_bid` WRITE;
/*!40000 ALTER TABLE `vf_bid` DISABLE KEYS */;
INSERT INTO `vf_bid` VALUES (1,1,1,0,2000.00),(2,9,3,1711108000,1500.00),(3,2,3,1711208000,1900.00),(4,8,7,1711610545,700.00),(5,1,7,1711611004,900.00),(6,8,7,1711611065,1000.00),(7,1,7,1711611111,1100.00),(8,8,7,1711611151,1200.00),(9,1,7,1711611177,1300.00),(10,8,7,1711611184,1400.00),(11,1,7,1711611579,1500.00),(12,8,7,1711611617,1600.00),(13,1,7,1711611644,1700.00),(14,8,7,1711611763,1800.00),(15,1,7,1711611794,1900.00),(16,8,7,1711613419,2000.00),(17,1,7,1711613441,2100.00),(18,8,7,1711613592,2300.00),(19,1,7,1711613628,2400.00),(20,8,7,1711613807,2500.00),(21,1,7,1711613837,2600.00),(22,8,7,1711614018,2700.00),(23,1,7,1711614033,3000.00),(24,8,7,1711614081,3200.00),(25,8,7,1711614644,5000.00),(26,1,1,1711616681,1000.00),(27,8,1,1711616690,1200.00),(28,1,1,1711616697,1300.00),(29,8,1,1711616939,7600.00),(30,1,1,1711620911,7700.00),(31,8,1,1711698724,7800.00);
/*!40000 ALTER TABLE `vf_bid` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vf_image`
--

DROP TABLE IF EXISTS `vf_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vf_image` (
  `image_id` int NOT NULL AUTO_INCREMENT,
  `object` varchar(16) NOT NULL,
  `object_id` int NOT NULL,
  `file_name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`image_id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vf_image`
--

LOCK TABLES `vf_image` WRITE;
/*!40000 ALTER TABLE `vf_image` DISABLE KEYS */;
INSERT INTO `vf_image` VALUES (20,'lot',8,'1711966161_b18ea1f521737a01fc2e0d43082dc213.jpg'),(7,'lot',1,'1710998136_331dbf3da2c7cff07933f979f90edf00.jpg'),(22,'lot',8,'1711966172_9f66fadcde8bd94f1c6ae0d97ea9404a.jpeg'),(4,'lot',0,'1710997920_71bc9e68ea53a46e09772fb6aaad9437.jpg'),(19,'lot',3,'1711965379_93cebc2de93f43693bb6e8fa4212724b.jpeg'),(21,'lot',8,'1711966167_030d985224c7b144b7d3f3e57e912ed8.jpg'),(17,'lot',7,'1711432141_780dbde86b7635db9fab2f14d6639bac.jpg'),(16,'lot',7,'1711432132_a2231a2d9c3dcd76353a3cb3b061c605.png'),(23,'lot',9,'1711966446_5934a36789c791589e88a8deafef6564.jpg'),(24,'lot',10,'1711966723_35774604075f4e8dc9c3fe226b3e2d8d.jpeg'),(25,'lot',10,'1711966732_6f4ddada44d557108b95dfaf25d7c707.jpeg');
/*!40000 ALTER TABLE `vf_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vf_lot`
--

DROP TABLE IF EXISTS `vf_lot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vf_lot` (
  `lot_id` int NOT NULL AUTO_INCREMENT,
  `lot_time` int NOT NULL,
  `lot_name` varchar(255) NOT NULL DEFAULT '',
  `lot_descr` text NOT NULL,
  `status` enum('N','S','F','P','C') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'N',
  `min_price` float(10,2) NOT NULL DEFAULT '0.00',
  `max_price` float(10,2) NOT NULL DEFAULT '0.00',
  `lot_step` int NOT NULL DEFAULT '0',
  `winner_bid` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`lot_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vf_lot`
--

LOCK TABLES `vf_lot` WRITE;
/*!40000 ALTER TABLE `vf_lot` DISABLE KEYS */;
INSERT INTO `vf_lot` VALUES (1,1711704600,'Wonder woman','Wonder woman nude photos :)','S',1000.00,10000.00,100,31),(8,1712311200,'Маска Дарта Вейдера','Маска Дарта Вейдера','N',900.00,5000.00,100,0),(3,1711008000,'Кольцо Всевластья','Одно кольцо, чтоб миром править, Одно кольцо, чтоб всех найти...','P',1000.00,10000.00,10,3),(7,1711633600,'Iron man','Маска железного человека','P',500.00,5000.00,100,25),(9,1712736900,'Сокол тысячелетия','Star Wars ship','N',1000.00,10000.00,500,0),(10,1712232000,'Фигурка Йоды','Star Wars Фигурка Йоды','N',1000.00,2500.00,100,0);
/*!40000 ALTER TABLE `vf_lot` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vf_payment`
--

DROP TABLE IF EXISTS `vf_payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vf_payment` (
  `payment_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `lot_id` int NOT NULL,
  `payment_time` int NOT NULL,
  `price` float(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`payment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vf_payment`
--

LOCK TABLES `vf_payment` WRITE;
/*!40000 ALTER TABLE `vf_payment` DISABLE KEYS */;
INSERT INTO `vf_payment` VALUES (3,8,7,1711693585,5000.00),(2,2,3,1712208000,1900.00);
/*!40000 ALTER TABLE `vf_payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vf_setting`
--

DROP TABLE IF EXISTS `vf_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vf_setting` (
  `setting_id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(128) NOT NULL,
  `value` text NOT NULL,
  `description` varchar(255) NOT NULL,
  `setting_type` varchar(16) NOT NULL DEFAULT '',
  `variants` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`setting_id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vf_setting`
--

LOCK TABLES `vf_setting` WRITE;
/*!40000 ALTER TABLE `vf_setting` DISABLE KEYS */;
INSERT INTO `vf_setting` VALUES (1,'admin_title','Админ панель лол','заголовок административной панели','input',''),(17,'currency','руб','Сокращенное обозначение валюты','input',''),(16,'per_page','10','Результатов поиска на страницу','input',''),(18,'lot_period_min','1','Минимальное время аукциона (суток)','input',''),(19,'lot_period_max','15','Максимальное время аукциона (суток)','input',''),(20,'site_title','Аукцион тест','title сайта','input',''),(25,'use_mail_model','mail','Способ отправки писем','select','{\"mail\":\"PHP mailer\",\"smtp\":\"SMTP\"}'),(22,'currency_cent','коп','Сокращенное обозначение копеек','input',''),(24,'php_errors','Y','выводить php ошибки','checkbox',''),(26,'mail_smtp_hostname','','SMTP hostname','input',''),(27,'mail_smtp_username','','SMTP username','input',''),(28,'mail_smtp_password','','SMTP password','input',''),(29,'mail_smtp_port','','SMTP port','input',''),(30,'mail_smtp_timeout','','SMTP timeout','input',''),(31,'mail_address_from','admin@auction.com','обратный адрес email','input','');
/*!40000 ALTER TABLE `vf_setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vf_user`
--

DROP TABLE IF EXISTS `vf_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vf_user` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `user_type` enum('C','A') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'C',
  `login` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `firstname` varchar(32) NOT NULL DEFAULT '',
  `lastname` varchar(32) NOT NULL DEFAULT '',
  `status` enum('A','D') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'A',
  `email` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vf_user`
--

LOCK TABLES `vf_user` WRITE;
/*!40000 ALTER TABLE `vf_user` DISABLE KEYS */;
INSERT INTO `vf_user` VALUES (1,'A','admin','21232f297a57a5a743894a0e4a801fc3','Admin','Admin','A','admin@admin.com'),(2,'C','user','ee11cbb19052e40b07aac0ca060c23ee','Test','User','D',''),(8,'C','111','698d51a19d8a121ce581499d7b701668','test111','test111','A','111@111111.ru'),(9,'C','222','bcbe3365e6ac95ea2c0343a2395834dd','222','222','A',''),(10,'C','333','310dcbbf4cce62f762a2aaa148d556bd','333','333333','A',''),(12,'C','444','550a141f12de6341fba65b0ad0433500','444','444','A','444@444.com'),(13,'C','555','15de21c670ae7c3f6f3f1f37029303c9','555','555','A',''),(17,'C','test2@test2.ru','ad0234829205b9033196ba818f7a872b','test2','test2','',''),(16,'C','test1','5a105e8b9d40e1329780d62ea2265d8a','test1','test1','',''),(18,'C','+7 (123) 123 1231','8ad8757baa8564dc136c1e07507f4a98','test3','test3','',''),(19,'C','74444444444','86985e105f79b95d6bc918fb45ec7727','test4','test4','',''),(20,'C','75555555555','e3d704f3542b44a621ebed70dc0efe13','test5','test5','',''),(21,'C','76666666666','4cfad7076129962ee70c36839a1e3e15','test6','test6','','');
/*!40000 ALTER TABLE `vf_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-04-01 14:25:38
