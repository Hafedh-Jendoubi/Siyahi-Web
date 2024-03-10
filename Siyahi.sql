-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2024 at 08:09 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siyahi`
--

-- --------------------------------------------------------

--
-- Table structure for table `achat`
--

CREATE TABLE `achat` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `achat`
--

INSERT INTO `achat` (`id`, `image`, `type`, `description`) VALUES
(1, 'badb51a1c6b4c7accfa6c5cfcb797c02.png', 'Voiture', 'Test'),
(2, 'd21b4a5cb4dae124a8b157cf4ef9e9e5.png', 'Appartement', 'Test'),
(3, '38a12267be653ccdb218c4f8eb4bf69e.png', 'Terrain', 'Voila'),
(4, '7db3ae270b5020dd190b07632fb7a25c.png', 'Voiture', 'Olaa');

-- --------------------------------------------------------

--
-- Table structure for table `calendar`
--

CREATE TABLE `calendar` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `description` varchar(255) NOT NULL,
  `all_day` tinyint(1) NOT NULL,
  `background_color` varchar(255) NOT NULL,
  `border_color` varchar(255) NOT NULL,
  `text_color` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `commande`
--

CREATE TABLE `commande` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `object` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `compte_client`
--

CREATE TABLE `compte_client` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rib` bigint(20) NOT NULL,
  `created_at` date NOT NULL,
  `solde` double NOT NULL,
  `service_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `compte_client`
--

INSERT INTO `compte_client` (`id`, `user_id`, `rib`, `created_at`, `solde`, `service_id`) VALUES
(1, 13, 1234567891011210, '2024-03-06', 1000000, 1),
(2, 14, 1245124536254156, '2024-03-06', 150, 3);

-- --------------------------------------------------------

--
-- Table structure for table `conge`
--

CREATE TABLE `conge` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `justification` varchar(255) DEFAULT NULL,
  `date_demande` date NOT NULL,
  `type_conge` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `conge`
--

INSERT INTO `conge` (`id`, `user_id`, `description`, `date_debut`, `date_fin`, `justification`, `date_demande`, `type_conge`, `status`) VALUES
(1, 11, 'Demande de congé 3jrs', '2024-03-07', '2024-03-10', '65e8b14df12b2.png', '2024-03-06', 'Maladie', 0),
(3, 11, 'Demande 2jrs', '2024-03-20', '2024-03-22', NULL, '2024-03-06', 'Mariage', 1),
(4, 11, 'Demande 5 jours', '2024-04-10', '2024-04-15', NULL, '2024-03-06', 'Vacance', 0),
(5, 13, 'Congé 2 jours.', '2024-03-07', '2024-03-09', '65e8b562a0f78.png', '2024-03-06', 'Maladie', 0);

-- --------------------------------------------------------

--
-- Table structure for table `credit`
--

CREATE TABLE `credit` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `solde_demande` double NOT NULL,
  `date_debut_paiement` date NOT NULL,
  `nbr_mois_paiement` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `contrat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `credit`
--

INSERT INTO `credit` (`id`, `user_id`, `solde_demande`, `date_debut_paiement`, `nbr_mois_paiement`, `description`, `contrat`) VALUES
(1, 5, 500000, '2024-03-30', 36, 'Je veux avoir une maison.', '65e8a517bd090.png'),
(2, 5, 100000, '2024-04-25', 24, 'Je veux avoir une voiture.', '65e8a571d6d6b.jpg'),
(3, 5, 5000, '2024-03-30', 36, 'Je veux continuer mes études.', '65e8a5a9be6ac.jpg'),
(4, 5, 3000, '2025-09-15', 6, 'Je veux avoir une moto.', '65e8a7267de0d.jpg'),
(5, 5, 1500000, '2027-10-15', 120, 'Je veux invester dans un projet.', '65e8a7978d2f9.png'),
(7, 7, 5000, '2025-03-06', 6, 'Je veux avoir une moto.', '65e8bbb04b6e8.png');

-- --------------------------------------------------------

--
-- Table structure for table `demande_achat`
--

