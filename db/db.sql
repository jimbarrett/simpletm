CREATE DATABASE `simpletm` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `simpletm`;

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE `tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `owner_id` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `complete` tinyint(4) NOT NULL DEFAULT 0,
  `due_date` datetime NOT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`id`, `username`, `password`, `created_date`) VALUES
(1,	'userone',	'9366b0a62c25af0cd4f1a65937ecbb8a',	'2019-02-01 22:20:37'),
(2,	'usertwo',	'9366b0a62c25af0cd4f1a65937ecbb8a',	'2019-02-01 22:20:58'),
(3,	'userthree',	'9366b0a62c25af0cd4f1a65937ecbb8a',	'2019-02-01 22:21:29');
