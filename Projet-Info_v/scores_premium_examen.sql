-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : dim. 26 mai 2024 à 09:33
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
-- Structure de la table `scores_premium_examen`
--

CREATE TABLE `scores_premium_examen` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `points` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `scores_premium_examen`
--

INSERT INTO `scores_premium_examen` (`id`, `utilisateur_id`, `date`, `points`) VALUES
(11, 32, '2024-05-25 20:18:08', 3),
(12, 32, '2024-05-25 20:20:04', 4),
(13, 33, '2024-05-25 22:24:56', 3);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `scores_premium_examen`
--
ALTER TABLE `scores_premium_examen`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `scores_premium_examen`
--
ALTER TABLE `scores_premium_examen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;