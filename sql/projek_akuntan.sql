-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 22, 2022 at 10:37 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projek_akuntan`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_det_jurnal`
--

CREATE TABLE `tb_det_jurnal` (
  `id` int(11) NOT NULL,
  `id_jurnal` int(11) DEFAULT NULL,
  `type` enum('PEMASUKAN','PIUTANG DIBAYAR','PIUTANG','PENGELUARAN') DEFAULT NULL,
  `id_table` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_det_jurnal`
--

INSERT INTO `tb_det_jurnal` (`id`, `id_jurnal`, `type`, `id_table`) VALUES
(22, 8, 'PIUTANG', 5),
(23, 8, 'PIUTANG DIBAYAR', 4),
(24, 9, 'PEMASUKAN', 4),
(25, 9, 'PEMASUKAN', 5),
(26, 9, 'PEMASUKAN', 6),
(27, 9, 'PENGELUARAN', 2),
(28, 9, 'PENGELUARAN', 3),
(29, 9, 'PIUTANG', 4);

-- --------------------------------------------------------

--
-- Table structure for table `tb_det_pesanan`
--

CREATE TABLE `tb_det_pesanan` (
  `id` int(11) NOT NULL,
  `id_pesanan` int(11) DEFAULT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `harga_satuan` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_det_pesanan`
--

INSERT INTO `tb_det_pesanan` (`id`, `id_pesanan`, `id_produk`, `qty`, `harga_satuan`) VALUES
(14, 10, 1, 6, 500000),
(15, 10, 4, 1, 400000),
(16, 11, 3, 10, 10000),
(17, 12, 3, 1, 10000),
(18, 13, 4, 6, 400000),
(19, 14, 1, 5, 500000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_jurnal`
--

CREATE TABLE `tb_jurnal` (
  `id` int(11) NOT NULL,
  `kode_jurnal` varchar(100) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `tgl_jurnal` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_jurnal`
--

INSERT INTO `tb_jurnal` (`id`, `kode_jurnal`, `keterangan`, `tgl_jurnal`, `created_at`, `updated_at`) VALUES
(9, 'JN/202208/001', 'Casss', '2022-08-20', '2022-08-21 14:43:19', '2022-08-21 14:43:19');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kategori`
--

CREATE TABLE `tb_kategori` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_kategori`
--

INSERT INTO `tb_kategori` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(2, 'Semen', '2022-08-15 21:09:45', '2022-08-15 21:09:45'),
(3, 'Paku', '2022-08-16 18:23:13', '2022-08-16 18:23:13'),
(4, 'Besi', '2022-08-16 18:23:18', '2022-08-16 18:23:18');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pemasukan`
--

CREATE TABLE `tb_pemasukan` (
  `id` int(11) NOT NULL,
  `id_pesanan` int(11) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `tgl_pemasukan` date DEFAULT NULL,
  `nominal` double DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_jurnal` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_pemasukan`
--

INSERT INTO `tb_pemasukan` (`id`, `id_pesanan`, `keterangan`, `tgl_pemasukan`, `nominal`, `created_at`, `updated_at`, `is_jurnal`) VALUES
(4, 10, 'Pemesanan dengan kode pesanan : TRX/202208/001', '2022-08-20', 3400000, '2022-08-19 12:59:14', '2022-08-21 14:43:19', 1),
(5, 0, 'Bonus Dari Luar Testt', '2022-08-20', 2200000, '2022-08-19 13:05:31', '2022-08-21 14:43:19', 1),
(6, 12, 'Pemesanan dengan kode pesanan : TRX/202208/003', '2022-08-20', 10000, '2022-08-19 15:23:49', '2022-08-21 14:43:19', 1),
(7, 14, 'Pemesanan dengan kode pesanan : TRX/202208/005', '2022-08-22', 2500000, '2022-08-22 06:00:09', '2022-08-22 06:00:09', 0),
(8, 0, 'Testtt', '2022-08-22', 20000, '2022-08-22 06:00:28', '2022-08-22 06:00:28', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengeluaran`
--

CREATE TABLE `tb_pengeluaran` (
  `id` int(11) NOT NULL,
  `tgl_pengeluaran` date DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `nominal` double DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_jurnal` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_pengeluaran`
--

INSERT INTO `tb_pengeluaran` (`id`, `tgl_pengeluaran`, `keterangan`, `nominal`, `created_at`, `updated_at`, `is_jurnal`) VALUES
(2, '2022-08-20', 'Pengeluaran XII', 200000, '2022-08-18 20:02:46', '2022-08-21 14:43:19', 1),
(3, '2022-08-20', 'Test', 200000, '2022-08-19 09:47:31', '2022-08-21 14:43:19', 1),
(4, '2022-08-23', 'Pembekalan', 900000, '2022-08-22 05:56:07', '2022-08-22 05:56:07', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_pesanan`
--

CREATE TABLE `tb_pesanan` (
  `id` int(11) NOT NULL,
  `kode_pesanan` varchar(100) DEFAULT NULL,
  `nama_pemesan` varchar(100) DEFAULT NULL,
  `total_pembayaran` double DEFAULT NULL,
  `tipe_pesanan` enum('BAYAR','PIUTANG') DEFAULT NULL,
  `tanggal_pesan` date DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_pesanan`
--

INSERT INTO `tb_pesanan` (`id`, `kode_pesanan`, `nama_pemesan`, `total_pembayaran`, `tipe_pesanan`, `tanggal_pesan`, `catatan`, `created_at`, `updated_at`) VALUES
(10, 'TRX/202208/001', 'Rois', 3400000, 'BAYAR', '2022-08-20', 'testtt', '2022-08-20 12:59:14', '2022-08-19 12:59:14'),
(11, 'TRX/202208/002', 'Hasan', 100000, 'PIUTANG', '2022-08-20', NULL, '2022-08-20 12:59:38', '2022-08-19 12:59:38'),
(12, 'TRX/202208/003', 'Reeee', 10000, 'BAYAR', '2022-08-20', NULL, '2022-08-20 15:23:49', '2022-08-19 15:23:49'),
(13, 'TRX/202208/004', 'Ceerrrr', 2400000, 'PIUTANG', '2022-08-21', 'Testtt', '2022-08-21 14:27:50', '2022-08-21 14:27:50'),
(14, 'TRX/202208/005', 'Testttt', 2500000, 'BAYAR', '2022-08-22', NULL, '2022-08-22 06:00:09', '2022-08-22 06:00:09');

-- --------------------------------------------------------

--
-- Table structure for table `tb_piutang`
--

CREATE TABLE `tb_piutang` (
  `id` int(11) NOT NULL,
  `id_pesanan` int(11) DEFAULT NULL,
  `nominal` double DEFAULT NULL,
  `status` enum('SUDAH BAYAR','BELUM BAYAR') DEFAULT NULL,
  `tanggal_bayar` date DEFAULT NULL,
  `periode` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_jurnal` int(1) DEFAULT NULL,
  `is_jurnal_bayar` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_piutang`
--

INSERT INTO `tb_piutang` (`id`, `id_pesanan`, `nominal`, `status`, `tanggal_bayar`, `periode`, `created_at`, `updated_at`, `is_jurnal`, `is_jurnal_bayar`) VALUES
(4, 11, 100000, 'SUDAH BAYAR', '2022-08-21', '2022-08-20', '2022-08-19 12:59:38', '2022-08-21 14:43:19', 1, 0),
(5, 13, 2400000, 'BELUM BAYAR', NULL, '2022-08-21', '2022-08-21 14:27:50', '2022-08-21 14:43:08', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_produk`
--

CREATE TABLE `tb_produk` (
  `id` int(11) NOT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `kode_produk` varchar(100) DEFAULT NULL,
  `nama` varchar(200) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` double DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_produk`
--

INSERT INTO `tb_produk` (`id`, `id_kategori`, `kode_produk`, `nama`, `deskripsi`, `harga`, `stok`, `created_at`, `updated_at`) VALUES
(1, 2, 'BR.08.001', 'Test Produk', 'Test Deskripsi', 500000, 0, '2022-08-16 14:45:18', '2022-08-16 14:45:18'),
(3, 3, 'BR.08.002', 'Paku Payung', NULL, 10000, 0, '2022-08-16 22:02:03', '2022-08-16 22:02:03'),
(4, 4, 'BR.08.003', 'Besi Baja', NULL, 400000, 0, '2022-08-16 22:02:20', '2022-08-16 22:02:20');

-- --------------------------------------------------------

--
-- Table structure for table `tb_saldo`
--

CREATE TABLE `tb_saldo` (
  `id` int(11) NOT NULL,
  `periode` varchar(30) DEFAULT NULL,
  `nominal` double DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_saldo`
--

INSERT INTO `tb_saldo` (`id`, `periode`, `nominal`, `created_at`, `updated_at`) VALUES
(1, '08-2022', 500000, '2022-08-19 14:54:54', '2022-08-19 15:03:34'),
(5, '07-2022', 1500000, '2022-08-19 15:20:21', '2022-08-19 15:20:21');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `level` enum('ADMIN','MANAGER') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id`, `username`, `password`, `nama`, `level`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$PVZbBsEhouQu3bYOI9hJweP63v0jqXn.vsp4yPiKOtXr9kD.uAZKy', 'Administrator', 'ADMIN', NULL, '2022-08-16 12:19:20'),
(2, 'manager', '$2y$10$hQzNjxXFwi0hdQKHzC487u8IlCL7RyaE.re7LC8Se45NKLo44SUXu', 'Manager', 'MANAGER', '2022-08-16 06:43:32', '2022-08-16 12:19:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_det_jurnal`
--
ALTER TABLE `tb_det_jurnal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_det_pesanan`
--
ALTER TABLE `tb_det_pesanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_jurnal`
--
ALTER TABLE `tb_jurnal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_kategori`
--
ALTER TABLE `tb_kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_pemasukan`
--
ALTER TABLE `tb_pemasukan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_pengeluaran`
--
ALTER TABLE `tb_pengeluaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_pesanan`
--
ALTER TABLE `tb_pesanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_piutang`
--
ALTER TABLE `tb_piutang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_produk`
--
ALTER TABLE `tb_produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_saldo`
--
ALTER TABLE `tb_saldo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_det_jurnal`
--
ALTER TABLE `tb_det_jurnal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tb_det_pesanan`
--
ALTER TABLE `tb_det_pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tb_jurnal`
--
ALTER TABLE `tb_jurnal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_kategori`
--
ALTER TABLE `tb_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_pemasukan`
--
ALTER TABLE `tb_pemasukan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_pengeluaran`
--
ALTER TABLE `tb_pengeluaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_pesanan`
--
ALTER TABLE `tb_pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tb_piutang`
--
ALTER TABLE `tb_piutang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_produk`
--
ALTER TABLE `tb_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_saldo`
--
ALTER TABLE `tb_saldo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