CREATE TABLE `demande_achat` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `achat_id` int(11) DEFAULT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `date_demande` date NOT NULL,
  `num_tel` varchar(255) NOT NULL,
  `type_paiement` varchar(255) NOT NULL,
  `cin` int(11) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `etatdemande` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `demande_achat`
--

INSERT INTO `demande_achat` (`id`, `user_id`, `achat_id`, `nom`, `prenom`, `date_demande`, `num_tel`, `type_paiement`, `cin`, `adresse`, `etatdemande`) VALUES
(2, 2, 1, 'Ahlem', 'Mhamdi', '2024-03-06', '25603680', 'Virement Bancaire', 14515936, 'Appartement n°16 Bloc B Résidence nessrine 1, Ariana Essoughra, Raoued, Ariana', 'demande accepter'),
(3, 2, 3, 'wvkn', 'kvbdk', '2024-03-01', '54152934', 'Cheque', 541885, 'Carthage, Tunis', 'demande refu');

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20240306163401', '2024-03-06 17:34:05', 634),
('DoctrineMigrations\\Version20240306164723', '2024-03-06 17:47:29', 82);

-- --------------------------------------------------------

--
-- Table structure for table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reclamation`
--

CREATE TABLE `reclamation` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `object` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date_creation` date NOT NULL,
  `auteur` varchar(255) NOT NULL,
  `status` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reclamation`
--

INSERT INTO `reclamation` (`id`, `user_id`, `object`, `description`, `date_creation`, `auteur`, `status`, `email`) VALUES
(1, NULL, 'Sécurité', 'Mon solde a été déduit.', '2024-03-06', 'Ahlem Mhamdi', 'repondue', 'ahlem.mhamdi@siyahi.tn'),
(3, NULL, 'Probleme', 'REZrze', '2024-03-06', '3123', 'Non traitée', 'hafedh@siyahi.tn'),
(4, NULL, 'REzrz', 'rezr', '2024-03-06', '531', 'Non traitée', 'jafe@siyahi.tn');

-- --------------------------------------------------------

--
-- Table structure for table `reponse_conge`
--

CREATE TABLE `reponse_conge` (
  `id` int(11) NOT NULL,
  `conge_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reponse_conge`
--

INSERT INTO `reponse_conge` (`id`, `conge_id`, `user_id`, `date_debut`, `date_fin`, `description`) VALUES
(2, 1, 2, '2024-03-07', '2024-03-10', 'Congé de Hamroun bien accepté.'),
(3, 5, 2, '2024-03-07', '2024-03-09', 'Accepté.');

-- --------------------------------------------------------

--
-- Table structure for table `reponse_credit`
--

CREATE TABLE `reponse_credit` (
  `id` int(11) NOT NULL,
  `credit_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `solde_a_payer` double NOT NULL,
  `date_debut_paiement` date NOT NULL,
  `nbr_mois_paiement` int(11) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reponse_credit`
--

INSERT INTO `reponse_credit` (`id`, `credit_id`, `user_id`, `solde_a_payer`, `date_debut_paiement`, `nbr_mois_paiement`, `description`) VALUES
(1, 1, 2, 700000, '2024-03-30', 36, 'J\'ai bien accepté.');

-- --------------------------------------------------------

--
-- Table structure for table `reponse_reclamation`
--

CREATE TABLE `reponse_reclamation` (
  `id` int(11) NOT NULL,
  `reclamation_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `date_creation` date NOT NULL,
  `auteur` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reponse_reclamation`
--

INSERT INTO `reponse_reclamation` (`id`, `reclamation_id`, `user_id`, `description`, `date_creation`, `auteur`) VALUES
(1, 1, NULL, 'On va voir ce problem.', '2019-01-01', 'Iheb');

-- --------------------------------------------------------

--
-- Table structure for table `reset_password_request`
--

CREATE TABLE `reset_password_request` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `selector` varchar(20) NOT NULL,
  `hashed_token` varchar(100) NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`id`, `name`, `description`) VALUES
(1, 'Business', 'C\'est un service dédié pour les Hommes d\'affaires.'),
(3, 'Courant', 'Ce service est utilisé pour les opérations quotidiennes.'),
(4, 'Epargne', 'Ce service est utilisé pour stocker les argents.');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL,
  `first_name` varchar(15) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `gender` varchar(1) NOT NULL,
  `address` varchar(50) DEFAULT NULL,
  `phone_number` int(11) DEFAULT NULL,
  `cin` int(11) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `image` varchar(255) DEFAULT NULL,
  `old_email` varchar(255) NOT NULL,
  `activity` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `first_name`, `last_name`, `gender`, `address`, `phone_number`, `cin`, `created_at`, `image`, `old_email`, `activity`) VALUES
(2, 'hafedh.jendoubi@siyahi.tn', '[\"ROLE_SUPER_ADMIN\"]', '$2y$13$gWIDoxmPVr9yJ8FJ2VwItOH6NM.gQVaikCyghSaiAciBB4iGk4KvK', 'Jendoubi', 'Hafedh', 'M', 'Manouba', 95052214, 14515936, '2024-02-17 14:14:45', '6444f15a62df6a0e9096d999b2d060e4.jpg', 'hafedh.jendoubi@esprit.tn', 'T'),
(5, 'ahlem.mhamdi@siyahi.tn', '[\"ROLE_USER\"]', '$2y$13$4SzSARk5Vg37iNf5ROgbQ.mKrjQcUFecXVLNtcTw/LqeQOoHjrFUG', 'Ahlem', 'Jendoubi', 'F', 'Mourouj, Tunisia', 53404903, 14221216, '2024-02-18 18:39:55', '78f1ff3123bff099a0bdd8a709ecd775.jpg', 'ahlem.mhamdi@esprit.tn', 'T'),
(7, 'Majdi.Jendoubi@siyahi.tn', '[\"ROLE_USER\"]', '$2y$13$M.6wLjPwI16MqITj4va/WuOIbO6akhG064oaocxFDKaBseMBg4jGq', 'Jendoubi', 'Majdi', 'M', 'Jdeida, Manouba', 52114132, 14223441, '2024-02-19 15:43:50', '10be5ddf9143c8a08c6027e40e7731ea.jpg', 'majdi.jendoubi@esprit.tn', 'T'),
(11, 'ben hamroun.yessine@siyahi.tn', '[\"ROLE_STAFF\"]', '$2y$13$oXLYs/7P91qbVPLUt4.poeq65VdJVBVSBgXfNOQj88Cs4L/L8mjCy', 'Ben Hamroun', 'Yessine', 'M', 'Hay Sahafa, Ariana Essoghra', 50443421, 14333200, '2024-02-21 14:46:23', '093495839684c297c6650a1d1ecf8df4.jpg', 'yessine.benhamroun@esprit.tn', 'T'),
(13, 'skander.kacem@siyahi.tn', '[\"ROLE_STAFF\"]', '$2y$13$oKuF9f.yAPTWEBb8yyez2uYchWYgg1JfqW5tAaTJpHcvuPy6DdeTO', 'Kacem', 'Skander', 'M', 'Hay Sahafa, Ariana Essoghra', 96505443, 14033213, '2024-02-21 16:05:14', 'c5457df5e577597371bb9115fe6bb3a1.jpg', 'skander.kacem@esprit.tn', 'T'),
(14, 'bettaieb.ahmed@siyahi.tn', '[\"ROLE_SUPER_ADMIN\"]', '$2y$13$IL3V1bEUQcesDnInhHqoren2lk0.c/kZbZ8eM3noKVOXoWFkAWn3S', 'Bettaieb', 'Ahmed', 'M', 'Hay Sahafa, Ariana Essoghra', 97205143, 14033214, '2024-02-21 16:05:51', '111befb12ff4e12ee0cf226de92706d8.jpg', 'ahmed.bettaieb@esprit.tn', 'T'),
(15, 'iheb.amri@siyahi.tn', '[\"ROLE_ADMIN\"]', '$2y$13$nvrbBVdZLtl60SrEa.Xd7ODTRQumEm8ZXyyX0ErwGa0Yeptck9rO.', 'Iheb', 'Amri', 'M', 'Sidi Bouzid, Tunis', 24339403, 14330030, '2024-02-21 19:38:46', '144a7e6cf05bfa83cb674cd50b0c9d64.jpg', 'iheb.amri@esprit.tn', 'T');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `achat`
--
ALTER TABLE `achat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `calendar`
--
ALTER TABLE `calendar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6EEAA67DA76ED395` (`user_id`);

