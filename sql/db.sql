-- shema uporabniki
DROP DATABASE IF EXISTS uporabniki;
CREATE DATABASE uporabniki;
USE uporabniki;

-- tabela uporabniki

DROP TABLE IF EXISTS `uporabniki`;
CREATE TABLE `uporabniki` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ime` text,
  `priimek` text,
  `email` text,
  `geslo` text,
  `naslov` text,
  `vloga` text,
  `aktiven` TINYINT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- vnosi v tabelo
INSERT INTO `uporabniki` (ime, priimek, email, geslo, vloga, aktiven) VALUES ('Adam', 'Admin', 'adam.admin@mail.com', 'adamAmin123', 'admin', 1);
INSERT INTO `uporabniki` (ime, priimek, email, geslo, vloga, aktiven) VALUES ('Janez', 'Novak', 'jn@mail.com', 'janez123', 'prodajalec', 1);
INSERT INTO `uporabniki` (ime, priimek, email, geslo, vloga, aktiven) VALUES ('Stane', 'Horvat', 'staneh@mail.com', 'stanko123', 'stranka', 1);
INSERT INTO `uporabniki` (ime, priimek, email, geslo, vloga, aktiven) VALUES ('Stanko', 'Horvat', 'stankohorvat@mail.com', 'stanko123', 'stranka', 1);

