-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 28 Mei 2019 pada 03.09
-- Versi Server: 10.1.29-MariaDB-6+b1
-- PHP Version: 7.2.4-1+b1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Struktur dari tabel `master_harga`
--

CREATE TABLE `master_harga` (
  `m_id_harga` int(100) NOT NULL,
  `m_nama` varchar(250) NOT NULL,
  `m_harga` varchar(250) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `master_harga`
--

INSERT INTO `master_harga` (`m_id_harga`, `m_nama`, `m_harga`, `status`) VALUES
(1, 'biasa', '1000', 'aktif'),
(3, 'Jens', '5000', 'aktif'),
(4, 'selimut ', '4500', 'aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
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
-- Dumping data untuk tabel `pengguna`
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
-- Struktur dari tabel `ticket`
--

CREATE TABLE `ticket` (
  `kode` int(100) NOT NULL,
  `id_ticket` varchar(100) NOT NULL,
  `id_pegawai` int(100) NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `nama_pelanggan` varchar(250) NOT NULL,
  `telp_pelangan` varchar(250) DEFAULT NULL,
  `alamat_pelanggan` text,
  `status_ticket` varchar(50) NOT NULL,
  `pembayaran` varchar(50) NOT NULL DEFAULT 'belum lunas'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ticket`
--

INSERT INTO `ticket` (`kode`, `id_ticket`, `id_pegawai`, `tanggal`, `nama_pelanggan`, `telp_pelangan`, `alamat_pelanggan`, `status_ticket`, `pembayaran`) VALUES
(3, '4e83a8fc-9a10-4d8b-bec5-587e81cad281', 12, '2019-05-28 03:00:23', 'yudi', '09778666', 'jkjkj jlkjlkj ;olk', 'proses', 'belum lunas');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
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
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_harga`, `jumlah`, `tanggal`, `id_pegawai`, `id_ticket`) VALUES
(36, 4, 1, '2019-05-26 12:03:23', 12, '4e83a8fc-9a10-4d8b-bec5-587e81cad281');

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
  ADD PRIMARY KEY (`kode`);

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
  MODIFY `m_id_harga` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int(100) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `kode` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