--
-- Indexes for table `compte_client`
--
ALTER TABLE `compte_client`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_1DDD5D62BFB7B5B6` (`rib`),
  ADD KEY `IDX_1DDD5D62A76ED395` (`user_id`),
  ADD KEY `IDX_1DDD5D62ED5CA9E6` (`service_id`);

--
-- Indexes for table `conge`
--
ALTER TABLE `conge`
  ADD PRIMARY KEY (`id`),
  ADD KEY `UNIQ_2ED89348A76ED395` (`user_id`) USING BTREE;

--
-- Indexes for table `credit`
--
ALTER TABLE `credit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_1CC16EFEA76ED395` (`user_id`);

--
-- Indexes for table `demande_achat`
--
ALTER TABLE `demande_achat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D077077FA76ED395` (`user_id`),
  ADD KEY `IDX_D077077FFE95D117` (`achat_id`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Indexes for table `reclamation`
--
ALTER TABLE `reclamation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_CE606404A76ED395` (`user_id`);

--
-- Indexes for table `reponse_conge`
--
ALTER TABLE `reponse_conge`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C131E82BCAAC9A59` (`conge_id`),
  ADD KEY `IDX_C131E82BA76ED395` (`user_id`);

--
-- Indexes for table `reponse_credit`
--
ALTER TABLE `reponse_credit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C895B767CE062FF9` (`credit_id`),
  ADD KEY `IDX_C895B767A76ED395` (`user_id`);

