-- Adminer 3.2.2 MySQL dump

SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = 'SYSTEM';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `viewed` int(11) NOT NULL,
  `published_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `article_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

INSERT INTO `article` (`id`, `user_id`, `viewed`, `published_at`) VALUES
(1,	1,	10,	'0000-00-00 00:00:00'),
(2,	1,	20,	'0000-00-00 00:00:00');

DROP TABLE IF EXISTS `article_trans`;
CREATE TABLE `article_trans` (
  `article_id` int(11) NOT NULL,
  `language` char(2) COLLATE utf8_slovak_ci NOT NULL,
  `title` varchar(100) COLLATE utf8_slovak_ci NOT NULL,
  `content` text COLLATE utf8_slovak_ci NOT NULL,
  PRIMARY KEY (`article_id`,`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

INSERT INTO `article_trans` (`article_id`, `language`, `title`, `content`) VALUES
(1,	'en',	'First article',	'Content of first article.'),
(1,	'sk',	'Prvý článok',	'Obsah prvého článku.'),
(2,	'sk',	'Druhý článok',	'Text druhého článku.');

DROP TABLE IF EXISTS `notorm`;
CREATE TABLE `notorm` (
  `id` varchar(255) COLLATE utf8_slovak_ci NOT NULL,
  `data` text COLLATE utf8_slovak_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

INSERT INTO `notorm` (`id`, `data`) VALUES
('article_trans;article_trans.article_id,language',	's:0:\"\";'),
('article;id',	'a:2:{s:2:\"id\";b:1;s:6:\"viewed\";b:1;}');

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8_slovak_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

INSERT INTO `user` (`id`, `name`) VALUES
(1,	'marek');

-- 2011-07-13 17:14:55
