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
INSERT INTO `uporabniki` (ime, priimek, email, geslo, vloga, aktiven) VALUES ('Adam', 'Admin', 'adam.admin@mail.com', '$1$trgovina$72NkI3N6C0d4WLXcGLcd20', 'admin', 1);
INSERT INTO `uporabniki` (ime, priimek, email, geslo, vloga, aktiven) VALUES ('Janez', 'Novak', 'jn@mail.com', '$1$trgovina$oLCDeNVWtehAZ1K2W.d6V.', 'prodajalec', 1);
INSERT INTO `uporabniki` (ime, priimek, email, geslo, vloga, aktiven) VALUES ('Stane', 'Horvat', 'staneh@mail.com', '$1$trgovina$hrbdw7I138tHVdx.9yJTZ.', 'stranka', 1);
INSERT INTO `uporabniki` (ime, priimek, email, geslo, vloga, aktiven) VALUES ('Stanko', 'Horvat', 'stankohorvat@mail.com', '$1$trgovina$hrbdw7I138tHVdx.9yJTZ.', 'stranka', 1);
-- GESLA:
-- adamAmin123
-- Janez123
-- stanko123
-- stanko123


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

DROP TABLE IF EXISTS `narocila`;
CREATE TABLE `narocila` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kupec_id` int(11) NOT NULL,
  `stanje` text NOT NULL,
  `cas` TIMESTAMP NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`kupec_id`) REFERENCES  uporabniki(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `izdelekNarocila`;
CREATE TABLE `izdelekNarocila` (
  `narocilo_id` int(11) NOT NULL,
  `izdelek_id` int(11) NOT NULL,
  `steviloIzdelkov` int(11),
  PRIMARY KEY (`narocilo_id`, `izdelek_id`),
  FOREIGN KEY (`narocilo_id`) REFERENCES  narocila(`id`),
  FOREIGN KEY (`izdelek_id`) REFERENCES  izdelki(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;