-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Mar 2024 pada 08.15
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_temp`
--
CREATE DATABASE IF NOT EXISTS `db_temp` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_temp`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `oauth_provider` enum('facebook','google','twitter','') NOT NULL DEFAULT '',
  `oauth_uid` varchar(50) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `password` text DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `is_block` tinyint(1) DEFAULT 0,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `oauth_provider`, `oauth_uid`, `first_name`, `last_name`, `email`, `password`, `is_admin`, `is_block`, `created`, `modified`) VALUES
(1, '', '01', 'super', 'admin', 'admin@mail', '21232f297a57a5a743894a0e4a801fc3', 1, 0, '2024-02-29 06:08:15', '2024-02-29 06:08:15'),
(3, 'google', '109416624914317885186', 'Ubaidilah', 'Al Bayu', 'ubaidilahalbayu@gmail.com', NULL, 0, 1, '2024-02-29 15:50:05', '2024-03-06 04:47:55'),
(4, 'facebook', '3418865118259725', 'Ubaidillah', 'Bayu', 'ubaidilahalbayu@gmail.com', NULL, 0, 0, '2024-02-29 15:51:57', '2024-03-06 04:48:03'),
(5, 'google', '100166030434532339161', 'udin', 'gambut', 'udingambut345@gmail.com', NULL, 0, 0, '2024-03-01 03:27:08', '2024-03-02 05:00:25');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
