-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : dim. 26 mai 2024 à 09:32
-- Version du serveur : 5.7.39
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet_info`
--

-- --------------------------------------------------------

--
-- Structure de la table `scores`
--

CREATE TABLE `scores` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `points` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `scores`
--

INSERT INTO `scores` (`id`, `utilisateur_id`, `date`, `points`) VALUES
(1, 26, '2024-05-24 13:23:27', 10),
(2, 26, '2024-05-24 16:58:35', 10),
(3, 26, '2024-05-24 17:02:57', 4),
(4, 26, '2024-05-24 17:14:22', 4),
(5, 26, '2024-05-24 18:36:40', 4),
(6, 26, '2024-05-24 18:40:26', 14),
(7, 26, '2024-05-24 21:11:30', 8),
(8, 26, '2024-05-25 12:18:54', 2),
(9, 31, '2024-05-25 12:35:58', 9),
(10, 32, '2024-05-25 13:43:02', 11),
(11, 32, '2024-05-25 14:30:24', 5),
(12, 33, '2024-05-25 22:22:21', 4),
(13, 33, '2024-05-25 22:27:04', 4),
(14, 33, '2024-05-25 22:37:37', 5),
(15, 33, '2024-05-25 23:25:11', 6);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `scores`
--
ALTER TABLE `scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
