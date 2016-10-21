# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 0.0.0.0 (MySQL 5.7.15)
# Database: debttracker
# Generation Time: 2016-10-21 21:38:02 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table Contacts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Contacts`;

CREATE TABLE `Contacts` (
  `user_id` int(6) unsigned NOT NULL,
  `contact_id` int(6) unsigned NOT NULL,
  `request_sent` tinyint(1) NOT NULL DEFAULT '1',
  `request_sent_date` datetime NOT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  KEY `user_id` (`user_id`),
  KEY `contact_id` (`contact_id`),
  CONSTRAINT `Contacts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `Contacts_ibfk_2` FOREIGN KEY (`contact_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `Contacts` WRITE;
/*!40000 ALTER TABLE `Contacts` DISABLE KEYS */;

INSERT INTO `Contacts` (`user_id`, `contact_id`, `request_sent`, `request_sent_date`, `confirmed`)
VALUES
	(2,1,1,'2016-10-11 21:33:00',1),
	(3,2,1,'2016-10-11 21:33:43',1),
	(6,2,1,'2016-10-17 16:27:31',1),
	(7,2,1,'2016-10-17 16:38:58',1),
	(9,2,1,'2016-10-17 16:39:51',1),
	(10,2,1,'2016-10-19 16:28:10',1),
	(11,2,1,'2016-10-20 15:34:30',0),
	(10,6,1,'2016-10-20 16:25:01',0),
	(10,11,1,'2016-10-20 16:25:07',0),
	(10,10,1,'2016-10-20 16:25:11',0),
	(10,9,1,'2016-10-20 16:25:18',1),
	(10,7,1,'2016-10-20 16:25:21',1),
	(7,9,1,'2016-10-20 16:26:00',1),
	(7,6,1,'2016-10-20 16:26:02',0),
	(9,6,1,'2016-10-20 16:26:19',0);

/*!40000 ALTER TABLE `Contacts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table Debts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Debts`;

CREATE TABLE `Debts` (
  `id` int(1) unsigned NOT NULL AUTO_INCREMENT,
  `amount` float unsigned NOT NULL,
  `description` tinyblob,
  `date_created` datetime NOT NULL,
  `fully_paid` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `Debts` WRITE;
/*!40000 ALTER TABLE `Debts` DISABLE KEYS */;

INSERT INTO `Debts` (`id`, `amount`, `description`, `date_created`, `fully_paid`)
VALUES
	(29,22.49,X'706C756773','2016-10-17 16:38:00',0),
	(39,90,X'68617368','2016-10-20 15:19:05',0),
	(42,8.27,X'77696C6B6F0A6469736820636C65616E6572','2016-10-20 15:21:56',1),
	(44,7.5,X'69726F6E20616E64207368697465','2016-10-20 15:28:14',1),
	(45,57,X'7073342066696661','2016-10-20 15:28:38',1),
	(46,50.71,X'62646179206472696E6B73','2016-10-20 15:29:39',1),
	(47,12,X'616D617A6F6E20626974732032','2016-10-20 15:30:27',1),
	(48,22,X'6F6C6C696520666573740A','2016-10-20 15:31:07',1),
	(49,80,X'677265656E73','2016-10-20 15:31:45',1),
	(50,80,X'677265656E732032','2016-10-20 15:32:11',1),
	(51,40,X'677265656E732033','2016-10-20 15:32:40',1),
	(52,40,X'677265656E732034','2016-10-20 15:32:56',1),
	(53,85,X'6861732031','2016-10-20 15:33:33',1),
	(54,15.99,X'6661697279206C6967687473','2016-10-20 15:52:41',1),
	(55,15.28,X'65787374656E73696F6E206361626C65','2016-10-20 15:53:54',1),
	(56,12.59,X'656C65637472696320686561746572','2016-10-20 15:54:28',1),
	(57,5.99,X'746561706F74','2016-10-20 15:55:07',1),
	(58,5.26,X'6173682074726179','2016-10-20 16:02:14',0),
	(59,15,X'677265656E73','2016-10-20 16:04:16',0);

/*!40000 ALTER TABLE `Debts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table Debts_Paid
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Debts_Paid`;

CREATE TABLE `Debts_Paid` (
  `debt_id` int(6) unsigned NOT NULL,
  `user_id` int(6) unsigned NOT NULL,
  `amount_paid` float NOT NULL,
  KEY `debt_id` (`debt_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `Debts_Paid_ibfk_1` FOREIGN KEY (`debt_id`) REFERENCES `Debts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `Debts_Paid_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `Debts_Paid` WRITE;
/*!40000 ALTER TABLE `Debts_Paid` DISABLE KEYS */;

INSERT INTO `Debts_Paid` (`debt_id`, `user_id`, `amount_paid`)
VALUES
	(29,2,22.49),
	(29,6,0),
	(29,7,0),
	(29,9,0),
	(39,2,0),
	(39,6,90),
	(39,7,0),
	(39,9,0),
	(42,2,0),
	(42,6,8.27),
	(42,7,0),
	(42,9,0),
	(42,10,0),
	(44,2,0),
	(44,6,0),
	(44,7,8),
	(44,9,0),
	(44,10,0),
	(45,2,0),
	(45,6,57),
	(45,7,0),
	(45,9,0),
	(45,10,0),
	(46,2,50.71),
	(46,6,0),
	(46,7,0),
	(46,9,0),
	(46,10,0),
	(47,2,0),
	(47,6,0),
	(47,7,12),
	(47,9,0),
	(47,10,0),
	(48,2,0),
	(48,6,22),
	(49,2,80),
	(49,6,0),
	(49,7,0),
	(50,2,0),
	(50,6,80),
	(50,7,0),
	(51,2,0),
	(51,6,0),
	(51,7,40),
	(52,2,40),
	(52,6,0),
	(52,7,0),
	(52,9,0),
	(53,2,0),
	(53,6,85),
	(53,7,0),
	(53,9,0),
	(54,2,0),
	(54,6,15.99),
	(54,7,0),
	(54,9,0),
	(55,2,0),
	(55,6,15.28),
	(55,7,0),
	(55,9,0),
	(56,2,0),
	(56,6,12.59),
	(56,7,0),
	(56,9,0),
	(57,2,0),
	(57,6,5.99),
	(57,7,0),
	(57,9,0),
	(58,2,5.26),
	(58,6,0),
	(58,7,0),
	(58,9,0),
	(29,10,0),
	(59,2,0),
	(59,6,0),
	(59,7,0),
	(59,9,15);

/*!40000 ALTER TABLE `Debts_Paid` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table Users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Users`;

CREATE TABLE `Users` (
  `id` int(1) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `password` varchar(256) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `email` varchar(256) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;

INSERT INTO `Users` (`id`, `name`, `password`, `email`)
VALUES
	(1,'testing','$2y$10$CGBMORTYIRMoUtP.nbLvLuCBk61pYBiQd87V0bH68F4feUkPqtHG2','testing@test'),
	(2,'Nat','$2y$10$g15CBAlPBSXTH5EQyYaZu.6hvbF47h6cDS.XDDsqyardr7V1V1R0i','theniffin@gmail.com'),
	(3,'test','$2y$10$TLhfeHuX9FYhFJdSCDPW/.eqTpe/EK4NKUWTp4T6R3C9XJxbL4hIq','test@test.com'),
	(4,'test 2','$2y$10$WzysQgOtGFOnv6r8I252Bek5tI4e1p08m38ehs7bmvXR80hdMcHti','testing@test.com'),
	(5,'testings','$2y$10$ya2kKHHX9o91CekomNVmyeVIS5JL5Ymh1xH4zF5skZBVY0dTU/a5a','testing@test.coms'),
	(6,'Ollie C','$2y$10$naf0XxDIJyS7ttBPqJoLy.3eUQbKQwvyQuC3PHcDGbQtvVEEcWahe','oliverlcramer@msn.com'),
	(7,'Hanley','$2y$10$H6rDPb1symG9LfjmIFGFS.xjxTR.zKULA9XaigEdF0G4aQS/okngO','h.test@gmail.com'),
	(9,'Lati','$2y$10$CCLeXVAjBquT6If7EwJyyuElfdscp05DdbnGH3LdADZNJGGsfJeU.','l.test@gmail.com'),
	(10,'Josh Yan','$2y$10$zfuP0TUlXyL8lcIT/wwW7eEvX.31bv.RtMjcT7E5dgC/aNIPNjfmW','j.test@gmail.com'),
	(11,'Michael Doswell','$2y$10$/QTohAENOSz6sa4wvWw9yOu8Ayq1ukAkeaG5M9ic3qY1436sBHRK.','m.test@gmail.com');

/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
