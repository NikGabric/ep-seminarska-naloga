drop database if exists ep_store;
create database ep_store;
use ep_store;

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `address` varchar(30),
  `email` varchar(80) NOT NULL,
  `password` varchar(64) NOT NULL,
  `role` varchar(8) NOT NULL, /* `admin`, `seller`, `customer` */
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

DROP TABLE IF EXISTS `rubiks_cube`;

CREATE TABLE `rubiks_cube` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `cube_name` varchar(30) NOT NULL,
  `manufacturer` varchar(30) NOT NULL,
  `cube_type` varchar(30) NOT NULL,
  `price` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `users`
--

LOCK TABLES `user` WRITE;
INSERT INTO `user` VALUES 
(1, 'admin1', 'Ivan','Pajo', NULL, 'admin1@test.si', 'adminpass', 'admin'),
(2, 'seller1', 'John', 'Doe', NULL, 'seller1@test.si', 'sellerpass', 'seller'),
(3, 'customer1', 'Mihi', 'Bele', 'Narnija 69', 'customer1@test.si', 'customerpass', 'customer');
UNLOCK TABLES;

LOCK TABLES `rubiks_cube` WRITE;
INSERT INTO `rubiks_cube` VALUES 
(1, 'Rubiks 3x3', 'Rubiks','3x3', 12),
(2, 'Rubiks 4x4', 'Rubiks','4x4', 16),
(3, 'Rubiks 5x5', 'Rubiks','5x5', 20);
UNLOCK TABLES;

-- Dump completed on 2014-12-12 16:45:04
