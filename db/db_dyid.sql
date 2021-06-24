-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2021 at 12:13 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_dyid`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `hapusadmin` (IN `idadmin` VARCHAR(200))  BEGIN
DELETE FROM tb_admin WHERE id_admin=idadmin;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `hapusbarang` (IN `namabarang` VARCHAR(200))  BEGIN
DELETE FROM tb_barang WHERE nama_barang=namabuku;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `order_barang` (IN `idbarang` INT(32), IN `ubah_stok` INT(32), IN `nama_pembeli` VARCHAR(64))  UPDATE tb_barang 
SET  
stok=stok-ubah_stok,
pembeli_terakhir = nama_pembeli
WHERE id_barang=idbarang$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_admin` (IN `username` VARCHAR(30), IN `password` VARCHAR(30), IN `nama` VARCHAR(30))  BEGIN
INSERT INTO tb_admin
VALUES(NULL, username, password, nama);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_barang` (IN `id_barang` VARCHAR(30), IN `nama_barang` VARCHAR(30), IN `supplier` VARCHAR(30), IN `harga` INT(30), IN `stok` INT(5))  BEGIN
INSERT INTO tb_barang
VALUES(NULL,id_barang, nama_barang, supplier, harga, stok, NULL);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_admin` (IN `idadmin` VARCHAR(10), IN `Username` VARCHAR(100), IN `password` VARCHAR(160), IN `Nama` VARCHAR(50))  BEGIN
UPDATE tb_admin 
SET  
username
=Username, password_= password, nama = Nama
WHERE id_admin=idadmin;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_barang` (IN `idBarang` INT(10), IN `Harga` INT(16), IN `Stok` INT(5))  BEGIN
UPDATE tb_barang 
SET  
stok=Stok, harga = Harga
WHERE id_barang=idBarang;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `NamaBrand` (`id` VARCHAR(20)) RETURNS VARCHAR(20) CHARSET utf8mb4 BEGIN
   DECLARE nama VARCHAR(20);
   SELECT nama_brand INTO nama FROM tb_brand WHERE id_brand = id;
   RETURN nama;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `brand`
-- (See below for the actual view)
--
CREATE TABLE `brand` (
`id_brand` varchar(10)
,`nama_brand` varchar(200)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `jumlahterjual`
-- (See below for the actual view)
--
CREATE TABLE `jumlahterjual` (
`jumlah_terjual` decimal(51,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `jumlah_stok`
-- (See below for the actual view)
--
CREATE TABLE `jumlah_stok` (
`stok_barang` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `jumlah_terjual`
-- (See below for the actual view)
--
CREATE TABLE `jumlah_terjual` (
`jumlah_terjual` decimal(51,0)
);

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id_admin` int(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_` varchar(50) NOT NULL,
  `nama` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`id_admin`, `username`, `password_`, `nama`) VALUES
(3, 'david', '190441100060', 'David Nasrulloh');

-- --------------------------------------------------------

--
-- Table structure for table `tb_barang`
--

CREATE TABLE `tb_barang` (
  `id_barang` int(10) NOT NULL,
  `id_brand` varchar(10) NOT NULL,
  `nama_barang` varchar(200) NOT NULL,
  `supplier` varchar(200) NOT NULL,
  `harga` int(10) NOT NULL,
  `stok` int(10) NOT NULL,
  `pembeli_terakhir` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_barang`
--

INSERT INTO `tb_barang` (`id_barang`, `id_brand`, `nama_barang`, `supplier`, `harga`, `stok`, `pembeli_terakhir`) VALUES
(2, '2', 'Keyboard ', 'Toko Makmur Sentosa', 300000, 18, 'Dika'),
(3, '3', 'Hardisk Drive', 'Toko Jaya Sentosa', 700000, 75, 'David'),
(4, '4', 'Flash Drive', 'Toko Makmur Abadi', 15000, 12, 'Dimas Zulkarnain'),
(5, '5', 'Floppy Disk', 'Toko Jaya Abadi', 5000, 11, 'David N'),
(6, '6', 'PC Gaming', 'Toko Makmur Jaya', 20000000, 29, 'Dimas Sentosa'),
(7, '7', 'Laptop SNSV RGB', 'Toko Sentosa Abadi', 15000000, 32, 'Dimas Labrett'),
(8, '8', 'Laptop Leknovi RGB', 'Toko Sentosa', 10000000, 76, 'Dimas Hikky'),
(9, '9', 'Laptop MSG RGB', 'Toko DbKom', 12000000, 59, 'Dimas Radika'),
(10, '10', 'Laptop Doll RGB', 'Toko RevengeKom', 5000000, 69, 'Dimas Hisbulloh');

--
-- Triggers `tb_barang`
--
DELIMITER $$
CREATE TRIGGER `update_barang` AFTER UPDATE ON `tb_barang` FOR EACH ROW BEGIN
  INSERT INTO tb_riwayat
  SET id_barang=old.id_barang,
  perubahan_stok=old.stok-new.stok,
  nama_pembeli=new.pembeli_terakhir,
  waktu = NOW(); 
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_brand`
--

CREATE TABLE `tb_brand` (
  `id_brand` varchar(10) NOT NULL,
  `nama_brand` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_brand`
--

INSERT INTO `tb_brand` (`id_brand`, `nama_brand`) VALUES
('1', 'Asus'),
('10', 'Mac OS'),
('2', 'Acer'),
('3', 'Vootre'),
('4', 'Hp'),
('5', 'Gas'),
('6', 'Dell'),
('7', 'Logitech'),
('8', 'Lenovo'),
('9', 'exus');

-- --------------------------------------------------------

--
-- Table structure for table `tb_riwayat`
--

CREATE TABLE `tb_riwayat` (
  `id_riwayat` int(11) NOT NULL,
  `waktu` varchar(99) NOT NULL,
  `id_barang` int(30) NOT NULL,
  `perubahan_stok` int(30) NOT NULL,
  `nama_pembeli` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_riwayat`
--

INSERT INTO `tb_riwayat` (`id_riwayat`, `waktu`, `id_barang`, `perubahan_stok`, `nama_pembeli`) VALUES
(25, '2021-06-14 12:48:07', 2, 3, 'Dika'),
(26, '2021-06-14 21:16:46', 3, 24, 'David'),
(27, '2021-06-23 13:23:29', 5, 3, 'David N');

-- --------------------------------------------------------

--
-- Structure for view `brand`
--
DROP TABLE IF EXISTS `brand`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `brand`  AS SELECT `tb_brand`.`id_brand` AS `id_brand`, `tb_brand`.`nama_brand` AS `nama_brand` FROM `tb_brand` ;

-- --------------------------------------------------------

--
-- Structure for view `jumlahterjual`
--
DROP TABLE IF EXISTS `jumlahterjual`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `jumlahterjual`  AS SELECT sum(`tb_riwayat`.`perubahan_stok`) AS `jumlah_terjual` FROM `tb_riwayat` WHERE `tb_riwayat`.`perubahan_stok` > 0 ;

-- --------------------------------------------------------

--
-- Structure for view `jumlah_stok`
--
DROP TABLE IF EXISTS `jumlah_stok`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `jumlah_stok`  AS SELECT sum(`tb_barang`.`stok`) AS `stok_barang` FROM `tb_barang` ;

-- --------------------------------------------------------

--
-- Structure for view `jumlah_terjual`
--
DROP TABLE IF EXISTS `jumlah_terjual`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `jumlah_terjual`  AS SELECT sum(`tb_riwayat`.`perubahan_stok`) AS `jumlah_terjual` FROM `tb_riwayat` WHERE `tb_riwayat`.`perubahan_stok` > 0 AND `tb_riwayat`.`nama_pembeli` <> '' ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id_admin`,`username`);

--
-- Indexes for table `tb_barang`
--
ALTER TABLE `tb_barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `id_brand` (`id_brand`);

--
-- Indexes for table `tb_brand`
--
ALTER TABLE `tb_brand`
  ADD PRIMARY KEY (`id_brand`);

--
-- Indexes for table `tb_riwayat`
--
ALTER TABLE `tb_riwayat`
  ADD PRIMARY KEY (`id_riwayat`),
  ADD KEY `id_buku` (`id_barang`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id_admin` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tb_barang`
--
ALTER TABLE `tb_barang`
  MODIFY `id_barang` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `tb_riwayat`
--
ALTER TABLE `tb_riwayat`
  MODIFY `id_riwayat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_barang`
--
ALTER TABLE `tb_barang`
  ADD CONSTRAINT `tb_buku_ibfk_1` FOREIGN KEY (`id_brand`) REFERENCES `tb_brand` (`id_brand`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
