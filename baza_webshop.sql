-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.21 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             9.1.0.4867
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for web_shop
CREATE DATABASE IF NOT EXISTS `web_shop` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `web_shop`;


-- Dumping structure for table web_shop.detalji_narudzbe
CREATE TABLE IF NOT EXISTS `detalji_narudzbe` (
  `sifra_detalja` int(11) NOT NULL AUTO_INCREMENT,
  `br_narudzbe` int(11) NOT NULL DEFAULT '0',
  `br_proizvoda` int(11) NOT NULL DEFAULT '0',
  `kolicina` int(11) NOT NULL DEFAULT '0',
  `jedinicna_cijena` decimal(10,2) NOT NULL DEFAULT '0.00',
  `detalji` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`sifra_detalja`),
  KEY `br_narudzbe` (`br_narudzbe`,`br_proizvoda`),
  KEY `FK_detalji_narudzbe_proizvodi` (`br_proizvoda`),
  CONSTRAINT `FK_detalji_narudzbe_narudzbe` FOREIGN KEY (`br_narudzbe`) REFERENCES `narudzbe` (`br_narudzbe`),
  CONSTRAINT `FK_detalji_narudzbe_proizvodi` FOREIGN KEY (`br_proizvoda`) REFERENCES `proizvodi` (`br_proizvoda`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table web_shop.detalji_narudzbe: ~3 rows (approximately)
/*!40000 ALTER TABLE `detalji_narudzbe` DISABLE KEYS */;
INSERT INTO `detalji_narudzbe` (`sifra_detalja`, `br_narudzbe`, `br_proizvoda`, `kolicina`, `jedinicna_cijena`, `detalji`) VALUES
	(1, 5, 1, 1, 24.99, ''),
	(2, 5, 2, 1, 100.00, ''),
	(3, 5, 1, 1, 24.99, '');
/*!40000 ALTER TABLE `detalji_narudzbe` ENABLE KEYS */;


-- Dumping structure for table web_shop.dostave
CREATE TABLE IF NOT EXISTS `dostave` (
  `br_dostave` int(11) NOT NULL AUTO_INCREMENT,
  `naziv_dostave` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `troškovi` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`br_dostave`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table web_shop.dostave: ~5 rows (approximately)
/*!40000 ALTER TABLE `dostave` DISABLE KEYS */;
INSERT INTO `dostave` (`br_dostave`, `naziv_dostave`, `troškovi`) VALUES
	(1, 'osobno preuzimanje', 0.00),
	(2, 'Hrvatska pošta', 10.00),
	(3, 'HP Express', 33.54),
	(4, 'City EX', 27.66),
	(5, 'Overseas', 23.99);
/*!40000 ALTER TABLE `dostave` ENABLE KEYS */;


-- Dumping structure for table web_shop.kategorije
CREATE TABLE IF NOT EXISTS `kategorije` (
  `br_kategorije` int(11) NOT NULL AUTO_INCREMENT,
  `naziv_kategorije` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`br_kategorije`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table web_shop.kategorije: ~0 rows (approximately)
/*!40000 ALTER TABLE `kategorije` DISABLE KEYS */;
INSERT INTO `kategorije` (`br_kategorije`, `naziv_kategorije`) VALUES
	(1, 'Muška odjeća'),
	(2, 'Ženska odjeća'),
	(3, 'Ručni satovi');
/*!40000 ALTER TABLE `kategorije` ENABLE KEYS */;


-- Dumping structure for table web_shop.kupci
CREATE TABLE IF NOT EXISTS `kupci` (
  `br_kupca` int(11) NOT NULL AUTO_INCREMENT,
  `ime` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `prezime` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `adresa` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `postanski_broj` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `mjesto` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `telefon` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`br_kupca`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table web_shop.kupci: ~4 rows (approximately)
/*!40000 ALTER TABLE `kupci` DISABLE KEYS */;
INSERT INTO `kupci` (`br_kupca`, `ime`, `prezime`, `adresa`, `postanski_broj`, `mjesto`, `telefon`, `email`, `username`, `password`) VALUES
	(1, 'Ivo', 'Ivić', 'Neka 22', '31000', 'Osijek', '34343', 'ivo@net.hr', 'ivo', 'e2fc714c4727ee9395f324cd2e7f331f'),
	(2, 'Marko', 'Marković', 'Duga 34', '31000', 'Osijek', '343434', 'mmarkovic@gmail.com', 'mmarkovic', '81dc9bdb52d04dc20036dbd8313ed055'),
	(3, 'bundeva', 'bundević', 'Bundevina 23', '44535', 'Osijek', '33434', 'bundeva51@net.hr', 'bundeva', '5b8e97b4d23f31874698f814a79603b0'),
	(4, 'osdav', 'osdav', 'sds', '334', 'sds', '3344', 'osdavidias@hotmail.com', 'osdav', '4eb15c84d0a076b28f088ad6c88ffa12');
/*!40000 ALTER TABLE `kupci` ENABLE KEYS */;


-- Dumping structure for table web_shop.narudzbe
CREATE TABLE IF NOT EXISTS `narudzbe` (
  `br_narudzbe` int(11) NOT NULL AUTO_INCREMENT,
  `kupac` int(11) NOT NULL DEFAULT '0',
  `dostava` int(11) NOT NULL DEFAULT '0',
  `ukupan_iznos` decimal(10,2) NOT NULL DEFAULT '0.00',
  `datum` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ime` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `prezime` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `adresa` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `mjesto` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `post_br` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `telefon` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`br_narudzbe`),
  KEY `narudzbe` (`kupac`),
  KEY `dostava` (`dostava`),
  CONSTRAINT `FK_narudzbe_dostave` FOREIGN KEY (`dostava`) REFERENCES `dostave` (`br_dostave`),
  CONSTRAINT `FK_prodano_kupci` FOREIGN KEY (`kupac`) REFERENCES `kupci` (`br_kupca`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table web_shop.narudzbe: ~0 rows (approximately)
/*!40000 ALTER TABLE `narudzbe` DISABLE KEYS */;
INSERT INTO `narudzbe` (`br_narudzbe`, `kupac`, `dostava`, `ukupan_iznos`, `datum`, `ime`, `prezime`, `adresa`, `mjesto`, `post_br`, `telefon`) VALUES
	(5, 1, 1, 24.99, '2016-01-29 15:11:04', '', '', '', '', '0', '0');
/*!40000 ALTER TABLE `narudzbe` ENABLE KEYS */;


-- Dumping structure for table web_shop.opcije
CREATE TABLE IF NOT EXISTS `opcije` (
  `br_opcije` int(11) NOT NULL AUTO_INCREMENT,
  `br_opc_grupe` int(11) NOT NULL DEFAULT '0',
  `naziv_opcije` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`br_opcije`),
  KEY `br_opc_grupe` (`br_opc_grupe`),
  CONSTRAINT `FK_opcije_opcijske_grupe` FOREIGN KEY (`br_opc_grupe`) REFERENCES `opcijske_grupe` (`br_opc_grupe`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table web_shop.opcije: ~14 rows (approximately)
/*!40000 ALTER TABLE `opcije` DISABLE KEYS */;
INSERT INTO `opcije` (`br_opcije`, `br_opc_grupe`, `naziv_opcije`) VALUES
	(1, 1, 'S'),
	(2, 1, 'M'),
	(3, 1, 'L'),
	(4, 1, 'XL'),
	(5, 1, 'XXL'),
	(6, 2, 'plava'),
	(7, 2, 'bijela'),
	(8, 2, 'crvena'),
	(9, 2, 'žuta'),
	(10, 2, 'smeđa'),
	(11, 2, 'ružičasta'),
	(12, 3, 'pozlaćeni'),
	(14, 3, 'sport'),
	(15, 3, 'kromirani');
/*!40000 ALTER TABLE `opcije` ENABLE KEYS */;


-- Dumping structure for table web_shop.opcijske_grupe
CREATE TABLE IF NOT EXISTS `opcijske_grupe` (
  `br_opc_grupe` int(11) NOT NULL AUTO_INCREMENT,
  `naziv_opc_grupe` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`br_opc_grupe`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table web_shop.opcijske_grupe: ~2 rows (approximately)
/*!40000 ALTER TABLE `opcijske_grupe` DISABLE KEYS */;
INSERT INTO `opcijske_grupe` (`br_opc_grupe`, `naziv_opc_grupe`) VALUES
	(1, 'veličine'),
	(2, 'boje'),
	(3, 'modeli sata');
/*!40000 ALTER TABLE `opcijske_grupe` ENABLE KEYS */;


-- Dumping structure for table web_shop.potkategorije
CREATE TABLE IF NOT EXISTS `potkategorije` (
  `br_potkategorije` int(11) NOT NULL AUTO_INCREMENT,
  `kategorija` int(11) NOT NULL,
  `naziv_potkategorije` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`br_potkategorije`),
  KEY `kategorija` (`kategorija`),
  CONSTRAINT `FK_potkategorije_kategorije` FOREIGN KEY (`kategorija`) REFERENCES `kategorije` (`br_kategorije`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table web_shop.potkategorije: ~0 rows (approximately)
/*!40000 ALTER TABLE `potkategorije` DISABLE KEYS */;
INSERT INTO `potkategorije` (`br_potkategorije`, `kategorija`, `naziv_potkategorije`) VALUES
	(1, 1, 'Muške majice'),
	(2, 1, 'Muške košulje'),
	(3, 1, 'Muške hlače'),
	(4, 2, 'Ženske majice');
/*!40000 ALTER TABLE `potkategorije` ENABLE KEYS */;


-- Dumping structure for table web_shop.proizvodi
CREATE TABLE IF NOT EXISTS `proizvodi` (
  `br_proizvoda` int(11) NOT NULL AUTO_INCREMENT,
  `naziv_proizvoda` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `opis` text COLLATE utf8_unicode_ci NOT NULL,
  `slika` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cijena` decimal(10,2) NOT NULL,
  `na_skladistu` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `kategorija` int(11) NOT NULL,
  `potkategorija` int(11) DEFAULT NULL,
  `vrijeme_dodavanja` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`br_proizvoda`),
  UNIQUE KEY `naziv_proizvoda` (`naziv_proizvoda`),
  KEY `kategorija` (`kategorija`),
  KEY `potkategorija` (`potkategorija`),
  CONSTRAINT `FK_proizvodi_kategorije` FOREIGN KEY (`kategorija`) REFERENCES `kategorije` (`br_kategorije`),
  CONSTRAINT `FK_proizvodi_potkategorije` FOREIGN KEY (`potkategorija`) REFERENCES `potkategorije` (`br_potkategorije`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table web_shop.proizvodi: ~5 rows (approximately)
/*!40000 ALTER TABLE `proizvodi` DISABLE KEYS */;
INSERT INTO `proizvodi` (`br_proizvoda`, `naziv_proizvoda`, `opis`, `slika`, `cijena`, `na_skladistu`, `kategorija`, `potkategorija`, `vrijeme_dodavanja`) VALUES
	(1, 'crna majica', 'Crna muška pamučna majica', 'crna_majica.jpg', 24.99, 'dostupno', 1, 1, '2016-01-30 11:20:17'),
	(2, 'muška košulja', 'Elegantna muška košulja', 'm_kosulja.jpg', 100.00, 'dostupno', 1, 2, '2016-01-31 11:32:17'),
	(5, 'muške hlače', 'Udobne muške hlače', 'muske_hlace.jpg', 220.56, 'dostupno', 1, 3, '2016-01-31 12:50:47'),
	(8, 'ženska ljetna majica', 'Ženska ljetna majica bez rukava', 'Zenska-majica.jpg', 77.56, 'dostupno', 2, 4, '2016-02-01 13:52:07'),
	(11, 'ručni sat', 'Praktičan, točan i pouzdan ručni sat.', 'r_sat.jpg', 566.78, 'dostupno', 3, NULL, '2016-02-01 18:57:25'),
	(12, 'muška ljetna majica', 'Muška ljetna majica kratkih rukava', 'p_majica.jpg', 45.67, 'nema', 1, 1, '2016-02-05 13:21:27');
/*!40000 ALTER TABLE `proizvodi` ENABLE KEYS */;


-- Dumping structure for table web_shop.proizvodi_opcije
CREATE TABLE IF NOT EXISTS `proizvodi_opcije` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `proizvod` int(11) NOT NULL,
  `opcijska_grupa` int(11) DEFAULT NULL,
  `opcija` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `proizvod` (`proizvod`),
  KEY `opcija` (`opcija`),
  KEY `opcijska_grupa` (`opcijska_grupa`),
  CONSTRAINT `FK_proizvodi_opcije_opcije` FOREIGN KEY (`opcija`) REFERENCES `opcije` (`br_opcije`),
  CONSTRAINT `FK_proizvodi_opcije_opcijske_grupe` FOREIGN KEY (`opcijska_grupa`) REFERENCES `opcijske_grupe` (`br_opc_grupe`),
  CONSTRAINT `FK_proizvodi_opcije_proizvodi` FOREIGN KEY (`proizvod`) REFERENCES `proizvodi` (`br_proizvoda`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table web_shop.proizvodi_opcije: ~23 rows (approximately)
/*!40000 ALTER TABLE `proizvodi_opcije` DISABLE KEYS */;
INSERT INTO `proizvodi_opcije` (`id`, `proizvod`, `opcijska_grupa`, `opcija`) VALUES
	(4, 1, 1, 1),
	(5, 1, 1, 2),
	(6, 1, 1, 3),
	(7, 1, 1, 4),
	(8, 1, 1, 5),
	(9, 2, 1, 2),
	(10, 2, 1, 3),
	(11, 2, 1, 4),
	(12, 2, 2, 7),
	(13, 2, 2, 6),
	(14, 2, 2, 8),
	(15, 8, 1, 1),
	(16, 8, 1, 2),
	(17, 8, 1, 3),
	(18, 8, 2, 11),
	(19, 8, 2, 9),
	(20, 11, 3, 12),
	(21, 11, 3, 14),
	(22, 11, 3, 15),
	(23, 12, 1, 4),
	(24, 12, 1, 5),
	(25, 12, 2, 7),
	(26, 12, 2, 6);
/*!40000 ALTER TABLE `proizvodi_opcije` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
