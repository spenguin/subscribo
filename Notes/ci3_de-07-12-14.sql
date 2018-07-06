/*
SQLyog Community v9.02 
MySQL - 5.6.11 : Database - ci3_de
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `answers` */

DROP TABLE IF EXISTS `answers`;

CREATE TABLE `answers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `collection` varchar(255) NOT NULL,
  `entry` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `answers` */

insert  into `answers`(`id`,`collection`,`entry`,`answer`) values (1,'publisher','pending','<p>Thank you for registering to use The Distribution Engine service. As soon as your registration has been confirmed, you will receive a confirmation email.</p>'),(2,'shop','pending','<p>Thank you for registering to use The Distribution Engine service. As soon as your registration has been confirmed, you will receive a confirmation email.</p>');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `migration` varchar(200) NOT NULL,
  `batch` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `migrations` */

insert  into `migrations`(`migration`,`batch`) values ('20141123_add_tags',1),('20141128_add_answers_table',1),('20141128_add_posts_table',1),('20141128_add_sitevars_table',1),('23112014_add_users',1);

/*Table structure for table `posts` */

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `url_title` varchar(255) NOT NULL,
  `body` longtext NOT NULL,
  `excerpt` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `userId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `posts` */

/*Table structure for table `sitevars` */

DROP TABLE IF EXISTS `sitevars`;

CREATE TABLE `sitevars` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `sitevars` */

insert  into `sitevars`(`id`,`name`,`value`) values (1,'HEADER__title','The Distribution Engine'),(2,'HEADER__author','John Anderson::Soaring Penguin Ltd.'),(3,'HEADER__copyright','&copy; The Distribution Engine'),(4,'HEADER__tagline','Bringing you the comics you didn\'t know you wanted.');

/*Table structure for table `tags` */

DROP TABLE IF EXISTS `tags`;

CREATE TABLE `tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `parentId` int(10) unsigned NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `tags` */

insert  into `tags`(`id`,`name`,`slug`,`parentId`,`description`) values (1,'Usertypes','usertypes',0,'User Types'),(2,'Admin','admin',1,'Administration type'),(3,'Shop','shop',1,'Comic Shop type'),(4,'Publisher','publisher',1,'Publisher type');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pwhash` varchar(255) NOT NULL,
  `nonce` varchar(255) NOT NULL,
  `userTypeId` int(10) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `remember_token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`username`,`email`,`pwhash`,`nonce`,`userTypeId`,`status`,`remember_token`,`created_at`,`updated_at`) values (1,'John Anderson','spenguinAdmin','info@soaringpenguin.com','12530f55abe20de395377afa0cd60f19e456ca98422bb4922403689af17685b2d2d2a11714c3102194f0514a9d6cd0d9c00397b4c5161eaa2278d3e49fc00ac4tn57QxUIFV1ICMzgRrodZ1S+9Mmv4LpAnqYEWFUOVVA=','e9994a003c1c0e8634cb021ef458ddb9',2,1,'','2014-11-28 14:07:54','0000-00-00 00:00:00'),(2,'John Anderson','janderson','info@soaringpenguinpress.com','ac5254896a24a0ff047bb4a9f9ea0719adab4fed471f430dc51452d4760a688cd7f8fdfc8c639cd582a20e6b1350ce28b944814ad6247693623aa22b4d1db0a81944OOjKU3FrXByJEO40QzDit/6Ae4fJaEqysIqbHUs=','e9994a003c1c0e8634cb021ef458ddb9',4,1,'','2014-11-28 14:07:54','0000-00-00 00:00:00');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