--
-- Indexes for table `reponse_reclamation`
--
ALTER TABLE `reponse_reclamation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C7CB51012D6BA2D9` (`reclamation_id`),
  ADD KEY `IDX_C7CB5101A76ED395` (`user_id`);

--
-- Indexes for table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7CE748AA76ED395` (`user_id`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `achat`
--
ALTER TABLE `achat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `calendar`
--
ALTER TABLE `calendar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `commande`
--
ALTER TABLE `commande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `compte_client`
--
ALTER TABLE `compte_client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `conge`
--
ALTER TABLE `conge`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `credit`
--
ALTER TABLE `credit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `demande_achat`
--
ALTER TABLE `demande_achat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reclamation`
--
ALTER TABLE `reclamation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reponse_conge`
--
ALTER TABLE `reponse_conge`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reponse_credit`
--
ALTER TABLE `reponse_credit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reponse_reclamation`
--
ALTER TABLE `reponse_reclamation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `FK_6EEAA67DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `compte_client`
--
ALTER TABLE `compte_client`
  ADD CONSTRAINT `FK_1DDD5D62A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_1DDD5D62ED5CA9E6` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`);

--
-- Constraints for table `conge`
--
ALTER TABLE `conge`
  ADD CONSTRAINT `FK_2ED89348A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `credit`
--
ALTER TABLE `credit`
  ADD CONSTRAINT `FK_1CC16EFEA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `demande_achat`
--
ALTER TABLE `demande_achat`
  ADD CONSTRAINT `FK_D077077FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_D077077FFE95D117` FOREIGN KEY (`achat_id`) REFERENCES `achat` (`id`);

--
-- Constraints for table `reclamation`
--
ALTER TABLE `reclamation`
  ADD CONSTRAINT `FK_CE606404A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `reponse_conge`
--
ALTER TABLE `reponse_conge`
  ADD CONSTRAINT `FK_C131E82BA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_C131E82BCAAC9A59` FOREIGN KEY (`conge_id`) REFERENCES `conge` (`id`);

--
-- Constraints for table `reponse_credit`
--
ALTER TABLE `reponse_credit`
  ADD CONSTRAINT `FK_C895B767A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_C895B767CE062FF9` FOREIGN KEY (`credit_id`) REFERENCES `credit` (`id`);

--
-- Constraints for table `reponse_reclamation`
--
ALTER TABLE `reponse_reclamation`
  ADD CONSTRAINT `FK_C7CB51012D6BA2D9` FOREIGN KEY (`reclamation_id`) REFERENCES `reclamation` (`id`),
  ADD CONSTRAINT `FK_C7CB5101A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
