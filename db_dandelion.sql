/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 10.4.11-MariaDB : Database - db_dandelion
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_dandelion` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `db_dandelion`;

/*Table structure for table `cart` */

DROP TABLE IF EXISTS `cart`;

CREATE TABLE `cart` (
  `IdCart` int(11) NOT NULL AUTO_INCREMENT,
  `IdPelanggan` int(11) NOT NULL,
  `IdStokProduk` int(11) NOT NULL,
  `Qty` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`IdCart`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4;

/*Data for the table `cart` */

insert  into `cart`(`IdCart`,`IdPelanggan`,`IdStokProduk`,`Qty`,`created_at`,`updated_at`) values 
(18,3,39,1,'2020-07-16 03:19:24','2020-07-16 03:19:24'),
(22,3,27,1,'2020-07-16 03:28:11','2020-07-16 03:28:11');

/*Table structure for table `detailtransaksi` */

DROP TABLE IF EXISTS `detailtransaksi`;

CREATE TABLE `detailtransaksi` (
  `IdDetailTransaksi` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Qty` int(11) NOT NULL,
  `Diskon` int(11) NOT NULL,
  `SubTotal` int(11) NOT NULL,
  `IdProduk` char(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `IdStokProduk` int(10) unsigned NOT NULL,
  `IdTransaksi` char(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`IdDetailTransaksi`),
  KEY `detailtransaksi_idproduk_foreign` (`IdProduk`),
  KEY `detailtransaksi_idtransaksi_foreign` (`IdTransaksi`),
  KEY `IdStokProduk` (`IdStokProduk`),
  CONSTRAINT `detailtransaksi_ibfk_1` FOREIGN KEY (`IdStokProduk`) REFERENCES `stokproduk` (`IdStokProduk`),
  CONSTRAINT `detailtransaksi_idproduk_foreign` FOREIGN KEY (`IdProduk`) REFERENCES `produk` (`IdProduk`),
  CONSTRAINT `detailtransaksi_idtransaksi_foreign` FOREIGN KEY (`IdTransaksi`) REFERENCES `transaksi` (`IdTransaksi`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `detailtransaksi` */

insert  into `detailtransaksi`(`IdDetailTransaksi`,`Qty`,`Diskon`,`SubTotal`,`IdProduk`,`IdStokProduk`,`IdTransaksi`,`created_at`,`updated_at`) values 
(22,1,0,40000,'DB0001',12,'20200714212945','2020-07-14 21:29:45','2020-07-14 21:29:45'),
(23,1,0,70000,'DB0002',15,'20200714212945','2020-07-14 21:29:45','2020-07-14 21:29:45'),
(25,1,0,40000,'DB0001',12,'20200715100748','2020-07-15 10:07:48','2020-07-15 10:07:48'),
(26,1,0,70000,'DB0002',15,'20200715100748','2020-07-15 10:07:48','2020-07-15 10:07:48'),
(27,1,0,40000,'DB0001',12,'20200715100802','2020-07-15 10:08:02','2020-07-15 10:08:02'),
(28,1,0,40000,'DB0001',12,'20200715102531','2020-07-15 10:25:31','2020-07-15 10:25:31'),
(29,1,0,70000,'DB0002',15,'20200715102531','2020-07-15 10:25:31','2020-07-15 10:25:31'),
(32,1,0,40000,'DB0001',12,'20200715104144','2020-07-15 10:41:45','2020-07-15 10:41:45'),
(33,1,0,40000,'DB0001',12,'20200715104240','2020-07-15 10:42:40','2020-07-15 10:42:40'),
(34,1,0,70000,'DB0002',15,'20200715104240','2020-07-15 10:42:40','2020-07-15 10:42:40'),
(35,1,0,40000,'DB0001',12,'20200715143444','2020-07-15 14:34:44','2020-07-15 14:34:44');

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `kategoriproduk` */

DROP TABLE IF EXISTS `kategoriproduk`;

CREATE TABLE `kategoriproduk` (
  `IdKategoriProduk` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `NamaKategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`IdKategoriProduk`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `kategoriproduk` */

insert  into `kategoriproduk`(`IdKategoriProduk`,`NamaKategori`,`created_at`,`updated_at`) values 
(1,'Baju','2020-06-12 23:37:28','2020-06-12 23:37:28'),
(2,'Celana','2020-06-12 23:37:39','2020-06-12 23:37:39'),
(3,'Aksesoriss','2020-07-04 22:34:49','2020-07-04 22:56:16'),
(5,'Jaket','2020-07-15 18:23:27','2020-07-15 18:23:27'),
(6,'Sweater','2020-07-15 18:23:46','2020-07-15 18:23:46'),
(7,'Dress','2020-07-15 18:23:50','2020-07-15 18:23:50'),
(8,'Blazzer','2020-07-15 18:23:55','2020-07-15 18:23:55');

/*Table structure for table `kupondiskon` */

DROP TABLE IF EXISTS `kupondiskon`;

CREATE TABLE `kupondiskon` (
  `IdKuponDiskon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NamaKupon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TglMulai` datetime NOT NULL,
  `TglSelesai` datetime NOT NULL,
  `JumlahPotongan` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`IdKuponDiskon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `kupondiskon` */

insert  into `kupondiskon`(`IdKuponDiskon`,`NamaKupon`,`TglMulai`,`TglSelesai`,`JumlahPotongan`,`created_at`,`updated_at`) values 
('-','-','2020-06-15 00:00:04','2020-05-31 00:00:04',0,'2020-06-15 00:56:24','2020-06-15 00:56:24');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'2014_10_12_000000_create_users_table',1),
(2,'2014_10_12_100000_create_password_resets_table',1),
(3,'2019_08_19_000000_create_failed_jobs_table',1),
(4,'2020_05_21_061907_create_pengguna_table',1),
(5,'2020_05_21_063637_create_kategori_produk_table',1),
(6,'2020_05_21_064049_create_warna_table',1),
(7,'2020_05_21_064050_create_ukuran_table',1),
(8,'2020_05_21_064537_create_kupon_diskon_table',1),
(9,'2020_05_21_064914_create_pelanggan_table',1),
(10,'2020_05_21_071454_create_produk_table',1),
(11,'2020_05_21_074152_create_stok_produk_table',1),
(12,'2020_05_21_074405_create_transaksi_table',1),
(13,'2020_05_21_085234_create_detail_transaksi_table',1),
(14,'2020_05_21_090126_create_ulasan_produk_table',1);

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `pelanggan` */

DROP TABLE IF EXISTS `pelanggan`;

CREATE TABLE `pelanggan` (
  `IdPelanggan` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `NamaPelanggan` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TglLahir` date NOT NULL,
  `JenisKelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`IdPelanggan`),
  UNIQUE KEY `pelanggan_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `pelanggan` */

insert  into `pelanggan`(`IdPelanggan`,`NamaPelanggan`,`TglLahir`,`JenisKelamin`,`email`,`password`,`remember_token`,`Alamat`,`NoHandphone`,`IdKecamatan`,`NamaKecamatan`,`IdKabupaten`,`NamaKabupaten`,`IdProvinsi`,`NamaProvinsi`,`created_at`,`updated_at`) values 
(1,'-','2020-06-01','Laki-laki','-@mail.com','$2y$10$x4tmbGNT4rswFYYzsBF9KOPNThYVenrpKN/bgJ37NU1nXYb9vWB6u',NULL,'-','00000000000',261,'Kuta Utara',17,'Badung',1,'Bali','2020-06-15 00:55:57','2020-06-15 00:55:57'),
(3,'aaaa','2020-07-29','Perempuan','a@a.com','$2y$10$YC3vBXmKtwwylj7JOiwh0.D3mRBhskk8I4feMQHXyybq2AhBho2Au',NULL,'asdasd','083119853063',261,'Kuta Utara',17,'Badung',1,'Bali','2020-07-15 02:41:32','2020-07-15 02:41:32');

/*Table structure for table `pengguna` */

DROP TABLE IF EXISTS `pengguna`;

CREATE TABLE `pengguna` (
  `IdPengguna` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `NamaPengguna` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `NoHandphone` char(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Is_admin` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`IdPengguna`),
  UNIQUE KEY `pengguna_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `pengguna` */

insert  into `pengguna`(`IdPengguna`,`NamaPengguna`,`email`,`password`,`remember_token`,`Alamat`,`NoHandphone`,`Is_admin`,`created_at`,`updated_at`) values 
(1,'Rama','ramaa@gmail.com','$2y$10$vEQ6IedAh/JZs7G9qk/WEehlzubF/.h2vebcANCRCO9LzFaUvKyM6',NULL,'asdasd','083119853063',1,'2020-06-13 11:26:07','2020-06-13 11:26:07');

/*Table structure for table `produk` */

DROP TABLE IF EXISTS `produk`;

CREATE TABLE `produk` (
  `IdProduk` char(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NamaProduk` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `GambarProduk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `HargaPokok` int(11) NOT NULL,
  `HargaJual` int(11) NOT NULL,
  `Berat` int(11) NOT NULL,
  `Deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `IdKategoriProduk` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`IdProduk`),
  KEY `produk_idkategoriproduk_foreign` (`IdKategoriProduk`),
  CONSTRAINT `produk_idkategoriproduk_foreign` FOREIGN KEY (`IdKategoriProduk`) REFERENCES `kategoriproduk` (`IdKategoriProduk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `produk` */

insert  into `produk`(`IdProduk`,`NamaProduk`,`GambarProduk`,`HargaPokok`,`HargaJual`,`Berat`,`Deskripsi`,`IdKategoriProduk`,`created_at`,`updated_at`) values 
('a','ad','no-image.png',2,2,2,'3',1,'2020-07-15 18:32:08','2020-07-15 18:32:08'),
('DB0001','Baju','gogatsu-baju-2.jpg',30000,40000,400,'Barang Bagus',1,'2020-06-15 14:54:46','2020-06-15 14:54:46'),
('DB0002','Celana Jeans','no-image.png',40000,70000,200,'Mantap Pokoknya',2,'2020-06-17 12:34:27','2020-06-17 12:34:27'),
('DB0003','Jaket','hm2-pro-8.jpg',60000,80000,200,'asd',5,'2020-07-15 18:23:02','2020-07-15 18:34:51'),
('DB0004','Dress','pro-6-1.jpg',60000,80000,500,'asdasdasd',7,'2020-07-15 18:26:57','2020-07-15 18:26:57'),
('DB0005','Jaket Bulu','hm2-pro-6.jpg',50000,80000,200,'asdasd',5,'2020-07-15 18:27:59','2020-07-15 18:27:59'),
('DB0006','Baju','hm19-pro-4.jpg',50000,80000,400,'asdasd',1,'2020-07-15 18:36:03','2020-07-15 18:36:03'),
('DB0007','Tes','hm2-pro-7.jpg',5000,8000,32,'234234',7,'2020-07-15 18:36:54','2020-07-15 18:36:54'),
('DB0009','Topi','hm3-pro-4.jpg',50000,55000,300,'asdasdasdsadasd',3,'2020-07-15 18:37:47','2020-07-15 18:37:47'),
('DB0010','Kacamata','hm3-pro-3.jpg',70000,80000,200,'bagusss',3,'2020-07-15 18:41:53','2020-07-15 18:41:53'),
('DB0011','Celana','no-image.png',80000,90000,400,'sadasd',2,'2020-07-15 18:42:55','2020-07-15 18:42:55');

/*Table structure for table `stokproduk` */

DROP TABLE IF EXISTS `stokproduk`;

CREATE TABLE `stokproduk` (
  `IdStokProduk` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `StokMasuk` int(11) NOT NULL,
  `StokKeluar` int(11) NOT NULL,
  `StokAkhir` int(11) NOT NULL,
  `IdWarna` int(10) unsigned NOT NULL,
  `IdUkuran` int(10) unsigned NOT NULL,
  `IdProduk` char(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`IdStokProduk`),
  KEY `stokproduk_idwarna_foreign` (`IdWarna`),
  KEY `stokproduk_idukuran_foreign` (`IdUkuran`),
  KEY `stokproduk_idproduk_foreign` (`IdProduk`),
  CONSTRAINT `stokproduk_idproduk_foreign` FOREIGN KEY (`IdProduk`) REFERENCES `produk` (`IdProduk`),
  CONSTRAINT `stokproduk_idukuran_foreign` FOREIGN KEY (`IdUkuran`) REFERENCES `ukuran` (`IdUkuran`),
  CONSTRAINT `stokproduk_idwarna_foreign` FOREIGN KEY (`IdWarna`) REFERENCES `warna` (`IdWarna`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `stokproduk` */

insert  into `stokproduk`(`IdStokProduk`,`StokMasuk`,`StokKeluar`,`StokAkhir`,`IdWarna`,`IdUkuran`,`IdProduk`,`created_at`,`updated_at`) values 
(12,5,7,-2,1,1,'DB0001','2020-06-15 14:54:46','2020-07-15 14:34:44'),
(14,2,0,2,2,5,'DB0001','2020-06-15 14:54:46','2020-06-15 18:29:59'),
(15,10,5,5,2,3,'DB0002','2020-06-17 12:34:27','2020-07-15 10:42:40'),
(16,0,2,-2,1,4,'DB0002','2020-06-17 12:34:27','2020-07-14 08:35:04'),
(22,4,0,4,3,4,'DB0003','2020-07-15 18:23:02','2020-07-15 18:23:02'),
(23,7,0,7,2,5,'DB0003','2020-07-15 18:23:02','2020-07-15 18:23:02'),
(24,4,0,4,3,3,'DB0004','2020-07-15 18:26:57','2020-07-15 18:26:57'),
(25,5,0,5,4,4,'DB0004','2020-07-15 18:26:57','2020-07-15 18:26:57'),
(26,5,0,5,4,3,'DB0005','2020-07-15 18:27:59','2020-07-15 18:27:59'),
(27,5,0,5,3,4,'DB0005','2020-07-15 18:27:59','2020-07-15 18:27:59'),
(28,5,0,5,6,5,'DB0005','2020-07-15 18:27:59','2020-07-15 18:27:59'),
(29,3,0,3,2,2,'DB0003','2020-07-15 18:32:08','2020-07-15 18:32:08'),
(30,3,0,3,1,1,'a','2020-07-15 18:32:08','2020-07-15 18:32:08'),
(31,4,0,4,1,1,'a','2020-07-15 18:32:08','2020-07-15 18:32:08'),
(32,4,0,4,1,2,'DB0006','2020-07-15 18:36:03','2020-07-15 18:36:03'),
(33,4,0,4,1,4,'DB0006','2020-07-15 18:36:03','2020-07-15 18:36:03'),
(34,34,0,34,1,1,'DB0007','2020-07-15 18:36:54','2020-07-15 18:36:54'),
(35,3,0,3,3,3,'DB0007','2020-07-15 18:36:54','2020-07-15 18:36:54'),
(36,40,0,40,4,7,'DB0009','2020-07-15 18:37:47','2020-07-15 18:37:47'),
(37,10,0,10,7,7,'DB0010','2020-07-15 18:41:53','2020-07-15 18:41:53'),
(38,5,0,5,2,2,'DB0011','2020-07-15 18:42:55','2020-07-15 18:42:55'),
(39,7,0,7,1,3,'DB0003','2020-07-16 02:45:55','2020-07-16 02:45:55');

/*Table structure for table `transaksi` */

DROP TABLE IF EXISTS `transaksi`;

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
  `IdPengguna` int(10) unsigned NOT NULL,
  `IdPelanggan` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`IdTransaksi`),
  KEY `transaksi_idkupondiskon_foreign` (`IdKuponDiskon`),
  KEY `transaksi_idpengguna_foreign` (`IdPengguna`),
  KEY `transaksi_idpelanggan_foreign` (`IdPelanggan`),
  CONSTRAINT `transaksi_idkupondiskon_foreign` FOREIGN KEY (`IdKuponDiskon`) REFERENCES `kupondiskon` (`IdKuponDiskon`),
  CONSTRAINT `transaksi_idpelanggan_foreign` FOREIGN KEY (`IdPelanggan`) REFERENCES `pelanggan` (`IdPelanggan`),
  CONSTRAINT `transaksi_idpengguna_foreign` FOREIGN KEY (`IdPengguna`) REFERENCES `pengguna` (`IdPengguna`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `transaksi` */

insert  into `transaksi`(`IdTransaksi`,`TglTransaksi`,`Total`,`Potongan`,`OngkosKirim`,`NamaEkspedisi`,`GrandTotal`,`MetodePembayaran`,`StatusPembayaran`,`StatusPesanan`,`Snap_token`,`IdKuponDiskon`,`IdPengguna`,`IdPelanggan`,`created_at`,`updated_at`) values 
('20200714212945','2020-07-14 21:29:45',110000,0,0,'-',110000,'BRI',1,3,'-','-',1,1,'2020-07-14 21:29:45','2020-07-14 21:29:45'),
('20200715100748','2020-08-15 10:07:48',110000,0,0,'-',110000,'Cash',1,3,'-','-',1,1,'2020-07-15 10:07:48','2020-07-15 10:07:48'),
('20200715100802','2020-09-15 10:08:02',40000,0,0,'-',40000,'Cash',1,0,'-','-',1,1,'2020-07-15 10:08:02','2020-07-15 10:08:02'),
('20200715102531','2020-07-15 10:25:31',110000,0,0,'-',110000,'Cash',1,3,'-','-',1,1,'2020-07-15 10:25:31','2020-07-15 10:25:31'),
('20200715104144','2020-07-15 10:41:44',110000,0,0,'-',110000,'BCA',1,3,'-','-',1,1,'2020-07-15 10:41:44','2020-07-15 10:41:44'),
('20200715104240','2020-07-15 10:42:40',110000,10000,0,'-',100000,'Cash',1,3,'-','-',1,1,'2020-07-15 10:42:40','2020-07-15 10:42:40'),
('20200715143444','2020-07-15 14:34:44',40000,0,0,'-',40000,'Cash',1,3,'-','-',1,1,'2020-07-15 14:34:44','2020-07-15 14:34:44');

/*Table structure for table `ukuran` */

DROP TABLE IF EXISTS `ukuran`;

CREATE TABLE `ukuran` (
  `IdUkuran` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `NamaUkuran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`IdUkuran`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `ukuran` */

insert  into `ukuran`(`IdUkuran`,`NamaUkuran`,`created_at`,`updated_at`) values 
(1,'XS','2020-06-12 23:38:06','2020-06-12 23:38:06'),
(2,'S','2020-06-12 23:38:10','2020-06-12 23:38:10'),
(3,'M','2020-06-15 14:53:36','2020-06-15 14:53:36'),
(4,'L','2020-06-15 14:53:40','2020-06-15 14:53:40'),
(5,'XL','2020-06-15 14:53:43','2020-06-15 14:53:43'),
(7,'All Size','2020-07-15 18:25:07','2020-07-15 18:25:07');

/*Table structure for table `ulasanproduk` */

DROP TABLE IF EXISTS `ulasanproduk`;

CREATE TABLE `ulasanproduk` (
  `IdUlasanProduk` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Deskripsi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai` int(11) NOT NULL,
  `IdPelanggan` int(10) unsigned NOT NULL,
  `IdProduk` char(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`IdUlasanProduk`),
  KEY `ulasanproduk_idpelanggan_foreign` (`IdPelanggan`),
  KEY `ulasanproduk_idproduk_foreign` (`IdProduk`),
  CONSTRAINT `ulasanproduk_idpelanggan_foreign` FOREIGN KEY (`IdPelanggan`) REFERENCES `pelanggan` (`IdPelanggan`),
  CONSTRAINT `ulasanproduk_idproduk_foreign` FOREIGN KEY (`IdProduk`) REFERENCES `produk` (`IdProduk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `ulasanproduk` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

/*Table structure for table `warna` */

DROP TABLE IF EXISTS `warna`;

CREATE TABLE `warna` (
  `IdWarna` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `NamaWarna` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`IdWarna`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `warna` */

insert  into `warna`(`IdWarna`,`NamaWarna`,`created_at`,`updated_at`) values 
(1,'Merah','2020-06-12 23:37:52','2020-06-12 23:37:52'),
(2,'Hijau','2020-06-12 23:37:57','2020-06-12 23:37:57'),
(3,'Biru','2020-06-15 14:53:21','2020-06-15 14:53:21'),
(4,'Putih','2020-06-15 14:53:27','2020-06-15 14:53:27'),
(6,'Kuning','2020-07-15 18:24:08','2020-07-15 18:24:08'),
(7,'Hitam','2020-07-15 18:24:19','2020-07-15 18:24:19');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
