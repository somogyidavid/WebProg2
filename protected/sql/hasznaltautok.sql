-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1:3308
-- Létrehozás ideje: 2020. Máj 08. 09:56
-- Kiszolgáló verziója: 8.0.18
-- PHP verzió: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `hasznaltautok`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `advertisementdetails`
--

DROP TABLE IF EXISTS `advertisementdetails`;
CREATE TABLE IF NOT EXISTS `advertisementdetails` (
  `id` int(64) NOT NULL AUTO_INCREMENT,
  `advertisementId` int(64) NOT NULL,
  `licencePlate` varchar(7) COLLATE utf8_hungarian_ci NOT NULL,
  `brand` int(11) NOT NULL,
  `model` int(11) NOT NULL,
  `vintage` int(4) NOT NULL,
  `type` varchar(64) COLLATE utf8_hungarian_ci NOT NULL,
  `condition` varchar(64) COLLATE utf8_hungarian_ci NOT NULL,
  `price` int(64) NOT NULL,
  `kilometer` int(64) NOT NULL,
  `fuel` varchar(64) COLLATE utf8_hungarian_ci NOT NULL,
  `engineCapacity` int(64) NOT NULL,
  `color` varchar(64) COLLATE utf8_hungarian_ci NOT NULL,
  `description` varchar(1000) CHARACTER SET utf8 COLLATE utf8_hungarian_ci NOT NULL,
  `contact` varchar(64) COLLATE utf8_hungarian_ci NOT NULL,
  `image` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ADVERTISEMENTID` (`advertisementId`),
  KEY `FK_advertisementDetails_brands` (`brand`),
  KEY `FK_advertisementDetails_models` (`model`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `advertisementdetails`
--

INSERT INTO `advertisementdetails` (`id`, `advertisementId`, `licencePlate`, `brand`, `model`, `vintage`, `type`, `condition`, `price`, `kilometer`, `fuel`, `engineCapacity`, `color`, `description`, `contact`, `image`) VALUES
(19, 25, 'JEP-714', 1, 1, 2018, 'Egyterű', 'Kitűnő', 2000000, 34000, 'Benzin', 3000, 'Fekete', 'Első tulajdonostól, sérülésmentes, márkaszervizben végig vezetett szervizkönyves, megkímélt műszaki, és esztétikai állapotú autó! Garantált, leinformálható kilométer futással, kilométer garanciával, 1év szavatossággal igényes vevőnek eladó! A gépkocs', '+36307415497', 'JEP714.jpg'),
(20, 26, 'GTH-421', 1, 3, 2018, 'Kisbusz', 'Kitűnő', 13000000, 1, 'Benzin', 5000, 'Fehér', 'Budapest', '+36204365431', 'GTH421.jpg'),
(42, 48, 'III-534', 2, 5, 2018, 'Ferdehátú', 'Megkímélt', 20000, 765000, 'Benzin/Gáz', 3000, 'Piros', 'Nem admin user', '+36204365234', 'III534.jpg'),
(44, 51, 'EFR-423', 4, 13, 2018, 'Kombi', 'Kitűnő', 1200000, 73000, 'Benzin', 2000, 'Fehér', 'Nem admin user', '+36207415497', 'EFR423.jpg');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `advertisements`
--

DROP TABLE IF EXISTS `advertisements`;
CREATE TABLE IF NOT EXISTS `advertisements` (
  `id` int(64) NOT NULL AUTO_INCREMENT,
  `userId` int(64) NOT NULL,
  `title` varchar(64) COLLATE utf8_hungarian_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_UserId_Id` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `advertisements`
--

INSERT INTO `advertisements` (`id`, `userId`, `title`) VALUES
(25, 1, 'Eladó Ford Focus 1'),
(26, 1, 'Eladó Ford Mustang'),
(48, 2, 'Eladó Peugeot'),
(49, 1, ''),
(51, 2, 'Eladó Renault');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `brands`
--

DROP TABLE IF EXISTS `brands`;
CREATE TABLE IF NOT EXISTS `brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_hungarian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `brands`
--

INSERT INTO `brands` (`id`, `brand_name`) VALUES
(1, 'FORD'),
(2, 'PEUGEOT'),
(3, 'OPEL'),
(4, 'RENAULT');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `models`
--

DROP TABLE IF EXISTS `models`;
CREATE TABLE IF NOT EXISTS `models` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brandId` int(11) NOT NULL,
  `model_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_hungarian_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_models_brands` (`brandId`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `models`
--

INSERT INTO `models` (`id`, `brandId`, `model_name`) VALUES
(1, 1, 'FOCUS'),
(2, 1, 'RANGER'),
(3, 1, 'MUSTANG'),
(4, 1, 'FIESTA'),
(5, 2, '208'),
(6, 2, '308'),
(7, 2, 'BOXER'),
(8, 2, 'RIFTER'),
(9, 3, 'ASTRA'),
(10, 3, 'COMBO'),
(11, 3, 'CROSSLAND'),
(12, 3, 'INSIGNIA'),
(13, 4, 'ZOE'),
(14, 4, 'CLIO'),
(15, 4, 'CAPTUR'),
(16, 4, 'KADJAR');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(64) COLLATE utf8_hungarian_ci NOT NULL,
  `last_name` varchar(64) COLLATE utf8_hungarian_ci NOT NULL,
  `email` varchar(250) COLLATE utf8_hungarian_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_hungarian_ci NOT NULL,
  `permission` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `permission`) VALUES
(1, 'Somogyi', 'Dávid', 'admin@admin.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 1),
(2, 'Teszt', 'Elek', 'Teszt@Elek.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 0),
(14, 'admin1', 'admin1', 'admin1@admin.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 1);

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `advertisementdetails`
--
ALTER TABLE `advertisementdetails`
  ADD CONSTRAINT `FK_ADVERTISEMENTID` FOREIGN KEY (`advertisementId`) REFERENCES `advertisements` (`id`),
  ADD CONSTRAINT `FK_advertisementDetails_brands` FOREIGN KEY (`brand`) REFERENCES `brands` (`id`),
  ADD CONSTRAINT `FK_advertisementDetails_models` FOREIGN KEY (`model`) REFERENCES `models` (`id`);

--
-- Megkötések a táblához `advertisements`
--
ALTER TABLE `advertisements`
  ADD CONSTRAINT `FK_UserId_Id` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
