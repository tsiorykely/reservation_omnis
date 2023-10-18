/*
SQLyog Enterprise - MySQL GUI v8.1 
MySQL - 8.0.31 : Database - vaovao
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`vaovao` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `vaovao`;

/*Table structure for table `calendrier_dates` */

DROP TABLE IF EXISTS `calendrier_dates`;

CREATE TABLE `calendrier_dates` (
  `id_date` int NOT NULL AUTO_INCREMENT,
  `selected_date` date DEFAULT NULL,
  PRIMARY KEY (`id_date`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `calendrier_dates` */

insert  into `calendrier_dates`(id_date,selected_date) values (1,'2023-10-06'),(2,'2023-10-03'),(3,'2023-10-10'),(4,'2023-10-02'),(5,'2023-10-30'),(6,'2023-10-16'),(7,'2023-10-26'),(8,'2023-10-17'),(9,'2023-10-11'),(10,'2023-10-25'),(11,'2023-10-19'),(12,'2023-10-20'),(13,'2023-10-18'),(14,'2023-10-28'),(15,'2023-10-24'),(16,'2023-10-29'),(17,'2023-10-12'),(18,'2023-10-23'),(19,'2023-12-15'),(20,'2023-11-02');

/*Table structure for table `heure` */

DROP TABLE IF EXISTS `heure`;

CREATE TABLE `heure` (
  `id_heure` int NOT NULL AUTO_INCREMENT,
  `heure_debut` varchar(255) DEFAULT NULL,
  `heure_fin` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_heure`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `heure` */

insert  into `heure`(id_heure,heure_debut,heure_fin) values (1,'06:00 ','O8:00'),(2,'08:00 ','10:00'),(3,'10:00 ','12:00'),(4,'12:00 ','14:00'),(5,'14:00','16:00');

/*Table structure for table `reservation` */

DROP TABLE IF EXISTS `reservation`;

CREATE TABLE `reservation` (
  `id_reservation` int NOT NULL AUTO_INCREMENT,
  `id_date` int DEFAULT NULL,
  `id_heure` int DEFAULT NULL,
  `id_utilisateur` int DEFAULT NULL,
  `date_reservation` date DEFAULT NULL,
  PRIMARY KEY (`id_reservation`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `reservation` */

insert  into `reservation`(id_reservation,id_date,id_heure,id_utilisateur,date_reservation) values (24,18,1,1,'2023-10-17'),(23,17,5,1,'2023-10-17'),(22,17,4,1,'2023-10-17'),(21,17,3,1,'2023-10-17'),(20,17,2,1,'2023-10-17'),(19,17,1,1,'2023-10-17'),(25,8,1,1,'2023-10-17'),(26,15,2,1,'2023-10-18'),(27,8,2,1,'2023-10-18'),(28,19,3,1,'2023-10-18'),(29,19,4,1,'2023-10-18'),(30,19,5,1,'2023-10-18'),(31,7,1,1,'2023-10-18'),(32,7,2,1,'2023-10-18');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
