# ************************************************************
# Sequel Ace SQL dump
# Version 20016
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: 127.0.0.1 (MySQL 8.0.26)
# Database: invoice
# Generation Time: 2021-11-14 21:15:49 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE='NO_AUTO_VALUE_ON_ZERO', SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table tblinvd
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tblinvd`;

CREATE TABLE `tblinvd` (
  `invId` varchar(4) NOT NULL DEFAULT '',
  `seq` int NOT NULL,
  `itemId` varchar(4) NOT NULL DEFAULT '',
  `qty` float(18,2) DEFAULT NULL,
  `createdAt` datetime DEFAULT NULL,
  `createdUser` varchar(4) DEFAULT NULL,
  `updatedAt` datetime DEFAULT NULL,
  `updatedUser` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`invId`,`seq`,`itemId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `tblinvd` WRITE;
/*!40000 ALTER TABLE `tblinvd` DISABLE KEYS */;

INSERT INTO `tblinvd` (`invId`, `seq`, `itemId`, `qty`, `createdAt`, `createdUser`, `updatedAt`, `updatedUser`)
VALUES
	('0001',1,'0001',41.00,'2021-11-14 20:56:32','0001',NULL,NULL),
	('0001',2,'0002',57.00,'2021-11-14 20:56:44','0001',NULL,NULL),
	('0001',3,'0003',4.50,'2021-11-14 20:57:39','0001',NULL,NULL),
	('0003',1,'0001',4.00,'2021-11-14 21:12:44','0001',NULL,NULL),
	('0003',2,'0002',7.00,'2021-11-14 21:12:52','0001',NULL,NULL);

/*!40000 ALTER TABLE `tblinvd` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tblinvm
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tblinvm`;

CREATE TABLE `tblinvm` (
  `invId` varchar(4) NOT NULL DEFAULT '',
  `subject` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `invStatus` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'UNPAID',
  `senderId` varchar(4) DEFAULT NULL,
  `receiverId` varchar(4) DEFAULT NULL,
  `dueDt` date DEFAULT NULL,
  `payments` float(18,2) DEFAULT NULL,
  `createdAt` datetime DEFAULT NULL,
  `createdUser` varchar(4) DEFAULT NULL,
  `updatedAt` datetime DEFAULT NULL,
  `updatedUser` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`invId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `tblinvm` WRITE;
/*!40000 ALTER TABLE `tblinvm` DISABLE KEYS */;

INSERT INTO `tblinvm` (`invId`, `subject`, `invStatus`, `senderId`, `receiverId`, `dueDt`, `payments`, `createdAt`, `createdUser`, `updatedAt`, `updatedUser`)
VALUES
	('0001','Spring Marketing Campaign','PAID','0001','0001','2017-05-06',31361.00,'2021-11-14 20:56:16','0001','2021-11-14 21:01:35','0001'),
	('0003','Summer Promote','UNPAID','0001','0002','2021-11-20',NULL,'2021-11-14 21:12:38','0001',NULL,NULL);

/*!40000 ALTER TABLE `tblinvm` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tblitem
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tblitem`;

CREATE TABLE `tblitem` (
  `itemId` varchar(4) NOT NULL DEFAULT '',
  `itemType` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `description` varchar(150) DEFAULT NULL,
  `unitPrice` float(18,2) DEFAULT NULL,
  `curCd` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `createdAt` datetime DEFAULT NULL,
  `createdUser` varchar(4) DEFAULT NULL,
  `updatedAt` datetime DEFAULT NULL,
  `updatedUser` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`itemId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `tblitem` WRITE;
/*!40000 ALTER TABLE `tblitem` DISABLE KEYS */;

INSERT INTO `tblitem` (`itemId`, `itemType`, `description`, `unitPrice`, `curCd`, `createdAt`, `createdUser`, `updatedAt`, `updatedUser`)
VALUES
	('0001','Service','Design',230.00,'EUR',NULL,'0001',NULL,NULL),
	('0002','Service','Development',330.00,'EUR',NULL,'0001',NULL,NULL),
	('0003','Service','Meetigns',60.00,'EUR',NULL,'0001',NULL,NULL);

/*!40000 ALTER TABLE `tblitem` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tblvendor
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tblvendor`;

CREATE TABLE `tblvendor` (
  `vendId` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `name` varchar(100) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `createdAt` datetime DEFAULT NULL,
  `createdUser` varchar(4) DEFAULT NULL,
  `updatedAt` datetime DEFAULT NULL,
  `updatedUser` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`vendId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `tblvendor` WRITE;
/*!40000 ALTER TABLE `tblvendor` DISABLE KEYS */;

INSERT INTO `tblvendor` (`vendId`, `name`, `address`, `createdAt`, `createdUser`, `updatedAt`, `updatedUser`)
VALUES
	('0001','Discovery Designs','41 St. Vincent Place Glasgrow G1 2ER Scotland',NULL,'0001',NULL,NULL),
	('0002','Barringon Publishers','17 Great Suffolk Street London SE1 0NS United Kingdom',NULL,'0001',NULL,NULL);

/*!40000 ALTER TABLE `tblvendor` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
