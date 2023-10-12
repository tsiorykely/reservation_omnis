/*
SQLyog Enterprise - MySQL GUI v8.1 
MySQL - 8.0.31 : Database - reservation_terrain
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`reservation_terrain` /*!40100 DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `reservation_terrain`;

/*Table structure for table `commentaire` */

CREATE TABLE `commentaire` (
  `id_commentaire` int NOT NULL AUTO_INCREMENT,
  `nom_client` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `mail_client` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `message` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_commentaire`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `commentaire` */

LOCK TABLES `commentaire` WRITE;

UNLOCK TABLES;

/*Table structure for table `facture` */

CREATE TABLE `facture` (
  `id_facture` int NOT NULL AUTO_INCREMENT,
  `id_reservation` int DEFAULT NULL,
  `nom_client` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_facture`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `facture` */

LOCK TABLES `facture` WRITE;

UNLOCK TABLES;

/*Table structure for table `intervalles` */

CREATE TABLE `intervalles` (
  `id_intervalles` int NOT NULL AUTO_INCREMENT,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  `disponibilite` tinyint NOT NULL,
  `id_reservation` int DEFAULT NULL,
  `id_heures` int DEFAULT NULL,
  `id_jours` int DEFAULT NULL,
  PRIMARY KEY (`id_intervalles`)
) ENGINE=MyISAM AUTO_INCREMENT=104 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `intervalles` */

LOCK TABLES `intervalles` WRITE;

insert  into `intervalles`(id_intervalles,heure_debut,heure_fin,disponibilite,id_reservation,id_heures,id_jours) values (1,'06:00:00','08:00:00',0,NULL,NULL,0),(2,'08:00:00','10:00:00',0,NULL,NULL,0),(3,'10:00:00','12:00:00',0,NULL,NULL,0),(4,'12:00:00','14:00:00',0,NULL,NULL,0),(5,'14:00:00','16:00:00',0,NULL,NULL,0),(6,'16:00:00','18:00:00',0,NULL,NULL,0);

UNLOCK TABLES;

/*Table structure for table `joueur` */

CREATE TABLE `joueur` (
  `id_joueur` int NOT NULL AUTO_INCREMENT,
  `nom_joueur` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `prenom_joueur` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `CIN` int DEFAULT NULL,
  `adress` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `telephone` int DEFAULT NULL,
  `mail` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `client_responsable` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_joueur`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `joueur` */

LOCK TABLES `joueur` WRITE;

insert  into `joueur`(id_joueur,nom_joueur,prenom_joueur,CIN,adress,telephone,mail,client_responsable) values (1,'RAZOSON','TSIORY',1117110291,'LOT ITS 36 TER BERAVINA',31232112,'TSIORYMANOVOSOA@gmail.com','KELY'),(2,'RAMANADRAIBE','Manuela',2147483647,'AVB 31 Andohhstanjona',331221212,'Manuela01gmail.com','kely');

UNLOCK TABLES;

/*Table structure for table `jours` */

CREATE TABLE `jours` (
  `id_jours` int NOT NULL AUTO_INCREMENT,
  `jours` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_jours`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `jours` */

LOCK TABLES `jours` WRITE;

insert  into `jours`(id_jours,jours) values (1,'Lundi'),(2,'Mardi'),(3,'Mercredi'),(4,'Jeudi'),(5,'Vendredi'),(6,'Samedi'),(7,'Dimanche');

UNLOCK TABLES;

/*Table structure for table `mois` */

CREATE TABLE `mois` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_mois` varchar(20) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `mois` */

LOCK TABLES `mois` WRITE;

insert  into `mois`(id,nom_mois) values (1,'janvier'),(2,'fevrier'),(3,'mars'),(4,'avril'),(5,'mai'),(6,'juin'),(7,'juillet'),(8,'aout'),(9,'septembre'),(10,'octobre'),(11,'novembre'),(12,'decembre');

UNLOCK TABLES;

/*Table structure for table `reservation` */

CREATE TABLE `reservation` (
  `id_reservation` int NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `nom_utilisateur` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `heure_debut` time DEFAULT NULL,
  `heure_fin` time DEFAULT NULL,
  `jours` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `nom_sport` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `nom_societe` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_reservation`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `reservation` */

LOCK TABLES `reservation` WRITE;

insert  into `reservation`(id_reservation,date,nom_utilisateur,heure_debut,heure_fin,jours,nom_sport,nom_societe) values (1,'2023-07-25','RAZOSON','06:00:00','08:00:00','Lundi','basket-ball','BOA'),(2,'2023-07-25','RAZOSON',NULL,NULL,NULL,NULL,NULL),(9,'0000-00-00',NULL,'16:00:00','18:00:00','Dimanche',NULL,'');

UNLOCK TABLES;

/*Table structure for table `responsable` */

CREATE TABLE `responsable` (
  `id_responsable` int NOT NULL AUTO_INCREMENT,
  `nom_resposable` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `prenom_responsable` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `telephone` int DEFAULT NULL,
  `mail` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `mot_de_passe` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_responsable`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `responsable` */

LOCK TABLES `responsable` WRITE;

insert  into `responsable`(id_responsable,nom_resposable,prenom_responsable,telephone,mail,mot_de_passe) values (1,'RAZOSON','Tsiory Manovosoa',333481572,'razosontsiory@gmail.com','manovosoa'),(2,'FANEVA','Kely',121212516,'faneva@gmail.com','1235');

UNLOCK TABLES;

/*Table structure for table `societe` */

CREATE TABLE `societe` (
  `id_societe` int NOT NULL AUTO_INCREMENT,
  `nom_societe` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `localisation` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `responsable` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_societe`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `societe` */

LOCK TABLES `societe` WRITE;

insert  into `societe`(id_societe,nom_societe,localisation,responsable) values (1,'Madauto',NULL,NULL),(2,'OMNIS',NULL,NULL),(3,'AXIAN',NULL,NULL),(4,'BATIMAX',NULL,NULL),(5,'STK Betafo',NULL,NULL),(6,'ALLIGA',NULL,NULL),(7,'BOA',NULL,NULL),(8,'FLOREAL',NULL,NULL),(9,'CT Motors',NULL,NULL),(10,'JOVENNA',NULL,NULL),(11,'BOA Volley',NULL,NULL),(12,'BAOBAB Bank',NULL,NULL),(13,'SMART PREDICT',NULL,NULL),(14,'BMOI',NULL,NULL),(15,'ANKOAY',NULL,NULL),(16,'SBM Bank',NULL,NULL),(17,'CAMUSA',NULL,NULL),(18,'KARIMO Fils',NULL,NULL),(19,'Mr MANOU',NULL,NULL),(20,'MCB',NULL,NULL);

UNLOCK TABLES;

/*Table structure for table `sports` */

CREATE TABLE `sports` (
  `id_sport` int NOT NULL AUTO_INCREMENT,
  `nom_sport` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_sport`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `sports` */

LOCK TABLES `sports` WRITE;

insert  into `sports`(id_sport,nom_sport,type) values (1,'basket_ball','colletif'),(2,'voley_ball','collectif');

UNLOCK TABLES;

/*Table structure for table `terrains` */

CREATE TABLE `terrains` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_terrain` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb3_unicode_ci,
  `capacite` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `terrains` */

LOCK TABLES `terrains` WRITE;

UNLOCK TABLES;

/*Table structure for table `utilisateur` */

CREATE TABLE `utilisateur` (
  `id_utilisateurs` int NOT NULL AUTO_INCREMENT,
  `nom_utilisateur` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `prenom_utilisateur` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `mail` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `mot_de_passe` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_utilisateurs`),
  UNIQUE KEY `email` (`mail`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `utilisateur` */

LOCK TABLES `utilisateur` WRITE;

insert  into `utilisateur`(id_utilisateurs,nom_utilisateur,prenom_utilisateur,mail,mot_de_passe) values (1,'Razoson','Tsiory','tsiorymanovosoa@gmail.com','manovosoa'),(2,'RABARISAOTRA','Manovosoa','kely@gmail.com','1235');

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
