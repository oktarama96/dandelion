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
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8mb4;

/*Data for the table `cart` */

insert  into `cart`(`IdCart`,`IdPelanggan`,`IdStokProduk`,`Qty`,`created_at`,`updated_at`) values 
(84,3,48,3,'2020-08-17 23:17:44','2020-08-17 23:49:06'),
(85,3,36,1,'2020-08-18 22:01:08','2020-08-18 22:01:08');

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
) ENGINE=InnoDB AUTO_INCREMENT=156 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `detailtransaksi` */

insert  into `detailtransaksi`(`IdDetailTransaksi`,`Qty`,`Diskon`,`SubTotal`,`IdProduk`,`IdStokProduk`,`IdTransaksi`,`created_at`,`updated_at`) values 
(25,1,0,40000,'DB0001',12,'20200715100748','2020-07-15 10:07:48','2020-07-15 10:07:48'),
(26,1,0,70000,'DB0002',15,'20200715100748','2020-07-15 10:07:48','2020-07-15 10:07:48'),
(28,1,0,40000,'DB0001',12,'20200715102531','2020-07-15 10:25:31','2020-07-15 10:25:31'),
(29,1,0,70000,'DB0002',15,'20200715102531','2020-07-15 10:25:31','2020-07-15 10:25:31'),
(33,1,0,40000,'DB0001',12,'20200715104240','2020-07-15 10:42:40','2020-07-15 10:42:40'),
(34,1,0,70000,'DB0002',15,'20200715104240','2020-07-15 10:42:40','2020-07-15 10:42:40'),
(35,1,0,40000,'DB0001',12,'20200715143444','2020-07-15 14:34:44','2020-07-15 14:34:44'),
(63,1,0,80000,'DB0003',39,'20200717104957','2020-07-17 10:49:57','2020-07-17 10:49:57'),
(64,1,0,80000,'DB0005',27,'20200717104957','2020-07-17 10:49:57','2020-07-17 10:49:57'),
(65,2,0,180000,'DB0011',38,'20200717104957','2020-07-17 10:49:57','2020-07-17 10:49:57'),
(66,1,0,40000,'DB0001',14,'20200717150508','2020-07-17 15:05:08','2020-07-17 15:05:08'),
(67,1,0,80000,'DB0003',23,'20200717150508','2020-07-17 15:05:08','2020-07-17 15:05:08'),
(68,2,10,72000,'DB0001',14,'20200717154217','2020-07-17 15:42:17','2020-07-17 15:42:17'),
(69,1,0,90000,'DB0011',38,'20200717154217','2020-07-17 15:42:17','2020-07-17 15:42:17'),
(70,1,0,80000,'DB0003',39,'20200717155356','2020-07-17 15:53:57','2020-07-17 15:53:57'),
(71,1,0,80000,'DB0005',27,'20200717155356','2020-07-17 15:53:57','2020-07-17 15:53:57'),
(72,1,0,80000,'DB0010',37,'20200717155356','2020-07-17 15:53:57','2020-07-17 15:53:57'),
(73,1,0,40000,'DB0001',12,'20200801171804','2020-08-01 17:18:04','2020-08-01 17:18:04'),
(74,1,0,40000,'DB0001',12,'20200801191724','2020-08-01 19:17:24','2020-08-01 19:17:24'),
(75,1,0,40000,'DB0001',12,'20200801191939','2020-08-01 19:19:39','2020-08-01 19:19:39'),
(76,1,0,40000,'DB0001',12,'20200801192105','2020-08-01 19:21:05','2020-08-01 19:21:05'),
(88,1,0,40000,'DB0001',12,'20200801195636','2020-08-01 19:56:36','2020-08-01 19:56:36'),
(89,1,0,40000,'DB0001',12,'20200801195653','2020-08-01 19:56:53','2020-08-01 19:56:53'),
(90,1,0,40000,'DB0001',12,'20200801195750','2020-08-01 19:57:50','2020-08-01 19:57:50'),
(91,1,0,40000,'DB0001',12,'20200801195842','2020-08-01 19:58:42','2020-08-01 19:58:42'),
(95,1,0,40000,'DB0001',12,'20200804011707','2020-08-04 01:17:07','2020-08-04 01:17:07'),
(104,1,0,8000,'DB0012',41,'20200808220835','2020-08-08 22:08:35','2020-08-08 22:08:35'),
(105,2,0,18000,'DB0014',47,'20200808222151','2020-08-08 22:21:51','2020-08-08 22:21:51'),
(106,1,0,9000,'DB0014',44,'20200808222652','2020-08-08 22:26:52','2020-08-08 22:26:52'),
(107,1,0,9000,'DB0014',44,'20200808223006','2020-08-08 22:30:06','2020-08-08 22:30:06'),
(108,1,0,8000,'DB0013',43,'20200808225309','2020-08-08 22:53:10','2020-08-08 22:53:10'),
(109,1,0,8000,'DB0013',43,'20200808230710','2020-08-08 23:07:11','2020-08-08 23:07:11'),
(110,1,0,90000,'DB0011',38,'20200808230710','2020-08-08 23:07:11','2020-08-08 23:07:11'),
(111,1,0,80000,'DB0010',37,'20200808230710','2020-08-08 23:07:11','2020-08-08 23:07:11'),
(112,1,0,8000,'DB0007',34,'20200808230710','2020-08-08 23:07:11','2020-08-08 23:07:11'),
(113,1,0,8000,'DB0013',43,'20200808230939','2020-08-08 23:09:39','2020-08-08 23:09:39'),
(114,1,0,8000,'DB0012',40,'20200808231305','2020-08-08 23:13:05','2020-08-08 23:13:05'),
(115,1,0,8000,'DB0013',43,'20200810175731','2020-08-10 17:57:33','2020-08-10 17:57:33'),
(117,1,0,9000,'DB0014',44,'20200813233151','2020-08-13 23:31:51','2020-08-13 23:31:51'),
(122,1,0,9000,'DB0014',44,'20200814005635','2020-08-14 00:56:35','2020-08-14 00:56:35'),
(123,1,0,9000,'DB0014',46,'20200814005635','2020-08-14 00:56:35','2020-08-14 00:56:35'),
(132,1,0,70000,'DB0002',15,'20200814032126','2020-08-14 03:21:26','2020-08-14 03:21:26'),
(135,1,10,63000,'DB0002',15,'20200814033717','2020-08-14 03:37:17','2020-08-14 03:37:17'),
(136,1,10,72000,'DB0004',24,'20200814033854','2020-08-14 03:38:54','2020-08-14 03:38:54'),
(137,1,10,7200,'DB0007',34,'20200814033854','2020-08-14 03:38:54','2020-08-14 03:38:54'),
(138,1,10,72000,'DB0010',37,'20200814034249','2020-08-14 03:42:49','2020-08-14 03:42:49'),
(139,1,10,49500,'DB0009',36,'20200814034249','2020-08-14 03:42:49','2020-08-14 03:42:49'),
(140,1,0,8000,'DB0012',40,'20200814034401','2020-08-14 03:44:01','2020-08-14 03:44:01'),
(142,1,0,9000,'DB0014',44,'20200816174030','2020-08-16 17:40:31','2020-08-16 17:40:31'),
(143,1,0,9000,'DB0014',47,'20200816174030','2020-08-16 17:40:31','2020-08-16 17:40:31'),
(148,1,0,9000,'DB0014',46,'20200816195218','2020-08-16 19:52:18','2020-08-16 19:52:18'),
(150,1,0,40000,'DB0001',12,'20200825184650','2020-08-25 18:46:50','2020-08-25 18:46:50'),
(151,1,10,72000,'DB0006',32,'20200826151847','2020-08-26 15:18:47','2020-08-26 15:18:47'),
(152,1,10,63000,'DB0002',15,'20200826151847','2020-08-26 15:18:47','2020-08-26 15:18:47'),
(153,2,0,160000,'DB0006',32,'20200826152647','2020-08-26 15:26:47','2020-08-26 15:26:47'),
(154,2,0,18000,'DB0014',44,'20200831142727','2020-08-31 14:27:27','2020-08-31 14:27:27'),
(155,1,0,80000,'DB0015',53,'20200831145359','2020-08-31 14:53:59','2020-08-31 14:53:59');

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `kategoriproduk` */

