-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le :  Dim 10 fév. 2019 à 08:13
-- Version du serveur :  5.7.19
-- Version de PHP :  7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `espacemembre`
--

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `confirmation_token` varchar(60) DEFAULT NULL,
  `confirmed_at` datetime DEFAULT NULL,
  `reset_token` varchar(60) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `remember_token` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `confirmation_token`, `confirmed_at`, `reset_token`, `reset_at`, `remember_token`) VALUES
(1, 'Janklod', 'jeanyao@ymail.com', '$2y$10$f9RVdU5uHEqfAs94HMRMTubeKFu.2y7klKvekmY.4gS7rmV7S2me.', NULL, '2019-02-10 08:46:20', NULL, NULL, 'KL9ggh3PEFQnEqypJwYTuFztMp9IZTrQR5L3zABfCXyQbZVG9EUm7PT5YxPSmFiZLI0tHyyCa9rG5ZB285ify8xbGQNZMmXzPtwraOCXclDxeHMqaIWmBvC3ZrhSqpXri1rWQ1SiQRyrD42Dnc9km37uszpAsQrjcqgK0DYtCJvzkCj7bpGnCk7TMQuq0DuVVk1IrsFQyx9JxsUVvfmVIpiSEimsGVxovnnHURBwqnlZvemVmwQ3DXs9qc'),
(2, 'Michelle', 'michelle@ymail.com', '$2y$10$f9RVdU5uHEqfAs94HMRMTubeKFu.2y7klKvekmY.4gS7rmV7S2me.', NULL, '2019-02-10 09:09:10', NULL, NULL, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
