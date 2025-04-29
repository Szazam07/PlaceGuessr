-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2025 at 08:48 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `geo_quiz`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `image_url`, `latitude`, `longitude`) VALUES
(1, 'https://myparis.pl/wp-content/uploads/2020/08/wieza-eiffla-03-1024x768.jpg', 48.8588, 2.29435),
(2, 'https://dalekoniedaleko.pl/wp-content/uploads/2011/05/statua_wolnosci_01.jpg', 40.6892, -74.0445),
(3, 'https://www.thetrainline.com/cms/media/5743/uk-london-big-ben.jpg?mode=crop&width=660&height=440&quality=70', 51.5007, -0.124625),
(4, 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/58/Tokyo_Tower_2023.jpg/800px-Tokyo_Tower_2023.jpg', 35.6586, 139.745),
(5, 'https://energy-floors.com/wp-content/uploads/2022/08/Rio-Christusbeeld.jpg', -22.9519, -43.2105),
(6, 'https://example.com/images/berlin.jpg', 52.52, 13.405),
(7, 'https://example.com/images/london.jpg', 51.5074, -0.1278),
(8, 'https://example.com/images/paris.jpg', 48.8566, 2.3522),
(9, 'https://example.com/images/new_york.jpg', 40.7128, -74.006),
(10, 'https://example.com/images/tokyo.jpg', 35.6762, 139.65),
(11, 'https://example.com/images/sydney.jpg', -33.8688, 151.209),
(12, 'https://example.com/images/dubai.jpg', 25.277, 55.2962),
(13, 'https://example.com/images/rome.jpg', 41.9028, 12.4964),
(14, 'https://example.com/images/cairo.jpg', 30.0444, 31.2357),
(15, 'https://example.com/images/rio_de_janeiro.jpg', -22.9068, -43.1729),
(16, 'https://example.com/images/moscow.jpg', 55.7558, 37.6173),
(17, 'https://example.com/images/los_angeles.jpg', 34.0522, -118.244),
(18, 'https://example.com/images/istanbul.jpg', 41.0082, 28.9784),
(19, 'https://example.com/images/amsterdam.jpg', 52.3676, 4.9041),
(20, 'https://example.com/images/cape_town.jpg', -33.9249, 18.4241);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `best_score` int(11) DEFAULT 0,
  `current_score` int(11) DEFAULT 0,
  `last_question_number` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `best_score`, `current_score`, `last_question_number`) VALUES
(1, 'Szazam07', '$2y$10$CMy3xx.X5AWNq/UJnBoiCeMt7CduugDmAcYnwkf5ESSe1G5SZ.O1q', 0, 0, 0),
(2, 'Admin', '$2y$10$bWADBXPr1vuKpnrcc9TR/.uUkynuZBKDlS/6.wwcZ/9UdRhjqaoI.', 0, 0, 0),
(10, 'debil123', '$2y$10$C3/786RIZsvcjdbaLTb.kuetNYwtxFJ.KBP4nnPvtY7wpoBr5c/Fm', 4154, 0, 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
