-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 19 jan. 2024 à 23:21
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `cabinet`
--

-- --------------------------------------------------------

--
-- Structure de la table `médecin`
--

CREATE TABLE `médecin` (
  `Id_Médecin` int(11) NOT NULL,
  `Civilité` varchar(50) NOT NULL,
  `Nom` varchar(50) NOT NULL,
  `Prénom` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `médecin`
--

INSERT INTO `médecin` (`Id_Médecin`, `Civilité`, `Nom`, `Prénom`) VALUES
(0, 'M', 'Dupont', 'Jean'),
(5, 'MME', 'Annie', 'Frite'),
(10, 'MME', 'Jeanne', 'Jean');

-- --------------------------------------------------------

--
-- Structure de la table `rdv`
--

CREATE TABLE `rdv` (
  `Id_RDV` int(11) NOT NULL,
  `Dates` date NOT NULL,
  `Heure` time NOT NULL,
  `Durée` int(11) NOT NULL,
  `Id_Médecin` int(11) NOT NULL,
  `Id_Usager` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `rdv`
--

INSERT INTO `rdv` (`Id_RDV`, `Dates`, `Heure`, `Durée`, `Id_Médecin`, `Id_Usager`) VALUES
(0, '0542-07-08', '17:36:00', 85, 5, 2),
(1, '3120-08-09', '12:20:00', 984651320, 5, 8),
(2, '2025-01-08', '12:59:00', 10, 5, 2),
(3, '2024-01-20', '10:59:00', 40, 5, 5),
(4, '2024-01-28', '10:09:00', 49, 0, 0),
(5, '2024-01-26', '15:50:00', 50, 10, 6);

-- --------------------------------------------------------

--
-- Structure de la table `usager`
--

CREATE TABLE `usager` (
  `Id_Usager` int(11) NOT NULL,
  `Civilité` varchar(50) NOT NULL,
  `Nom` varchar(50) NOT NULL,
  `Prenom` varchar(60) NOT NULL,
  `Adresse_complète` varchar(200) NOT NULL,
  `Lieu_de_naissance` varchar(200) NOT NULL,
  `Date_de_naissance` date NOT NULL,
  `Num_Sécu` decimal(15,0) NOT NULL,
  `Id_Médecin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `usager`
--

INSERT INTO `usager` (`Id_Usager`, `Civilité`, `Nom`, `Prenom`, `Adresse_complète`, `Lieu_de_naissance`, `Date_de_naissance`, `Num_Sécu`, `Id_Médecin`) VALUES
(0, 'Homme', 'Doe', 'gyhugvub', 'ftgyhu', 'uhij dtryugi tytuv', '0052-04-02', 789465151388887, 5),
(2, 'Homme', 'Doe', 'eoD', 'EZpxhosro sotugh sepZE', '489 E4F8R4 G846H4E 6T6H864 ET864H8ETHERFV', '6581-04-08', 899879865132123, 0),
(3, 'Femme', 'Coucou', 'Bzgoierpig', 'Uoghe OIEF ijzfe', 'IEO ieg hzieh oiEHZf', '6532-07-08', 878879787964853, 0),
(4, 'Femme', 'ftgy', 'tgyhu', 'tygu', 'gyhu', '0965-08-28', 984698656894986, 0),
(5, 'Femme', 'Anne', 'Mouri', 'Toulouse', 'pas à toulouse', '1991-03-12', 111111115858585, 0),
(6, 'Femme', 'd', 'd', 'd', 'd', '0005-05-05', 888787878788787, 0),
(8, 'Homme', 'YGHJok', 'IGYUOijp', 'yhuo', 'gyiuoji', '2012-08-08', 465124754247477, 5),
(10, 'Femme', 'YIUOJpkjihugy', 'VVUBiouyg', 'FITGUhgytf', 'TYIGIhgytf', '0455-07-08', 796485146874657, 10),
(12, 'Homme', 'IOUE', 'IUAopiufh ', 'IUHiousdf ouihsdofiu h', 'oihOU UIIUOUGoygouyg iui', '0845-07-08', 878465314876548, 10),
(13, 'Homme', 'bhijnokibn', 'gjbhknl', 'yiujo,p', 'uvbijno,kp', '0855-08-07', 745457557858754, 5),
(14, 'Homme', 'bhijnokibnjki', 'jiojiuh', 'uhijhuij', 'uhijuhjik', '4848-05-04', 845148751487547, 5),
(15, 'Homme', 'YGIhoji', 'ygiuoij', 'uygihuoji', 'ugyihoj', '0465-08-09', 849884994894657, 0),
(16, 'Homme', 'biuopk', 'iuop', 'hbijnk', 'uyio', '0054-04-19', 465864658964984, 10),
(18, 'Homme', 'biuopk', 'iuop', 'hbijnk', 'uyio', '0054-04-19', 465864658964979, 0),
(21, 'Homme', 'Oi,p', 'binojk,', 'obinjo,', 'yvubyi', '0007-07-07', 878878787787878, 5),
(22, 'Homme', 'Oi,p', 'binojk,', 'obinjo,', 'yvubyi', '9999-12-31', 846846846848564, 5);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`username`, `password`) VALUES
('caca', '$2y$10$bp1LyMLA.3cZ/DOwSMeeSOxBmk66pg8jw6910aRQPt/ibO7IdVhD6'),
('test', '$2y$10$1BUOB2zx3rFcfEsn0NPd0ebODDVHYOjkktZgtt9nTBwe7.EODx6kG');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `médecin`
--
ALTER TABLE `médecin`
  ADD PRIMARY KEY (`Id_Médecin`);

--
-- Index pour la table `rdv`
--
ALTER TABLE `rdv`
  ADD PRIMARY KEY (`Id_RDV`),
  ADD KEY `Id_Médecin` (`Id_Médecin`),
  ADD KEY `Id_Usager` (`Id_Usager`);

--
-- Index pour la table `usager`
--
ALTER TABLE `usager`
  ADD PRIMARY KEY (`Id_Usager`),
  ADD UNIQUE KEY `Num_Sécu` (`Num_Sécu`),
  ADD KEY `Id_Médecin` (`Id_Médecin`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`username`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `rdv`
--
ALTER TABLE `rdv`
  ADD CONSTRAINT `rdv_ibfk_1` FOREIGN KEY (`Id_Médecin`) REFERENCES `médecin` (`Id_Médecin`),
  ADD CONSTRAINT `rdv_ibfk_2` FOREIGN KEY (`Id_Usager`) REFERENCES `usager` (`Id_Usager`);

--
-- Contraintes pour la table `usager`
--
ALTER TABLE `usager`
  ADD CONSTRAINT `usager_ibfk_1` FOREIGN KEY (`Id_Médecin`) REFERENCES `médecin` (`Id_Médecin`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
