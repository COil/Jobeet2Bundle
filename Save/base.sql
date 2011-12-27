-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Mar 27 Décembre 2011 à 00:33
-- Version du serveur: 5.1.44
-- Version de PHP: 5.3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `jobeet2`
--

-- --------------------------------------------------------

--
-- Structure de la table `affiliate`
--

CREATE TABLE `affiliate` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `affiliate`
--


-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `category`
--


-- --------------------------------------------------------

--
-- Structure de la table `category_affiliate`
--

CREATE TABLE `category_affiliate` (
  `category_id` bigint(20) NOT NULL,
  `affiliate_id` bigint(20) NOT NULL,
  PRIMARY KEY (`category_id`,`affiliate_id`),
  KEY `category_id` (`category_id`),
  KEY `affiliate_id` (`affiliate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `category_affiliate`
--


-- --------------------------------------------------------

--
-- Structure de la table `job`
--

CREATE TABLE `job` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `company` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `position` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` tinytext NOT NULL,
  `how_to_apply` tinytext NOT NULL,
  `token` varchar(255) NOT NULL,
  `is_public` tinyint(4) NOT NULL,
  `is_activated` tinyint(4) NOT NULL,
  `email` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `job`
--


--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `category_affiliate`
--
ALTER TABLE `category_affiliate`
  ADD CONSTRAINT `category_affiliate_ibfk_2` FOREIGN KEY (`affiliate_id`) REFERENCES `affiliate` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `category_affiliate_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `job`
--
ALTER TABLE `job`
  ADD CONSTRAINT `job_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE;
