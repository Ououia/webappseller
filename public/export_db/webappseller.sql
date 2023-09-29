-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 29, 2023 at 01:38 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webappseller`
--

-- --------------------------------------------------------
DROP DATABASE IF EXISTS webappseller;


CREATE DATABASE IF NOT EXISTS webappseller;

use webappseller;


--
-- Table structure for table `application`
--

CREATE TABLE `application` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chefdeprojet`
--

CREATE TABLE `chefdeprojet` (
  `id` int(11) NOT NULL,
  `collaborateur_id` int(11) DEFAULT NULL,
  `boost_production` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `raison_sociale` varchar(50) DEFAULT NULL,
  `ridet` varchar(10) DEFAULT NULL,
  `ssi2` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `collaborateur`
--

CREATE TABLE `collaborateur` (
  `id` int(11) NOT NULL,
  `prenom_nom` varchar(255) DEFAULT NULL,
  `niveau_competence` enum('1','2','3') DEFAULT NULL,
  `prime_embauche` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `composant`
--

CREATE TABLE `composant` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `competence` enum('1','2','3') DEFAULT NULL,
  `charge` int(11) DEFAULT NULL,
  `progression` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `composition_equipe`
--

CREATE TABLE `composition_equipe` (
  `id` int(11) NOT NULL,
  `id_team` int(11) DEFAULT NULL,
  `id_dev` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `developpeur`
--

CREATE TABLE `developpeur` (
  `id` int(11) NOT NULL,
  `collaborateur_id` int(11) DEFAULT NULL,
  `competence` varchar(2) DEFAULT NULL,
  `indice_production` int(11) DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `application_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projet`
--

CREATE TABLE `projet` (
  `id` int(11) NOT NULL,
  `id_developpeur` int(11) DEFAULT NULL,
  `id_chefdeprojet` int(11) DEFAULT NULL,
  `type` enum('1','2','3') DEFAULT NULL,
  `id_application` int(11) DEFAULT NULL,
  `id_module` int(11) DEFAULT NULL,
  `id_composant` int(11) DEFAULT NULL,
  `id_client` int(11) NOT NULL,
  `prix` int(11) NOT NULL,
  `statut` enum('0','1','2','3','4') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `chefdeprojet_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `application`
--
ALTER TABLE `application`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chefdeprojet`
--
ALTER TABLE `chefdeprojet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `collaborateur_id` (`collaborateur_id`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `collaborateur`
--
ALTER TABLE `collaborateur`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `composant`
--
ALTER TABLE `composant`
  ADD PRIMARY KEY (`id`),
  ADD KEY `module_id` (`module_id`);

--
-- Indexes for table `composition_equipe`
--
ALTER TABLE `composition_equipe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_team` (`id_team`),
  ADD KEY `id_dev` (`id_dev`);

--
-- Indexes for table `developpeur`
--
ALTER TABLE `developpeur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `collaborateur_id` (`collaborateur_id`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_id` (`application_id`);

--
-- Indexes for table `projet`
--
ALTER TABLE `projet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_developpeur` (`id_developpeur`),
  ADD KEY `id_chefdeprojet` (`id_chefdeprojet`),
  ADD KEY `id_application` (`id_application`),
  ADD KEY `id_module` (`id_module`),
  ADD KEY `id_composant` (`id_composant`),
  ADD KEY `id_client` (`id_client`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chefdeprojet_id` (`chefdeprojet_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `application`
--
ALTER TABLE `application`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chefdeprojet`
--
ALTER TABLE `chefdeprojet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `collaborateur`
--
ALTER TABLE `collaborateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `composant`
--
ALTER TABLE `composant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `composition_equipe`
--
ALTER TABLE `composition_equipe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `developpeur`
--
ALTER TABLE `developpeur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projet`
--
ALTER TABLE `projet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chefdeprojet`
--
ALTER TABLE `chefdeprojet`
  ADD CONSTRAINT `chefdeprojet_ibfk_1` FOREIGN KEY (`collaborateur_id`) REFERENCES `collaborateur` (`id`);

--
-- Constraints for table `composant`
--
ALTER TABLE `composant`
  ADD CONSTRAINT `composant_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`);

--
-- Constraints for table `composition_equipe`
--
ALTER TABLE `composition_equipe`
  ADD CONSTRAINT `composition_equipe_ibfk_1` FOREIGN KEY (`id_team`) REFERENCES `team` (`id`),
  ADD CONSTRAINT `composition_equipe_ibfk_2` FOREIGN KEY (`id_dev`) REFERENCES `developpeur` (`id`);

--
-- Constraints for table `developpeur`
--
ALTER TABLE `developpeur`
  ADD CONSTRAINT `developpeur_ibfk_1` FOREIGN KEY (`collaborateur_id`) REFERENCES `collaborateur` (`id`);

--
-- Constraints for table `module`
--
ALTER TABLE `module`
  ADD CONSTRAINT `module_ibfk_1` FOREIGN KEY (`application_id`) REFERENCES `application` (`id`);

--
-- Constraints for table `projet`
--
ALTER TABLE `projet`
  ADD CONSTRAINT `projet_ibfk_1` FOREIGN KEY (`id_developpeur`) REFERENCES `developpeur` (`id`),
  ADD CONSTRAINT `projet_ibfk_2` FOREIGN KEY (`id_chefdeprojet`) REFERENCES `chefdeprojet` (`id`),
  ADD CONSTRAINT `projet_ibfk_3` FOREIGN KEY (`id_application`) REFERENCES `application` (`id`),
  ADD CONSTRAINT `projet_ibfk_4` FOREIGN KEY (`id_module`) REFERENCES `module` (`id`),
  ADD CONSTRAINT `projet_ibfk_5` FOREIGN KEY (`id_composant`) REFERENCES `composant` (`id`),
  ADD CONSTRAINT `projet_ibfk_6` FOREIGN KEY (`id_client`) REFERENCES `client` (`id`);

--
-- Constraints for table `team`
--
ALTER TABLE `team`
  ADD CONSTRAINT `team_ibfk_1` FOREIGN KEY (`chefdeprojet_id`) REFERENCES `chefdeprojet` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
