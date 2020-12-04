-- shema uporabniki
DROP DATABASE IF EXISTS uporabiniki;
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- vnosi v tabelo
INSERT INTO `uporabniki` (ime, priimek, email, geslo, vloga) VALUES ('Adam', 'Admin', 'adam.admin@mail.com', 'adamAmin123', 'admin');

