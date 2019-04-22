-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2019 at 10:02 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iksan`
--

-- --------------------------------------------------------

--
-- Table structure for table `master_harga`
--

CREATE TABLE `master_harga` (
  `m_id_harga` int(100) NOT NULL,
  `m_nama` varchar(250) NOT NULL,
  `m_harga` varchar(250) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_harga`
--

INSERT INTO `master_harga` (`m_id_harga`, `m_nama`, `m_harga`, `status`) VALUES
(1, 'biasa', '1000', 'aktif'),
(2, 'jens', '6000', 'nonaktif');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id` int(100) UNSIGNED NOT NULL,
  `nama_pengguna` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `level` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tanggal_mulai` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tanggal_diperbarui` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `alamat` text COLLATE utf8_unicode_ci NOT NULL,
  `telfon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'foto.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id`, `nama_pengguna`, `password`, `nama`, `level`, `tanggal_mulai`, `tanggal_diperbarui`, `alamat`, `telfon`, `foto`) VALUES
(12, 'admin', '$2y$10$h2bWN.5ZFSw5eC7K3eqKr.T7/VMGYQ7MCkuund4RcHBhvOK1lvlAG', 'admin', 'pemilik', '2019-04-08 16:36:56', '2019-04-13 19:27:22', '', '', 'foto.png'),
(17, 'pegawai ', '$2y$10$yfLAnfJBxiizBKmM0VJsreDk5aZur2zHyVP1m4lE6xgsVW8pV9yvu', 'pegawai', 'pegawai', '2019-04-09 02:00:38', '2019-04-13 20:36:34', 'mojokerto', '085106114545', 'foto.png'),
(18, 'syam', '$2y$10$93GcXvqopmGqyzhc1CcDA.pWSlqdUe0Eh7pTmRQUuz9BAfSLbMwO6', 'syam fauzy', 'pegawai', '2019-04-11 18:14:18', '2019-04-13 19:28:28', 'df ', '333333', 'foto.png'),
(19, 'iksan', '$2y$10$8xU/XN9uVbrY6ZMuNgo9BemxOZHcHSOINnOXijBAWdtGi6R55NXBe', 'iksan', 'pegawai', '2019-04-11 18:15:16', '2019-04-13 19:59:59', 'kkk', '99999090', 'foto.png'),
(20, 'elepsi', '$2y$10$G9yOMzplj3Mp2JXwbyHeSO0v6X5bVMr0u3CMpHLO.We5JNUAfz2aG', 'elepsiq', 'pegawai', '2019-04-11 18:16:11', '2019-04-13 20:00:03', 'kdkkkd', '0000', 'foto.png'),
(22, 's', '$2y$10$5RcyFFNkaPNAXxq7qiRFe.5r5l2fcZ7PS1hCb68d1oNXI7mkHv2S.', 'ss', 'pegawai', '2019-04-13 19:45:25', '2019-04-13 19:59:45', '2222wwss', '2222', 'foto.png'),
(24, 'syam1', '$2y$10$2aX.owJmd/ZO4lRNEvpVtusOUaSXTl1SxnzWh4E1.w6Wu1XFNU.am', 'pegawai', 'pemilik', '2019-04-19 12:09:15', '2019-04-19 12:09:15', 'mojokerto', '085106114545', 'foto.png');

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `id_ticket` varchar(100) NOT NULL,
  `id_pegawai` int(100) NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `nama_pelanggan` varchar(250) NOT NULL,
  `telp_pelangan` varchar(250) DEFAULT NULL,
  `alamat_pelanggan` text,
  `status_ticket` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`id_ticket`, `id_pegawai`, `tanggal`, `nama_pelanggan`, `telp_pelangan`, `alamat_pelanggan`, `status_ticket`) VALUES
('1f079c6a-85cf-4dd2-8bf2-41fc43b27c58', 12, '2019-04-21 20:38:11', 'ss', '999', '', 'baru'),
('f9658a33-fef4-4571-a30e-8b09415c89dc', 12, '2019-04-21 18:47:32', 'tepo', '66', '', 'selesai');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(100) NOT NULL,
  `id_harga` int(100) NOT NULL,
  `jumlah` float DEFAULT NULL,
  `tanggal` datetime NOT NULL,
  `id_pegawai` int(100) NOT NULL,
  `id_ticket` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_harga`, `jumlah`, `tanggal`, `id_pegawai`, `id_ticket`) VALUES
(34, 1, 1, '2019-04-21 18:47:07', 12, 'f9658a33-fef4-4571-a30e-8b09415c89dc');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `master_harga`
--
ALTER TABLE `master_harga`
  ADD PRIMARY KEY (`m_id_harga`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_pengguna_unique` (`nama_pengguna`) USING BTREE;

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id_ticket`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `master_harga`
--
ALTER TABLE `master_harga`
  MODIFY `m_id_harga` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int(100) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
