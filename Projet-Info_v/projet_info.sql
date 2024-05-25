-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : sam. 25 mai 2024 à 23:20
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
-- Structure de la table `formulaire_contact`
--

CREATE TABLE `formulaire_contact` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `objet` varchar(100) NOT NULL,
  `msg` text NOT NULL,
  `date_enregistrement` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `formulaire_contact`
--

INSERT INTO `formulaire_contact` (`id`, `nom`, `prenom`, `telephone`, `email`, `objet`, `msg`, `date_enregistrement`) VALUES
(1, 'zagliz', 'marwa', '0769206225', 'zaglizmarwa@gmail.com', 'rdv code', 'je souhaite passer le code ', '2024-05-14 18:15:11'),
(2, 'zagliz', 'marwa', '0769206225', 'zaglizmarwa@gmail.com', 'rdv', 'je souhaite modifier ma date', '2024-05-25 20:54:26'),
(3, 'zagliz', 'marwa', '0769206225', 'zaglizmarwa@gmail.com', 'rdv', 'je souhaite un rdv', '2024-05-25 21:05:54'),
(4, 'zagliz', 'marwa', '0769206225', 'zaglizmarwa@gmail.com', 'rdv', 'je souhaite un rdv', '2024-05-25 21:08:03'),
(5, 'zagliz', 'marwa', '0769206225', 'zaglizmarwa@gmail.com', 'rdv', 'rdv', '2024-05-25 21:08:32'),
(6, 'zagliz', 'marwa', '0769206225', 'zaglizmarwa@gmail.com', 'rdv', 'rdv', '2024-05-25 21:11:24'),
(7, 'zagliz', 'marwa', '0769206225', 'zaglizmarwa@gmail.com', 'rdv', 'rdv', '2024-05-25 21:11:43'),
(8, 'zagliz', 'marwa', '0769206225', 'zaglizmarwa@gmail.com', 'rdv', 'rdv', '2024-05-25 21:14:58'),
(9, 'zagliz', 'marwa', '0769206225', 'zaglizmarwa@gmail.com', 'rdv', 'rdv', '2024-05-25 21:15:00'),
(10, 'zagliz', 'marwa', '0769206225', 'zaglizmarwa@gmail.com', 'rdv', 'rdv', '2024-05-25 21:15:01'),
(11, 'zagliz', 'marwa', '0769206225', 'zaglizmarwa@gmail.com', 'rdv', 'rdv', '2024-05-25 21:15:01'),
(12, 'zagliz', 'marwa', '0769206225', 'zaglizmarwa@gmail.com', 'rdv', 'rdv', '2024-05-25 21:15:01'),
(13, 'zagliz', 'marwa', '0769206225', 'zaglizmarwa@gmail.com', 'rdv', 'rdv', '2024-05-25 21:15:01');

-- --------------------------------------------------------

--
-- Structure de la table `forum_posts`
--

CREATE TABLE `forum_posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `forum_posts`
--

INSERT INTO `forum_posts` (`id`, `user_id`, `content`, `created_at`) VALUES
(14, 32, 'salut je veux avoir mon code !!!!', '2024-05-25 15:33:49'),
(15, 33, 'moi aussi', '2024-05-25 22:21:56');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(14, 33, '2024-05-25 22:37:37', 5);

-- --------------------------------------------------------

--
-- Structure de la table `scores_examen`
--

CREATE TABLE `scores_examen` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `points` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `scores_examen`
--

INSERT INTO `scores_examen` (`id`, `utilisateur_id`, `date`, `points`) VALUES
(9, 32, '2024-05-25 20:02:43', 6);

-- --------------------------------------------------------

--
-- Structure de la table `scores_premium`
--

CREATE TABLE `scores_premium` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `points` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(33, 'kardallas', 'mariam', 'f', 'mariaam', 'mk@gmail.com', '$2y$10$JhQmFFj6HMFE2e9xaPjR.ek9WcQJoibt6QT//1I2Blo96Ejgl.o6W', '2024-05-17', 1, 'user', 'profile_33.png', 1, '2024-05-26 00:47:23');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `formulaire_contact`
--
ALTER TABLE `formulaire_contact`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `forum_posts`
--
ALTER TABLE `forum_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `scores_examen`
--
ALTER TABLE `scores_examen`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `scores_premium`
--
ALTER TABLE `scores_premium`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `scores_premium_examen`
--
ALTER TABLE `scores_premium_examen`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `formulaire_contact`
--
ALTER TABLE `formulaire_contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `forum_posts`
--
ALTER TABLE `forum_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `scores`
--
ALTER TABLE `scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `scores_examen`
--
ALTER TABLE `scores_examen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `scores_premium`
--
ALTER TABLE `scores_premium`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `scores_premium_examen`
--
ALTER TABLE `scores_premium_examen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `forum_posts`
--
ALTER TABLE `forum_posts`
  ADD CONSTRAINT `forum_posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
