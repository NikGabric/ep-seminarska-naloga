drop database if exists ep_store;
create database ep_store;
use ep_store;

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `user_id` int(8) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `address` varchar(30),
  `email` varchar(80) NOT NULL,
  `password` varchar(64) NOT NULL,
  `role` varchar(8) NOT NULL, /* `admin`, `seller`, `customer` */
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

DROP TABLE IF EXISTS `rubiks_cube`;

CREATE TABLE `rubiks_cube` (
  `cube_id` int(8) NOT NULL AUTO_INCREMENT,
  `cube_name` varchar(30) NOT NULL,
  `manufacturer` varchar(30) NOT NULL,
  `cube_type` varchar(30) NOT NULL,
  `price` float NOT NULL,
  PRIMARY KEY (`cube_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

DROP TABLE IF EXISTS `finished_order`;

CREATE TABLE `finished_order` (
  `order_id` int(8) NOT NULL AUTO_INCREMENT,
  `customer_id` int(8) NOT NULL,
  `order_status` varchar(15) NOT NULL,
  `order_total` float NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

DROP TABLE IF EXISTS `order_detail`;

CREATE TABLE `order_detail` (
  `detail_id` int(8) NOT NULL AUTO_INCREMENT,
  `order_id` int(8) NOT NULL,
  `product_id` int(8) NOT NULL,
  `product_price` float NOT NULL,
  `product_quantity` int(8) NOT NULL,
  PRIMARY KEY (`detail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `users`
--

LOCK TABLES `user` WRITE;
INSERT INTO `user` VALUES 
('4', 'admin', 'admin', 'admin', '', 'admin@test.si', '$2y$10$38DwIObCkfk6m5QJVGhN0O1AtdCWR8tUYCGBxH0pIol550Nxm8YdO', 'admin', 'active'),
('5', 'seller1', 'seller1', 'seller1', '', 'seller1@test.si', '$2y$10$O9Cu6SlsZXtTS4gydVIYfuqAOuxQACspUSyx4IljCVO76JoffcuGi', 'seller', 'active'),
('6', 'seller2', 'seller2', 'seller2', '', 'seller2@test.si', '$2y$10$7kkYsVzkFVgxrmh4ke0egewxcq38yKLTNah5VvB8DCz0VLgrA5Mqm', 'seller', 'active'),
('7', 'customer1', 'customer1', 'customer1', 'Narnija', 'customer1@test.si', '$2y$10$TVFQWxwrne2g1fi6is/KQOzgB9mveOqlkCkMRAY6XtK4s0sl4llUS', 'customer', 'active'),
('8', 'customer2', 'customer2', 'customer2', 'Hogwarts', 'customer2@test.si', '$2y$10$MyogYCf.MyW20PslqiYh9.hJx9l0zsJSumIZPPtYD.vh0XuRbyBP6', 'customer', 'active');
UNLOCK TABLES;

LOCK TABLES `rubiks_cube` WRITE;
INSERT INTO `rubiks_cube` VALUES 
(1, 'Rubiks 3x3', 'Rubiks','3x3', 12),
(2, 'Rubiks 4x4', 'Rubiks','4x4', 16),
(3, 'Rubiks 5x5', 'Rubiks','5x5', 20);
UNLOCK TABLES;

-- Dump completed on 2014-12-12 16:45:04
