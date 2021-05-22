-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 04, 2021 at 06:19 PM
-- Server version: 8.0.23-0ubuntu0.20.04.1
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
  `stk_id` int NOT NULL,
  `stk_product_id_fk` int NOT NULL,
  `stk_good` int NOT NULL,
  `stk_not_good` int NOT NULL,
  `stk_opname` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `det_product_stock`
--

INSERT INTO `det_product_stock` (`stk_id`, `stk_product_id_fk`, `stk_good`, `stk_not_good`, `stk_opname`) VALUES
(1, 1, 11, 0, 0),
(2, 2, 4, 0, 0),
(3, 3, 1, 1, 1),
(4, 6, 1, 1, 1),
(5, 7, 1, 1, 1),
(6, 8, 19, 0, 0),
(7, 9, 5, 0, 0),
(8, 4, 0, 1, 1),
(9, 10, 10, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `det_return_customer`
--

CREATE TABLE `det_return_customer` (
  `drc_id` int NOT NULL,
  `rc_id_fk` int NOT NULL,
  `prd_id_fk` int NOT NULL,
  `drc_qty` int NOT NULL,
  `drc_status` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `det_trans_purchases`
--

CREATE TABLE `det_trans_purchases` (
  `dtp_id` int NOT NULL,
  `dtp_tp_fk` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dtp_product_fk` int NOT NULL,
  `dtp_product_amount` int NOT NULL,
  `dtp_purchase_price` decimal(10,2) NOT NULL,
  `dtp_total_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `det_trans_purchases`
--

INSERT INTO `det_trans_purchases` (`dtp_id`, `dtp_tp_fk`, `dtp_product_fk`, `dtp_product_amount`, `dtp_purchase_price`, `dtp_total_price`) VALUES
(6, '2', 1, 10, '70000.00', '700000.00'),
(7, '3', 8, 10, '68500.00', '685000.00'),
(8, '4', 8, 5, '68500.00', '342500.00'),
(9, '4', 9, 3, '66500.00', '199500.00'),
(10, '4', 10, 5, '147200.00', '736000.00'),
(11, '6', 2, 2, '74500.00', '149000.00'),
(12, '6', 8, 1, '68500.00', '68500.00'),
(13, '6', 9, 1, '66500.00', '66500.00'),
(14, '6', 10, 2, '147200.00', '294400.00'),
(15, '7', 10, 1, '147200.00', '147200.00'),
(16, '8', 8, 1, '68500.00', '68500.00'),
(17, '9', 2, 1, '74500.00', '74500.00'),
(18, '10', 10, 1, '147200.00', '147200.00'),
(19, '11', 10, 1, '147200.00', '147200.00');

--
-- Triggers `det_trans_purchases`
--
DELIMITER $$
CREATE TRIGGER `TG_UpdateStock_Purchases` AFTER INSERT ON `det_trans_purchases` FOR EACH ROW UPDATE `det_product_stock` 
SET stk_good = stk_good + NEW.dtp_product_amount
WHERE stk_product_id_fk = NEW.dtp_product_fk
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `det_trans_sales`
--

CREATE TABLE `det_trans_sales` (
  `dts_id` int NOT NULL,
  `dts_ts_id_fk` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dts_product_fk` int NOT NULL,
  `dts_product_amount` int NOT NULL,
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
  `ip_id` int NOT NULL,
  `ip_trans_id_fk` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_periode` int NOT NULL,
  `ip_periode_end` int NOT NULL,
  `ip_date` datetime NOT NULL,
  `ip_payment` decimal(10,2) NOT NULL,
  `ip_invoice_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_invoice_file` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `installment_sales`
--

CREATE TABLE `installment_sales` (
  `is_id` int NOT NULL,
  `is_trans_id_fk` int NOT NULL,
  `is_code` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_periode` int NOT NULL,
  `is_due_date` datetime NOT NULL,
  `is_payment` decimal(10,2) DEFAULT NULL,
  `is_payment_date` date DEFAULT NULL,
  `is_status` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ref_bank`
--

CREATE TABLE `ref_bank` (
  `bank_id` int NOT NULL,
  `bank_code` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_name` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ref_bank`
--

INSERT INTO `ref_bank` (`bank_id`, `bank_code`, `bank_name`) VALUES
(1, '002', 'BRI'),
(2, '014', 'BCA');

-- --------------------------------------------------------

--
-- Table structure for table `return_customer`
--

CREATE TABLE `return_customer` (
  `rc_id` int NOT NULL,
  `ts_id_fk` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rc_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `rc_paid` decimal(10,2) DEFAULT NULL,
  `rc_note` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `return_customer`
--

INSERT INTO `return_customer` (`rc_id`, `ts_id_fk`, `rc_paid`, `rc_note`) VALUES
(1, '1', '1231231.00', 'asdasdasd');

-- --------------------------------------------------------

--
-- Table structure for table `tb_bank_account`
--

CREATE TABLE `tb_bank_account` (
  `acc_id` int NOT NULL,
  `acc_bank_code` int NOT NULL,
  `acc_number` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `acc_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_bank_account`
--

INSERT INTO `tb_bank_account` (`acc_id`, `acc_bank_code`, `acc_number`, `acc_name`) VALUES
(1, 2, '2147483647', 'Rekening BCA 1'),
(2, 1, '2147483647', 'Rekening BRI 1'),
(3, 2, '2147483647', 'Rekening BCA 2'),
(4, 2, '014000000000003', 'Rekening BCA 3'),
(5, 1, '002000000000002', 'Rekening BRI 2'),
(6, 1, '002000000000003', 'Rekening BRI 3');

-- --------------------------------------------------------

--
-- Table structure for table `tb_category`
--

CREATE TABLE `tb_category` (
  `ctgr_id` int NOT NULL,
  `ctgr_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
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
(10, 'Bor'),
(11, 'Dinabol');

-- --------------------------------------------------------

--
-- Table structure for table `tb_customer`
--

CREATE TABLE `tb_customer` (
  `ctm_id` int NOT NULL,
  `ctm_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ctm_phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ctm_email` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ctm_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ctm_status` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_customer`
--

INSERT INTO `tb_customer` (`ctm_id`, `ctm_name`, `ctm_phone`, `ctm_email`, `ctm_address`, `ctm_status`) VALUES
(1, 'Pelanggan A', '', '', '', '0'),
(2, 'Pelanggan B', '08123', '', '', '0'),
(3, 'Pelanggan C', '', '', '', '0'),
(4, 'Pelanggan D', '088892349233', 'email@email.com', 'Alamat alamat kota alamat edited', '0'),
(5, 'Pelanggan E', '', 'emailsurel@surmail.com', '', '0'),
(6, 'Pelanggan F', '0897654321', '', 'Editeed', '0'),
(7, 'Pelanggan G', '08666666', 'GsixG@email.com', 'alamatpelanggan G', '0'),
(8, 'Pelanggan H', '011111111', '', '', '0'),
(9, 'Pelanggan I', '', '', '', '0'),
(10, 'Pelanggan J', '0855', 'email@email.com', '', '0'),
(11, 'Pelanggan K', '', '', '', '0'),
(12, 'Pelanggan Z', '', '', '', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tb_invoice`
--

CREATE TABLE `tb_invoice` (
  `inv_id` int NOT NULL,
  `ts_id_fk` int NOT NULL,
  `inv_code` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `inv_date` date NOT NULL,
  `inv_payment_due` date NOT NULL,
  `inv_status` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `inv_type` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `inv_periode_a` int DEFAULT NULL,
  `inv_periode_b` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_product`
--

CREATE TABLE `tb_product` (
  `prd_id` int NOT NULL,
  `prd_barcode` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prd_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prd_category_id_fk` int DEFAULT NULL,
  `prd_purchase_price` decimal(10,2) NOT NULL,
  `prd_selling_price` decimal(10,2) NOT NULL,
  `prd_unit_id_fk` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prd_containts` int DEFAULT NULL,
  `prd_initial_g_stock` int NOT NULL DEFAULT '0',
  `prd_initial_ng_stock` int NOT NULL DEFAULT '0',
  `prd_initial_op_stock` int NOT NULL DEFAULT '0',
  `prd_description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prd_image` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `prd_status` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_product`
--

INSERT INTO `tb_product` (`prd_id`, `prd_barcode`, `prd_name`, `prd_category_id_fk`, `prd_purchase_price`, `prd_selling_price`, `prd_unit_id_fk`, `prd_containts`, `prd_initial_g_stock`, `prd_initial_ng_stock`, `prd_initial_op_stock`, `prd_description`, `prd_image`, `prd_status`) VALUES
(1, '', 'C75 0,75 M-NET', 1, '70000.00', '85000.00', '1', 1, 0, 0, 0, 'Deskripsi', NULL, 0),
(2, '', 'C75 0,75 G-NET', 1, '74500.00', '82000.00', '1', 1, 0, 0, 0, 'Deskripsi', NULL, 0),
(3, '', 'Product to delete', 5, '1.00', '1.00', '3', 1, 1, 1, 1, 'asdasdasda', 'assets/uploaded_files/product_img/a4c720227a5543879883c7374ec3e5a2.png', 1),
(4, 'BPrdE', 'Produk Edited', 5, '99.00', '100.99', '2', 10, 0, 0, 0, 'Deskripsi product edited', 'assets/uploaded_files/product_img/bcb4f42bfa740438eb25ca7f80e07a3e.jpeg', 1),
(8, '', 'C75 0,75 WIRAMA', 1, '68500.00', '77000.00', '1', 1, 0, 0, 0, 'Deskripsi', NULL, 0),
(9, '', 'C75 0,75 MAXI', 1, '66500.00', '73000.00', '1', 1, 0, 0, 0, '', NULL, 0),
(10, 'B10G', 'Galvalume 0,30 G-NET 4m', 3, '147200.00', '168000.00', '2', 1, 0, 0, 0, 'Deskripsi Galvalume 0,30 G-NET 4m', NULL, 0);

--
-- Triggers `tb_product`
--
DELIMITER $$
CREATE TRIGGER `TG_UpdateStock_Initialstock` AFTER UPDATE ON `tb_product` FOR EACH ROW UPDATE `det_product_stock` 
SET 
stk_good = CASE WHEN NEW.prd_status = 0 THEN stk_good + (NEW.prd_initial_g_stock - OLD.prd_initial_g_stock) ELSE stk_good END,
stk_not_good = CASE WHEN NEW.prd_status = 0 THEN stk_not_good + (NEW.prd_initial_ng_stock - OLD.prd_initial_ng_stock) ELSE stk_not_good END,
stk_opname = CASE WHEN NEW.prd_status = 0 THEN stk_opname + (NEW.prd_initial_op_stock - OLD.prd_initial_op_stock) ELSE stk_opname END
WHERE stk_product_id_fk = NEW.prd_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_profile`
--

CREATE TABLE `tb_profile` (
  `pfl_id` int NOT NULL,
  `pfl_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pfl_logo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `pfl_email` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `pfl_telp` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pfl_fax` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pfl_address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_profile`
--

INSERT INTO `tb_profile` (`pfl_id`, `pfl_name`, `pfl_logo`, `pfl_email`, `pfl_telp`, `pfl_fax`, `pfl_address`) VALUES
(1, 'Toko 1', 'assets/dist/img/94334252d6528aa79e1c398cb2ae4d9d.png', 'email@eamial.com', '0289292929', '0289323232', 'Jl. Alamat Toko no. 1, Kelurahan Alamat, Kecamatan Toko, Kota NomorSatu ');

-- --------------------------------------------------------

--
-- Table structure for table `tb_supplier`
--

CREATE TABLE `tb_supplier` (
  `supp_id` int NOT NULL,
  `supp_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `supp_contact_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supp_email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `supp_telp` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `supp_address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `supp_status` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_supplier`
--

INSERT INTO `tb_supplier` (`supp_id`, `supp_name`, `supp_contact_name`, `supp_email`, `supp_telp`, `supp_address`, `supp_status`) VALUES
(1, 'PT A', 'Bp Anton', '', '', '', 0),
(2, 'PT B', 'Ibu Merry', '', '', '', 0),
(3, 'PT C', 'Mas Sugeng', '', '', '', 0),
(4, 'PT D', 'Mbak Uni', '', '', '', 0),
(5, 'PT D', 'Gunawan', 'gunawan@ptsd.co.id', '089969694646', 'KI BSB blok A no !A, Ngaliyan, Semarang, Jateng, ', 0),
(6, 'PT E', 'Anseng', '', '', '', 0),
(7, 'PT F', 'Soni', '', '', '', 0),
(8, 'PT G', 'Raden', '', '', '', 0),
(9, 'PT H', 'Eko HARDIANTO', '', '', '', 0),
(10, 'PT K', 'Sumiati R', '', '', '', 0),
(11, 'PT I', 'HARIANTO', '', '', '', 0),
(12, 'PT J', 'Gunawan PT J', '', '', '', 0),
(13, 'PT L', 'Hartono', 'email@email.com', '082292839291', 'alamat supplier', 0),
(33, 'PT L', 'Sudarsono Marketing L', 'emailesudasono@ptl.my.id', '082246469876', '', 0),
(34, 'PT M', 'Daryono', '', '', '', 0),
(35, 'Untuk dihapus', 'Kontak', '', '', '', 1),
(36, 'Test New Supp', 'New Supp', '', '', '', 1),
(37, 'Supp', 'To be deleted', '', '', '', 0),
(38, 'aaa', 'aaa', '', '112', '', 0),
(39, 'ZZ', 'ZZ', '', '12312', '', 0),
(40, 'ZZ', 'ZZ', '', '12312', '', 0),
(41, 'zcoba', 'zzz', 'email@weia.com', '1231', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_unit`
--

CREATE TABLE `tb_unit` (
  `unit_id` int NOT NULL,
  `unit_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
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
-- Table structure for table `temp_purchases`
--

CREATE TABLE `temp_purchases` (
  `tp_id` int NOT NULL,
  `tp_product_fk` int NOT NULL,
  `tp_product_amount` int NOT NULL,
  `tp_purchase_price` decimal(10,2) NOT NULL,
  `tp_total_paid` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `temp_sales`
--

CREATE TABLE `temp_sales` (
  `temps_id` int NOT NULL,
  `temps_product_fk` int NOT NULL,
  `temps_product_amount` int NOT NULL,
  `temps_sale_price` decimal(10,2) NOT NULL,
  `temps_discount` decimal(10,2) NOT NULL,
  `temps_total_paid` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trans_expense`
--

CREATE TABLE `trans_expense` (
  `te_id` int NOT NULL,
  `te_necessity` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `te_date` date NOT NULL,
  `te_payment_method` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `te_payment` decimal(10,2) NOT NULL,
  `te_note` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `te_account_id_fk` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `te_invoice` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trans_purchases`
--

CREATE TABLE `trans_purchases` (
  `tp_id` int NOT NULL,
  `tp_note_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tp_note_file` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tp_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tp_supplier_fk` int NOT NULL,
  `tp_payment_method` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tp_additional_cost` decimal(10,2) DEFAULT '0.00',
  `tp_total_cost` decimal(10,2) NOT NULL,
  `tp_account_fk` int DEFAULT NULL,
  `tp_paid` decimal(10,2) NOT NULL,
  `tp_payment_status` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tp_tenor` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tp_tenor_periode` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tp_installment` decimal(10,2) DEFAULT NULL,
  `tp_due_date` date DEFAULT NULL,
  `tp_delete` int NOT NULL DEFAULT '0',
  `tp_post_script` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trans_purchases`
--

INSERT INTO `trans_purchases` (`tp_id`, `tp_note_code`, `tp_note_file`, `tp_date`, `tp_supplier_fk`, `tp_payment_method`, `tp_additional_cost`, `tp_total_cost`, `tp_account_fk`, `tp_paid`, `tp_payment_status`, `tp_tenor`, `tp_tenor_periode`, `tp_installment`, `tp_due_date`, `tp_delete`, `tp_post_script`) VALUES
(2, 'NP2603202100001', 'assets/uploaded_files/purchase_note/963e7654cb09b164c380aba06eb69da1.jpg', '2021-03-25 17:00:00', 1, 'TN', '0.00', '0.00', 0, '700000.00', 'T', '', '', '0.00', '0000-00-00', 0, NULL),
(3, 'NP2603202100002', 'assets/uploaded_files/purchase_note/63dd2c0e08da30da8957b2d67988b6e9.jpg', '2021-03-25 17:00:00', 2, 'TF', '0.00', '0.00', 0, '85000.00', 'K', '10', 'M', '60000.00', '2021-04-26', 0, NULL),
(4, 'NP0204202100001', 'assets/uploaded_files/purchase_note/f4944ee5c3bb8e3c5540eb79cedd3c3d.jpg', '2021-04-01 17:00:00', 39, 'TF', '0.00', '0.00', 0, '278000.00', 'K', '2', 'Y', '500000.00', '2022-04-02', 0, NULL),
(6, 'NP0504202100001', 'assets/uploaded_files/purchase_note/9ce6c8322ba9fcd336edef1f3377cff3.jpg', '2021-04-04 17:00:00', 4, 'TN', '600.00', '579000.00', 0, '579000.00', 'T', '', '', '0.00', '0000-00-00', 0, ''),
(7, 'NP0504202100002', 'assets/uploaded_files/purchase_note/d36ec00856b67227789424d4940330bf.jpg', '2021-04-04 17:00:00', 13, 'TN', '800.00', '148000.00', 0, '148000.00', 'T', '', '', '0.00', '0000-00-00', 0, 'Tambah 800'),
(8, 'NP0504202100003', 'assets/uploaded_files/purchase_note/3e1d0d39200b191a69307fdaef483c54.jpg', '2021-04-04 17:00:00', 34, 'TN', '0.00', '68500.00', 0, '500.00', 'K', '10', 'D', '6800.00', '2021-04-12', 0, 'catatan'),
(9, 'NP0604202100001', 'assets/uploaded_files/purchase_note/368bdd7e8dda6b5f01d2a465736fc452.jpg', '2021-04-05 17:00:00', 13, 'TF', '500.00', '75000.00', 0, '0.00', 'K', '1', 'W', '75000.00', '2021-04-12', 0, ''),
(10, 'NP0604202100002', 'assets/uploaded_files/purchase_note/33b0cc954913dde8bf1aac147ed71c61.jpg', '2021-04-05 17:00:00', 11, 'TF', '2800.00', '150000.00', 0, '0.00', 'K', '3', 'M', '50000.00', '2021-05-03', 0, ''),
(11, 'NP0704202100001', 'assets/uploaded_files/purchase_note/45b617348f4ae9a1c626ebd617c5b83f.jpg', '2021-04-06 17:00:00', 12, 'TF', '52800.00', '200000.00', 0, '100000.00', 'K', '1', 'W', '100000.00', '2021-04-12', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `trans_revenues`
--

CREATE TABLE `trans_revenues` (
  `tr_id` int NOT NULL,
  `tr_trans_code` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tr_source` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tr_date` datetime NOT NULL,
  `tr_payment_method` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tr_payment` decimal(10,2) NOT NULL,
  `tr_account_id_fk` int DEFAULT NULL,
  `tr_note` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trans_sales`
--

CREATE TABLE `trans_sales` (
  `ts_id` int NOT NULL,
  `ts_trans_code` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ts_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ts_customer_fk` int NOT NULL,
  `ts_payment_metode` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ts_delivery_metode` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ts_delivery_payment` decimal(10,2) NOT NULL,
  `ts_sales_price` decimal(10,2) NOT NULL,
  `ts_account_fk` int DEFAULT NULL,
  `ts_paid` decimal(10,2) NOT NULL,
  `ts_status` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ts_tenor` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ts_tenor_periode` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ts_installment` decimal(10,2) DEFAULT NULL,
  `ts_due_date` date DEFAULT NULL,
  `ts_invoice` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ts_delete` int NOT NULL DEFAULT '0',
  `ts_return` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
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
-- Indexes for table `det_return_customer`
--
ALTER TABLE `det_return_customer`
  ADD PRIMARY KEY (`drc_id`);

--
-- Indexes for table `det_trans_purchases`
--
ALTER TABLE `det_trans_purchases`
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
-- Indexes for table `return_customer`
--
ALTER TABLE `return_customer`
  ADD PRIMARY KEY (`rc_id`);

--
-- Indexes for table `tb_bank_account`
--
ALTER TABLE `tb_bank_account`
  ADD PRIMARY KEY (`acc_id`);

--
-- Indexes for table `tb_category`
--
ALTER TABLE `tb_category`
  ADD PRIMARY KEY (`ctgr_id`);

--
-- Indexes for table `tb_customer`
--
ALTER TABLE `tb_customer`
  ADD PRIMARY KEY (`ctm_id`);

--
-- Indexes for table `tb_invoice`
--
ALTER TABLE `tb_invoice`
  ADD PRIMARY KEY (`inv_id`);

--
-- Indexes for table `tb_product`
--
ALTER TABLE `tb_product`
  ADD PRIMARY KEY (`prd_id`),
  ADD KEY `prd_barcode` (`prd_barcode`) USING BTREE;

--
-- Indexes for table `tb_profile`
--
ALTER TABLE `tb_profile`
  ADD PRIMARY KEY (`pfl_id`);

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
-- Indexes for table `temp_purchases`
--
ALTER TABLE `temp_purchases`
  ADD PRIMARY KEY (`tp_id`);

--
-- Indexes for table `temp_sales`
--
ALTER TABLE `temp_sales`
  ADD PRIMARY KEY (`temps_id`);

--
-- Indexes for table `trans_expense`
--
ALTER TABLE `trans_expense`
  ADD PRIMARY KEY (`te_id`);

--
-- Indexes for table `trans_purchases`
--
ALTER TABLE `trans_purchases`
  ADD PRIMARY KEY (`tp_id`),
  ADD UNIQUE KEY `tp_invoice_code` (`tp_note_code`);

--
-- Indexes for table `trans_revenues`
--
ALTER TABLE `trans_revenues`
  ADD PRIMARY KEY (`tr_id`);

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
  MODIFY `stk_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `det_return_customer`
--
ALTER TABLE `det_return_customer`
  MODIFY `drc_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `det_trans_purchases`
--
ALTER TABLE `det_trans_purchases`
  MODIFY `dtp_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `det_trans_sales`
--
ALTER TABLE `det_trans_sales`
  MODIFY `dts_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `installment_purchases`
--
ALTER TABLE `installment_purchases`
  MODIFY `ip_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `installment_sales`
--
ALTER TABLE `installment_sales`
  MODIFY `is_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ref_bank`
--
ALTER TABLE `ref_bank`
  MODIFY `bank_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `return_customer`
--
ALTER TABLE `return_customer`
  MODIFY `rc_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_bank_account`
--
ALTER TABLE `tb_bank_account`
  MODIFY `acc_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_category`
--
ALTER TABLE `tb_category`
  MODIFY `ctgr_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tb_customer`
--
ALTER TABLE `tb_customer`
  MODIFY `ctm_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tb_invoice`
--
ALTER TABLE `tb_invoice`
  MODIFY `inv_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_product`
--
ALTER TABLE `tb_product`
  MODIFY `prd_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tb_profile`
--
ALTER TABLE `tb_profile`
  MODIFY `pfl_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_supplier`
--
ALTER TABLE `tb_supplier`
  MODIFY `supp_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `tb_unit`
--
ALTER TABLE `tb_unit`
  MODIFY `unit_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `temp_purchases`
--
ALTER TABLE `temp_purchases`
  MODIFY `tp_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temp_sales`
--
ALTER TABLE `temp_sales`
  MODIFY `temps_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trans_expense`
--
ALTER TABLE `trans_expense`
  MODIFY `te_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trans_purchases`
--
ALTER TABLE `trans_purchases`
  MODIFY `tp_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `trans_revenues`
--
ALTER TABLE `trans_revenues`
  MODIFY `tr_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trans_sales`
--
ALTER TABLE `trans_sales`
  MODIFY `ts_id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
