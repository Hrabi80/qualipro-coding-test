-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 20, 2025 at 03:43 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `concert`
--

-- --------------------------------------------------------

--
-- Table structure for table `concert`
--

CREATE TABLE `concert` (
  `id` int(11) NOT NULL,
  `party_hall_id` int(11) DEFAULT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `concert`
--

INSERT INTO `concert` (`id`, `party_hall_id`, `date`) VALUES
(1, 3, '2001-01-01'),
(2, 3, '2002-01-01'),
(3, 4, '2003-01-01'),
(4, 5, '2010-10-10');

-- --------------------------------------------------------

--
-- Table structure for table `concert_musical_band`
--

CREATE TABLE `concert_musical_band` (
  `concert_id` int(11) NOT NULL,
  `musical_band_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `concert_musical_band`
--

INSERT INTO `concert_musical_band` (`concert_id`, `musical_band_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(3, 1),
(3, 2),
(4, 5),
(4, 6);

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
('DoctrineMigrations\\Version20250219170314', '2025-02-19 17:03:30', 57);

-- --------------------------------------------------------

--
-- Table structure for table `musical_band`
--

CREATE TABLE `musical_band` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `origin` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `founded_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `separation_date` date DEFAULT NULL,
  `founders` varchar(255) NOT NULL,
  `members` int(11) NOT NULL,
  `music_style` varchar(255) DEFAULT NULL,
  `about` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `musical_band`
--

INSERT INTO `musical_band` (`id`, `name`, `origin`, `city`, `founded_at`, `separation_date`, `founders`, `members`, `music_style`, `about`) VALUES
(1, 'Nirvana', 'USA', 'SanFranciscddo', '1997-02-01 00:00:00', NULL, 'micker ', 3, NULL, 'hello world'),
(2, 'Linken Park', 'USA', 'SanFranciscddo', '1997-02-01 00:00:00', NULL, 'micker ', 3, NULL, 'hello world'),
(3, 'SOD', 'USA', 'SanFranciscddo', '1997-02-01 00:00:00', '2005-03-01', 'micker ', 3, NULL, 'hello world'),
(4, 'SODdd', 'USA', 'SanFranciscddo', '1997-02-01 00:00:00', '2005-03-01', 'micker ', 3, NULL, 'hello world'),
(5, 'test updated', 'usa', 'Texas', '2023-01-21 00:00:00', NULL, 'ddd', 3, NULL, 'dsqsq qsdqs dqsd qs dqsd sqdqsdqsqs'),
(6, 'Green Days', 'USA', 'Florida', '2022-05-20 00:00:00', NULL, 'sdqsdsdq', 2, NULL, 'qsd qsdsd qsdj qslkd jklmdfjQSDPOQS^DQSDKJ QSKdqSD Q'),
(7, 'The Beatles', 'Royaume-Uni ', 'Liverpool', '1960-02-20 12:51:06', '1970-02-20', 'John Lennon', 4, NULL, 'The Beatles [ðə ˈbiːtəlz] est un quatuor musical britannique originaire de Liverpool, en Angleterre. Le noyau du groupe se forme avec les Quarrymen fondés ...'),
(8, 'Indochine', 'France', 'paris', '1981-02-20 12:51:06', NULL, 'Nicola Sirkis et Dominique Nicolas', 5, 'pop rock', 'Indochine est un groupe de pop rock français originaire de Paris, formé par Nicola Sirkis et Dominique Nicolas en 1981. Le groupe est issu du courant new wave'),
(9, 'Noir Désir', 'France', 'bordeaux', '1980-02-20 12:51:06', '2025-02-20', 'Bertrand Cantat', 4, 'rock', 'Noir Désir est un groupe de rock français, originaire de Bordeaux, en Gironde. Formé dans les années 1980, et dissout en 2010, il se compose de Bertrand Cantat, Denis Barthe, Serge Teyssot-Gay et Frédéric Vidalenc remplacé par Jean-Paul Roy à partir de 1996'),
(10, 'Nirvana', 'Etats-unis', 'Aberdeen', '1987-02-20 12:51:06', '1994-02-20', 'Kurt Cobain', 3, 'grunge', 'Nirvana est un groupe de grunge américain, originaire d\'Aberdeen, dans l\'État de Washington, formé en 1987 par le chanteur-guitariste Kurt Cobain et le bassiste Krist Novoselic'),
(11, 'Pink Floyd', 'Royaume-Uni ', 'Londres', '1964-02-20 12:51:06', '2025-02-20', 'Syd Barrett,', 3, 'rock', 'Pink Floyd [pɪŋk flɔɪd] est un groupe britannique de rock originaire de Londres. Le groupe débute avec un premier album de musique psychédélique pour ensuite bifurquer vers le rock progressif. Formé en 1965, il est considéré comme un pionnier et représentant majeur de ces styles musicaux.');

-- --------------------------------------------------------

--
-- Table structure for table `party_hall`
--

CREATE TABLE `party_hall` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `party_hall`
--

INSERT INTO `party_hall` (`id`, `name`, `address`, `city`) VALUES
(1, 'SanFrancisco Hall', 'san francisco', 'san francisco'),
(2, 'SanFrancisco Hall', 'san francisco', 'san francisco'),
(3, 'SanFrancisco Hall 22', 'san francisco', 'san francisco'),
(4, 'SanFrancisco Hall 22', 'san francisco', 'san francisco'),
(5, 'SanFrancisco Hall 22', 'san francisco', 'san francisco'),
(6, 'SanFranciscddo Hall 22', 'san ddddfrancisco', 'san francisco'),
(7, 'Berlin Hall 10', 'updated adress', 'Berlin'),
(8, 'updated', 'albaniad', 'dsaaa'),
(9, 'FreeWay', 'Florida,15-06', 'Florida');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `concert`
--
ALTER TABLE `concert`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D57C02D2405E50FD` (`party_hall_id`);

--
-- Indexes for table `concert_musical_band`
--
ALTER TABLE `concert_musical_band`
  ADD PRIMARY KEY (`concert_id`,`musical_band_id`),
  ADD KEY `IDX_427489BB83C97B2E` (`concert_id`),
  ADD KEY `IDX_427489BBA06F9737` (`musical_band_id`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `musical_band`
--
ALTER TABLE `musical_band`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `party_hall`
--
ALTER TABLE `party_hall`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `concert`
--
ALTER TABLE `concert`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `musical_band`
--
ALTER TABLE `musical_band`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `party_hall`
--
ALTER TABLE `party_hall`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `concert`
--
ALTER TABLE `concert`
  ADD CONSTRAINT `FK_D57C02D2405E50FD` FOREIGN KEY (`party_hall_id`) REFERENCES `party_hall` (`id`);

--
-- Constraints for table `concert_musical_band`
--
ALTER TABLE `concert_musical_band`
  ADD CONSTRAINT `FK_427489BB83C97B2E` FOREIGN KEY (`concert_id`) REFERENCES `concert` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_427489BBA06F9737` FOREIGN KEY (`musical_band_id`) REFERENCES `musical_band` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
