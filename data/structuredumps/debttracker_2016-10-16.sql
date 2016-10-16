# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 0.0.0.0 (MySQL 5.7.15)
# Database: debttracker
# Generation Time: 2016-10-16 16:41:47 +0000
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



# Dump of table Debts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Debts`;

CREATE TABLE `Debts` (
  `id` int(1) unsigned NOT NULL AUTO_INCREMENT,
  `amount` int(11) unsigned NOT NULL,
  `description` tinyblob,
  `date_created` datetime NOT NULL,
  `fully_paid` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table Debts_Paid
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Debts_Paid`;

CREATE TABLE `Debts_Paid` (
  `debt_id` int(6) unsigned NOT NULL,
  `user_id` int(6) unsigned NOT NULL,
  `amount_paid` int(20) NOT NULL,
  KEY `debt_id` (`debt_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `Debts_Paid_ibfk_1` FOREIGN KEY (`debt_id`) REFERENCES `Debts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `Debts_Paid_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



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




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
