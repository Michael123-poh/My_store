-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 11 août 2025 à 15:09
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
-- Base de données : `m&ystore`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie_produit`
--

CREATE TABLE `categorie_produit` (
  `id_categorie` varchar(10) NOT NULL,
  `nomCategorie` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categorie_produit`
--

INSERT INTO `categorie_produit` (`id_categorie`, `nomCategorie`) VALUES
('CAT00001', 'ALIMENTATION'),
('CAT00002', 'Fourniture'),
('CAT00003', 'MENAGE'),
('CAT00004', 'CUISINE');

-- --------------------------------------------------------

--
-- Structure de la table `ciasse`
--

CREATE TABLE `ciasse` (
  `id_caisse` varchar(10) NOT NULL,
  `id_transaction` varchar(10) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `MontantT` int(100) NOT NULL,
  `date_create` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ciasse`
--

INSERT INTO `ciasse` (`id_caisse`, `id_transaction`, `type`, `MontantT`, `date_create`) VALUES
('CAI00001', 'TRS00010', 0, 12100, '2025-07-12 20:51:44'),
('CAI00002', 'TRS00009', 0, 5600, '2025-07-12 20:51:45'),
('CAI00003', 'TRS00003', 1, 433400, '2025-07-12 23:37:38'),
('CAI00004', 'TRS00001', 0, 45100, '2025-07-13 01:47:21'),
('CAI00005', 'TRS00011', 1, 30000, '2025-07-15 10:29:49'),
('CAI00006', 'TRS00012', 1, 165780, '2025-07-15 10:31:24'),
('CAI00007', 'TRS00015', 0, 350, '2025-07-16 05:07:20'),
('CAI00008', 'TRS00014', 1, 1430, '2025-07-21 05:09:48');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `idClient` varchar(10) NOT NULL,
  `nomComplet` varchar(100) NOT NULL,
  `adresse` varchar(100) NOT NULL,
  `solde_dette` int(100) NOT NULL DEFAULT 0,
  `telephone_client` varchar(20) NOT NULL,
  `credit_autorise` tinyint(1) NOT NULL DEFAULT 0,
  `Type_client` tinyint(1) NOT NULL DEFAULT 1,
  `date_create` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`idClient`, `nomComplet`, `adresse`, `solde_dette`, `telephone_client`, `credit_autorise`, `Type_client`, `date_create`) VALUES
('CLI00000', 'MAISON', 'Douala, Cameroun', 0, '657890023', 0, 1, '2025-07-08 18:06:51'),
('CLI00001', 'yves', 'Douala, Cameroun', 0, '657890023', 1, 1, '2025-07-08 14:40:53'),
('CLI00002', 'Noah', 'Edea, Cameroun', 100000, '657890023', 1, 1, '2025-07-08 14:40:53'),
('CLI00003', 'william yves', 'Bafoussam, Cameroun', 0, '578903212', 0, 1, '2025-07-15 06:48:03');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id_commande` varchar(10) NOT NULL,
  `id_produit` varchar(10) NOT NULL,
  `idClient` varchar(10) NOT NULL,
  `statut_paiement` int(10) NOT NULL,
  `date_create` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

CREATE TABLE `facture` (
  `id_facture` varchar(10) NOT NULL,
  `id_commande` varchar(10) NOT NULL,
  `montant_paye` int(100) NOT NULL,
  `date_paiement` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `fournisseur`
--

CREATE TABLE `fournisseur` (
  `id_fournisseur` varchar(10) NOT NULL,
  `nom_fournisseur` varchar(100) NOT NULL,
  `raison_sociale` varchar(100) NOT NULL,
  `telephone` varchar(150) NOT NULL,
  `adresse` varchar(100) NOT NULL,
  `date_create` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `fournisseur`
--

INSERT INTO `fournisseur` (`id_fournisseur`, `nom_fournisseur`, `raison_sociale`, `telephone`, `adresse`, `date_create`) VALUES
('FRN00000', 'MAISON', 'SARL', '', 'DOUALA', '2025-07-08 18:06:09'),
('FRN00001', 'Anaise', 'Sarl', '22kts', 'Douala, Akwa', '2025-06-29 08:19:45'),
('FRN00002', 'Fokou', 'SARL', '671567916', 'Douala, Cameroun', '2025-07-15 07:33:56');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id_produit` varchar(10) NOT NULL,
  `id_categorie` varchar(10) NOT NULL,
  `idUser` varchar(10) NOT NULL,
  `id_fournisseur` varchar(10) NOT NULL,
  `nomProduit` varchar(100) NOT NULL,
  `descriptions` text NOT NULL,
  `prix_vente` int(10) NOT NULL,
  `prix_Achat` int(10) NOT NULL,
  `quantiteProduit` int(100) NOT NULL,
  `seuile_minimum` int(10) NOT NULL,
  `date_create` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id_produit`, `id_categorie`, `idUser`, `id_fournisseur`, `nomProduit`, `descriptions`, `prix_vente`, `prix_Achat`, `quantiteProduit`, `seuile_minimum`, `date_create`) VALUES
('PRD00001', 'CAT00001', 'USR00001', 'FRN00001', 'bics', 'A base de cacao d\'origine ivorienne et de lait travaille en fraance', 900, 350, 2, 10, '2025-06-29 08:21:48'),
('PRD00002', 'CAT00004', 'USR00001', 'FRN00001', 'POELLE TEFALE ', 'Une poelle resistance et qui ne colle pas vos aliments', 5500, 5000, 75, 10, '2025-06-29 08:21:48'),
('PRD00003', 'CAT00004', 'USR00001', 'FRN00001', 'TASSE', 'Tasse de décoration avec motif ancien', 530, 200, 996, 10, '2025-06-29 08:21:48'),
('PRD00004', 'CAT00001', 'USR00001', 'FRN00001', 'Airpod', 'Ananas du Cameroun', 10000, 8000, 494, 10, '2025-06-29 08:21:48'),
('PRD00005', 'CAT00002', 'USR00001', 'FRN00001', 'CRAYON', 'Outil d\'aide a l\'apprentissage', 250, 75, 352, 10, '2025-07-01 10:10:05'),
('PRD00006', 'CAT00002', 'USR00001', 'FRN00001', 'chaussette', 'Otil d\'aide a l\'apprentissage', 400, 350, 6999, 20, '2025-07-01 10:11:27'),
('PRD00007', 'CAT00001', 'USR00001', 'FRN00001', 'POUDRE DE FECULE', 'go', 5000, 0, 134, 10, '2025-07-15 06:51:05');

-- --------------------------------------------------------

--
-- Structure de la table `transaction`
--

CREATE TABLE `transaction` (
  `id_transaction` varchar(10) NOT NULL,
  `id_fournisseur` varchar(10) NOT NULL DEFAULT 'FRN00000',
  `idClient` varchar(10) NOT NULL DEFAULT 'CLI00000',
  `id_type_transaction` varchar(10) NOT NULL,
  `status_transaction` int(10) NOT NULL,
  `date_reception` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `transaction`
--

INSERT INTO `transaction` (`id_transaction`, `id_fournisseur`, `idClient`, `id_type_transaction`, `status_transaction`, `date_reception`) VALUES
('TRS00001', 'FRN00001', 'CLI00000', 'TPT00001', 0, '2025-07-09 18:08:02'),
('TRS00002', 'FRN00001', 'CLI00000', 'TPT00001', 2, '2025-07-09 18:08:02'),
('TRS00003', 'FRN00000', 'CLI00001', 'TPT00002', 0, '2025-07-09 18:59:16'),
('TRS00004', 'FRN00000', 'CLI00002', 'TPT00002', 1, '2025-07-09 18:59:16'),
('TRS00005', 'FRN00001', 'CLI00000', 'TPT00001', 1, '2025-07-10 05:55:17'),
('TRS00006', 'FRN00001', 'CLI00000', 'TPT00001', 1, '2025-07-10 05:57:08'),
('TRS00007', 'FRN00001', 'CLI00000', 'TPT00001', 1, '2025-07-10 06:02:04'),
('TRS00009', 'FRN00001', 'CLI00000', 'TPT00001', 0, '2025-07-10 06:04:45'),
('TRS00010', 'FRN00001', 'CLI00000', 'TPT00001', 0, '2025-07-12 04:17:57'),
('TRS00011', 'FRN00000', 'CLI00003', 'TPT00002', 0, '2025-07-15 10:25:30'),
('TRS00012', 'FRN00000', 'CLI00003', 'TPT00002', 0, '2025-07-15 10:27:24'),
('TRS00013', 'FRN00000', 'CLI00003', 'TPT00002', 1, '2025-07-10 10:53:00'),
('TRS00014', 'FRN00000', 'CLI00000', 'TPT00002', 0, '2025-07-15 18:31:00'),
('TRS00015', 'FRN00001', 'CLI00000', 'TPT00001', 0, '2025-07-16 04:56:05'),
('TRS00016', 'FRN00002', 'CLI00000', 'TPT00001', 1, '2025-07-16 05:24:25');

-- --------------------------------------------------------

--
-- Structure de la table `transaction_produit`
--

CREATE TABLE `transaction_produit` (
  `id_transaction_produit` varchar(10) NOT NULL,
  `id_transaction` varchar(10) NOT NULL,
  `id_produit` varchar(10) NOT NULL,
  `quantite_attendue` int(10) NOT NULL,
  `quantite_recue` int(10) NOT NULL,
  `prix_unitaire` int(100) NOT NULL,
  `note_transaction` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `transaction_produit`
--

INSERT INTO `transaction_produit` (`id_transaction_produit`, `id_transaction`, `id_produit`, `quantite_attendue`, `quantite_recue`, `prix_unitaire`, `note_transaction`) VALUES
('TRP00001', 'TRS00001', 'PRD00001', 50, 50, 500, ''),
('TRP00002', 'TRS00001', 'PRD00002', 30, 30, 670, ''),
('TRP00003', 'TRS00002', 'PRD00001', 12, 12, 10000, ''),
('TRP00004', 'TRS00002', 'PRD00003', 29, 25, 3500, ''),
('TRP00005', 'TRS00003', 'PRD00004', 50, 60, 7000, ''),
('TRP00006', 'TRS00003', 'PRD00002', 20, 20, 670, ''),
('TRP00007', 'TRS00004', 'PRD00003', 40, 45, 3500, ''),
('TRP00008', 'TRS00004', 'PRD00004', 500, 500, 550, ''),
('TRP00009', 'TRS00007', 'PRD00002', 10, 10, 5000, ''),
('TRP00010', 'TRS00007', 'PRD00003', 100, 100, 200, ''),
('TRP00011', 'TRS00009', 'PRD00002', 1, 1, 5000, ''),
('TRP00012', 'TRS00009', 'PRD00003', 3, 3, 200, ''),
('TRP00013', 'TRS00010', 'PRD00001', 9, 8, 350, ''),
('TRP00014', 'TRS00010', 'PRD00003', 9, 9, 200, ''),
('TRP00015', 'TRS00010', 'PRD00005', 79, 100, 75, ''),
('TRP00016', 'TRS00011', 'PRD00004', 3, 3, 10000, ''),
('TRP00017', 'TRS00012', 'PRD00003', 5, 1, 530, ''),
('TRP00018', 'TRS00012', 'PRD00005', 5, 1, 250, ''),
('TRP00019', 'TRS00012', 'PRD00007', 33, 33, 5000, ''),
('TRP00020', 'TRS00013', 'PRD00002', 1, 1, 5500, ''),
('TRP00021', 'TRS00013', 'PRD00001', 1, 1, 900, ''),
('TRP00022', 'TRS00013', 'PRD00005', 1, 1, 250, ''),
('TRP00023', 'TRS00013', 'PRD00006', 1, 1, 400, ''),
('TRP00024', 'TRS00014', 'PRD00001', 2, 1, 900, ''),
('TRP00025', 'TRS00014', 'PRD00003', 3, 1, 530, ''),
('TRP00026', 'TRS00015', 'PRD00001', 1, 1, 350, ''),
('TRP00027', 'TRS00016', 'PRD00001', 1, 1, 350, '');

-- --------------------------------------------------------

--
-- Structure de la table `type_transaction`
--

CREATE TABLE `type_transaction` (
  `id_type_transaction` varchar(10) NOT NULL,
  `libelle_transaction` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `type_transaction`
--

INSERT INTO `type_transaction` (`id_type_transaction`, `libelle_transaction`) VALUES
('TPT00001', 'Entrée'),
('TPT00002', 'Sortie');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `idUser` varchar(10) NOT NULL,
  `idUserType` varchar(10) NOT NULL,
  `nomUser` varchar(100) NOT NULL,
  `passwordUser` varchar(50) NOT NULL,
  `date_creation` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`idUser`, `idUserType`, `nomUser`, `passwordUser`, `date_creation`) VALUES
('USR00001', 'UST00001', 'Mick', '12345', '2025-06-29 08:16:21');

-- --------------------------------------------------------

--
-- Structure de la table `user_type`
--

CREATE TABLE `user_type` (
  `idUserType` varchar(10) NOT NULL,
  `libelleUserType` varchar(50) NOT NULL,
  `date_create` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user_type`
--

INSERT INTO `user_type` (`idUserType`, `libelleUserType`, `date_create`) VALUES
('UST00001', 'gerant', '0000-00-00'),
('UST00002', 'gerante', '2025-07-02');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categorie_produit`
--
ALTER TABLE `categorie_produit`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Index pour la table `ciasse`
--
ALTER TABLE `ciasse`
  ADD PRIMARY KEY (`id_caisse`),
  ADD KEY `id_transaction` (`id_transaction`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`idClient`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id_commande`),
  ADD KEY `id_produit` (`id_produit`,`idClient`),
  ADD KEY `idClient` (`idClient`);

--
-- Index pour la table `facture`
--
ALTER TABLE `facture`
  ADD PRIMARY KEY (`id_facture`),
  ADD KEY `id_commande` (`id_commande`);

--
-- Index pour la table `fournisseur`
--
ALTER TABLE `fournisseur`
  ADD PRIMARY KEY (`id_fournisseur`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id_produit`),
  ADD KEY `id_categorie` (`id_categorie`,`idUser`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `id_fournisseur` (`id_fournisseur`);

--
-- Index pour la table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id_transaction`),
  ADD KEY `id_fournisseur` (`id_fournisseur`),
  ADD KEY `id_type_transaction` (`id_type_transaction`),
  ADD KEY `id_type_transaction_2` (`id_type_transaction`),
  ADD KEY `idClient` (`idClient`);

--
-- Index pour la table `transaction_produit`
--
ALTER TABLE `transaction_produit`
  ADD PRIMARY KEY (`id_transaction_produit`),
  ADD KEY `id_transaction` (`id_transaction`,`id_produit`),
  ADD KEY `id_produit` (`id_produit`);

--
-- Index pour la table `type_transaction`
--
ALTER TABLE `type_transaction`
  ADD PRIMARY KEY (`id_type_transaction`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`),
  ADD KEY `idUserType` (`idUserType`);

--
-- Index pour la table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`idUserType`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `ciasse`
--
ALTER TABLE `ciasse`
  ADD CONSTRAINT `ciasse_ibfk_2` FOREIGN KEY (`id_transaction`) REFERENCES `transaction` (`id_transaction`);

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`),
  ADD CONSTRAINT `commande_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id_produit`);

--
-- Contraintes pour la table `facture`
--
ALTER TABLE `facture`
  ADD CONSTRAINT `facture_ibfk_1` FOREIGN KEY (`id_commande`) REFERENCES `commande` (`id_commande`);

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `produit_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`),
  ADD CONSTRAINT `produit_ibfk_2` FOREIGN KEY (`id_categorie`) REFERENCES `categorie_produit` (`id_categorie`),
  ADD CONSTRAINT `produit_ibfk_3` FOREIGN KEY (`id_fournisseur`) REFERENCES `fournisseur` (`id_fournisseur`);

--
-- Contraintes pour la table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`id_fournisseur`) REFERENCES `fournisseur` (`id_fournisseur`),
  ADD CONSTRAINT `transaction_ibfk_3` FOREIGN KEY (`id_type_transaction`) REFERENCES `type_transaction` (`id_type_transaction`),
  ADD CONSTRAINT `transaction_ibfk_4` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`);

--
-- Contraintes pour la table `transaction_produit`
--
ALTER TABLE `transaction_produit`
  ADD CONSTRAINT `transaction_produit_ibfk_1` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id_produit`),
  ADD CONSTRAINT `transaction_produit_ibfk_2` FOREIGN KEY (`id_transaction`) REFERENCES `transaction` (`id_transaction`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`idUserType`) REFERENCES `user_type` (`idUserType`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
