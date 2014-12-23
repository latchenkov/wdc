-- Adminer 4.1.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `test`;
CREATE DATABASE `test` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `test`;

DROP TABLE IF EXISTS `ads`;
CREATE TABLE `ads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `title` varchar(30) NOT NULL,
  `price` int(11) NOT NULL,
  `seller_name` varchar(25) NOT NULL,
  `private` tinyint(4) NOT NULL,
  `email` varchar(20) NOT NULL,
  `allow_mails` tinyint(4) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `location_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- 2014-12-21 17:58:37
