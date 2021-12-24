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
  `password` varchar(30) NOT NULL,
  `role` varchar(8) NOT NULL, /* `admin`, `salesman`, `customer`, `anon` */
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

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
(1, 'pivofrajer', 'Ivan','Pajo', NULL, 'P.Ivan@sds.si', 'jj_overlord', 'admin'),
(2, 'john', 'John', 'Doe', NULL, 'j.dough@c9.com', '00000000', 'salesman'),
(3, 'mihi bele 123', 'Mihi', 'Bele', 'Narnija 69', 'mihi.bele.123@lolpro.com', 'mid_or_AFK', 'customer');
UNLOCK TABLES;

LOCK TABLES `rubiks_cube` WRITE;
INSERT INTO `rubiks_cube` VALUES 
(1, '11 pro-M', 'Gan','3x3', 16),
(2, 'RS3M', 'MoYu','3x3', 12),
(3, 'Weilong WR M 2021', 'Moyu','3x3', 15),
(4, 'MGC 4x4 Magnetic', 'YJ','4x4', 22),
(5, 'MS 4x4', 'QiYi','4x4', 20);
UNLOCK TABLES;

-- Dump completed on 2014-12-12 16:45:04
