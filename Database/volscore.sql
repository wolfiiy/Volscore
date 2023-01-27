DROP DATABASE IF EXISTS `volscore`;
CREATE DATABASE `volscore` /*!40100 DEFAULT CHARACTER SET utf8mb3 */;
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

--
-- Table structure for table `teams`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `teams` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `teams` VALUES (2,'Ecublens'),(3,'Froideville'),(4,'Littoral'),(1,'LUC'),(5,'Lutry'),(6,'Yverdon');

--
-- Table structure for table `members`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=201 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `members` VALUES (1,1,'J','Gavin','Franks',91453,1,NULL),(2,1,'J','Brody','Workman',11498,14,NULL),(3,1,'J','Rudyard','Rush',39546,15,NULL),(4,5,'J','Theodore','Whitehead',55183,2,NULL),(5,3,'J','Chaim','Stewart',10529,12,NULL),(6,2,'J','Austin','Riddle',34116,4,NULL),(7,2,'J','Lyle','Eaton',41709,7,NULL),(8,6,'J','Kuame','Beach',51207,6,NULL),(9,3,'J','Noble','Lamb',44499,11,NULL),(10,3,'J','Magee','Joyce',85616,4,NULL),(11,6,'J','John','Davidson',84036,14,NULL),(12,6,'J','Thomas','Schroeder',34654,2,NULL),(13,5,'J','Matthew','Parker',84467,3,NULL),(14,5,'J','Noah','Benson',17345,6,NULL),(15,5,'J','Edward','Flowers',83454,1,NULL),(16,3,'J','Lyle','Sellers',50358,14,NULL),(17,4,'J','Amir','Rose',94398,3,NULL),(18,1,'J','Dean','Conrad',48163,6,NULL),(19,3,'J','Honorato','Merrill',22132,2,NULL),(20,3,'J','Cedric','Conner',23052,5,NULL),(21,2,'J','Murphy','Woods',32964,10,NULL),(22,5,'J','Stephen','Mathis',91690,6,NULL),(23,4,'J','Phelan','Emerson',39118,9,NULL),(24,4,'J','Herrod','Harding',32134,8,NULL),(25,4,'J','Nathan','Daugherty',39557,6,NULL),(26,2,'J','Emerson','Lindsey',98287,14,NULL),(27,4,'J','Ivan','Koch',18875,3,NULL),(28,4,'J','Xander','Gonzales',56924,2,NULL),(29,3,'J','Christopher','Melendez',72345,7,NULL),(30,3,'J','Jerry','Estes',45560,12,NULL),(31,5,'J','Laith','Gould',98255,2,NULL),(32,2,'J','Kibo','Garner',20039,5,NULL),(33,1,'J','Kato','Holmes',25941,6,NULL),(34,5,'J','Silas','O\'donnell',11628,14,NULL),(35,4,'J','Todd','Burt',58404,6,NULL),(36,1,'J','Gareth','Leblanc',26579,3,NULL),(37,4,'J','Lane','Benson',94586,14,NULL),(38,1,'J','Eaton','Mills',48309,6,NULL),(39,6,'J','Boris','Deleon',33613,2,NULL),(40,1,'J','Dillon','Mccormick',10906,9,NULL),(41,3,'J','Honorato','Guerrero',45989,9,NULL),(42,1,'J','Coby','Bell',46277,6,NULL),(43,5,'J','Kane','Drake',53072,3,NULL),(44,5,'J','Vaughan','Faulkner',27102,13,NULL),(45,2,'J','Erich','Sykes',33688,3,NULL),(46,2,'J','Adam','Davis',15896,11,NULL),(47,3,'J','Byron','Knox',16190,13,NULL),(48,6,'J','Cairo','Briggs',21834,4,NULL),(49,4,'J','Deacon','Aguirre',19076,15,NULL),(50,6,'J','Joseph','Soto',80744,3,NULL),(51,5,'J','Alden','Ingram',27461,13,NULL),(52,4,'J','Lev','Petty',94524,7,NULL),(53,6,'J','Wang','Wiley',94894,7,NULL),(54,5,'J','Oren','Rollins',14421,10,NULL),(55,1,'J','Vaughan','Horton',47511,6,NULL),(56,2,'J','Murphy','Wise',51632,11,NULL),(57,3,'J','Keane','Goodman',97922,14,NULL),(58,4,'J','Hyatt','Allison',47125,3,NULL),(59,5,'J','Lyle','Emerson',86438,14,NULL),(60,5,'J','Leroy','Shepard',86691,14,NULL),(61,3,'J','Ronan','Dale',65142,11,NULL),(62,5,'J','Bruce','Horn',30136,4,NULL),(63,1,'J','Quamar','Parrish',67220,7,NULL),(64,2,'J','Aristotle','Parks',63888,1,NULL),(65,2,'J','Walker','Hart',48291,7,NULL),(66,2,'J','Carl','Mclaughlin',28182,10,NULL),(67,4,'J','Ulysses','Curry',60183,9,NULL),(68,6,'J','Cyrus','Schwartz',91659,3,NULL),(69,6,'J','Knox','Adams',24085,13,NULL),(70,5,'J','Abel','Weber',98891,14,NULL),(71,2,'J','Louis','Bean',75328,12,NULL),(72,5,'J','Brenden','Kinney',76042,3,NULL),(73,2,'J','Abdul','Knowles',59613,8,NULL),(74,3,'J','Cairo','Parrish',63586,10,NULL),(75,4,'J','Raja','Shelton',48129,1,NULL),(76,2,'J','Norman','Mckinney',74837,7,NULL),(77,6,'J','Hayden','O\'donnell',52247,6,NULL),(78,5,'J','Xanthus','Ruiz',75685,3,NULL),(79,2,'J','Herrod','Mathews',80663,6,NULL),(80,3,'J','Emerson','Terrell',72265,9,NULL),(81,3,'J','Dalton','Rosario',31939,5,NULL),(82,2,'J','Keaton','Pratt',84728,5,NULL),(83,5,'J','Merrill','Landry',87011,6,NULL),(84,2,'J','Steel','Goodwin',87113,14,NULL),(85,3,'J','Marshall','Pratt',78250,13,NULL),(86,3,'J','Nissim','Reed',99499,8,NULL),(87,2,'J','Silas','Duke',72006,10,NULL),(88,4,'J','Ira','Johns',49394,8,NULL),(89,2,'J','Brody','Koch',45327,3,NULL),(90,3,'J','Allen','Lara',96374,11,NULL),(91,5,'J','Ethan','English',80821,12,NULL),(92,3,'J','Elijah','Conner',58205,11,NULL),(93,2,'J','Jack','Hunt',21097,9,NULL),(94,4,'J','Thane','Dudley',63701,4,NULL),(95,3,'J','Herman','Gaines',45023,9,NULL),(96,1,'J','Lucius','Munoz',31390,11,NULL),(97,2,'J','Gary','Hester',59987,12,NULL),(98,5,'J','Malachi','Jones',29747,5,NULL),(99,2,'J','Felix','Gilbert',54212,5,NULL),(100,5,'J','Todd','Cameron',55269,3,NULL),(101,5,'J','Myles','Harding',36102,3,NULL),(102,6,'J','Merrill','Herman',48597,10,NULL),(103,2,'J','Henry','Stafford',52129,12,NULL),(104,4,'J','Gage','Rasmussen',28092,15,NULL),(105,5,'J','Bernard','Ross',56416,1,NULL),(106,5,'J','Raymond','Sexton',68102,6,NULL),(107,2,'J','Brenden','Rodriguez',17323,6,NULL),(108,4,'J','Leroy','Harris',72359,10,NULL),(109,2,'J','Eagan','Little',63756,9,NULL),(110,4,'J','Orson','Bell',27082,4,NULL),(111,2,'J','Basil','Meyers',66309,6,NULL),(112,4,'J','Wylie','Gonzalez',95029,11,NULL),(113,5,'J','Garrett','Ashley',72683,10,NULL),(114,4,'J','Cade','Daniels',30450,6,NULL),(115,5,'J','Paki','Boone',87956,2,NULL),(116,6,'J','Solomon','Howell',30668,8,NULL),(117,3,'J','Jarrod','Kirk',36663,4,NULL),(118,5,'J','Alexander','Gentry',12371,7,NULL),(119,6,'J','Len','Henson',21886,11,NULL),(120,2,'J','Ethan','Wilkins',95587,2,NULL),(121,6,'J','Zahir','Britt',56958,3,NULL),(122,2,'J','Beau','Davenport',94674,5,NULL),(123,1,'J','Adrian','Craft',21742,3,NULL),(124,4,'J','Preston','Wilkins',33002,6,NULL),(125,6,'J','Brian','Hyde',96812,3,NULL),(126,4,'J','Cody','Matthews',42956,4,NULL),(127,4,'J','Noah','Decker',70019,10,NULL),(128,5,'J','Bert','Clark',22071,14,NULL),(129,6,'J','Caesar','Moses',30156,11,NULL),(130,3,'J','Maxwell','Meadows',80402,13,NULL),(131,1,'J','Benjamin','Orr',62572,13,NULL),(132,5,'J','Ezekiel','Santana',35023,8,NULL),(133,2,'J','Lucian','Drake',94958,1,NULL),(134,6,'J','Reed','Wilcox',36504,14,NULL),(135,3,'J','Fulton','Saunders',90044,10,NULL),(136,5,'J','Harrison','Preston',80063,6,NULL),(137,1,'J','Hall','Pittman',97092,10,NULL),(138,2,'J','Griffith','Cross',20362,5,NULL),(139,4,'J','Christian','Gregory',29441,8,NULL),(140,4,'J','Leo','Owens',96683,7,NULL),(141,5,'J','Davis','Collins',18509,7,NULL),(142,3,'J','Elliott','Hensley',36363,3,NULL),(143,4,'J','Isaiah','Mckee',84425,1,NULL),(144,3,'J','Emerson','Adams',11693,7,NULL),(145,3,'J','Carter','Webster',43343,6,NULL),(146,5,'J','Vladimir','Velez',65530,12,NULL),(147,3,'J','Vance','Gamble',33422,7,NULL),(148,3,'J','Marvin','Garcia',39553,11,NULL),(149,3,'J','Emmanuel','Calderon',69225,15,NULL),(150,2,'J','Otto','Henry',52760,4,NULL),(151,4,'J','Howard','Hendrix',58220,5,NULL),(152,5,'J','Dieter','Fitzgerald',20035,8,NULL),(153,4,'J','Martin','Mullins',38310,3,NULL),(154,2,'J','Ivor','Mills',96406,3,NULL),(155,4,'J','Elton','Morrison',92538,14,NULL),(156,2,'J','Rashad','Gillespie',73615,6,NULL),(157,2,'J','Baxter','Levy',53316,13,NULL),(158,4,'J','Allistair','Herman',31608,12,NULL),(159,2,'J','Aladdin','Cox',20184,10,NULL),(160,3,'J','Reuben','Howell',45408,6,NULL),(161,3,'J','Talon','Hoffman',57585,8,NULL),(162,1,'J','Emery','Levy',59369,9,NULL),(163,6,'J','Victor','Pollard',52474,5,NULL),(164,4,'J','William','Hammond',21634,14,NULL),(165,3,'J','Ezra','Wynn',80396,8,NULL),(166,5,'J','Gabriel','Morrow',84579,3,NULL),(167,5,'J','Zephania','Bell',70399,9,NULL),(168,4,'J','Raymond','Copeland',80025,8,NULL),(169,6,'J','Byron','Greer',73516,8,NULL),(170,3,'J','Rooney','Miller',78198,10,NULL),(171,6,'J','Alan','Justice',31294,10,NULL),(172,2,'J','Joshua','Buchanan',99721,5,NULL),(173,5,'J','Henry','Hunt',65034,7,NULL),(174,3,'J','Drew','Key',41804,9,NULL),(175,5,'J','Bruce','Barlow',44050,4,NULL),(176,3,'J','Blake','Mcleod',59781,6,NULL),(177,2,'J','Harding','Gill',71914,12,NULL),(178,5,'J','Barclay','Thompson',75915,7,NULL),(179,2,'J','Melvin','Mcdaniel',43339,10,NULL),(180,3,'J','Kirk','Bryan',56619,15,NULL),(181,1,'J','Damian','Reed',31704,8,NULL),(182,4,'J','Elton','Wyatt',82700,6,NULL),(183,4,'J','Rudyard','O\'brien',44576,6,NULL),(184,4,'J','Carlos','Glenn',79452,14,NULL),(185,4,'J','Hyatt','Tillman',11002,7,NULL),(186,3,'J','Zephania','Schmidt',80795,9,NULL),(187,6,'J','Bruno','Marsh',59844,7,NULL),(188,5,'J','Marsden','Sanford',94743,10,NULL),(189,2,'J','Holmes','Woods',95267,4,NULL),(190,2,'J','Jamal','Hernandez',17767,13,NULL),(191,5,'J','Castor','Munoz',28183,4,NULL),(192,3,'J','Paul','Woods',73986,12,NULL),(193,5,'J','Chancellor','Lopez',29246,15,NULL),(194,5,'J','Brett','Sloan',99606,10,NULL),(195,1,'J','Chandler','Dunlap',99881,9,NULL),(196,6,'J','Lane','Nichols',30562,8,NULL),(197,4,'J','Ethan','Conner',26945,5,NULL),(198,4,'J','Mason','Emerson',73614,1,NULL),(199,2,'J','Flynn','Doyle',37017,5,NULL),(200,2,'J','Quamar','Rodriquez',77712,3,NULL);

--
-- Table structure for table `games`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `games` VALUES (1,'Championnat','Régional-Vaud','M','U17','Froideville','Salle des Platanes','2013-01-20 20:00:00',3,2),(2,'Championnat','Régional-Vaud','M','U17','Yverdon','Salle des Iles','2013-01-20 20:45:00',6,5),(3,'Championnat','Régional-Vaud','M','U17','Dorigny','Salle Omnisport','2013-01-20 20:00:00',1,4);

--
-- Table structure for table `sets`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `position`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;


/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
