-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : ven. 24 mai 2024 à 22:10
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
(9, 'Admin', 'Super', '', 'admin', 'admin@example.com', '$2y$10$W6FL/dPuOneI5i1ZT.BBp.sqGo2ujWS9.pg57RiyWnb80Lvopiu5W', '2000-01-01', 1, 'admin', NULL, 0, '2024-05-24 18:31:18'),
(25, 'kardallas', 'mariam', '', 'mk', 'mk@gmail.com', '$2y$10$zVZULHm.1nhbtWGLh4RjAOsA2xzioQeV5TBCvktdcmeGXOOGzs2Le', '2024-05-09', 1, 'user', NULL, 1, '2024-05-24 15:12:21'),
(26, 'zagliz', 'marwa', '', 'marwaz', 'zaglizmarwa@gmail.com', '$2y$10$vRDHCvjU.LBbr42jhP99meVMt9tbcGCV62xrAzXD8D5qRvJVp6r0K', '2024-05-14', 1, 'user', 'profile_26.png', 1, '2024-05-24 21:34:31'),
(29, 'elomri', 'hafsa', 'f', 'hafsaaa', 'hafsal@gmail.com', '$2y$10$wT1qdgmuNdBWX9ERqHr2mOWhP2h4JRxRaY9lb.P.kVHy1Y/E9weVu', '2024-05-22', 1, 'user', 'profile_29.jpeg', 0, '2024-05-24 18:27:47');

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
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
