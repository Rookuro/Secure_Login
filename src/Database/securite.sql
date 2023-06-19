-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 09 juin 2023 à 21:42
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `securite`
--

-- --------------------------------------------------------

--
-- Structure de la table `account`
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE IF NOT EXISTS `account` (
  `guid` varchar(36) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `stretch` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `accountattemps`
--

DROP TABLE IF EXISTS `accountattemps`;
CREATE TABLE IF NOT EXISTS `accountattemps` (
  `guid` varchar(100) NOT NULL,
  `time` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `accountattemps`
--

INSERT INTO `accountattemps` (`guid`, `time`) VALUES
('68807ee3-06cc-11ee-9639-04bf1b327336', '2023-06-09 22:53:58'),
('68807ee3-06cc-11ee-9639-04bf1b327336', '2023-06-09 22:54:02'),
('68807ee3-06cc-11ee-9639-04bf1b327336', '2023-06-09 22:54:05');

-- --------------------------------------------------------

--
-- Structure de la table `accountotp`
--

DROP TABLE IF EXISTS `accountotp`;
CREATE TABLE IF NOT EXISTS `accountotp` (
  `guid` int NOT NULL,
  `OTP` varchar(255) NOT NULL,
  `Validity` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `accountotp`
--

INSERT INTO `accountotp` (`guid`, `OTP`, `Validity`) VALUES
(472, 'ce4daa1ecda83afb2ea16e20c42960c2', '2023-06-09 16:55:29'),
(0, '4a24316c91d2758f0256afd1bb1aadbe', '2023-06-09 17:26:59');

-- --------------------------------------------------------

--
-- Structure de la table `accounttmp`
--

DROP TABLE IF EXISTS `accounttmp`;
CREATE TABLE IF NOT EXISTS `accounttmp` (
  `guid` varchar(100) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `stretch` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `accounttmp`
--

INSERT INTO `accounttmp` (`guid`, `pwd`, `salt`, `stretch`) VALUES
('68807ee3-06cc-11ee-9639-04bf1b327336', '37b9a86b36a6f0d0f4bd9e3e1263102d24c09f74c020d96b521d9d488af88f4402edeccb82cdbc3aa59e57dfe7054979dfa16bc3b5fc591290ae7a701cbe2e57', '9e3b27b5b196885657d34bda8d10b41c', '8336'),
('94cba7e5-06d3-11ee-9639-04bf1b327336', 'bc9ed7fd4e032b6bd88e74e9153ab35fddb6499399564a0c7fdc7bb14f8a590f4634a863cc177733f3b871324b24aae18ff5529e1fd250a3001d2f0ebd069ca1', '167a03a3648707d645752a2f07dc7f1f', '10008'),
('472b5c53-06d4-11ee-9639-04bf1b327336', 'b4dd07fb2740bf6222a8db5dbfbcdefa1c985a76b16c7709bf079f699eb098edebf7ed8055a828ffc67ecac2d6c3ad8944baf94fdc3ba342a80d7f947b5be14c', 'c62c6f77e8364158656cf16e2a492909', '14959'),
('adfbf09e-06d8-11ee-9639-04bf1b327336', '18a0e42ecc52610c7f5b1efc9d428745fcb0557ba632f401d85bfb4b88344ca3dbe322875b3df71a5613a4e750f003c52c6fc6b2c135e83ea25adc85aee545ae', 'ae0e317862bb18c1697fffdbdfe8f207', '13693');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `guid` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`guid`, `email`) VALUES
('68807ee3-06cc-11ee-9639-04bf1b327336', 'test@test'),
('94cba7e5-06d3-11ee-9639-04bf1b327336', 'test@test2'),
('472b5c53-06d4-11ee-9639-04bf1b327336', 'test@test3'),
('adfbf09e-06d8-11ee-9639-04bf1b327336', 'test@test4');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
