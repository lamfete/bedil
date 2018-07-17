-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2018 at 09:58 AM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bedil`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `test` (`kartuStokId` VARCHAR(20))  BEGIN    
    DECLARE kartu_stok_id_next VARCHAR(20);
		
	SET kartu_stok_id_next = kartuStokId;
	
	START TRANSACTION;			
		UPDATE kartu_stok
		SET jual_harga = 200
		WHERE kartu_stok_id = kartuStokId;
	COMMIT;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `AUTO_GENERATE_ID_ITEM` (`PARAMTAHUN` DATETIME) RETURNS VARCHAR(10) CHARSET latin1 BEGIN
	DECLARE HASIL INT;
	DECLARE THN VARCHAR(2);
	DECLARE AUTO VARCHAR(10);
	
	SELECT RIGHT(YEAR(PARAMTAHUN), 2) INTO THN;	
	
	SELECT RIGHT(MAX(item_id),6) + 1 INTO HASIL FROM item;
	
		IF HASIL IS NULL THEN
		SET HASIL = 1;
	END IF;
	
	IF (HASIL > 0) AND (HASIL < 10) THEN			
		SET AUTO = CONCAT('BR', THN, '00000', HASIL);
	
	ELSEIF (HASIL >= 10) AND (HASIL < 100) THEN					
		SET AUTO = CONCAT('BR', THN, '0000', HASIL);
	
	ELSEIF (HASIL >= 100) AND (HASIL < 1000) THEN
		SET AUTO = CONCAT('BR', THN, '000', HASIL);
	
	ELSEIF (HASIL >= 1000) AND (HASIL < 10000) THEN
		SET AUTO = CONCAT('BR', THN, '00', HASIL);
	
	ELSEIF (HASIL >= 10000) AND (HASIL < 100000) THEN
		SET AUTO = CONCAT('BR', THN, '0', HASIL);
	
	ELSEIF (HASIL >= 100000) AND (HASIL < 1000000) THEN			
    SET AUTO = CONCAT('BR', THN, HASIL);
	END IF;
	
	RETURN AUTO;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `AUTO_GENERATE_ID_KARTU_STOK` (`PARAMTAHUN` DATETIME) RETURNS VARCHAR(10) CHARSET latin1 BEGIN
	DECLARE HASIL INT;
	DECLARE THN VARCHAR(2);
	DECLARE AUTO VARCHAR(10);
	
	SELECT RIGHT(YEAR(PARAMTAHUN), 2) INTO THN;	
	
	SELECT RIGHT(MAX(kartu_stok_id),6) + 1 INTO HASIL FROM KARTU_STOK;
	
		IF HASIL IS NULL THEN
		SET HASIL = 1;
	END IF;
	
	IF (HASIL > 0) AND (HASIL < 10) THEN			
		SET AUTO = CONCAT('KS', THN, '00000', HASIL);
	
	ELSEIF (HASIL >= 10) AND (HASIL < 100) THEN					
		SET AUTO = CONCAT('KS', THN, '0000', HASIL);
	
	ELSEIF (HASIL >= 100) AND (HASIL < 1000) THEN
		SET AUTO = CONCAT('KS', THN, '000', HASIL);
	
	ELSEIF (HASIL >= 1000) AND (HASIL < 10000) THEN
		SET AUTO = CONCAT('KS', THN, '00', HASIL);
	
	ELSEIF (HASIL >= 10000) AND (HASIL < 100000) THEN
		SET AUTO = CONCAT('KS', THN, '0', HASIL);
	
	ELSEIF (HASIL >= 100000) AND (HASIL < 1000000) THEN			
    SET AUTO = CONCAT('KS', THN, HASIL);
	END IF;
	
	RETURN AUTO;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `AUTO_GENERATE_ID_USER_LOG` (`PARAMTAHUN` DATETIME) RETURNS VARCHAR(10) CHARSET latin1 BEGIN
	DECLARE HASIL INT;
	DECLARE THN VARCHAR(2);
	DECLARE AUTO VARCHAR(10);
    DECLARE KODE VARCHAR(2);
    
    SET KODE = 'UL';
	
	SELECT RIGHT(YEAR(PARAMTAHUN), 2) INTO THN;	
	
	SELECT RIGHT(MAX(user_log_id),6) + 1 INTO HASIL FROM user_log;
	
		IF HASIL IS NULL THEN
		SET HASIL = 1;
	END IF;
	
	IF (HASIL > 0) AND (HASIL < 10) THEN			
		SET AUTO = CONCAT(KODE, THN, '00000', HASIL);
	
	ELSEIF (HASIL >= 10) AND (HASIL < 100) THEN					
		SET AUTO = CONCAT(KODE, THN, '0000', HASIL);
	
	ELSEIF (HASIL >= 100) AND (HASIL < 1000) THEN
		SET AUTO = CONCAT(KODE, THN, '000', HASIL);
	
	ELSEIF (HASIL >= 1000) AND (HASIL < 10000) THEN
		SET AUTO = CONCAT(KODE, THN, '00', HASIL);
	
	ELSEIF (HASIL >= 10000) AND (HASIL < 100000) THEN
		SET AUTO = CONCAT(KODE, THN, '0', HASIL);
	
	ELSEIF (HASIL >= 100000) AND (HASIL < 1000000) THEN			
    SET AUTO = CONCAT(KODE, THN, HASIL);
	END IF;
	
	RETURN AUTO;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `brand_id` int(10) UNSIGNED NOT NULL,
  `type_id` int(10) UNSIGNED DEFAULT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `brand_name` varchar(50) NOT NULL,
  `brand_remark` varchar(100) NOT NULL,
  `brand_status` enum('AKTIF','INAKTIF') NOT NULL DEFAULT 'AKTIF',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`brand_id`, `type_id`, `category_id`, `brand_name`, `brand_remark`, `brand_status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 3, 2, 'SHARP', '-', 'AKTIF', '2018-03-20 14:05:01', 1, NULL, NULL),
