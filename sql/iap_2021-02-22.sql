# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.32)
# Database: iap
# Generation Time: 2021-02-22 05:26:42 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table android
# ------------------------------------------------------------

DROP TABLE IF EXISTS `android`;

CREATE TABLE `android` (
  `receipt` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `validation` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `expireDate` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`receipt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `android` WRITE;
/*!40000 ALTER TABLE `android` DISABLE KEYS */;

INSERT INTO `android` (`receipt`, `validation`, `expireDate`, `created_at`, `updated_at`)
VALUES
	('ddd','1','2021-12-12 12:12:12',NULL,NULL);

/*!40000 ALTER TABLE `android` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table applications
# ------------------------------------------------------------

DROP TABLE IF EXISTS `applications`;

CREATE TABLE `applications` (
  `appId` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uid` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `applications_appid_unique` (`appId`),
  KEY `applications_uid_foreign` (`uid`),
  CONSTRAINT `applications_uid_foreign` FOREIGN KEY (`uid`) REFERENCES `devices` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `applications` WRITE;
/*!40000 ALTER TABLE `applications` DISABLE KEYS */;

INSERT INTO `applications` (`appId`, `uid`, `created_at`, `updated_at`)
VALUES
	('u1RgT','1','2021-02-22 04:34:23','2021-02-22 04:34:23');

/*!40000 ALTER TABLE `applications` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table devices
# ------------------------------------------------------------

DROP TABLE IF EXISTS `devices`;

CREATE TABLE `devices` (
  `uid` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `os` tinyint(1) NOT NULL,
  `language` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `clientToken` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `devices_clienttoken_unique` (`clientToken`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `devices` WRITE;
/*!40000 ALTER TABLE `devices` DISABLE KEYS */;

INSERT INTO `devices` (`uid`, `os`, `language`, `clientToken`, `created_at`, `updated_at`)
VALUES
	('1',1,'tr','XPngIU0EWF',NULL,'2021-02-22 04:34:23');

/*!40000 ALTER TABLE `devices` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ios
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ios`;

CREATE TABLE `ios` (
  `receipt` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `validation` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `expireDate` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`receipt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `ios` WRITE;
/*!40000 ALTER TABLE `ios` DISABLE KEYS */;

INSERT INTO `ios` (`receipt`, `validation`, `expireDate`, `created_at`, `updated_at`)
VALUES
	('ddd','1','2021-12-21 12:12:12',NULL,NULL);

/*!40000 ALTER TABLE `ios` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES
	(66,'2021_02_20_214008_devices',1),
	(67,'2021_02_20_214049_applications',1),
	(68,'2021_02_21_070610_purchases',1),
	(69,'2021_02_21_070625_android',1),
	(70,'2021_02_21_070629_ios',1);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table purchases
# ------------------------------------------------------------

DROP TABLE IF EXISTS `purchases`;

CREATE TABLE `purchases` (
  `purchaseId` varchar(17) COLLATE utf8mb4_unicode_ci NOT NULL,
  `receipt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expireDate` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`purchaseId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `purchases` WRITE;
/*!40000 ALTER TABLE `purchases` DISABLE KEYS */;

INSERT INTO `purchases` (`purchaseId`, `receipt`, `expireDate`, `created_at`, `updated_at`)
VALUES
	('u1RgT1','ddd','2021-12-12 06:12:12',NULL,NULL);

/*!40000 ALTER TABLE `purchases` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
