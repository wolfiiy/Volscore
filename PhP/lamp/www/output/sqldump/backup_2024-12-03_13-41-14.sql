

CREATE TABLE `bookings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `player_id` int NOT NULL,
  `point_id` int NOT NULL,
  `severity` int NOT NULL DEFAULT '0' COMMENT '0 -> yellow, 1 -> red, 2 -> yellowred, 3 -> yellow and red',
  PRIMARY KEY (`id`),
  KEY `fk_bookings_players_idx` (`player_id`),
  KEY `fk_bookings_points_idx` (`point_id`),
  CONSTRAINT `fk_booking_player` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_booking_point` FOREIGN KEY (`point_id`) REFERENCES `points` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Contains bookings.';



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
  `toss` int NOT NULL DEFAULT '0' COMMENT 'Receiving: 1, Visiting: 2',
  PRIMARY KEY (`id`),
  KEY `fk_games_teams_idx` (`receiving_id`),
  KEY `fk_games_teams1_idx` (`visiting_id`),
  CONSTRAINT `fk_games_teams` FOREIGN KEY (`receiving_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_games_teams1` FOREIGN KEY (`visiting_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;

INSERT INTO `games` (`id`, `type`, `level`, `category`, `league`, `location`, `venue`, `moment`, `receiving_id`, `visiting_id`, `toss`) VALUES ('1', 'Championnat', 'R', 'M', 'U17', 'Froideville', 'Salle des Platanes', '2023-01-20 20:00:00', '3', '2', '0');
INSERT INTO `games` (`id`, `type`, `level`, `category`, `league`, `location`, `venue`, `moment`, `receiving_id`, `visiting_id`, `toss`) VALUES ('2', 'Championnat', 'R', 'M', 'U17', 'Yverdon', 'Salle des Iles', '2023-01-20 20:45:00', '6', '5', '0');
INSERT INTO `games` (`id`, `type`, `level`, `category`, `league`, `location`, `venue`, `moment`, `receiving_id`, `visiting_id`, `toss`) VALUES ('3', 'Championnat', 'R', 'M', 'U17', 'Dorigny', 'Salle Omnisport', '2023-01-20 20:00:00', '1', '4', '0');
INSERT INTO `games` (`id`, `type`, `level`, `category`, `league`, `location`, `venue`, `moment`, `receiving_id`, `visiting_id`, `toss`) VALUES ('7', 'Coupe', 'Régional-Vaud', 'F', 'F2', 'Froideville', 'Complexe sportif', '2024-12-03 20:00:00', '6', '3', '0');
INSERT INTO `games` (`id`, `type`, `level`, `category`, `league`, `location`, `venue`, `moment`, `receiving_id`, `visiting_id`, `toss`) VALUES ('8', 'Coupe', 'Régional-Vaud', 'F', 'F2', 'Lausanne', 'Vennes', '2024-12-04 21:00:00', '3', '1', '0');
INSERT INTO `games` (`id`, `type`, `level`, `category`, `league`, `location`, `venue`, `moment`, `receiving_id`, `visiting_id`, `toss`) VALUES ('9', 'Coupe', 'Régional-Vaud', 'F', 'F2', 'Lutry', 'Les Pales', '2024-12-05 20:45:00', '1', '3', '0');


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
  CONSTRAINT `fk_members_teams1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=201 DEFAULT CHARSET=utf8mb3;

INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('1', '1', 'C', 'Gavin', 'Franks', '91453', '1', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('2', '1', 'J', 'Brody', 'Workman', '11498', '14', '1');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('3', '1', 'J', 'Rudyard', 'Rush', '39546', '15', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('4', '5', 'C', 'Theodore', 'Whitehead', '55183', '2', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('5', '3', 'C', 'Chaim', 'Stewart', '10529', '12', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('6', '2', 'C', 'Austin', 'Riddle', '34116', '4', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('7', '2', 'J', 'Lyle', 'Eaton', '41709', '7', '1');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('8', '6', 'C', 'Kuame', 'Beach', '51207', '6', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('9', '3', 'J', 'Noble', 'Lamb', '44499', '11', '1');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('10', '3', 'J', 'Magee', 'Joyce', '85616', '4', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('11', '6', 'J', 'John', 'Davidson', '84036', '14', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('12', '6', 'J', 'Thomas', 'Schroeder', '34654', '2', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('13', '5', 'J', 'Matthew', 'Parker', '84467', '3', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('14', '5', 'J', 'Noah', 'Benson', '17345', '6', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('15', '5', 'J', 'Edward', 'Flowers', '83454', '1', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('16', '3', 'J', 'Lyle', 'Sellers', '50358', '14', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('17', '4', 'C', 'Amir', 'Rose', '94398', '3', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('18', '1', 'J', 'Dean', 'Conrad', '48163', '6', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('19', '3', 'J', 'Honorato', 'Merrill', '22132', '2', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('20', '3', 'J', 'Cedric', 'Conner', '23052', '5', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('21', '2', 'J', 'Murphy', 'Woods', '32964', '10', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('22', '5', 'J', 'Stephen', 'Mathis', '91690', '7', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('23', '4', 'J', 'Phelan', 'Emerson', '39118', '9', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('24', '4', 'J', 'Herrod', 'Harding', '32134', '8', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('25', '4', 'J', 'Nathan', 'Daugherty', '39557', '6', '1');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('26', '2', 'J', 'Emerson', 'Lindsey', '98287', '14', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('27', '4', 'J', 'Ivan', 'Koch', '18875', '4', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('28', '4', 'J', 'Xander', 'Gonzales', '56924', '2', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('29', '3', 'J', 'Christopher', 'Melendez', '72345', '7', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('30', '3', 'J', 'Jerry', 'Estes', '45560', '15', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('31', '5', 'J', 'Laith', 'Gould', '98255', '8', '1');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('32', '2', 'J', 'Kibo', 'Garner', '20039', '5', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('33', '1', 'J', 'Kato', 'Holmes', '25941', '2', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('34', '5', 'J', 'Silas', 'Odonnell', '11628', '14', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('35', '4', 'J', 'Todd', 'Burt', '58404', '13', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('36', '1', 'J', 'Gareth', 'Leblanc', '26579', '3', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('37', '4', 'J', 'Lane', 'Benson', '94586', '14', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('38', '1', 'J', 'Eaton', 'Mills', '48309', '4', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('39', '6', 'J', 'Boris', 'Deleon', '33613', '1', '1');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('40', '1', 'J', 'Dillon', 'Mccormick', '10906', '9', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('41', '3', 'J', 'Honorato', 'Guerrero', '45989', '9', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('42', '1', 'J', 'Coby', 'Bell', '46277', '5', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('43', '5', 'J', 'Kane', 'Drake', '53072', '9', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('44', '5', 'J', 'Vaughan', 'Faulkner', '27102', '13', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('45', '2', 'J', 'Erich', 'Sykes', '33688', '3', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('46', '2', 'J', 'Adam', 'Davis', '15896', '11', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('47', '3', 'J', 'Byron', 'Knox', '16190', '13', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('48', '6', 'J', 'Cairo', 'Briggs', '21834', '4', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('49', '4', 'J', 'Deacon', 'Aguirre', '19076', '15', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('50', '6', 'J', 'Joseph', 'Soto', '80744', '3', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('51', '5', 'J', 'Alden', 'Ingram', '27461', '11', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('52', '4', 'J', 'Lev', 'Petty', '94524', '7', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('53', '6', 'J', 'Wang', 'Wiley', '94894', '7', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('54', '5', 'J', 'Oren', 'Rollins', '14421', '10', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('55', '1', 'J', 'Vaughan', 'Horton', '47511', '8', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('56', '2', 'J', 'Murphy', 'Wise', '51632', '2', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('57', '3', 'J', 'Keane', 'Goodman', '97922', '3', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('58', '4', 'J', 'Hyatt', 'Allison', '47125', '12', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('61', '3', 'J', 'Ronan', 'Dale', '65142', '1', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('63', '1', 'J', 'Quamar', 'Parrish', '67220', '7', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('64', '2', 'J', 'Aristotle', 'Parks', '63888', '1', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('65', '2', 'J', 'Walker', 'Hart', '48291', '6', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('66', '2', 'J', 'Carl', 'Mclaughlin', '28182', '9', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('67', '4', 'J', 'Ulysses', 'Curry', '60183', '9', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('68', '6', 'J', 'Cyrus', 'Schwartz', '91659', '8', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('69', '6', 'J', 'Knox', 'Adams', '24085', '13', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('71', '2', 'J', 'Louis', 'Bean', '75328', '12', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('74', '3', 'J', 'Cairo', 'Parrish', '63586', '10', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('75', '4', 'J', 'Raja', 'Shelton', '48129', '1', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('77', '6', 'J', 'Hayden', 'Onell', '52247', '9', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('80', '3', 'J', 'Emerson', 'Terrell', '72265', '6', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('96', '1', 'J', 'Lucius', 'Munoz', '31390', '11', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('102', '6', 'J', 'Merrill', 'Herman', '48597', '10', '');
INSERT INTO `members` (`id`, `team_id`, `role`, `first_name`, `last_name`, `license`, `number`, `libero`) VALUES ('123', '1', 'J', 'Adrian', 'Craft', '21742', '12', '');


CREATE TABLE `players` (
  `id` int NOT NULL AUTO_INCREMENT,
  `game_id` int NOT NULL,
  `member_id` int NOT NULL,
  `number` int DEFAULT NULL,
  `validated` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_players_game_idx` (`game_id`),
  KEY `fk_players_teams_idx` (`member_id`),
  CONSTRAINT `fk_player_game` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_player_team` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb3;

INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('1', '1', '5', '12', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('2', '1', '9', '11', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('3', '1', '10', '4', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('4', '1', '16', '14', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('5', '1', '19', '2', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('6', '1', '20', '5', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('7', '1', '29', '7', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('8', '1', '30', '15', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('9', '1', '41', '9', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('10', '1', '47', '13', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('11', '1', '57', '3', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('12', '1', '61', '1', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('13', '1', '74', '10', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('14', '1', '80', '6', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('15', '1', '6', '4', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('16', '1', '7', '7', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('17', '1', '21', '10', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('18', '1', '26', '14', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('19', '1', '32', '5', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('20', '1', '45', '3', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('21', '1', '46', '11', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('22', '1', '56', '2', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('23', '1', '64', '1', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('24', '1', '65', '6', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('25', '1', '66', '9', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('26', '1', '71', '12', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('27', '2', '8', '6', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('28', '2', '11', '14', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('29', '2', '12', '2', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('30', '2', '39', '1', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('31', '2', '48', '4', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('32', '2', '50', '3', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('33', '2', '53', '7', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('34', '2', '68', '8', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('35', '2', '69', '13', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('36', '2', '77', '9', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('37', '2', '102', '10', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('38', '2', '4', '2', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('39', '2', '13', '3', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('40', '2', '14', '6', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('41', '2', '15', '1', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('42', '2', '22', '7', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('43', '2', '31', '8', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('44', '2', '34', '14', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('45', '2', '43', '9', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('46', '2', '44', '13', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('47', '2', '51', '11', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('48', '2', '54', '10', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('49', '3', '1', '1', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('50', '3', '2', '14', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('51', '3', '3', '15', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('52', '3', '18', '6', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('53', '3', '33', '2', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('54', '3', '36', '3', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('55', '3', '38', '4', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('56', '3', '40', '9', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('57', '3', '42', '5', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('58', '3', '55', '8', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('59', '3', '63', '7', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('60', '3', '96', '11', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('61', '3', '123', '12', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('62', '3', '17', '3', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('63', '3', '23', '9', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('64', '3', '24', '8', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('65', '3', '25', '6', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('66', '3', '27', '4', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('67', '3', '28', '2', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('68', '3', '35', '13', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('69', '3', '37', '14', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('70', '3', '49', '15', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('71', '3', '52', '7', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('72', '3', '58', '12', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('73', '3', '67', '9', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('74', '3', '75', '1', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('75', '7', '8', '6', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('76', '7', '11', '14', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('77', '7', '12', '2', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('78', '7', '39', '1', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('79', '7', '48', '4', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('80', '7', '50', '3', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('81', '7', '53', '7', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('82', '7', '68', '8', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('83', '7', '69', '13', '0');
INSERT INTO `players` (`id`, `game_id`, `member_id`, `number`, `validated`) VALUES ('84', '7', '77', '9', '0');


CREATE TABLE `points` (
  `id` int NOT NULL AUTO_INCREMENT,
  `team_id` int NOT NULL,
  `set_id` int NOT NULL,
  `position_of_server` int NOT NULL COMMENT 'The position (1-6) of the last server of the team which scored the point.',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_points_teams1_idx` (`team_id`),
  KEY `fk_points_sets1_idx` (`set_id`),
  CONSTRAINT `fk_points_sets1` FOREIGN KEY (`set_id`) REFERENCES `sets` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_points_teams1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Contains all points scored.';



CREATE TABLE `positions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `set_id` int NOT NULL,
  `team_id` int NOT NULL,
  `player_position_1_id` int NOT NULL,
  `player_position_2_id` int NOT NULL,
  `player_position_3_id` int NOT NULL,
  `player_position_4_id` int NOT NULL,
  `player_position_5_id` int NOT NULL,
  `player_position_6_id` int NOT NULL,
  `final` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_position_sets1_idx` (`set_id`),
  KEY `fk_position_teams_idx` (`team_id`),
  KEY `fk_positions_members1_idx` (`player_position_1_id`),
  KEY `fk_positions_members2_idx` (`player_position_2_id`),
  KEY `fk_positions_members3_idx` (`player_position_3_id`),
  KEY `fk_positions_members4_idx` (`player_position_4_id`),
  KEY `fk_positions_members5_idx` (`player_position_5_id`),
  KEY `fk_positions_members6_idx` (`player_position_6_id`),
  CONSTRAINT `fk_position_sets1` FOREIGN KEY (`set_id`) REFERENCES `sets` (`id`),
  CONSTRAINT `fk_position_teams` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`),
  CONSTRAINT `fk_positions_players1` FOREIGN KEY (`player_position_1_id`) REFERENCES `players` (`id`),
  CONSTRAINT `fk_positions_players2` FOREIGN KEY (`player_position_2_id`) REFERENCES `players` (`id`),
  CONSTRAINT `fk_positions_players3` FOREIGN KEY (`player_position_3_id`) REFERENCES `players` (`id`),
  CONSTRAINT `fk_positions_players4` FOREIGN KEY (`player_position_4_id`) REFERENCES `players` (`id`),
  CONSTRAINT `fk_positions_players5` FOREIGN KEY (`player_position_5_id`) REFERENCES `players` (`id`),
  CONSTRAINT `fk_positions_players6` FOREIGN KEY (`player_position_6_id`) REFERENCES `players` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;



CREATE TABLE `sets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `number` int DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `game_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sets_games1_idx` (`game_id`),
  CONSTRAINT `fk_sets_games1` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;



CREATE TABLE `substitutions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `position_id` int NOT NULL COMMENT 'References the "position sheet" of a specific set',
  `player_position_out` int NOT NULL COMMENT 'The position of the player who exits',
  `player_in_id` int NOT NULL COMMENT 'The player who enters',
  `returned` tinyint NOT NULL DEFAULT '0' COMMENT 'Indicates that the starting player has returned (and can no longer leave during this set)',
  PRIMARY KEY (`id`),
  KEY `fk_positions_idx` (`position_id`),
  KEY `fk_player_sub_idx` (`player_in_id`),
  CONSTRAINT `fk_player_sub` FOREIGN KEY (`player_in_id`) REFERENCES `members` (`id`),
  CONSTRAINT `fk_positions` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;



CREATE TABLE `teams` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;

INSERT INTO `teams` (`id`, `name`) VALUES ('2', 'Ecublens');
INSERT INTO `teams` (`id`, `name`) VALUES ('3', 'Froideville');
INSERT INTO `teams` (`id`, `name`) VALUES ('7', 'kill me');
INSERT INTO `teams` (`id`, `name`) VALUES ('4', 'Littoral');
INSERT INTO `teams` (`id`, `name`) VALUES ('1', 'LUC');
INSERT INTO `teams` (`id`, `name`) VALUES ('5', 'Lutry');
INSERT INTO `teams` (`id`, `name`) VALUES ('6', 'Yverdon');


CREATE TABLE `timeouts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `team_id` int NOT NULL,
  `set_id` int NOT NULL,
  `point_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_timeouts_teams_idx` (`team_id`),
  KEY `fk_sets_teams_idx` (`set_id`),
  KEY `fk_timeouts_points_idx` (`point_id`),
  CONSTRAINT `fk_timeout_point` FOREIGN KEY (`point_id`) REFERENCES `points` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_timeout_set` FOREIGN KEY (`set_id`) REFERENCES `sets` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_timeout_team` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

