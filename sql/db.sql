-- shema jokes
DROP DATABASE IF EXISTS jokes;
CREATE DATABASE jokes;
USE jokes;

-- tabela jokes

DROP TABLE IF EXISTS `jokes`;
CREATE TABLE `jokes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `joke_text` text,
  `joke_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- vnosi v tabelo
INSERT INTO `jokes` (joke_text, joke_date) VALUES ('Chuck Norris can write infinite recursion functions ... and have them return.', NOW());
INSERT INTO `jokes` (joke_text, joke_date) VALUES ('Chuck can hit you so hard your web app will turn into swing application.', NOW());
INSERT INTO `jokes` (joke_text, joke_date) VALUES ('The functions Chuck Norris writes have no arguments, because nobody argues with Chuck Norris.', NOW());