insert  into `kategoriproduk`(`IdKategoriProduk`,`NamaKategori`,`created_at`,`updated_at`) values 
(1,'Baju','2020-06-12 23:37:28','2020-06-12 23:37:28'),
(2,'Celana','2020-06-12 23:37:39','2020-06-12 23:37:39'),
(3,'Aksesoris','2020-07-04 22:34:49','2020-08-25 18:34:10'),
(5,'Jaket','2020-07-15 18:23:27','2020-07-15 18:23:27'),
(6,'Sweater','2020-07-15 18:23:46','2020-07-15 18:23:46'),
(7,'Dress','2020-07-15 18:23:50','2020-07-15 18:23:50'),
(8,'Blazzer','2020-07-15 18:23:55','2020-07-15 18:23:55'),
(9,'Kaoss','2020-08-26 15:10:51','2020-08-26 15:10:59');

/*Table structure for table `kupondiskon` */

DROP TABLE IF EXISTS `kupondiskon`;

CREATE TABLE `kupondiskon` (
  `IdKuponDiskon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NamaKupon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TglMulai` datetime NOT NULL,
  `TglSelesai` datetime NOT NULL,
  `JumlahPotongan` int(11) NOT NULL,
  `MinimalTotal` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`IdKuponDiskon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `kupondiskon` */

insert  into `kupondiskon`(`IdKuponDiskon`,`NamaKupon`,`TglMulai`,`TglSelesai`,`JumlahPotongan`,`MinimalTotal`,`created_at`,`updated_at`) values 
('-','-','2020-06-15 00:00:04','2020-05-31 00:00:04',0,0,'2020-06-15 00:56:24','2020-06-15 00:56:24'),
('17AUG','17 Agustus Sale','2020-08-01 00:00:11','2020-08-31 23:55:12',17000,50000,'2020-08-13 23:55:45','2020-08-13 23:56:47'),
('SEMINAR','Seminar Oktarama','2020-08-26 00:00:39','2020-08-29 15:10:39',10000,50000,'2020-08-26 15:15:24','2020-08-26 15:15:24'),
('TES','Tes','2019-01-01 00:00:06','2030-12-31 23:55:06',1000,10000,'2020-08-01 22:06:36','2020-08-14 00:41:07');

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `pelanggan` */

insert  into `pelanggan`(`IdPelanggan`,`NamaPelanggan`,`TglLahir`,`JenisKelamin`,`email`,`password`,`remember_token`,`Alamat`,`NoHandphone`,`IdKecamatan`,`NamaKecamatan`,`IdKabupaten`,`NamaKabupaten`,`IdProvinsi`,`NamaProvinsi`,`created_at`,`updated_at`) values 
(1,'-','2020-06-01','Laki-laki','-@mail.com','$2y$10$x4tmbGNT4rswFYYzsBF9KOPNThYVenrpKN/bgJ37NU1nXYb9vWB6u',NULL,'-','00000000000',261,'Kuta Utara',17,'Badung',1,'Bali','2020-06-15 00:55:57','2020-06-15 00:55:57'),
(3,'Pandika Pinata','2020-07-29','Laki-laki','a@a.com','$2y$10$Qxwo0Uqwn0SV2Kj/Zw8o/uFVqZzJ//KrLKKY4AA/js4tavVR6qrwe',NULL,'asdasdasdasdasdasd','083119853063',261,'Kuta Utara',17,'Badung',1,'Bali','2020-07-15 02:41:32','2020-08-08 09:43:58'),
(4,'oktarama','1997-10-12','Laki-laki','oktarama@gmail.com','$2y$10$rq61Io0Lj/zBjkb1FauWdOniFxVtxBwTXDhRQjnCG260gQhTXVxX6',NULL,'Jln Raya Padang Luwih','083119853063',261,'Kuta Utara',17,'Badung',1,'Bali','2020-08-05 13:20:33','2020-08-05 13:20:33'),
(5,'asd','2020-08-26','Perempuan','asd@asd.asd','$2y$10$DBxLNHgWiDxfs0Ia6Py5s.F5zjTCQWbSvrqr5.vBXekyYigoCL8cW',NULL,'asdasd','083119853063',1924,'Kayoa',139,'Halmahera Selatan',20,'Maluku Utara','2020-08-05 13:23:21','2020-08-05 13:23:21'),
(6,'zccvx','2020-08-26','Perempuan','xcv@ad.asd','$2y$10$g86bRuPFKaz7OlzriEQRKO5hZHTulBZm99yfHalFEFrs.lq2pRgNK',NULL,'asdasd','083119853063',2099,'Menteng',152,'Jakarta Pusat',6,'DKI Jakarta','2020-08-05 13:28:10','2020-08-05 13:28:10'),
(7,'Percobaan','1997-10-08','Laki-laki','percobaan@gmail.com','$2y$10$FXJgOF/hCRu4wmVE94kz5OykG1kG1VrAFSfgxMWIgyrHgE6JHLZiW',NULL,'asdsaasd','083119853063',1574,'Denpasar Selatan',114,'Denpasar',1,'Bali','2020-08-25 18:52:18','2020-08-25 18:52:18'),
(8,'Oktarama Bagus','1997-10-12','Laki-laki','ramabagus@gmail.com','$2y$10$GCrgKEo7dmxXVLMR.Lk3guu2xFqkCBAxspjsrdmngFPFOFeKAz2JS',NULL,'padang luwih','083119853063',1573,'Denpasar Barat',114,'Denpasar',1,'Bali','2020-08-26 15:23:49','2020-08-26 15:23:49'),
(9,'Sidang rama','2020-08-05','Laki-laki','sidang@gmail.com','$2y$10$YcA3rDLzvYQCOGuSX3kkMOcSeqVUYyv5thcVT8Bg3.vX/zm0SZvD.',NULL,'jalan raya puputan','083119853063',1575,'Denpasar Timur',114,'Denpasar',1,'Bali','2020-08-31 14:21:44','2020-08-31 14:35:33');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `pengguna` */

insert  into `pengguna`(`IdPengguna`,`NamaPengguna`,`email`,`password`,`remember_token`,`Alamat`,`NoHandphone`,`Is_admin`,`created_at`,`updated_at`) values 
(0,'Online','online@online.com','$2y$10$2E3S/T3Undb2CRWkjFQU1OK5OXnsQM0cny/ZfirJ7vnbCw6IClIkC',NULL,'112334','123123',0,'2020-07-17 15:06:15','2020-07-17 15:06:15'),
(1,'Rama','admin@dfs.com','$2b$10$gP6bvhHjjTxHZoIbXQh9ee9nuOhIqMsjtkwLLNmB6E.l38mO7JbhK',NULL,'asdasdsd','083119853063',1,'2020-06-13 11:26:07','2020-08-17 08:57:59'),
(4,'Bagus','kasir@dfs.com','$2y$10$2xZ8e4haQV4fg95rZawvtuJaFR/Ir3Xn9Ta1ck/O3YahMt5cJh8g.',NULL,'Jln Raya Abianbase','083119853063',0,'2020-08-17 00:53:19','2020-08-17 09:50:02'),
(6,'Sidang Admin 2','sidang@gmail.com','$2y$10$ReHUycu7H0j7DtMHz8dmxejQkAjUiIzQiWsOzX/1J97H4XpWbhQq6',NULL,'jalan raya puputan','083119853063',1,'2020-08-31 14:39:53','2020-08-31 14:40:21');

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
('DB0001','Baju','gogatsu-baju-2.jpg',30000,40000,400,'Barang Bagus',1,'2020-06-15 14:54:46','2020-06-15 14:54:46'),
('DB0002','Celana Jeans','no-image.png',40000,70000,200,'Mantap Pokoknya',2,'2020-06-17 12:34:27','2020-06-17 12:34:27'),
('DB0003','Jaket','hm2-pro-8.jpg',60000,80000,200,'ini deskripsinya',5,'2020-07-15 18:23:02','2020-08-17 09:36:40'),
('DB0004','Jaket','pro-6-1.jpg',60000,80000,500,'asdasdasd',5,'2020-07-15 18:26:57','2020-08-25 18:37:36'),
('DB0005','Dress','hm2-pro-6.jpg',50000,80000,200,'asdasd',7,'2020-07-15 18:27:59','2020-08-25 18:36:39'),
('DB0006','Baju','hm19-pro-4.jpg',50000,80000,400,'asdasd',1,'2020-07-15 18:36:03','2020-07-15 18:36:03'),
('DB0007','Dress','no-image.png',5000,8000,32,'234234',7,'2020-07-15 18:36:54','2020-08-17 11:37:16'),
('DB0009','Topi','hm3-pro-4.jpg',50000,55000,300,'asdasdasdsadasd',3,'2020-07-15 18:37:47','2020-07-15 18:37:47'),
('DB0010','Kacamata','hm3-pro-3.jpg',70000,80000,200,'bagusss',3,'2020-07-15 18:41:53','2020-07-15 18:41:53'),
('DB0011','Celana','no-image.png',80000,90000,400,'sadasd',2,'2020-07-15 18:42:55','2020-07-15 18:42:55'),
('DB0012','Baju 1','no-image.png',5000,8000,100,'asdasdasdasd',1,'2020-08-06 16:31:13','2020-08-06 16:31:13'),
('DB0013','Baju 2','no-image.png',6000,8000,100,'asdsad',1,'2020-08-06 16:31:41','2020-08-06 16:31:41'),
('DB0014','baju 3','no-image.png',3000,9000,100,'asdasd',1,'2020-08-06 16:32:11','2020-08-06 16:32:11'),
('DB0015','Dress','hm27-pro-2.jpg',50000,80000,100,'Ini merupakan jenis produk dengan kategori Dress',7,'2020-08-31 14:43:56','2020-08-31 14:43:56');

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
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `stokproduk` */

insert  into `stokproduk`(`IdStokProduk`,`StokMasuk`,`StokKeluar`,`StokAkhir`,`IdWarna`,`IdUkuran`,`IdProduk`,`created_at`,`updated_at`) values 
(12,58,14,44,1,1,'DB0001','2020-06-15 14:54:46','2020-08-25 18:46:50'),
(14,52,3,49,2,5,'DB0001','2020-06-15 14:54:46','2020-08-17 09:34:35'),
(15,11,7,4,2,3,'DB0002','2020-06-17 12:34:27','2020-08-26 15:18:47'),
(16,5,2,3,1,4,'DB0002','2020-06-17 12:34:27','2020-08-25 18:35:29'),
(22,4,0,4,3,4,'DB0003','2020-07-15 18:23:02','2020-07-15 18:23:02'),
(23,7,1,6,2,5,'DB0003','2020-07-15 18:23:02','2020-07-17 15:05:08'),
(24,4,1,3,7,3,'DB0004','2020-07-15 18:26:57','2020-08-25 18:38:57'),
(25,6,0,6,7,4,'DB0004','2020-07-15 18:26:57','2020-08-25 18:38:57'),
(26,5,0,5,7,3,'DB0005','2020-07-15 18:27:59','2020-08-25 18:36:39'),
(27,5,0,5,7,4,'DB0005','2020-07-15 18:27:59','2020-08-25 18:36:39'),
(28,5,0,5,7,5,'DB0005','2020-07-15 18:27:59','2020-08-25 18:36:39'),
(29,3,0,3,2,2,'DB0003','2020-07-15 18:32:08','2020-07-15 18:32:08'),
(32,4,3,1,1,2,'DB0006','2020-07-15 18:36:03','2020-08-26 15:26:47'),
(33,4,0,4,1,4,'DB0006','2020-07-15 18:36:03','2020-07-15 18:36:03'),
(34,34,2,32,1,1,'DB0007','2020-07-15 18:36:54','2020-08-14 03:38:54'),
(35,3,0,3,3,3,'DB0007','2020-07-15 18:36:54','2020-07-15 18:36:54'),
(36,41,1,40,4,7,'DB0009','2020-07-15 18:37:47','2020-08-17 13:16:28'),
(37,10,2,8,7,7,'DB0010','2020-07-15 18:41:53','2020-08-14 03:42:49'),
(38,5,2,3,2,2,'DB0011','2020-07-15 18:42:55','2020-08-08 23:07:11'),
(39,7,0,7,1,3,'DB0003','2020-07-16 02:45:55','2020-07-16 02:45:55'),
(40,3,2,1,2,3,'DB0012','2020-08-06 16:31:13','2020-08-14 03:44:01'),
(41,12,1,11,4,4,'DB0012','2020-08-06 16:31:13','2020-08-11 11:46:28'),
(42,0,0,0,3,3,'DB0013','2020-08-06 16:31:41','2020-08-13 22:08:17'),
(43,4,4,0,6,5,'DB0013','2020-08-06 16:31:41','2020-08-10 17:57:33'),
(44,7,7,0,2,2,'DB0014','2020-08-06 16:32:11','2020-08-31 14:27:27'),
(45,4,0,4,4,3,'DB0014','2020-08-06 16:32:11','2020-08-11 11:39:44'),
(46,6,2,4,4,1,'DB0014','2020-08-08 17:11:01','2020-08-16 19:52:18'),
(47,9,3,6,2,3,'DB0014','2020-08-08 17:32:59','2020-08-16 20:49:24'),
(53,5,1,4,1,3,'DB0015','2020-08-31 14:43:56','2020-08-31 14:53:59'),
(54,5,0,5,3,4,'DB0015','2020-08-31 14:43:56','2020-08-31 14:43:56');

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
  CONSTRAINT `transaksi_idpelanggan_foreign` FOREIGN KEY (`IdPelanggan`) REFERENCES `pelanggan` (`IdPelanggan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `transaksi` */

insert  into `transaksi`(`IdTransaksi`,`TglTransaksi`,`Total`,`Potongan`,`OngkosKirim`,`NamaEkspedisi`,`GrandTotal`,`MetodePembayaran`,`StatusPembayaran`,`StatusPesanan`,`Snap_token`,`IdKuponDiskon`,`IdPengguna`,`IdPelanggan`,`created_at`,`updated_at`) values 
('20200715100748','2020-08-15 10:07:48',110000,0,0,'-',110000,'Cash',1,3,'-','-',1,1,'2020-07-15 10:07:48','2020-07-15 10:07:48'),
('20200715102531','2020-07-15 10:25:31',110000,0,0,'-',110000,'Cash',1,3,'-','-',1,1,'2020-07-15 10:25:31','2020-07-15 10:25:31'),
('20200715104240','2020-07-15 10:42:40',110000,10000,0,'-',100000,'Cash',1,3,'-','-',1,1,'2020-07-15 10:42:40','2020-07-15 10:42:40'),
('20200715143444','2020-07-15 14:34:44',40000,0,0,'-',40000,'Cash',1,3,'-','-',1,1,'2020-07-15 14:34:44','2020-07-15 14:34:44'),
('20200717104957','2020-07-17 10:49:57',340000,0,8000,'CTC',348000,'Midtrans',1,3,'','-',1,3,'2020-07-17 10:49:57','2020-08-08 20:59:38'),
('20200717150508','2020-07-17 15:05:08',120000,10000,0,'-',110000,'Cash',1,3,'-','-',1,1,'2020-07-17 15:05:08','2020-07-17 15:05:08'),
('20200717154217','2020-07-17 15:42:17',162000,2000,0,'-',160000,'Cash',1,3,'-','-',1,1,'2020-07-17 15:42:17','2020-07-17 15:42:17'),
('20200717155356','2020-07-17 15:53:56',240000,0,18000,'CTCYES',258000,'Midtrans',1,1,'','-',1,3,'2020-07-17 15:53:56','2020-08-04 10:43:42'),
('20200801171804','2020-08-01 17:18:04',40000,0,0,'-',40000,'Cash',1,3,'-','-',1,1,'2020-08-01 17:18:04','2020-08-01 17:18:04'),
('20200801191724','2020-08-01 19:17:24',40000,0,0,'-',40000,'Cash',1,3,'-','-',1,1,'2020-08-01 19:17:24','2020-08-01 19:17:24'),
('20200801191939','2020-08-01 19:19:39',40000,0,0,'-',40000,'Cash',1,3,'-','-',1,1,'2020-08-01 19:19:39','2020-08-01 19:19:39'),
('20200801192105','2020-08-01 19:21:05',40000,0,0,'-',40000,'Cash',1,3,'-','-',1,1,'2020-08-01 19:21:05','2020-08-01 19:21:05'),
('20200801195636','2020-08-01 19:56:36',40000,0,0,'-',40000,'Cash',1,3,'-','-',1,1,'2020-08-01 19:56:36','2020-08-01 19:56:36'),
('20200801195653','2020-08-01 19:56:53',40000,0,0,'-',40000,'Cash',1,3,'-','-',1,1,'2020-08-01 19:56:53','2020-08-01 19:56:53'),
('20200801195750','2020-08-01 19:57:50',40000,0,0,'-',40000,'Cash',1,3,'-','-',1,1,'2020-08-01 19:57:50','2020-08-01 19:57:50'),
('20200801195842','2020-08-01 19:58:42',40000,0,0,'-',40000,'Cash',1,3,'-','-',1,1,'2020-08-01 19:58:42','2020-08-01 19:58:42'),
('20200804011707','2020-08-04 01:17:07',40000,10000,0,'-',30000,'Cash',1,3,'-','-',1,1,'2020-08-04 01:17:07','2020-08-04 01:17:07'),
('20200808133320','2020-08-08 13:33:20',8000,0,8000,'JNE - CTC',16000,'Midtrans',1,4,'642df3b1-dee2-4fa0-aa48-6567dbfc0c4d','-',1,3,'2020-08-08 13:33:20','2020-08-11 11:46:28'),
('20200808193525','2020-08-08 19:35:25',17000,0,18000,'CTCYES',35000,'Midtrans',4,4,'b50b5583-652a-45f4-b00e-5bf8cc87a238','-',1,3,'2020-08-08 19:35:26','2020-08-11 11:39:44'),
('20200808220835','2020-08-08 22:08:35',8000,0,18000,'JNE - CTCYES',26000,'Midtrans',4,0,'3f7c54b7-c22c-4098-b19a-44f768131b09','-',0,3,'2020-08-08 22:08:35','2020-08-09 00:08:38'),
('20200808222151','2020-08-08 22:21:51',18000,0,8000,'JNE - CTC',26000,'Midtrans',4,0,'9a4a191b-89e6-4703-b56a-6bff2e3b111a','-',0,3,'2020-08-08 22:21:51','2020-08-09 00:21:58'),
('20200808222652','2020-08-08 22:26:52',9000,0,18000,'JNE - CTCYES',27000,'Midtrans',4,0,'0adac3d2-366d-4114-a379-052757e63763','-',0,3,'2020-08-08 22:26:52','2020-08-09 00:26:59'),
('20200808223006','2020-08-08 22:30:06',9000,0,8000,'JNE - CTC',17000,'Midtrans',4,0,'0e032973-ab5f-48bc-82f5-27aafcbbf7d5','-',0,3,'2020-08-08 22:30:06','2020-08-09 00:30:08'),
('20200808225309','2020-08-08 22:53:09',8000,0,18000,'JNE - CTCYES',26000,'Midtrans',4,0,'70032c1d-e9c8-4b9a-b6ab-f2e2c69e9c40','-',0,3,'2020-08-08 22:53:10','2020-08-09 00:53:18'),
('20200808230710','2020-08-08 23:07:10',186000,0,18000,'JNE - CTCYES',204000,'Midtrans',4,0,'24193eac-b87e-4995-9c19-72149b45a716','-',0,3,'2020-08-08 23:07:11','2020-08-09 01:07:19'),
('20200808230939','2020-08-08 23:09:39',8000,0,8000,'JNE - CTC',16000,'Midtrans',1,3,'b15d5570-80f1-4585-94f8-e652bfa3ad12','-',1,3,'2020-08-08 23:09:39','2020-08-08 23:29:31'),
('20200808231305','2020-08-08 23:13:05',8000,0,8000,'JNE - CTC',16000,'Midtrans',4,0,'997fb570-8119-4a1f-80a8-b9ed8595567b','-',0,3,'2020-08-08 23:13:05','2020-08-09 01:13:09'),
('20200810175731','2020-08-10 17:57:31',8000,0,18000,'JNE - CTCYES',26000,'Midtrans',2,0,'da5b659d-2892-403a-b4fd-1f07bba4a0a3','-',0,3,'2020-08-10 17:57:33','2020-08-10 17:57:48'),
('20200810175856','2020-08-10 17:58:56',9000,0,8000,'JNE - CTC',17000,'Midtrans',4,0,'1921ef3a-18a6-40cb-922a-8d0b956325f6','-',0,3,'2020-08-10 17:58:56','2020-08-10 18:01:02'),
('20200813233151','2020-08-13 23:31:51',9000,0,8000,'JNE - CTC',17000,'Midtrans',0,0,'a463dfe5-1b20-4df5-8f17-63ccbfd836e5','-',0,3,'2020-08-13 23:31:51','2020-08-13 23:31:51'),
('20200814005635','2020-08-14 00:56:35',18000,1000,8000,'JNE - CTC',25000,'Midtrans',1,3,'0a3ee0aa-fb3b-4e5b-942e-58f6b7cae494','TES',1,3,'2020-08-14 00:56:35','2020-08-14 00:58:36'),
('20200814032126','2020-08-14 03:21:26',70000,10000,0,'-',60000,'Cash',1,3,'-','-',1,1,'2020-08-14 03:21:26','2020-08-14 03:21:26'),
('20200814033717','2020-08-14 03:37:17',63000,3000,0,'-',60000,'Cash',1,3,'-','-',1,1,'2020-08-14 03:37:17','2020-08-14 03:37:17'),
('20200814033854','2020-08-14 03:38:54',79200,200,0,'-',79000,'Cash',1,3,'-','-',1,1,'2020-08-14 03:38:54','2020-08-14 03:38:54'),
('20200814034249','2020-08-14 03:42:49',121500,1500,0,'-',120000,'Cash',1,3,'-','-',1,1,'2020-08-14 03:42:49','2020-08-14 03:42:49'),
('20200814034401','2020-08-14 03:44:01',8000,0,0,'-',8000,'Cash',1,3,'-','-',1,1,'2020-08-14 03:44:01','2020-08-14 03:44:01'),
('20200816174030','2020-08-16 17:40:30',18000,0,8000,'JNE - CTC',26000,'Midtrans',0,0,'689b8fc2-62de-4f8b-93d0-f41a04ea3976','-',0,3,'2020-08-16 17:40:31','2020-08-16 17:40:31'),
('20200816194137','2020-08-16 19:41:37',9000,0,8000,'JNE - CTC',17000,'Midtrans',4,4,'ac4e6713-9f77-4a2d-8876-d3e8ed299796','-',0,3,'2020-08-16 19:41:38','2020-08-16 20:11:44'),
('20200816194730','2020-08-16 19:47:30',9000,0,8000,'JNE - CTC',17000,'Midtrans',4,4,'462673fe-1867-4264-ac59-72f1a6850e13','-',0,3,'2020-08-16 19:47:31','2020-08-16 20:47:35'),
('20200816194915','2020-08-16 19:49:15',9000,0,8000,'JNE - CTC',17000,'Midtrans',4,4,'9e773da4-6fde-45f7-a698-6528c36c5e96','-',0,3,'2020-08-16 19:49:15','2020-08-16 20:49:24'),
('20200816195038','2020-08-16 19:50:38',9000,0,8000,'JNE - CTC',17000,'Midtrans',4,4,'13dd0277-7667-40c4-8009-f5f1ce70f640','-',0,3,'2020-08-16 19:50:38','2020-08-16 20:20:44'),
('20200816195218','2020-08-16 19:52:18',9000,0,8000,'JNE - CTC',17000,'Midtrans',1,2,'f91614b2-bcbc-4a78-be48-5fda148b6704','-',1,3,'2020-08-16 19:52:18','2020-08-16 19:55:28'),
('20200817124620','2020-08-17 12:46:20',55000,1000,8000,'JNE - CTC',62000,'Midtrans',4,4,'88b8a43f-3d3e-4a2c-9184-f579d6722912','TES',0,3,'2020-08-17 12:46:20','2020-08-17 13:16:28'),
('20200825184650','2020-08-25 18:46:50',40000,0,0,'-',40000,'Cash',1,3,'-','-',1,1,'2020-08-25 18:46:50','2020-08-25 18:46:50'),
('20200826151847','2020-08-26 15:18:47',135000,5000,0,'-',130000,'Cash',1,3,'-','-',1,1,'2020-08-26 15:18:47','2020-08-26 15:18:47'),
('20200826152647','2020-08-26 15:26:47',160000,10000,11000,'JNE - OKE',161000,'Midtrans',1,3,'f509e6e7-fe97-44d3-9a01-ad3fb306d92b','SEMINAR',4,8,'2020-08-26 15:26:47','2020-08-26 15:29:45'),
('20200831142727','2020-08-31 14:27:27',18000,1000,11000,'JNE - OKE',28000,'Midtrans',1,3,'a38f62c3-93f9-4bc7-bf8f-6126eaba9509','TES',1,9,'2020-08-31 14:27:27','2020-08-31 14:34:35'),
('20200831145359','2020-08-31 14:53:59',80000,0,0,'-',80000,'Cash',1,3,'-','-',4,1,'2020-08-31 14:53:59','2020-08-31 14:53:59');

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
