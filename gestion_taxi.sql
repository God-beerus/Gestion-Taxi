-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 21 juin 2024 à 20:42
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_taxi`
--

-- --------------------------------------------------------

--
-- Structure de la table `chauffeurs`
--

CREATE TABLE `chauffeurs` (
  `id` int(11) NOT NULL,
  `Nom` varchar(255) NOT NULL,
  `Adresse` varchar(255) NOT NULL,
  `Téléphone` varchar(20) NOT NULL,
  `vehicule_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `chauffeurs`
--

INSERT INTO `chauffeurs` (`id`, `Nom`, `Adresse`, `Téléphone`, `vehicule_id`) VALUES
(2, 'Aris', 'Chaillot', '06565443', 1),
(3, 'Kani Malonga', 'Rue Bergère 305 Mpissa Bacongo', '05688546', 2);

-- --------------------------------------------------------

--
-- Structure de la table `depots`
--

CREATE TABLE `depots` (
  `id` int(11) NOT NULL,
  `chauffeur_id` int(11) NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `depots`
--

INSERT INTO `depots` (`id`, `chauffeur_id`, `montant`, `date`) VALUES
(1, 1, 15000.00, '2024-06-11'),
(2, 1, 34555.00, '2024-06-11'),
(4, 1, 288000.00, '2024-06-10'),
(5, 1, 1500033.00, '2024-06-10'),
(6, 1, 14000.00, '2024-06-10'),
(14, 2, 1000000.00, '2024-06-10'),
(18, 1, 10000.00, '2024-06-18'),
(19, 2, 10000.00, '2024-06-18'),
(20, 2, 1555555.00, '2024-06-18'),
(21, 3, 23023343.00, '2024-06-18');

-- --------------------------------------------------------

--
-- Structure de la table `maintenances`
--

CREATE TABLE `maintenances` (
  `id` int(11) NOT NULL,
  `vehicule_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `cout` decimal(10,2) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `email`, `mot_de_passe`) VALUES
(1, 'Aris', 'arielmalonga0@gmail.com', '$2y$10$7zG04HTR.nS7Ih0Yne1a8Otw/5YKSO9ZhF/.K0MLB0vZtx5/2LE5W');

-- --------------------------------------------------------

--
-- Structure de la table `vehicules`
--

CREATE TABLE `vehicules` (
  `id` int(11) NOT NULL,
  `marque` varchar(255) NOT NULL,
  `modele` varchar(255) NOT NULL,
  `plaque_immatriculation` varchar(255) NOT NULL,
  `date_achat` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `vehicules`
--

INSERT INTO `vehicules` (`id`, `marque`, `modele`, `plaque_immatriculation`, `date_achat`) VALUES
(1, 'Benoit 16', 'TOYOTA', '792 SL 4', '2024-02-06'),
(2, 'Benoit 16', 'TOYOTA', '791 SL 4', '2022-02-06'),
(3, 'Benoit 16', 'TOYOTA', '793 SL 4', '2022-02-02'),
(4, 'Benoit 16', 'TOYOTA', '176 NT 4', '2024-06-05');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `chauffeurs`
--
ALTER TABLE `chauffeurs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_vehicule_id` (`vehicule_id`);

--
-- Index pour la table `depots`
--
ALTER TABLE `depots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_chauffeur_id` (`chauffeur_id`);

--
-- Index pour la table `maintenances`
--
ALTER TABLE `maintenances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_vehicule_id` (`vehicule_id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `vehicules`
--
ALTER TABLE `vehicules`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `chauffeurs`
--
ALTER TABLE `chauffeurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `depots`
--
ALTER TABLE `depots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `maintenances`
--
ALTER TABLE `maintenances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `vehicules`
--
ALTER TABLE `vehicules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `chauffeurs`
--
ALTER TABLE `chauffeurs`
  ADD CONSTRAINT `fk_vehicule_id` FOREIGN KEY (`vehicule_id`) REFERENCES `vehicules` (`id`);

--
-- Contraintes pour la table `maintenances`
--
ALTER TABLE `maintenances`
  ADD CONSTRAINT `maintenances_ibfk_1` FOREIGN KEY (`vehicule_id`) REFERENCES `vehicules` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
