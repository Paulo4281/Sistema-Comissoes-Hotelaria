-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2023 at 03:16 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `agentes`
--

-- --------------------------------------------------------

--
-- Table structure for table `ag_agentes`
--

CREATE TABLE `ag_agentes` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `sobrenome` varchar(255) NOT NULL,
  `dataNascimento` date NOT NULL,
  `genero` enum('Homem','Mulher') NOT NULL DEFAULT 'Homem',
  `cpf` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `whatsapp` varchar(25) NOT NULL,
  `pix` varchar(255) NOT NULL,
  `agencia` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `bairro` varchar(255) NOT NULL,
  `rua` varchar(255) NOT NULL,
  `verificado` int(11) NOT NULL DEFAULT '0',
  `permission` int(11) NOT NULL DEFAULT '0',
  `DATA_CADASTRO` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ag_agentes`
--

INSERT INTO `ag_agentes` (`id`, `nome`, `sobrenome`, `dataNascimento`, `genero`, `cpf`, `email`, `senha`, `whatsapp`, `pix`, `agencia`, `estado`, `cidade`, `bairro`, `rua`, `verificado`, `permission`, `DATA_CADASTRO`) VALUES
(305, 'Teste', 'dos Santos', '2000-01-01', 'Homem', '216.325.100-49', 'teste@gmail.com', '$2y$10$7fRmMKUnJbabfOyKkyvOl.ap0jG2VE3weUxHTo61AxBhCw5bSEeVm', '(73)98844-8855', 'TESTE', 'TESTE', 'BA', 'Salvador', 'TESTE', 'TESTE', 1, 0, '2023-09-10 13:13:56');

-- --------------------------------------------------------

--
-- Table structure for table `ag_agentes_adm`
--

CREATE TABLE `ag_agentes_adm` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `sobrenome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `verificado` int(11) NOT NULL DEFAULT '0',
  `permission` int(11) NOT NULL DEFAULT '0',
  `DATA_CADASTRO` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ag_agentes_adm`
--

INSERT INTO `ag_agentes_adm` (`id`, `nome`, `sobrenome`, `email`, `senha`, `verificado`, `permission`, `DATA_CADASTRO`) VALUES
(13, 'admin', 'admin', 'admin@admin.com', '$2y$10$y/hoHtDUVjqPZJirTL/1u.ZA8S1hQP7uwP86Uh.nz3jWfGiUM/2X.', 1, 1, '2023-09-10 16:10:18');

-- --------------------------------------------------------

--
-- Table structure for table `ag_agentes_nao_verificados`
--

CREATE TABLE `ag_agentes_nao_verificados` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `sobrenome` varchar(255) NOT NULL,
  `dataNascimento` date NOT NULL,
  `genero` enum('Homem','Mulher') NOT NULL,
  `cpf` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `whatsapp` varchar(25) NOT NULL,
  `pix` varchar(255) NOT NULL,
  `agencia` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `bairro` varchar(255) NOT NULL,
  `rua` varchar(255) NOT NULL,
  `verificado` int(11) NOT NULL DEFAULT '0',
  `permission` int(11) NOT NULL DEFAULT '0',
  `DATA_CADASTRO` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ag_login_sucedidos`
--

