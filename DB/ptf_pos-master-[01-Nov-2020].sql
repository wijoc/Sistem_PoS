-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 01, 2020 at 08:08 AM
-- Server version: 10.5.5-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ptf_pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `det_product_stock`
--

CREATE TABLE `det_product_stock` (
  `stk_id` int(11) NOT NULL,
  `stk_product_id_fk` int(11) NOT NULL,
  `stk_good` int(6) NOT NULL,
  `stk_not_good` int(6) NOT NULL,
  `stk_return` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `det_product_stock`
--

INSERT INTO `det_product_stock` (`stk_id`, `stk_product_id_fk`, `stk_good`, `stk_not_good`, `stk_return`) VALUES
(1, 1, 90, 0, 0),
(2, 2, 5, 0, 0),
(3, 3, 0, 0, 0),
(4, 4, 0, 0, 0),
(5, 5, 0, 0, 0),
(6, 6, 0, 0, 0),
(7, 7, 0, 0, 0),
(8, 8, 0, 0, 0),
(9, 9, 0, 0, 0),
(10, 10, 0, 0, 0),
(11, 11, 0, 0, 0),
(12, 12, 0, 0, 0),
(13, 13, 0, 0, 0),
(14, 14, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `det_trans_purchase`
--

CREATE TABLE `det_trans_purchase` (
  `dtp_id` int(3) NOT NULL,
  `dtp_tp_fk` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dtp_product_fk` int(3) NOT NULL,
  `dtp_product_amount` int(5) NOT NULL,
  `dtp_purchase_price` decimal(10,2) NOT NULL,
  `dtp_total_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Triggers `det_trans_purchase`
--
DELIMITER $$
CREATE TRIGGER `TG_UpdateStock_Purchases` AFTER INSERT ON `det_trans_purchase` FOR EACH ROW UPDATE `det_product_stock` 
SET stk_good = stk_good + NEW.dtp_product_amount
WHERE stk_product_id_fk = NEW.dtp_product_fk
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `det_trans_sales`
--

CREATE TABLE `det_trans_sales` (
  `dts_id` int(3) NOT NULL,
  `dts_ts_id_fk` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dts_product_fk` int(3) NOT NULL,
  `dts_product_amount` int(5) NOT NULL,
  `dts_sale_price` decimal(10,2) NOT NULL,
  `dts_discount` decimal(10,2) NOT NULL,
  `dts_total_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Triggers `det_trans_sales`
--
DELIMITER $$
CREATE TRIGGER `TG_UpdateStock_Sales` AFTER INSERT ON `det_trans_sales` FOR EACH ROW UPDATE `det_product_stock` 
SET stk_good = stk_good - NEW.dts_product_amount
WHERE stk_product_id_fk = NEW.dts_product_fk
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `installment_purchases`
--

CREATE TABLE `installment_purchases` (
  `ip_id` int(5) NOT NULL,
  `ip_trans_id_fk` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_periode` int(3) NOT NULL,
  `ip_periode_end` int(11) NOT NULL,
  `ip_date` datetime NOT NULL,
  `ip_payment` decimal(10,2) NOT NULL,
  `ip_invoice_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_invoice_file` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `installment_sales`
--

CREATE TABLE `installment_sales` (
  `is_id` int(5) NOT NULL,
  `is_trans_id_fk` int(5) NOT NULL,
  `is_code` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_periode` int(3) NOT NULL,
  `is_due_date` datetime NOT NULL,
  `is_payment` decimal(10,2) DEFAULT NULL,
  `is_payment_date` date DEFAULT NULL,
  `is_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ref_bank`
--

CREATE TABLE `ref_bank` (
  `bank_id` int(4) NOT NULL,
  `bank_code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_category`
--

CREATE TABLE `tb_category` (
  `ctgr_id` int(3) NOT NULL,
  `ctgr_name` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_category`
--

INSERT INTO `tb_category` (`ctgr_id`, `ctgr_name`) VALUES
(1, 'Canal'),
(2, 'Reng'),
(3, 'Galvalume'),
(4, 'Hollow'),
(5, 'Bondek'),
(6, 'Wiremesh'),
(7, 'Genteng'),
(8, 'Gypsun'),
(9, 'Skrup'),
(10, 'Bor'),
(11, 'Dinabol');

-- --------------------------------------------------------

--
-- Table structure for table `tb_member`
--

CREATE TABLE `tb_member` (
  `member_id` int(3) NOT NULL,
  `member_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `member_status` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `member_discount` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_member`
--

INSERT INTO `tb_member` (`member_id`, `member_name`, `member_status`, `member_discount`) VALUES
(1, 'et', 'Y', 1),
(2, 'eos', 'Y', 3),
(3, 'soluta', 'Y', 5),
(4, 'fuga', 'Y', 1),
(5, 'est', 'Y', 9),
(6, 'quas', 'Y', 7),
(7, 'maiores', 'Y', 1),
(8, 'sit', 'Y', 6),
(9, 'minima', 'Y', 6),
(10, 'aut', 'Y', 7),
(11, 'numquam', 'Y', 4),
(12, 'sunt', 'Y', 2),
(13, 'est', 'Y', 7),
(14, 'ducimus', 'Y', 8),
(15, 'eos', 'Y', 4),
(16, 'at', 'Y', 8),
(17, 'et', 'Y', 3),
(18, 'animi', 'Y', 9),
(19, 'labore', 'Y', 2),
(20, 'voluptas', 'Y', 4),
(21, 'officia', 'Y', 9),
(22, 'mollitia', 'Y', 2),
(23, 'tempora', 'Y', 7),
(24, 'reiciendis', 'Y', 9),
(25, 'aut', 'Y', 6),
(26, 'et', 'Y', 3),
(27, 'pariatur', 'Y', 1),
(28, 'dolor', 'Y', 3),
(29, 'ad', 'Y', 4),
(30, 'quo', 'Y', 5),
(31, 'A Member', 'Y', 6000),
(32, 'et', 'Y', 3),
(33, 'Member 1 Normal', 'D', 10000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_product`
--

CREATE TABLE `tb_product` (
  `prd_id` int(4) NOT NULL,
  `prd_barcode` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prd_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `prd_category_id_fk` int(3) DEFAULT NULL,
  `prd_purchase_price` decimal(10,2) NOT NULL,
  `prd_selling_price` decimal(10,2) NOT NULL,
  `prd_unit_id_fk` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prd_containts` int(3) DEFAULT NULL,
  `prd_initial_g_stock` int(6) NOT NULL DEFAULT 0,
  `prd_initial_ng_stock` int(6) NOT NULL DEFAULT 0,
  `prd_initial_return_stock` int(6) NOT NULL DEFAULT 0,
  `prd_description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `prd_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_product`
--

INSERT INTO `tb_product` (`prd_id`, `prd_barcode`, `prd_name`, `prd_category_id_fk`, `prd_purchase_price`, `prd_selling_price`, `prd_unit_id_fk`, `prd_containts`, `prd_initial_g_stock`, `prd_initial_ng_stock`, `prd_initial_return_stock`, `prd_description`, `prd_status`) VALUES
(1, '', 'C75 0.75 M-NET', 1, '70000.00', '85000.00', '1', 1, 0, 0, 0, 'Deskripsi C75 0.75 M-NET', 0),
(2, '', 'C75 0.75 G-NET', 1, '74500.00', '82000.00', '1', 1, 0, 0, 0, 'Deskripsi C75', 0),
(3, '', 'C75 0.75 WIRAMA', 1, '68500.00', '77000.00', '1', 1, 0, 0, 0, 'Deskripsi WIRAMA', 0),
(4, '', 'C75 0.75 MAXI', 1, '66500.00', '73000.00', '1', 1, 0, 0, 0, '', 0),
(5, '', 'C75 0.75 A-PLUS (motif)', 1, '71700.00', '78000.00', '1', 1, 0, 0, 0, '', 0),
(6, '', 'C75 0.70 A-PLUS (motif)', 1, '66000.00', '72000.00', '1', 1, 0, 0, 0, 'Deskripsi C75 0.70 A-PLUS (motif)', 0),
(7, '', 'C75 0.70 A-PLUS (polos)', 1, '65000.00', '71000.00', '1', 1, 0, 0, 0, 'Deskripsi C75 0.70 A-PLUS (polos)', 0),
(8, '', 'C75 0.75 AL', 1, '67000.00', '75000.00', '1', 1, 0, 0, 0, 'Deskripsi C75 0.75 AL', 0),
(9, '', 'C75 0.70 AL', 1, '66000.00', '72000.00', '1', 1, 0, 0, 0, 'Deskripsi C75 0.70 AL', 0),
(10, '', 'Galvalume 0.30 G-NET 4m', 3, '147200.00', '168000.00', '2', 1, 0, 0, 0, 'Deskripsi Galvalume 0.30 G-NET 4m\r\n', 0),
(11, '', 'Galvalume 0.30 G-NET 5m', 3, '184000.00', '210000.00', '2', 1, 0, 0, 0, 'Deskripsi Galvalume 0.30 G-NET 5m', 0),
(12, '', 'Galvalume 0.30 G-NET 6m', 3, '220800.00', '252000.00', '2', 1, 0, 0, 0, 'Deskripsi Galvalume 0.30 G-NET 6m', 0),
(13, '', 'Galvalume 0.25 G-NET 4m', 3, '136400.00', '156000.00', '2', 1, 0, 0, 0, 'Deskripsi Galvalume 0.25 G-NET 4m', 0),
(14, '', 'Galvalume 0.25 G-NET 5m', 3, '170500.00', '195000.00', '2', 1, 0, 0, 0, 'Deskripsi Galvalume 0.25 G-NET 5m', 0);

--
-- Triggers `tb_product`
--
DELIMITER $$
CREATE TRIGGER `TG_UpdateStock_Initialstock` AFTER UPDATE ON `tb_product` FOR EACH ROW UPDATE `det_product_stock` 
SET 
stk_good = stk_good + (NEW.prd_initial_g_stock - OLD.prd_initial_g_stock),
stk_not_good = stk_not_good + (NEW.prd_initial_ng_stock - OLD.prd_initial_ng_stock),
stk_return = stk_return + (NEW.prd_initial_return_stock - OLD.prd_initial_return_stock)
WHERE stk_product_id_fk = NEW.prd_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_rekening_bank`
--

CREATE TABLE `tb_rekening_bank` (
  `rek_id` int(3) NOT NULL,
  `rek_bank_code` int(4) NOT NULL,
  `rek_nomor` int(25) NOT NULL,
  `rek_atas_nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_supplier`
--

CREATE TABLE `tb_supplier` (
  `supp_id` int(3) NOT NULL,
  `supp_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supp_contact_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supp_email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supp_telp` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supp_address` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `supp_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_supplier`
--

INSERT INTO `tb_supplier` (`supp_id`, `supp_name`, `supp_contact_name`, `supp_email`, `supp_telp`, `supp_address`, `supp_status`) VALUES
(1, 'PT. Global Indo Asia Sejahtera', 'PT. Global Indo Asia Sejahtera', '', '', '', 0),
(2, 'CV. Griya Semarang', 'CV. Griya Semarang', '', '', '', 0),
(3, 'CV. Putra Padjajaran', 'CV. Putra Padjajaran', '', '', '', 0),
(4, 'PT. A', 'PT. A', '', '', '', 0),
(5, 'CV. B Edited', 'CV. B', '1', '1', '1', 0),
(6, 'CV. C', 'CV. C', '', '', '', 0),
(7, 'PT. D', 'PT. E', '', '', '', 0),
(8, 'CV. F', 'CV. F', '', '', '', 0),
(9, 'CV. G', 'CV. G', '', '', '', 0),
(10, 'PT. H', 'PT. H', '', '', '', 0),
(11, 'CV. I', 'CV. I', '', '', '', 0),
(12, 'CV. J', 'CV. J', '', '', '', 0),
(13, 'Supplier 1 Edited', 'Kontak Supp 1', 'email@email.com', '082292839291', 'alamat supplier', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_unit`
--

CREATE TABLE `tb_unit` (
  `unit_id` int(3) NOT NULL,
  `unit_name` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_unit`
--

INSERT INTO `tb_unit` (`unit_id`, `unit_name`) VALUES
(1, 'Batang'),
(2, 'Lembar'),
(3, 'Botol'),
(4, 'Piece'),
(5, 'Meter'),
(6, 'Meter kubik'),
(7, 'sak');

-- --------------------------------------------------------

--
-- Table structure for table `temp_purchase`
--

CREATE TABLE `temp_purchase` (
  `tp_id` int(10) NOT NULL,
  `tp_product_fk` int(5) NOT NULL,
  `tp_product_amount` int(5) NOT NULL,
  `tp_purchase_price` decimal(10,2) NOT NULL,
  `tp_total_paid` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `temp_sales`
--

CREATE TABLE `temp_sales` (
  `temps_id` int(10) NOT NULL,
  `temps_product_fk` int(5) NOT NULL,
  `temps_product_amount` int(5) NOT NULL,
  `temps_sale_price` decimal(10,2) NOT NULL,
  `temps_discount` decimal(10,2) NOT NULL,
  `temps_total_paid` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trans_purchase`
--

CREATE TABLE `trans_purchase` (
  `tp_id` int(5) NOT NULL,
  `tp_trans_code` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tp_invoice_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tp_invoice_file` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tp_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `tp_supplier_fk` int(3) NOT NULL,
  `tp_payment_metode` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tp_purchase_price` decimal(10,2) NOT NULL,
  `tp_account_fk` int(3) DEFAULT NULL,
  `tp_paid` decimal(10,2) NOT NULL,
  `tp_insufficient` decimal(10,2) NOT NULL,
  `tp_status` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tp_tenor` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tp_tenor_periode` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tp_installment` decimal(10,2) DEFAULT NULL,
  `tp_due_date` date DEFAULT NULL,
  `tp_delete` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trans_sales`
--

CREATE TABLE `trans_sales` (
  `ts_id` int(5) NOT NULL,
  `ts_trans_code` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ts_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ts_member_fk` int(5) NOT NULL,
  `ts_payment_metode` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ts_sales_price` decimal(10,2) NOT NULL,
  `ts_account_fk` int(3) DEFAULT NULL,
  `ts_paid` decimal(10,2) NOT NULL,
  `ts_insufficient` decimal(10,2) NOT NULL,
  `ts_status` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ts_tenor` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ts_tenor_periode` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ts_installment` decimal(10,2) DEFAULT NULL,
  `ts_due_date` date DEFAULT NULL,
  `ts_delete` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `det_product_stock`
--
ALTER TABLE `det_product_stock`
  ADD PRIMARY KEY (`stk_id`),
  ADD UNIQUE KEY `stk_product_id_fk` (`stk_product_id_fk`);

--
-- Indexes for table `det_trans_purchase`
--
ALTER TABLE `det_trans_purchase`
  ADD PRIMARY KEY (`dtp_id`);

--
-- Indexes for table `det_trans_sales`
--
ALTER TABLE `det_trans_sales`
  ADD PRIMARY KEY (`dts_id`);

--
-- Indexes for table `installment_purchases`
--
ALTER TABLE `installment_purchases`
  ADD PRIMARY KEY (`ip_id`);

--
-- Indexes for table `installment_sales`
--
ALTER TABLE `installment_sales`
  ADD PRIMARY KEY (`is_id`);

--
-- Indexes for table `ref_bank`
--
ALTER TABLE `ref_bank`
  ADD PRIMARY KEY (`bank_id`),
  ADD UNIQUE KEY `bank_code` (`bank_code`);

--
-- Indexes for table `tb_category`
--
ALTER TABLE `tb_category`
  ADD PRIMARY KEY (`ctgr_id`);

--
-- Indexes for table `tb_member`
--
ALTER TABLE `tb_member`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `tb_product`
--
ALTER TABLE `tb_product`
  ADD PRIMARY KEY (`prd_id`),
  ADD KEY `prd_barcode` (`prd_barcode`) USING BTREE;

--
-- Indexes for table `tb_rekening_bank`
--
ALTER TABLE `tb_rekening_bank`
  ADD PRIMARY KEY (`rek_id`);

--
-- Indexes for table `tb_supplier`
--
ALTER TABLE `tb_supplier`
  ADD PRIMARY KEY (`supp_id`);

--
-- Indexes for table `tb_unit`
--
ALTER TABLE `tb_unit`
  ADD PRIMARY KEY (`unit_id`);

--
-- Indexes for table `temp_purchase`
--
ALTER TABLE `temp_purchase`
  ADD PRIMARY KEY (`tp_id`);

--
-- Indexes for table `temp_sales`
--
ALTER TABLE `temp_sales`
  ADD PRIMARY KEY (`temps_id`);

--
-- Indexes for table `trans_purchase`
--
ALTER TABLE `trans_purchase`
  ADD PRIMARY KEY (`tp_id`),
  ADD UNIQUE KEY `tp_no_trans` (`tp_trans_code`);

--
-- Indexes for table `trans_sales`
--
ALTER TABLE `trans_sales`
  ADD PRIMARY KEY (`ts_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `det_product_stock`
--
ALTER TABLE `det_product_stock`
  MODIFY `stk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `det_trans_purchase`
--
ALTER TABLE `det_trans_purchase`
  MODIFY `dtp_id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `det_trans_sales`
--
ALTER TABLE `det_trans_sales`
  MODIFY `dts_id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `installment_purchases`
--
ALTER TABLE `installment_purchases`
  MODIFY `ip_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `installment_sales`
--
ALTER TABLE `installment_sales`
  MODIFY `is_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ref_bank`
--
ALTER TABLE `ref_bank`
  MODIFY `bank_id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_category`
--
ALTER TABLE `tb_category`
  MODIFY `ctgr_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tb_member`
--
ALTER TABLE `tb_member`
  MODIFY `member_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `tb_product`
--
ALTER TABLE `tb_product`
  MODIFY `prd_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tb_rekening_bank`
--
ALTER TABLE `tb_rekening_bank`
  MODIFY `rek_id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_supplier`
--
ALTER TABLE `tb_supplier`
  MODIFY `supp_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tb_unit`
--
ALTER TABLE `tb_unit`
  MODIFY `unit_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `temp_purchase`
--
ALTER TABLE `temp_purchase`
  MODIFY `tp_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temp_sales`
--
ALTER TABLE `temp_sales`
  MODIFY `temps_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trans_purchase`
--
ALTER TABLE `trans_purchase`
  MODIFY `tp_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trans_sales`
--
ALTER TABLE `trans_sales`
  MODIFY `ts_id` int(5) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
