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
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `genre` varchar(55) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `birthdate` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `role` varchar(50) NOT NULL DEFAULT 'user',
  `profile_pic` varchar(255) DEFAULT NULL,
  `is_premium` tinyint(1) DEFAULT '0',
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `genre`, `username`, `email`, `mdp`, `birthdate`, `active`, `role`, `profile_pic`, `is_premium`, `last_login`) VALUES
(9, 'Admin', 'Super', '', 'admin', 'admin@example.com', '$2y$10$W6FL/dPuOneI5i1ZT.BBp.sqGo2ujWS9.pg57RiyWnb80Lvopiu5W', '2000-01-01', 1, 'admin', NULL, 0, '2024-05-25 20:49:50'),
(32, 'zagliz', 'marwa', 'f', 'marwaz', 'zaglizmarwa@gmail.com', '$2y$10$ocM3H/BzjSJ5HwlAlEwTx.JLUhiHt30vStZPpXXbv0eWg9cOG9Th.', '2004-09-20', 1, 'user', 'default.png', 1, '2024-05-25 22:53:48'),
(33, 'kardallas', 'mariam', 'f', 'mariaam', 'mk@gmail.com', '$2y$10$JhQmFFj6HMFE2e9xaPjR.ek9WcQJoibt6QT//1I2Blo96Ejgl.o6W', '2024-05-17', 1, 'user', 'profile_33.png', 1, '2024-05-26 01:24:43');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