CREATE TABLE `ag_login_sucedidos` (
  `id` int(11) NOT NULL,
  `id_usuario` varchar(45) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `endereco_ip` varchar(255) NOT NULL DEFAULT '',
  `plataforma` varchar(255) NOT NULL DEFAULT '',
  `browser` varchar(255) NOT NULL DEFAULT '',
  `DATA_HORA` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ag_login_sucedidos`
--

INSERT INTO `ag_login_sucedidos` (`id`, `id_usuario`, `email`, `endereco_ip`, `plataforma`, `browser`, `DATA_HORA`) VALUES
(26, '27', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-20 21:13:08'),
(27, '10', 'lorem@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-20 21:13:31'),
(28, '10', 'lorem@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-20 21:42:09'),
(29, '27', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-20 21:42:27'),
(30, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-20 21:44:47'),
(31, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-20 22:05:16'),
(32, '12', 'wanderson@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-20 22:15:21'),
(33, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-20 22:46:46'),
(34, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-20 23:10:21'),
(35, '112', 'marketing@pspresort.com.br', '127.0.0.1', 'Windows', 'Chrome', '2023-08-20 23:17:45'),
(36, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-21 14:35:58'),
(37, '200', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-21 15:06:33'),
(38, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-21 15:09:58'),
(39, '200', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-21 15:24:44'),
(40, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-21 16:23:43'),
(41, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-21 16:58:29'),
(42, '301', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-21 17:00:41'),
(43, '301', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-21 17:05:08'),
(44, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-21 17:08:50'),
(45, '304', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-21 18:16:15'),
(46, '304', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-21 18:17:47'),
(47, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-21 18:19:26'),
(48, '304', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-21 18:26:20'),
(49, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-21 18:27:34'),
(50, '304', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-21 18:47:03'),
(51, '301', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-21 21:12:12'),
(52, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-22 16:20:43'),
(53, '301', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-22 16:30:07'),
(54, '12', 'eduardo@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-22 16:33:44'),
(55, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-22 17:26:26'),
(56, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-22 17:29:01'),
(57, '301', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-22 17:34:15'),
(58, '301', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-22 17:38:10'),
(59, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-22 17:46:22'),
(60, '301', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-22 18:07:26'),
(61, '301', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-22 18:16:13'),
(62, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-22 18:16:22'),
(63, '301', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-22 20:39:31'),
(64, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-22 20:44:19'),
(65, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-23 14:13:08'),
(66, '302', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-23 15:26:22'),
(67, '302', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-23 15:28:02'),
(68, '302', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-23 23:45:38'),
(69, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-23 23:46:14'),
(70, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-24 15:39:30'),
(71, '302', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-24 16:34:59'),
(72, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-24 16:35:41'),
(73, '302', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-24 16:39:21'),
(74, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-24 16:40:00'),
(75, '302', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-24 17:30:09'),
(76, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-24 17:46:20'),
(77, '302', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-24 18:01:17'),
(78, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-24 18:38:26'),
(79, '302', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-24 19:41:21'),
(80, '302', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-25 04:03:26'),
(81, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-25 14:38:50'),
(82, '302', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-25 14:40:02'),
(83, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-25 14:40:58'),
(84, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-25 14:47:35'),
(85, '302', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-25 14:50:18'),
(86, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-25 14:56:48'),
(87, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-25 14:57:15'),
(88, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-25 14:59:06'),
(89, '303', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-25 15:22:33'),
(90, '301', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-25 16:15:34'),
(91, '301', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-25 17:27:59'),
(92, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-25 18:21:40'),
(93, '301', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-25 18:44:07'),
(94, '301', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-25 19:16:51'),
(95, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-25 19:28:29'),
(96, '302', 'paulowjo@yahoo.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-25 21:25:43'),
(97, '301', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-25 21:33:59'),
(98, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-25 21:38:54'),
(99, '301', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-25 22:10:20'),
(100, '301', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-25 22:11:56'),
(101, '301', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-25 22:16:47'),
(102, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-25 22:18:19'),
(103, '301', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-26 19:21:47'),
(104, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-26 20:10:37'),
(105, '301', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-26 20:11:43'),
(106, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-26 20:58:48'),
(107, '301', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-26 22:34:18'),
(108, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-26 22:52:44'),
(109, '303', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-26 23:17:48'),
(110, '304', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-27 00:00:17'),
(111, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-27 00:04:46'),
(112, '304', 'paulowjo32@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-08-27 00:48:34'),
(113, '13', 'admin@admin.com', '127.0.0.1', 'Windows', 'Chrome', '2023-09-10 16:10:44'),
(114, '13', 'admin@admin.com', '127.0.0.1', 'Windows', 'Chrome', '2023-09-10 16:14:10'),
(115, '305', 'teste@gmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-09-10 16:14:23');

-- --------------------------------------------------------

--
-- Table structure for table `ag_login_sucedidos_arquivado`
--

CREATE TABLE `ag_login_sucedidos_arquivado` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `endereco_ip` varchar(255) NOT NULL,
  `plataforma` varchar(255) NOT NULL,
  `browser` varchar(255) NOT NULL,
  `DATA_HORA` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ag_login_sucedidos_superadm`
--

CREATE TABLE `ag_login_sucedidos_superadm` (
  `id` int(11) NOT NULL,
  `id_usuario` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `endereco_ip` varchar(255) NOT NULL DEFAULT '',
  `plataforma` varchar(255) NOT NULL DEFAULT '',
  `browser` varchar(255) NOT NULL DEFAULT '',
  `DATA_HORA` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ag_login_sucedidos_superadm`
--

INSERT INTO `ag_login_sucedidos_superadm` (`id`, `id_usuario`, `email`, `endereco_ip`, `plataforma`, `browser`, `DATA_HORA`) VALUES
(22, '11', 'paulo.wjo@hotmail.com', '127.0.0.1', 'Windows', 'Chrome', '2023-09-10 16:09:32');

-- --------------------------------------------------------

--
-- Table structure for table `ag_login_tentativas`
--

CREATE TABLE `ag_login_tentativas` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `endereco_ip` varchar(45) NOT NULL,
  `plataforma` varchar(255) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `DATA_HORA` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ag_login_tentativas_arquivado`
--

CREATE TABLE `ag_login_tentativas_arquivado` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `data_hora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `endereco_ip` varchar(45) NOT NULL,
  `plataforma` varchar(255) NOT NULL,
  `browser` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ag_login_tentativas_superadm`
--

CREATE TABLE `ag_login_tentativas_superadm` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `endereco_ip` varchar(255) NOT NULL DEFAULT '',
  `plataforma` varchar(255) NOT NULL DEFAULT '',
  `browser` varchar(255) NOT NULL DEFAULT '',
  `DATA_HORA` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ag_reservas_cadastro`
--

CREATE TABLE `ag_reservas_cadastro` (
  `id_reserva` int(11) NOT NULL,
  `id_agente` int(11) DEFAULT NULL,
  `agente` varchar(255) NOT NULL,
  `operadora` varchar(255) NOT NULL,
  `titular` varchar(255) NOT NULL,
  `sobrenome` varchar(255) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `roomnights` int(11) NOT NULL DEFAULT '1',
  `aptos` int(11) NOT NULL DEFAULT '1',
  `status` varchar(10) NOT NULL DEFAULT 'nao_pago',
  `adm_alteracao` varchar(255) DEFAULT NULL,
  `valor` varchar(255) DEFAULT NULL,
  `previsao` date NOT NULL DEFAULT '2023-01-01',
  `data_pagamento` date DEFAULT NULL,
  `data_reserva_cadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ag_reservas_cadastro`
--

INSERT INTO `ag_reservas_cadastro` (`id_reserva`, `id_agente`, `agente`, `operadora`, `titular`, `sobrenome`, `check_in`, `check_out`, `roomnights`, `aptos`, `status`, `adm_alteracao`, `valor`, `previsao`, `data_pagamento`, `data_reserva_cadastro`) VALUES
(44, 305, 'Teste dos Santos', 'OPERADORA X', 'JOSÉ', 'FREDERICO', '2024-01-11', '2024-01-16', 5, 1, 'nao_pago', NULL, '50', '2024-01-31', NULL, '2023-09-10 13:15:06');

-- --------------------------------------------------------

--
-- Table structure for table `ag_reservas_cadastro_excluidas`
--

CREATE TABLE `ag_reservas_cadastro_excluidas` (
  `id` int(11) NOT NULL,
  `id_reserva` int(11) NOT NULL,
  `id_agente` int(11) NOT NULL,
  `agente` varchar(255) NOT NULL,
  `operadora` varchar(255) NOT NULL,
  `titular` varchar(255) NOT NULL,
  `sobrenome` varchar(255) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `roomnights` int(11) NOT NULL,
  `aptos` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'nao_pago',
  `adm_alteracao` varchar(255) DEFAULT NULL,
  `valor` varchar(255) NOT NULL,
  `previsao` date NOT NULL,
  `data_reserva_cadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_exclusao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ag_agentes`
--
ALTER TABLE `ag_agentes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `ag_agentes_adm`
--
ALTER TABLE `ag_agentes_adm`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `ag_agentes_nao_verificados`
--
ALTER TABLE `ag_agentes_nao_verificados`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `ag_login_sucedidos`
--
ALTER TABLE `ag_login_sucedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ag_login_sucedidos_superadm`
--
ALTER TABLE `ag_login_sucedidos_superadm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ag_login_tentativas`
--
ALTER TABLE `ag_login_tentativas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ag_login_tentativas_arquivado`
--
ALTER TABLE `ag_login_tentativas_arquivado`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ag_login_tentativas_superadm`
--
ALTER TABLE `ag_login_tentativas_superadm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ag_reservas_cadastro`
--
ALTER TABLE `ag_reservas_cadastro`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `id_agente` (`id_agente`);

--
-- Indexes for table `ag_reservas_cadastro_excluidas`
--
ALTER TABLE `ag_reservas_cadastro_excluidas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ag_agentes`
--
ALTER TABLE `ag_agentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=306;

--
-- AUTO_INCREMENT for table `ag_agentes_adm`
--
ALTER TABLE `ag_agentes_adm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `ag_agentes_nao_verificados`
--
ALTER TABLE `ag_agentes_nao_verificados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=264;

--
-- AUTO_INCREMENT for table `ag_login_sucedidos`
--
ALTER TABLE `ag_login_sucedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `ag_login_sucedidos_superadm`
--
ALTER TABLE `ag_login_sucedidos_superadm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `ag_login_tentativas`
--
ALTER TABLE `ag_login_tentativas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ag_login_tentativas_arquivado`
--
ALTER TABLE `ag_login_tentativas_arquivado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `ag_login_tentativas_superadm`
--
ALTER TABLE `ag_login_tentativas_superadm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ag_reservas_cadastro`
--
ALTER TABLE `ag_reservas_cadastro`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `ag_reservas_cadastro_excluidas`
--
ALTER TABLE `ag_reservas_cadastro_excluidas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `transferir_login_sucedidos_arquivado` ON SCHEDULE EVERY 14 DAY STARTS '2023-07-15 22:19:05' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
	INSERT INTO `login_sucedidos_arquivado` (id, id_usuario, email, 	endereco_ip, plataforma, browser, DATA_HORA)
    SELECT * FROM `login_sucedidos`
    WHERE DATA_HORA < now();
    
    DELETE FROM `login_sucedidos`
    WHERE DATA_HORA < NOW();
END$$

CREATE DEFINER=`root`@`localhost` EVENT `transferir_login_tentativas_arquivado` ON SCHEDULE EVERY 1 DAY STARTS '2023-07-15 22:19:05' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    INSERT INTO `login_tentativas_arquivado` (email, data_hora, endereco_ip, plataforma, browser)
    SELECT email, data_hora, endereco_ip, plataforma, browser
    FROM `login_tentativas`
    WHERE data_hora < NOW();
    
    DELETE FROM `login_tentativas`
    WHERE data_hora < NOW();
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