(2, 4, 2, 'BENJAMIN', '-', 'AKTIF', '2018-03-20 14:05:01', 1, NULL, NULL),
(3, 8, 3, 'BUSHNELL', '', 'AKTIF', '2018-04-12 15:40:28', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(10) UNSIGNED NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `category_status` enum('AKTIF','INAKTIF') NOT NULL DEFAULT 'AKTIF',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `category_status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'SENAPAN', 'AKTIF', '2017-12-12 14:22:48', 0, NULL, 0),
(2, 'PELURU', 'AKTIF', '2017-12-12 14:22:48', 0, NULL, 0),
(3, 'SCOOP', 'AKTIF', '2018-04-06 16:47:43', 1, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `item_id` varchar(20) NOT NULL,
  `brand_id` int(10) UNSIGNED DEFAULT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `type_id` int(10) UNSIGNED DEFAULT NULL,
  `item_name` varchar(50) NOT NULL,
  `item_remark` varchar(100) NOT NULL,
  `item_status` enum('AKTIF','INAKTIF') NOT NULL DEFAULT 'AKTIF',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`item_id`, `brand_id`, `category_id`, `type_id`, `item_name`, `item_remark`, `item_status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
('BR18000001', 1, 2, 3, 'Silver Bullet 0.2mm', 'Buat bunuh vampir', 'AKTIF', '2018-03-29 12:42:46', 1, '2018-04-02 10:50:34', 1),
('BR18000002', 3, 3, 8, 'Telescope 20cm with infrared', '-', 'AKTIF', '2018-04-12 15:41:05', 1, NULL, NULL);

--
-- Triggers `item`
--
DELIMITER $$
CREATE TRIGGER `ins_item` BEFORE INSERT ON `item` FOR EACH ROW BEGIN
   DECLARE itemId varchar(10);
   
   SELECT AUTO_GENERATE_ID_ITEM(NOW()) INTO itemId;
   SET NEW.item_id = itemId;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `item_price`
--

CREATE TABLE `item_price` (
  `item_id` varchar(20) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kartu_stok`
--

CREATE TABLE `kartu_stok` (
  `kartu_stok_id` varchar(10) NOT NULL,
  `tanggal_transaksi` datetime NOT NULL,
  `item_id` varchar(20) NOT NULL,
  `s_awal_jumlah` int(11) DEFAULT NULL,
  `s_awal_harga` decimal(10,0) DEFAULT NULL,
  `s_awal_total` decimal(10,0) DEFAULT NULL,
  `jual_jumlah` int(11) DEFAULT NULL,
  `jual_harga` decimal(10,0) DEFAULT NULL,
  `jual_total` decimal(10,0) DEFAULT NULL,
  `jual_retur_jumlah` int(11) DEFAULT NULL,
  `jual_retur_harga` decimal(10,0) DEFAULT NULL,
  `jual_retur_total` decimal(10,0) DEFAULT NULL,
  `beli_jumlah` int(11) DEFAULT NULL,
  `beli_harga` decimal(10,0) DEFAULT NULL,
  `beli_total` decimal(10,0) DEFAULT NULL,
  `beli_retur_jumlah` int(11) DEFAULT NULL,
  `beli_retur_harga` decimal(10,0) DEFAULT NULL,
  `beli_retur_total` decimal(10,0) DEFAULT NULL,
  `s_akhir_jumlah` int(11) DEFAULT NULL,
  `s_akhir_harga` decimal(10,0) DEFAULT NULL,
  `s_akhir_total` decimal(10,0) DEFAULT NULL,
  `keterangan` text,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kartu_stok`
--

INSERT INTO `kartu_stok` (`kartu_stok_id`, `tanggal_transaksi`, `item_id`, `s_awal_jumlah`, `s_awal_harga`, `s_awal_total`, `jual_jumlah`, `jual_harga`, `jual_total`, `jual_retur_jumlah`, `jual_retur_harga`, `jual_retur_total`, `beli_jumlah`, `beli_harga`, `beli_total`, `beli_retur_jumlah`, `beli_retur_harga`, `beli_retur_total`, `s_akhir_jumlah`, `s_akhir_harga`, `s_akhir_total`, `keterangan`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
('KS18000001', '2018-01-22 00:00:00', 'BR18000001', 0, '0', '0', 5, '200', '1000', 0, '0', '0', 0, '0', '0', 0, '0', '0', -5, '200', '1000', 'tes trigger', '2018-01-24 00:00:00', NULL, NULL, NULL),
('KS18000002', '2018-04-11 00:00:00', 'BR18000001', -5, '200', '1000', 0, '0', '0', 0, '0', '0', 50, '1000', '5000', 0, '0', '0', 45, '100', '4500', NULL, '2018-04-11 16:00:00', 1, NULL, NULL);

--
-- Triggers `kartu_stok`
--
DELIMITER $$
CREATE TRIGGER `ins_kartu_stok_id` BEFORE INSERT ON `kartu_stok` FOR EACH ROW BEGIN
    DECLARE kartuStokId varchar(10);
    DECLARE harga decimal;
    DECLARE total decimal;
    DECLARE kartu_stok_id_prev VARCHAR(10);
    
        SELECT AUTO_GENERATE_ID_KARTU_STOK(NOW()) INTO kartuStokId;
    SET NEW.kartu_stok_id = kartuStokId;
    
    SELECT kartu_stok_id INTO kartu_stok_id_prev FROM kartu_stok WHERE kartu_stok_id < kartuStokId LIMIT 0,1;
	#CALL test(kartu_stok_id_prev);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE `type` (
  `type_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `type_name` varchar(50) NOT NULL,
  `type_status` enum('AKTIF','INAKTIF') NOT NULL DEFAULT 'AKTIF',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`type_id`, `category_id`, `type_name`, `type_status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1, 'GEJLUK', 'AKTIF', '2017-12-12 14:38:16', 0, NULL, 0),
(2, 1, 'GAS', 'AKTIF', '2017-12-12 14:38:16', 0, NULL, 0),
(3, 2, 'TIMAH', 'AKTIF', '2017-12-12 14:38:16', 0, NULL, 0),
(4, 2, 'KUNINGAN', 'AKTIF', '2017-12-12 14:38:16', 0, NULL, 0),
(8, 3, 'PLASTIK', 'AKTIF', '2018-04-10 15:42:49', 1, '2018-04-10 11:00:47', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_level_id` int(10) UNSIGNED DEFAULT NULL,
  `user_login` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `status` enum('AKTIF','INAKTIF') NOT NULL DEFAULT 'AKTIF',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_level_id`, `user_login`, `name`, `email`, `password`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1, 'lamfete', 'AL', 'lamfete@yahoo.com', '202cb962ac59075b964b07152d234b70', 'AKTIF', '2017-12-12 15:13:55', 0, NULL, 0),
(2, 2, 'benedict', 'Benedict Roxanne', 'benedict@mail.com', '202cb962ac59075b964b07152d234b70', 'AKTIF', '2017-12-13 10:33:53', 0, '2018-03-06 10:57:06', 1),
(3, 3, 'tes', 'tea', 'tes@mail.com', '202cb962ac59075b964b07152d234b70', 'AKTIF', '0000-00-00 00:00:00', 1, NULL, 0),
(4, 2, 'rew', 'rewina', 'rew@mail.com', '202cb962ac59075b964b07152d234b70', 'AKTIF', '0000-00-00 00:00:00', 1, '2018-04-09 10:20:13', 1),
(5, 2, 'yea', 'yesung', 'yesu@mail.com', '202cb962ac59075b964b07152d234b70', 'AKTIF', '0000-00-00 00:00:00', 1, '2018-03-06 10:59:51', 1),
(6, 1, 'hush', 'husk', 'hus@mail.com', '202cb962ac59075b964b07152d234b70', 'AKTIF', '2018-02-27 09:34:47', 1, NULL, 0),
(7, 1, 'bui', 'buu', 'buu@mail.com', '202cb962ac59075b964b07152d234b70', 'AKTIF', '2018-02-27 09:38:05', 1, NULL, 0),
(8, 3, 'weru', 'wereq', 'wer@mail.com', '202cb962ac59075b964b07152d234b70', 'AKTIF', '2018-02-27 09:40:09', 1, NULL, 0),
(9, 3, 'wer', 'weru', 'weru@mail.com', '202cb962ac59075b964b07152d234b70', 'AKTIF', '2018-02-27 09:41:33', 1, NULL, 0),
(10, 1, 'wes', 'wesmar', 'mar@mail.com', '202cb962ac59075b964b07152d234b70', 'AKTIF', '2018-02-27 09:42:49', 1, NULL, 0),
(11, 3, 'yuk', 'yuki', 'yuk@mail.com', '202cb962ac59075b964b07152d234b70', 'AKTIF', '2018-02-27 09:44:16', 1, NULL, 0),
(12, 1, 'beau', 'Beau', 'beau@mail.com', '202cb962ac59075b964b07152d234b70', 'AKTIF', '2018-03-01 07:06:23', 1, NULL, 0),
(13, 2, 'king', 'King', 'king@mail.com', '202cb962ac59075b964b07152d234b70', 'INAKTIF', '2018-03-01 07:08:06', 1, NULL, 0),
(15, 1, 'bul', 'buli', 'bul@mail.com', '202cb962ac59075b964b07152d234b70', 'AKTIF', '2018-03-07 08:08:37', 1, '2018-03-07 08:21:57', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_level`
--

CREATE TABLE `user_level` (
  `user_level_id` int(10) UNSIGNED NOT NULL,
  `user_level_name` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_level`
--

INSERT INTO `user_level` (`user_level_id`, `user_level_name`, `created_at`, `updated_at`) VALUES
(1, 'SUPER ADMINISTRATOR', '2017-12-12 15:10:36', NULL),
(2, 'OWNER', '2017-12-12 15:10:36', NULL),
(3, 'ACCOUNTING', '2017-12-12 15:10:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE `user_log` (
  `user_log_id` varchar(10) NOT NULL,
  `tindakan` varchar(200) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_log`
--

INSERT INTO `user_log` (`user_log_id`, `tindakan`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
('UL18000001', 'CREATE NEW USER', '2018-03-06 05:22:43', 1, NULL, NULL),
('UL18000002', 'CREATE NEW USER dot', '2018-03-06 05:24:15', 1, NULL, NULL),
('UL18000003', 'lamfete CREATE NEW USER bin', '2018-03-06 06:11:24', 1, NULL, NULL),
('UL18000004', 'lamfete DELETE USER hus', '2018-03-06 08:31:51', NULL, NULL, NULL),
('UL18000005', 'lamfete DELETE USER bin', '2018-03-06 08:48:32', NULL, NULL, NULL),
('UL18000006', 'lamfete DELETE USER dot', '2018-03-06 08:51:36', 1, NULL, NULL),
('UL18000007', 'lamfete DELETE USER wir', '2018-03-06 08:53:31', 1, NULL, NULL),
('UL18000008', 'lamfete UPDATE USER benedict', '2018-03-06 10:37:32', NULL, NULL, NULL),
('UL18000009', 'lamfete UPDATE USER benedict', '2018-03-06 10:38:39', NULL, NULL, NULL),
('UL18000010', 'lamfete UPDATE USER benedict', '2018-03-06 10:40:06', 1, NULL, NULL),
('UL18000011', 'lamfete UPDATE USER benedict', '2018-03-06 10:51:43', 1, NULL, NULL),
('UL18000012', 'lamfete UPDATE USER benedict', '2018-03-06 10:57:06', 1, NULL, NULL),
('UL18000013', 'lamfete DELETE USER ', '2018-03-06 10:58:38', 1, NULL, NULL),
('UL18000014', 'lamfete DELETE USER ', '2018-03-06 10:58:47', 1, NULL, NULL),
('UL18000015', 'lamfete DELETE USER ', '2018-03-06 10:58:53', 1, NULL, NULL),
('UL18000016', 'lamfete UPDATE USER yea', '2018-03-06 10:59:51', 1, NULL, NULL),
('UL18000017', 'lamfete CREATE NEW USER bun', '2018-03-07 05:42:39', 1, NULL, NULL),
('UL18000018', 'lamfete UPDATE USER bun', '2018-03-07 05:42:59', 1, NULL, NULL),
('UL18000019', 'lamfete UPDATE USER bun', '2018-03-07 05:43:12', 1, NULL, NULL),
('UL18000020', 'lamfete DELETE USER bun', '2018-03-07 05:44:57', 1, NULL, NULL),
('UL18000021', 'lamfete CREATE NEW USER bul', '2018-03-07 08:08:37', 1, NULL, NULL),
('UL18000022', 'lamfete CREATE NEW USER guk', '2018-03-07 08:11:06', 1, NULL, NULL),
('UL18000023', 'lamfete DELETE USER guk', '2018-03-07 08:21:36', 1, NULL, NULL),
('UL18000024', 'lamfete UPDATE USER bul', '2018-03-07 08:21:57', 1, NULL, NULL),
('UL18000025', 'lamfete CREATE NEW ITEM Silver Bullet 0.1mm', '2018-03-28 11:06:26', 1, NULL, NULL),
('UL18000026', 'lamfete CREATE NEW ITEM Silver Bullet 0.1mm', '2018-03-29 07:42:46', 1, NULL, NULL),
('UL18000027', 'lamfete UPDATE ITEM ', '2018-04-02 10:26:23', 1, NULL, NULL),
('UL18000028', 'lamfete UPDATE ITEM BR18000001', '2018-04-02 10:50:23', 1, NULL, NULL),
('UL18000029', 'lamfete UPDATE ITEM BR18000001', '2018-04-02 10:50:34', 1, NULL, NULL),
('UL18000030', 'lamfete CREATE NEW ITEM Sueb 0.5mm', '2018-04-02 11:02:45', 1, NULL, NULL),
('UL18000031', 'lamfete UPDATE ITEM BR18000002', '2018-04-02 11:03:00', 1, NULL, NULL),
('UL18000032', 'lamfete DELETE ITEM Sueb 0.5mm', '2018-04-02 11:03:43', 1, NULL, NULL),
('UL18000033', 'lamfete CREATE NEW CATEGORY SCOOP', '2018-04-06 11:47:43', 1, NULL, NULL),
('UL18000034', 'lamfete CREATE NEW CATEGORY AKSESORIS', '2018-04-06 11:49:58', 1, NULL, NULL),
('UL18000035', 'lamfete UPDATE CATEGORY ', '2018-04-09 09:04:51', 1, NULL, NULL),
('UL18000036', 'lamfete UPDATE CATEGORY ', '2018-04-09 09:05:15', 1, NULL, NULL),
('UL18000037', 'lamfete UPDATE CATEGORY ', '2018-04-09 09:06:17', 1, NULL, NULL),
('UL18000038', 'lamfete UPDATE CATEGORY ', '2018-04-09 09:08:32', 1, NULL, NULL),
('UL18000039', 'lamfete UPDATE CATEGORY ', '2018-04-09 09:08:49', 1, NULL, NULL),
('UL18000040', 'lamfete UPDATE CATEGORY 4', '2018-04-09 10:13:04', 1, NULL, NULL),
('UL18000041', 'lamfete UPDATE CATEGORY 4', '2018-04-09 10:14:09', 1, NULL, NULL),
('UL18000042', 'lamfete UPDATE CATEGORY 4', '2018-04-09 10:14:44', 1, NULL, NULL),
('UL18000043', 'lamfete DELETE CATEGORY AKSESORIS', '2018-04-09 10:19:39', 1, NULL, NULL),
('UL18000044', 'lamfete UPDATE USER rew', '2018-04-09 10:20:13', 1, NULL, NULL),
('UL18000045', 'lamfete CREATE NEW TYPE PLASTIK', '2018-04-10 09:53:12', 1, NULL, NULL),
('UL18000046', 'lamfete DELETE TYPE ', '2018-04-10 09:56:59', 1, NULL, NULL),
('UL18000047', 'lamfete CREATE NEW TYPE PLASTIK', '2018-04-10 09:57:28', 1, NULL, NULL),
('UL18000048', 'lamfete DELETE TYPE ', '2018-04-10 09:57:36', 1, NULL, NULL),
('UL18000049', 'lamfete CREATE NEW TYPE PLASTIK', '2018-04-10 09:58:54', 1, NULL, NULL),
('UL18000050', 'lamfete DELETE TYPE PLASTIK', '2018-04-10 09:59:00', 1, NULL, NULL),
('UL18000051', 'lamfete CREATE NEW TYPE PLASTIK', '2018-04-10 10:42:49', 1, NULL, NULL),
('UL18000052', 'lamfete UPDATE TYPE PLASTIC', '2018-04-10 10:50:15', 1, NULL, NULL),
('UL18000053', 'lamfete UPDATE TYPE PLASTIC', '2018-04-10 11:00:32', 1, NULL, NULL),
('UL18000054', 'lamfete UPDATE TYPE PLASTIC', '2018-04-10 11:00:39', 1, NULL, NULL),
('UL18000055', 'lamfete UPDATE TYPE PLASTIK', '2018-04-10 11:00:47', 1, NULL, NULL),
('UL18000056', 'lamfete CREATE NEW BRAND Bushnell', '2018-04-10 11:52:30', 1, NULL, NULL),
('UL18000057', 'lamfete DELETE BRAND Bushnell', '2018-04-10 11:55:45', 1, NULL, NULL),
('UL18000058', 'lamfete CREATE NEW BRAND Bushnell', '2018-04-11 08:07:26', 1, NULL, NULL),
('UL18000059', 'lamfete UPDATE BRAND Bushnel', '2018-04-11 09:03:35', 1, NULL, NULL),
('UL18000060', 'lamfete UPDATE BRAND Bushnell', '2018-04-11 09:03:43', 1, NULL, NULL),
('UL18000061', 'lamfete DELETE BRAND Bushnell', '2018-04-11 09:05:17', 1, NULL, NULL),
('UL18000062', 'lamfete CREATE NEW BRAND BUSHNELL', '2018-04-12 10:40:28', 1, NULL, NULL),
('UL18000063', 'lamfete CREATE NEW ITEM Telescope 20cm with infrared', '2018-04-12 10:41:05', 1, NULL, NULL);

--
-- Triggers `user_log`
--
DELIMITER $$
CREATE TRIGGER `ins_user_log` BEFORE INSERT ON `user_log` FOR EACH ROW BEGIN
   DECLARE userLogId varchar(10);
   
   SELECT AUTO_GENERATE_ID_USER_LOG(NOW()) INTO userLogId;
   SET NEW.user_log_id = userLogId;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`brand_id`),
  ADD KEY `brand_id` (`brand_id`,`brand_status`,`created_at`,`created_by`,`updated_at`,`updated_by`),
  ADD KEY `category_id` (`category_id`,`type_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `item_id` (`item_id`,`brand_id`,`category_id`,`item_status`),
  ADD KEY `category_id` (`category_id`,`type_id`,`brand_id`);

--
-- Indexes for table `item_price`
--
ALTER TABLE `item_price`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `item_id` (`item_id`,`created_at`,`created_by`,`updated_at`,`updated_by`);

--
-- Indexes for table `kartu_stok`
--
ALTER TABLE `kartu_stok`
  ADD PRIMARY KEY (`kartu_stok_id`);

--
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`type_id`),
  ADD KEY `type_id` (`type_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_id` (`user_id`,`user_level_id`),
  ADD KEY `user_level_id` (`user_level_id`);

--
-- Indexes for table `user_level`
--
ALTER TABLE `user_level`
  ADD PRIMARY KEY (`user_level_id`);

--
-- Indexes for table `user_log`
--
ALTER TABLE `user_log`
  ADD PRIMARY KEY (`user_log_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `brand_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `type`
--
ALTER TABLE `type`
  MODIFY `type_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `user_level`
--
ALTER TABLE `user_level`
  MODIFY `user_level_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `brand`
--
ALTER TABLE `brand`
  ADD CONSTRAINT `brand_ibfk_1` FOREIGN KEY (`category_id`,`type_id`) REFERENCES `type` (`category_id`, `type_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`category_id`,`type_id`,`brand_id`) REFERENCES `brand` (`category_id`, `type_id`, `brand_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `item_price`
--
ALTER TABLE `item_price`
  ADD CONSTRAINT `item_price_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `type`
--
ALTER TABLE `type`
  ADD CONSTRAINT `type_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`user_level_id`) REFERENCES `user_level` (`user_level_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
