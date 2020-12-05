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

-- tabela izdelki

DROP TABLE IF EXISTS `izdelki`;
CREATE TABLE `izdelki` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ime` text,
  `opis` text,
  `cena` text,
  `prodajalec_id` int(11) NOT NULL,
  `aktiven` TINYINT,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`prodajalec_id`) REFERENCES  uporabniki(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- vnosi v tabelo
INSERT INTO `izdelki` (ime, opis, cena, prodajalec_id, aktiven) VALUES ('Očala', 'Ray-Ban očala', '50', '2', 1);
INSERT INTO `izdelki` (ime, opis, cena, prodajalec_id, aktiven) VALUES ('Voda', 'Evian', '2', '3', 1);
INSERT INTO `izdelki` (ime, opis, cena, prodajalec_id, aktiven) VALUES ('Radio', 'Pioneer radio z uro', '17', '4', 1);

