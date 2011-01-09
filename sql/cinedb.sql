-- phpMyAdmin SQL Dump
-- version 3.3.2deb1
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Dim 09 Janvier 2011 à 10:36
-- Version du serveur: 5.1.41
-- Version de PHP: 5.3.2-1ubuntu4.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `cinedb`
--

-- --------------------------------------------------------

--
-- Structure de la table `Film`
--

CREATE TABLE IF NOT EXISTS `Film` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `originalTitle` varchar(255) NOT NULL,
  `nationality` varchar(255) NOT NULL,
  `resume` text NOT NULL,
  `poster` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  `soundVersion` enum('VF','VOST') NOT NULL,
  `oldForbade` int(11) NOT NULL,
  `allocineId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `Film`
--


-- --------------------------------------------------------

--
-- Structure de la table `Prog`
--

CREATE TABLE IF NOT EXISTS `Prog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `film_id` int(11) NOT NULL,
  `day` date NOT NULL,
  `time` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `Prog`
--

