DROP DATABASE IF EXISTS `volscore`;
CREATE DATABASE  `volscore` /*!40100 DEFAULT CHARACTER SET utf8mb3 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `volscore`;
-- MySQL dump 10.13  Distrib 8.0.31, for Win64 (x86_64)
--
-- Host: localhost    Database: volscore
-- ------------------------------------------------------
-- Server version	8.0.31

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

CREATE TABLE `teams` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `games` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` varchar(45) NOT NULL,
  `level` varchar(45) NOT NULL,
  `category` varchar(45) NOT NULL,
  `league` varchar(45) NOT NULL,
  `location` varchar(45) DEFAULT NULL,
  `venue` varchar(45) DEFAULT NULL,
  `moment` datetime DEFAULT NULL,
  `receiving_id` int NOT NULL,
  `visiting_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_games_teams_idx` (`receiving_id`),
  KEY `fk_games_teams1_idx` (`visiting_id`),
  CONSTRAINT `fk_games_teams` FOREIGN KEY (`receiving_id`) REFERENCES `teams` (`id`),
  CONSTRAINT `fk_games_teams1` FOREIGN KEY (`visiting_id`) REFERENCES `teams` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `members` (
  `id` int NOT NULL AUTO_INCREMENT,
  `team_id` int NOT NULL,
  `role` varchar(45) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `license` int DEFAULT NULL,
  `number` int DEFAULT NULL,
  `libero` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_members_teams1_idx` (`team_id`),
  CONSTRAINT `fk_members_teams1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb3;

CREATE TABLE `sets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `number` int DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `game_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sets_games1_idx` (`game_id`),
  CONSTRAINT `fk_sets_games1` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `position` (
  `id` int NOT NULL AUTO_INCREMENT,
  `set_id` int NOT NULL,
  `member_id` int NOT NULL,
  `position` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_position_sets1_idx` (`set_id`),
  KEY `fk_position_members1_idx` (`member_id`),
  CONSTRAINT `fk_position_members1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`),
  CONSTRAINT `fk_position_sets1` FOREIGN KEY (`set_id`) REFERENCES `sets` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-01-26 10:34:10
INSERT INTO `teams` VALUES (2,'Ecublens'),(3,'Froideville'),(4,'Lavaux'),(1,'LUC');
INSERT INTO `games` VALUES (1,'Championnat','Régional','H','M4','Froideville','Salle des planches','2023-01-27 20:45:00',2,3);
INSERT INTO `members` VALUES (1,2,'Joueur','Sade','Lynn',562556,12,NULL),(2,3,'Joueur','Orli','Barlow',396331,15,NULL),(3,3,'Joueur','Jason','Flowers',850697,5,NULL),(4,4,'Joueur','Cara','Mann',418540,7,NULL),(5,2,'Joueur','Bernard','Bradford',884497,14,NULL),(6,4,'Joueur','Jana','Douglas',944004,15,NULL),(7,4,'Joueur','Ulla','Nelson',132545,19,NULL),(8,2,'Joueur','Tara','Goodwin',648553,8,NULL),(9,2,'Joueur','Guinevere','Best',470070,4,NULL),(10,1,'Joueur','Fay','Dickson',580746,12,NULL),(11,2,'Joueur','Acton','Flores',691602,10,NULL),(12,2,'Joueur','Candace','Mccullough',761617,6,NULL),(13,4,'Joueur','Ryan','William',366954,13,NULL),(14,4,'Joueur','Liberty','Watkins',509936,16,NULL),(15,1,'Joueur','Finn','Roberson',663889,12,NULL),(16,2,'Joueur','Norman','Peters',465336,5,NULL),(17,1,'Joueur','Wynne','Pittman',365271,2,NULL),(18,2,'Joueur','Martin','Powell',878861,8,NULL),(19,3,'Joueur','Madeson','Carey',133389,12,NULL),(20,3,'Joueur','Blythe','Clark',844220,12,NULL),(21,2,'Joueur','Allegra','Mccall',919560,17,NULL),(22,2,'Joueur','Aladdin','Barnett',823577,19,NULL),(23,4,'Joueur','Keaton','Dalton',384896,7,NULL),(24,2,'Joueur','Phoebe','Lawson',222431,9,NULL),(25,2,'Joueur','Quyn','Avila',411230,9,NULL),(26,4,'Joueur','Wynter','Hoffman',672517,13,NULL),(27,2,'Joueur','Marsden','Raymond',660362,18,NULL),(28,1,'Joueur','Suki','Munoz',339526,13,NULL),(29,1,'Joueur','Lydia','Jacobs',435546,11,NULL),(30,1,'Joueur','Isadora','Knox',986926,13,NULL),(31,2,'Joueur','Camilla','Woodard',224180,1,NULL),(32,1,'Joueur','Ariana','Dean',295924,8,NULL),(33,4,'Joueur','Theodore','Walters',891428,2,NULL),(34,4,'Joueur','Azalia','Wallace',599056,14,NULL),(35,1,'Joueur','Wang','Randall',134016,17,NULL),(36,3,'Joueur','Tashya','Ward',237642,19,NULL),(37,3,'Joueur','Amethyst','Black',365353,2,NULL),(38,4,'Joueur','Aiko','Hickman',578260,11,NULL),(39,3,'Joueur','Celeste','Durham',577723,5,NULL),(40,3,'Joueur','Tarik','Cantu',967476,15,NULL),(41,3,'Joueur','Rahim','Vazquez',590203,15,NULL),(42,2,'Joueur','Christen','Sanders',515423,3,NULL),(43,3,'Joueur','Rajah','Wells',656731,16,NULL),(44,4,'Joueur','Charlotte','Barlow',479041,5,NULL),(45,3,'Joueur','Maxwell','Brennan',154274,2,NULL),(46,2,'Joueur','Lance','Wallace',535211,3,NULL),(47,1,'Joueur','Clementine','Curtis',846024,2,NULL),(48,3,'Joueur','Jackson','Pearson',199839,11,NULL),(49,2,'Joueur','Madonna','Wolfe',647695,12,NULL),(50,2,'Joueur','Ciaran','Morton',852484,10,NULL),(51,2,'Joueur','Vance','Gomez',117188,13,NULL),(52,1,'Joueur','Rooney','Edwards',583412,14,NULL),(53,2,'Joueur','Maya','Phelps',375123,14,NULL),(54,3,'Joueur','Amanda','Hayes',458362,16,NULL),(55,3,'Joueur','Elijah','Blackwell',522457,14,NULL),(56,2,'Joueur','Deirdre','Day',765682,17,NULL),(57,1,'Joueur','Hanna','Walsh',834473,15,NULL),(58,4,'Joueur','Velma','Howell',952167,19,NULL),(59,4,'Joueur','Quon','Mullins',214314,17,NULL),(60,2,'Joueur','Reed','Velez',426428,19,NULL),(61,2,'Joueur','Charity','Ellis',498847,18,NULL),(62,1,'Joueur','Evan','Delacruz',751938,2,NULL),(63,2,'Joueur','Alana','Everett',904714,8,NULL),(64,3,'Joueur','Kirestin','Patrick',337502,9,NULL),(65,2,'Joueur','Hyatt','Best',139438,11,NULL),(66,2,'Joueur','Xenos','Nielsen',320034,18,NULL),(67,2,'Joueur','Sade','Hawkins',449418,9,NULL),(68,2,'Joueur','Stella','Merritt',666161,20,NULL),(69,1,'Joueur','Josiah','Estrada',701895,18,NULL),(70,4,'Joueur','Azalia','Wolfe',910495,12,NULL),(71,2,'Joueur','Dana','Beck',480097,6,NULL),(72,2,'Joueur','Deanna','Padilla',520829,12,NULL),(73,2,'Joueur','Kelsey','Riggs',652543,18,NULL),(74,3,'Joueur','MacKensie','Kerr',399090,5,NULL),(75,3,'Joueur','Raja','Barron',667992,9,NULL),(76,3,'Joueur','Madonna','Bass',369862,2,NULL),(77,2,'Joueur','Amanda','David',258597,3,NULL),(78,1,'Joueur','Dora','Russell',678258,5,NULL),(79,3,'Joueur','Risa','Benton',980082,11,NULL),(80,3,'Joueur','Davis','French',889523,10,NULL),(81,4,'Joueur','Abbot','Kelley',120529,18,NULL),(82,4,'Joueur','Nina','Whitaker',703528,12,NULL),(83,3,'Joueur','Cedric','Fleming',704746,1,NULL),(84,2,'Joueur','Patrick','Ayers',354693,13,NULL),(85,2,'Joueur','Bree','Munoz',603310,9,NULL),(86,3,'Joueur','Leigh','Lloyd',529759,19,NULL),(87,3,'Joueur','Davis','Coleman',229618,5,NULL),(88,4,'Joueur','Alika','Cole',229218,3,NULL),(89,1,'Joueur','Kibo','England',151238,9,NULL),(90,3,'Joueur','Nigel','Barlow',380670,9,NULL),(91,3,'Joueur','Cassidy','Sargent',197561,5,NULL),(92,2,'Joueur','Sheila','Morrison',661674,6,NULL),(93,2,'Joueur','Allegra','Wagner',196603,7,NULL),(94,2,'Joueur','Giacomo','Booth',666214,13,NULL),(95,1,'Joueur','Hoyt','Blankenship',409236,18,NULL),(96,3,'Joueur','Deirdre','Jones',452318,1,NULL),(97,2,'Joueur','Reese','Berger',407765,16,NULL),(98,2,'Joueur','Alisa','Richard',767331,19,NULL),(99,4,'Joueur','Cassidy','Edwards',232951,19,NULL),(100,3,'Joueur','Emi','Jenkins',541065,19,NULL);

