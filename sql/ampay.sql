-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 07 oct. 2025 à 00:59
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ampay`
--

-- --------------------------------------------------------

--
-- Structure de la table `listings`
--

CREATE TABLE `listings` (
  `id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `ratings` decimal(3,1) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `currency` varchar(5) NOT NULL,
  `country` varchar(10) NOT NULL,
  `city` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `listings`
--

INSERT INTO `listings` (`id`, `created_at`, `user_id`, `type`, `ratings`, `amount`, `currency`, `country`, `city`, `status`) VALUES
(1, '2025-10-03 23:03:45', 3, 'Offre', 4.0, 4000000.00, 'XOF', 'Bénin', 'Cotonou', 'Actif'),
(2, '2025-10-02 23:03:45', 3, 'Offre', 4.0, 100000.00, 'XOF', 'Bénin', 'Cotonou', 'Actif'),
(3, '2025-10-02 23:03:45', 3, 'Demande', 4.0, 2000000.00, 'XOF', 'Bénin', 'Cotonou', 'Actif');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `created at` datetime NOT NULL DEFAULT current_timestamp(),
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `created at`, `transaction_id`, `user_id`, `message`, `status`) VALUES
(1, '2025-10-04 01:26:06', 1, 4, 'je suis interessé svp', 'envoy'),
(2, '2025-10-04 01:26:42', 3, 4, 'je veux', 'envoy'),
(3, '2025-10-04 01:26:06', 1, 5, 'inbox svp', 'envoy');

-- --------------------------------------------------------

--
-- Structure de la table `sponsorships`
--

CREATE TABLE `sponsorships` (
  `id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `sponsor_id` int(11) NOT NULL,
  `sponsored_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `sponsorships`
--

INSERT INTO `sponsorships` (`id`, `created_at`, `sponsor_id`, `sponsored_id`) VALUES
(1, '2025-10-04 10:11:09', 3, 4);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `ratings` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL,
  `ref_link` varchar(100) DEFAULT NULL,
  `role` varchar(20) NOT NULL,
  `phone_prefix` varchar(10) NOT NULL,
  `account_verified` varchar(10) NOT NULL,
  `country` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `created_at`, `first_name`, `last_name`, `phone`, `email`, `username`, `password`, `ratings`, `status`, `ref_link`, `role`, `phone_prefix`, `account_verified`, `country`, `city`) VALUES
(1, '0000-00-00 00:00:00', 'admin', 'admin', '0196228863', 'admin@ampay.com', 'admin', '$2a$12$ad6HzfdVzAgUYUgNeRWVXO2lFHo4tUEE7wStEm5gABj59dNb6QGbu', '4', 'Actif', NULL, 'admin', '', '', '', ''),
(3, '2025-10-03 23:01:30', 'rachad', 'adekambi', '0196228860', 'rach@ampay.com', 'rachad', '$2a$12$ad6HzfdVzAgUYUgNeRWVXO2lFHo4tUEE7wStEm5gABj59dNb6QGbu', '4', 'Actif', NULL, 'user', '', '', '', ''),
(4, '2025-10-03 23:01:30', 'ray', 'liota', '0196228860', 'ray@ampay.com', 'rachad', '$2a$12$ad6HzfdVzAgUYUgNeRWVXO2lFHo4tUEE7wStEm5gABj59dNb6QGbu', '4', 'Actif', NULL, 'user', '', '', '', ''),
(5, '2025-10-03 23:01:30', 'hohn', 'way', '0155228860', 'john@ampay.com', 'john', '$2a$12$ad6HzfdVzAgUYUgNeRWVXO2lFHo4tUEE7wStEm5gABj59dNb6QGbu', '4', 'Actif', NULL, 'user', '', '', '', ''),
(6, '2025-10-05 15:10:40', 'john', 'wayne', '54788544', 'test@tes.fr', '', '$2y$10$hWLfa1v3nr/nyxLIdhSmK.r00v.egtyQEQK4tSbyuwy4N4p9n08zO', '', '', NULL, 'user', '+355', 'no', 'AL', 'yhgfo'),
(7, '2025-10-05 15:24:27', 'yjhi', 'ijioj', '6775675', 'test@twtt.fr', '', '$2y$10$rZb42T6e/JoHAMFq7MneuuKtgFp/5Gtf3FId3N236xVhmJ/ywqDHy', '', '', NULL, 'user', '+229', 'n', 'BJ', 'uruu');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `listings`
--
ALTER TABLE `listings`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sponsorships`
--
ALTER TABLE `sponsorships`
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
-- AUTO_INCREMENT pour la table `listings`
--
ALTER TABLE `listings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `sponsorships`
--
ALTER TABLE `sponsorships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
