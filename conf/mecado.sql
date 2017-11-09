-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Lun 06 Novembre 2017 à 15:41
-- Version du serveur :  5.7.14
-- Version de PHP :  7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `mecado`
--

-- --------------------------------------------------------

--
-- Structure de la table `contenir`
--

CREATE TABLE `contenir` (
  `id` int(11) NOT NULL,
  `id_ITEM` int(11) NOT NULL,
  `id_LISTE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `contribution`
--

CREATE TABLE `contribution` (
  `id` int(11) NOT NULL,
  `montant` float NOT NULL,
  `participant` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `donner`
--

CREATE TABLE `donner` (
  `id` int(11) NOT NULL,
  `id_GROUPE` int(11) NOT NULL,
  `id_ITEM` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `groupe`
--

CREATE TABLE `groupe` (
  `id` int(11) NOT NULL,
  `nom` varchar(25) NOT NULL,
  `description` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `tarif` float DEFAULT NULL,
  `url_ecommerce` varchar(250) DEFAULT NULL,
  `reserve` tinyint(1) NOT NULL,
  `cagnotte` tinyint(1) DEFAULT NULL,
  `id_GROUPE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `laisser`
--

CREATE TABLE `laisser` (
  `id` int(11) NOT NULL,
  `id_LISTE` int(11) NOT NULL,
  `id_MESSAGE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `liste`
--

CREATE TABLE `liste` (
  `id` int(11) NOT NULL,
  `nom` varchar(25) NOT NULL,
  `description` text NOT NULL,
  `date_limite` date NOT NULL,
  `destinataire` varchar(25) NOT NULL,
  `pour_soi` tinyint(1) NOT NULL,
  `url` varchar(250) DEFAULT NULL,
  `id_UTILISATEUR` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `contenu` varchar(25) NOT NULL,
  `auteur` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

CREATE TABLE `photo` (
  `id` int(11) NOT NULL,
  `nom` varchar(25) DEFAULT NULL,
  `url` varchar(25) NOT NULL,
  `id_ITEM` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(25) NOT NULL,
  `mdp` varchar(250) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `nom_complet` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `contenir`
--
ALTER TABLE `contenir`
  ADD PRIMARY KEY (`id`,`id_ITEM`,`id_LISTE`),
  ADD KEY `FK_contenir_id_ITEM` (`id_ITEM`),
  ADD KEY `FK_contenir_id_LISTE` (`id_LISTE`);

--
-- Index pour la table `contribution`
--
ALTER TABLE `contribution`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `donner`
--
ALTER TABLE `donner`
  ADD PRIMARY KEY (`id`,`id_GROUPE`,`id_ITEM`),
  ADD KEY `FK_donner_id_GROUPE` (`id_GROUPE`),
  ADD KEY `FK_donner_id_ITEM` (`id_ITEM`);

--
-- Index pour la table `groupe`
--
ALTER TABLE `groupe`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ITEM_id_GROUPE` (`id_GROUPE`);

--
-- Index pour la table `laisser`
--
ALTER TABLE `laisser`
  ADD PRIMARY KEY (`id`,`id_LISTE`,`id_MESSAGE`),
  ADD KEY `FK_laisser_id_LISTE` (`id_LISTE`),
  ADD KEY `FK_laisser_id_MESSAGE` (`id_MESSAGE`);

--
-- Index pour la table `liste`
--
ALTER TABLE `liste`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_LISTE_id_UTILISATEUR` (`id_UTILISATEUR`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_PHOTO_id_ITEM` (`id_ITEM`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `contribution`
--
ALTER TABLE `contribution`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `groupe`
--
ALTER TABLE `groupe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `liste`
--
ALTER TABLE `liste`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `photo`
--
ALTER TABLE `photo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `contenir`
--
ALTER TABLE `contenir`
  ADD CONSTRAINT `FK_contenir_id` FOREIGN KEY (`id`) REFERENCES `liste` (`id`),
  ADD CONSTRAINT `FK_contenir_id_ITEM` FOREIGN KEY (`id_ITEM`) REFERENCES `item` (`id`),
  ADD CONSTRAINT `FK_contenir_id_LISTE` FOREIGN KEY (`id_LISTE`) REFERENCES `liste` (`id`);

--
-- Contraintes pour la table `donner`
--
ALTER TABLE `donner`
  ADD CONSTRAINT `FK_donner_id` FOREIGN KEY (`id`) REFERENCES `contribution` (`id`),
  ADD CONSTRAINT `FK_donner_id_GROUPE` FOREIGN KEY (`id_GROUPE`) REFERENCES `groupe` (`id`),
  ADD CONSTRAINT `FK_donner_id_ITEM` FOREIGN KEY (`id_ITEM`) REFERENCES `item` (`id`);

--
-- Contraintes pour la table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `FK_ITEM_id_GROUPE` FOREIGN KEY (`id_GROUPE`) REFERENCES `groupe` (`id`);

--
-- Contraintes pour la table `laisser`
--
ALTER TABLE `laisser`
  ADD CONSTRAINT `FK_laisser_id` FOREIGN KEY (`id`) REFERENCES `item` (`id`),
  ADD CONSTRAINT `FK_laisser_id_LISTE` FOREIGN KEY (`id_LISTE`) REFERENCES `liste` (`id`),
  ADD CONSTRAINT `FK_laisser_id_MESSAGE` FOREIGN KEY (`id_MESSAGE`) REFERENCES `message` (`id`);

--
-- Contraintes pour la table `liste`
--
ALTER TABLE `liste`
  ADD CONSTRAINT `FK_LISTE_id_UTILISATEUR` FOREIGN KEY (`id_UTILISATEUR`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `photo`
--
ALTER TABLE `photo`
  ADD CONSTRAINT `FK_PHOTO_id_ITEM` FOREIGN KEY (`id_ITEM`) REFERENCES `item` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
