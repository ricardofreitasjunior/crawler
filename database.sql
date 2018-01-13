-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 13-Jan-2018 às 18:23
-- Versão do servidor: 5.7.14
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `widesoft`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `ws_urls`
--

DROP TABLE IF EXISTS `ws_urls`;
CREATE TABLE IF NOT EXISTS `ws_urls` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `url` varchar(250) NOT NULL,
  `path` varchar(250) DEFAULT NULL,
  `status` varchar(250) NOT NULL DEFAULT 'Pendente',
  `status_code` varchar(250) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `ws_urls`
--

INSERT INTO `ws_urls` (`ID`, `id_user`, `url`, `path`, `status`, `status_code`, `created`, `modified`) VALUES
(10, 1, 'https://www.olx.com.br/', NULL, 'Pendente', 'HTTP/1.0 544 Unknown', '2018-01-13 13:48:10', '2018-01-13 14:09:00'),
(11, 1, 'http://www.tudointeressante.com.br', 'http://dev.crawler.com.br/public/files/OEtGTWc2T0ZhREdLWGlIQVNHaTUrdz09/www.tudointeressante.com.br', 'Concluído', 'HTTP/1.1 200 OK', '2018-01-13 14:08:47', '2018-01-13 14:08:59'),
(9, 1, 'https://www.tudointeressante.com.br/sdgbtdAAA', NULL, 'Erro', 'HTTP/1.1 404 Not Found', '2018-01-11 15:54:15', '2018-01-13 14:07:34');

-- --------------------------------------------------------

--
-- Estrutura da tabela `ws_users`
--

DROP TABLE IF EXISTS `ws_users`;
CREATE TABLE IF NOT EXISTS `ws_users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(250) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID_UNIQUE` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `ws_users`
--

INSERT INTO `ws_users` (`ID`, `name`, `email`, `password`, `created`, `modified`) VALUES
(1, 'John Smith', 'teste@teste.com', 'OTlNNGtVcGc1R0FVeDZOM1ZoNlhCZz09', '2017-12-28 17:02:48', '2017-12-28 17:03:35'),
(2, 'Fulano da Silva', 'teste2@teste.com', 'teste', '2017-12-28 17:04:55', '2017-12-28 17:04:55'),
(3, 'Ciclano de Souza', 'teste3@teste.com', 'teste', '2017-12-28 17:07:03', '2017-12-28 17:07:03'),
(17, 'Beltrano de Oliveira', 'teste4@teste.com', 'OTlNNGtVcGc1R0FVeDZOM1ZoNlhCZz09', '2018-01-04 14:32:57', '2018-01-04 14:32:57');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
