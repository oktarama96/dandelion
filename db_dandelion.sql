-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2020 at 04:59 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_dandelion`
--

-- --------------------------------------------------------

--
-- Table structure for table `detailtransaksi`
--

CREATE TABLE `detailtransaksi` (
  `IdDetailTransaksi` int(10) UNSIGNED NOT NULL,
  `Qty` int(11) NOT NULL,
  `Diskon` int(11) NOT NULL,
  `SubTotal` int(11) NOT NULL,
  `IdProduk` char(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `IdStokProduk` int(10) UNSIGNED NOT NULL,
  `IdTransaksi` char(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategoriproduk`
--

CREATE TABLE `kategoriproduk` (
  `IdKategoriProduk` int(10) UNSIGNED NOT NULL,
  `NamaKategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategoriproduk`
--

INSERT INTO `kategoriproduk` (`IdKategoriProduk`, `NamaKategori`, `created_at`, `updated_at`) VALUES
(1, 'Baju', '2020-06-12 15:37:28', '2020-06-12 15:37:28'),
(2, 'Celana', '2020-06-12 15:37:39', '2020-06-12 15:37:39'),
(3, 'Aksesoriss', '2020-07-04 14:34:49', '2020-07-04 14:56:16');

-- --------------------------------------------------------

--
-- Table structure for table `kupondiskon`
--

CREATE TABLE `kupondiskon` (
  `IdKuponDiskon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NamaKupon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TglMulai` datetime NOT NULL,
  `TglSelesai` datetime NOT NULL,
  `JumlahPotongan` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kupondiskon`
--

INSERT INTO `kupondiskon` (`IdKuponDiskon`, `NamaKupon`, `TglMulai`, `TglSelesai`, `JumlahPotongan`, `created_at`, `updated_at`) VALUES
('-', '-', '2020-06-15 00:00:04', '2020-05-31 00:00:04', 0, '2020-06-14 16:56:24', '2020-06-14 16:56:24');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_05_21_061907_create_pengguna_table', 1),
(5, '2020_05_21_063637_create_kategori_produk_table', 1),
(6, '2020_05_21_064049_create_warna_table', 1),
(7, '2020_05_21_064050_create_ukuran_table', 1),
(8, '2020_05_21_064537_create_kupon_diskon_table', 1),
(9, '2020_05_21_064914_create_pelanggan_table', 1),
(10, '2020_05_21_071454_create_produk_table', 1),
(11, '2020_05_21_074152_create_stok_produk_table', 1),
(12, '2020_05_21_074405_create_transaksi_table', 1),
(13, '2020_05_21_085234_create_detail_transaksi_table', 1),
(14, '2020_05_21_090126_create_ulasan_produk_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `IdPelanggan` int(10) UNSIGNED NOT NULL,
  `NamaPelanggan` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TglLahir` date NOT NULL,
  `JenisKelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `Email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `NoHandphone` char(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `IdKecamatan` int(11) NOT NULL,
  `NamaKecamatan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `IdKabupaten` int(11) NOT NULL,
  `NamaKabupaten` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `IdProvinsi` int(11) NOT NULL,
  `NamaProvinsi` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`IdPelanggan`, `NamaPelanggan`, `TglLahir`, `JenisKelamin`, `Email`, `Password`, `remember_token`, `Alamat`, `NoHandphone`, `IdKecamatan`, `NamaKecamatan`, `IdKabupaten`, `NamaKabupaten`, `IdProvinsi`, `NamaProvinsi`, `created_at`, `updated_at`) VALUES
(1, '-', '2020-06-01', 'Laki-laki', '-@mail.com', '$2y$10$x4tmbGNT4rswFYYzsBF9KOPNThYVenrpKN/bgJ37NU1nXYb9vWB6u', NULL, '-', '00000000000', 261, 'Kuta Utara', 17, 'Badung', 1, 'Bali', '2020-06-14 16:55:57', '2020-06-14 16:55:57');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `IdPengguna` int(10) UNSIGNED NOT NULL,
  `NamaPengguna` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `NoHandphone` char(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Is_admin` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`IdPengguna`, `NamaPengguna`, `Email`, `Password`, `remember_token`, `Alamat`, `NoHandphone`, `Is_admin`, `created_at`, `updated_at`) VALUES
(1, 'Rama', 'ramaa@gmail.com', '$2y$10$vEQ6IedAh/JZs7G9qk/WEehlzubF/.h2vebcANCRCO9LzFaUvKyM6', NULL, 'asdasd', '083119853063', 1, '2020-06-13 03:26:07', '2020-06-13 03:26:07');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `IdProduk` char(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NamaProduk` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `GambarProduk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `HargaPokok` int(11) NOT NULL,
  `HargaJual` int(11) NOT NULL,
  `Berat` int(11) NOT NULL,
  `Deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `IdKategoriProduk` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`IdProduk`, `NamaProduk`, `GambarProduk`, `HargaPokok`, `HargaJual`, `Berat`, `Deskripsi`, `IdKategoriProduk`, `created_at`, `updated_at`) VALUES
('DB0001', 'Baju', 'gogatsu-baju-2.jpg', 30000, 40000, 400, 'Barang Bagus', 1, '2020-06-15 06:54:46', '2020-06-15 06:54:46'),
('DB0002', 'Celana Jeans', 'no-image.png', 40000, 70000, 200, 'Mantap Pokoknya', 2, '2020-06-17 04:34:27', '2020-06-17 04:34:27');

-- --------------------------------------------------------

--
-- Table structure for table `stokproduk`
--

CREATE TABLE `stokproduk` (
  `IdStokProduk` int(10) UNSIGNED NOT NULL,
  `StokMasuk` int(11) NOT NULL,
  `StokKeluar` int(11) NOT NULL,
  `StokAkhir` int(11) NOT NULL,
  `IdWarna` int(10) UNSIGNED NOT NULL,
  `IdUkuran` int(10) UNSIGNED NOT NULL,
  `IdProduk` char(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stokproduk`
--

INSERT INTO `stokproduk` (`IdStokProduk`, `StokMasuk`, `StokKeluar`, `StokAkhir`, `IdWarna`, `IdUkuran`, `IdProduk`, `created_at`, `updated_at`) VALUES
(12, 5, 0, 5, 1, 1, 'DB0001', '2020-06-15 06:54:46', '2020-06-15 06:54:46'),
(14, 2, 0, 2, 2, 5, 'DB0001', '2020-06-15 06:54:46', '2020-06-15 10:29:59'),
(15, 10, 1, 9, 2, 3, 'DB0002', '2020-06-17 04:34:27', '2020-07-05 02:24:21'),
(16, 0, 2, -2, 1, 4, 'DB0002', '2020-06-17 04:34:27', '2020-07-14 00:35:04');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `IdTransaksi` char(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TglTransaksi` datetime NOT NULL,
  `Total` int(11) NOT NULL,
  `Potongan` int(11) NOT NULL,
  `OngkosKirim` int(11) NOT NULL,
  `NamaEkspedisi` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `GrandTotal` int(11) NOT NULL,
  `MetodePembayaran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `StatusPembayaran` int(11) NOT NULL,
  `StatusPesanan` int(11) NOT NULL,
  `Snap_token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `IdKuponDiskon` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `IdPengguna` int(10) UNSIGNED NOT NULL,
  `IdPelanggan` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ukuran`
--

CREATE TABLE `ukuran` (
  `IdUkuran` int(10) UNSIGNED NOT NULL,
  `NamaUkuran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ukuran`
--

INSERT INTO `ukuran` (`IdUkuran`, `NamaUkuran`, `created_at`, `updated_at`) VALUES
(1, 'XS', '2020-06-12 15:38:06', '2020-06-12 15:38:06'),
(2, 'S', '2020-06-12 15:38:10', '2020-06-12 15:38:10'),
(3, 'M', '2020-06-15 06:53:36', '2020-06-15 06:53:36'),
(4, 'L', '2020-06-15 06:53:40', '2020-06-15 06:53:40'),
(5, 'XL', '2020-06-15 06:53:43', '2020-06-15 06:53:43');

-- --------------------------------------------------------

--
-- Table structure for table `ulasanproduk`
--

CREATE TABLE `ulasanproduk` (
  `IdUlasanProduk` int(10) UNSIGNED NOT NULL,
  `Deskripsi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai` int(11) NOT NULL,
  `IdPelanggan` int(10) UNSIGNED NOT NULL,
  `IdProduk` char(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `warna`
--

CREATE TABLE `warna` (
  `IdWarna` int(10) UNSIGNED NOT NULL,
  `NamaWarna` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `warna`
--

INSERT INTO `warna` (`IdWarna`, `NamaWarna`, `created_at`, `updated_at`) VALUES
(1, 'Merah', '2020-06-12 15:37:52', '2020-06-12 15:37:52'),
(2, 'Hijau', '2020-06-12 15:37:57', '2020-06-12 15:37:57'),
(3, 'Biru', '2020-06-15 06:53:21', '2020-06-15 06:53:21'),
(4, 'Putih', '2020-06-15 06:53:27', '2020-06-15 06:53:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detailtransaksi`
--
ALTER TABLE `detailtransaksi`
  ADD PRIMARY KEY (`IdDetailTransaksi`),
  ADD KEY `detailtransaksi_idproduk_foreign` (`IdProduk`),
  ADD KEY `detailtransaksi_idtransaksi_foreign` (`IdTransaksi`),
  ADD KEY `IdStokProduk` (`IdStokProduk`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategoriproduk`
--
ALTER TABLE `kategoriproduk`
  ADD PRIMARY KEY (`IdKategoriProduk`);

--
-- Indexes for table `kupondiskon`
--
ALTER TABLE `kupondiskon`
  ADD PRIMARY KEY (`IdKuponDiskon`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`IdPelanggan`),
  ADD UNIQUE KEY `pelanggan_email_unique` (`Email`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`IdPengguna`),
  ADD UNIQUE KEY `pengguna_email_unique` (`Email`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`IdProduk`),
  ADD KEY `produk_idkategoriproduk_foreign` (`IdKategoriProduk`);

--
-- Indexes for table `stokproduk`
--
ALTER TABLE `stokproduk`
  ADD PRIMARY KEY (`IdStokProduk`),
  ADD KEY `stokproduk_idwarna_foreign` (`IdWarna`),
  ADD KEY `stokproduk_idukuran_foreign` (`IdUkuran`),
  ADD KEY `stokproduk_idproduk_foreign` (`IdProduk`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`IdTransaksi`),
  ADD KEY `transaksi_idkupondiskon_foreign` (`IdKuponDiskon`),
  ADD KEY `transaksi_idpengguna_foreign` (`IdPengguna`),
  ADD KEY `transaksi_idpelanggan_foreign` (`IdPelanggan`);

--
-- Indexes for table `ukuran`
--
ALTER TABLE `ukuran`
  ADD PRIMARY KEY (`IdUkuran`);

--
-- Indexes for table `ulasanproduk`
--
ALTER TABLE `ulasanproduk`
  ADD PRIMARY KEY (`IdUlasanProduk`),
  ADD KEY `ulasanproduk_idpelanggan_foreign` (`IdPelanggan`),
  ADD KEY `ulasanproduk_idproduk_foreign` (`IdProduk`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `warna`
--
ALTER TABLE `warna`
  ADD PRIMARY KEY (`IdWarna`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detailtransaksi`
--
ALTER TABLE `detailtransaksi`
  MODIFY `IdDetailTransaksi` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategoriproduk`
--
ALTER TABLE `kategoriproduk`
  MODIFY `IdKategoriProduk` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `IdPelanggan` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `IdPengguna` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stokproduk`
--
ALTER TABLE `stokproduk`
  MODIFY `IdStokProduk` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `ukuran`
--
ALTER TABLE `ukuran`
  MODIFY `IdUkuran` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ulasanproduk`
--
ALTER TABLE `ulasanproduk`
  MODIFY `IdUlasanProduk` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `warna`
--
ALTER TABLE `warna`
  MODIFY `IdWarna` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detailtransaksi`
--
ALTER TABLE `detailtransaksi`
  ADD CONSTRAINT `detailtransaksi_ibfk_1` FOREIGN KEY (`IdStokProduk`) REFERENCES `stokproduk` (`IdStokProduk`),
  ADD CONSTRAINT `detailtransaksi_idproduk_foreign` FOREIGN KEY (`IdProduk`) REFERENCES `produk` (`IdProduk`),
  ADD CONSTRAINT `detailtransaksi_idtransaksi_foreign` FOREIGN KEY (`IdTransaksi`) REFERENCES `transaksi` (`IdTransaksi`);

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_idkategoriproduk_foreign` FOREIGN KEY (`IdKategoriProduk`) REFERENCES `kategoriproduk` (`IdKategoriProduk`);

--
-- Constraints for table `stokproduk`
--
ALTER TABLE `stokproduk`
  ADD CONSTRAINT `stokproduk_idproduk_foreign` FOREIGN KEY (`IdProduk`) REFERENCES `produk` (`IdProduk`),
  ADD CONSTRAINT `stokproduk_idukuran_foreign` FOREIGN KEY (`IdUkuran`) REFERENCES `ukuran` (`IdUkuran`),
  ADD CONSTRAINT `stokproduk_idwarna_foreign` FOREIGN KEY (`IdWarna`) REFERENCES `warna` (`IdWarna`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_idkupondiskon_foreign` FOREIGN KEY (`IdKuponDiskon`) REFERENCES `kupondiskon` (`IdKuponDiskon`),
  ADD CONSTRAINT `transaksi_idpelanggan_foreign` FOREIGN KEY (`IdPelanggan`) REFERENCES `pelanggan` (`IdPelanggan`),
  ADD CONSTRAINT `transaksi_idpengguna_foreign` FOREIGN KEY (`IdPengguna`) REFERENCES `pengguna` (`IdPengguna`);

--
-- Constraints for table `ulasanproduk`
--
ALTER TABLE `ulasanproduk`
  ADD CONSTRAINT `ulasanproduk_idpelanggan_foreign` FOREIGN KEY (`IdPelanggan`) REFERENCES `pelanggan` (`IdPelanggan`),
  ADD CONSTRAINT `ulasanproduk_idproduk_foreign` FOREIGN KEY (`IdProduk`) REFERENCES `produk` (`IdProduk`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
