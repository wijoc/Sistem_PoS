-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 06, 2022 at 09:42 AM
-- Server version: 10.3.32-MariaDB-0ubuntu0.20.04.1
-- PHP Version: 8.0.13

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
  `stk_good` int(11) NOT NULL,
  `stk_not_good` int(11) NOT NULL,
  `stk_opname` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `det_product_stock`
--

INSERT INTO `det_product_stock` (`stk_id`, `stk_product_id_fk`, `stk_good`, `stk_not_good`, `stk_opname`) VALUES
(2, 2, 10, 5, 5),
(3, 3, 72, 8, 9),
(4, 4, 109, 0, 0),
(5, 5, 12, 0, 0),
(6, 6, 5, 0, 0),
(9, 11, 7, 8, 9),
(10, 12, 1, 1, 1),
(11, 13, 1, 1, 1),
(12, 14, 10, 9, 8);

-- --------------------------------------------------------

--
-- Table structure for table `det_return_customer`
--

CREATE TABLE `det_return_customer` (
  `drc_id` int(11) NOT NULL,
  `drc_rc_id_fk` int(11) NOT NULL,
  `drc_product_id_fk` int(11) NOT NULL,
  `drc_return_qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `det_return_supplier`
--

CREATE TABLE `det_return_supplier` (
  `drs_id` int(11) NOT NULL,
  `drs_rs_id_fk` int(11) NOT NULL,
  `drs_product_id_fk` int(11) NOT NULL,
  `drs_return_qty` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `det_trans_purchases`
--

CREATE TABLE `det_trans_purchases` (
  `dtp_id` int(11) NOT NULL,
  `dtp_tp_fk` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dtp_product_fk` int(11) NOT NULL,
  `dtp_product_amount` int(11) NOT NULL,
  `dtp_purchase_price` decimal(10,2) NOT NULL,
  `dtp_total_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `det_trans_purchases`
--

INSERT INTO `det_trans_purchases` (`dtp_id`, `dtp_tp_fk`, `dtp_product_fk`, `dtp_product_amount`, `dtp_purchase_price`, `dtp_total_price`) VALUES
(1, '1', 3, 50, '68500.00', '3425000.00'),
(2, '1', 4, 10, '66500.00', '665000.00'),
(3, '2', 5, 10, '66000.00', '660000.00'),
(4, '2', 6, 5, '65000.00', '325000.00'),
(5, '3', 5, 5, '66000.00', '330000.00'),
(6, '3', 7, 10, '147200.00', '1472000.00'),
(7, '4', 2, 20, '74500.00', '1490000.00'),
(8, '5', 8, 35, '184000.00', '6440000.00'),
(9, '6', 2, 5, '74500.00', '372500.00'),
(10, '6', 8, 5, '184000.00', '920000.00');

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
  `dts_id` int(11) NOT NULL,
  `dts_ts_id_fk` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dts_product_fk` int(11) NOT NULL,
  `dts_product_amount` int(11) NOT NULL,
  `dts_sale_price` decimal(10,2) NOT NULL,
  `dts_discount` decimal(10,2) NOT NULL,
  `dts_total_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `det_trans_sales`
--

INSERT INTO `det_trans_sales` (`dts_id`, `dts_ts_id_fk`, `dts_product_fk`, `dts_product_amount`, `dts_sale_price`, `dts_discount`, `dts_total_price`) VALUES
(1, '1', 3, 10, '68500.00', '0.00', '685000.00'),
(2, '1', 2, 5, '74500.00', '0.00', '372500.00'),
(3, '1', 5, 1, '66000.00', '0.00', '66000.00'),
(4, '1', 8, 5, '184000.00', '0.00', '920000.00');

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
  `ip_id` int(11) NOT NULL,
  `ip_trans_id_fk` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_periode_begin` int(11) NOT NULL,
  `ip_periode_end` int(11) NOT NULL,
  `ip_date` datetime NOT NULL,
  `ip_payment` decimal(10,2) NOT NULL,
  `ip_note_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_note_file` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_post_script` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `installment_sales`
--

CREATE TABLE `installment_sales` (
  `is_id` int(11) NOT NULL,
  `is_trans_id_fk` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_code` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_periode` int(11) NOT NULL,
  `is_due_date` date NOT NULL,
  `is_payment` decimal(10,2) DEFAULT NULL,
  `is_payment_date` date DEFAULT NULL,
  `is_post_script` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ref_bank`
--

CREATE TABLE `ref_bank` (
  `bank_id` int(11) NOT NULL,
  `bank_code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL
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
  `rc_id` int(11) NOT NULL,
  `rc_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rc_ts_id_fk` int(11) NOT NULL,
  `rc_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `rc_status` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rc_cash` decimal(10,2) DEFAULT 0.00,
  `rc_post_script` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `return_supplier`
--

CREATE TABLE `return_supplier` (
  `rs_id` int(11) NOT NULL,
  `rs_tp_id_fk` int(11) NOT NULL,
  `rs_date` date NOT NULL,
  `rs_status` varchar(2) NOT NULL,
  `rs_cash_out` decimal(10,2) NOT NULL DEFAULT 0.00,
  `rs_cash_in` decimal(10,2) NOT NULL DEFAULT 0.00,
  `rs_post_script` longtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_bank_account`
--

CREATE TABLE `tb_bank_account` (
  `acc_id` int(11) NOT NULL,
  `acc_bank_id_fk` int(11) NOT NULL,
  `acc_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `acc_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `acc_status` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_bank_account`
--

INSERT INTO `tb_bank_account` (`acc_id`, `acc_bank_id_fk`, `acc_number`, `acc_name`, `acc_status`) VALUES
(1, 1, '100000020001', 'Rekening BRI 1', 0),
(2, 2, '100000140001', 'Rekening BCA 1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_category`
--

CREATE TABLE `tb_category` (
  `ctgr_id` int(11) NOT NULL,
  `ctgr_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `last_updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(3) DEFAULT NULL,
  `last_updated_by` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_category`
--

INSERT INTO `tb_category` (`ctgr_id`, `ctgr_name`, `created_at`, `last_updated_at`, `created_by`, `last_updated_by`) VALUES
(1, 'Canal', '2021-06-21 02:23:29', '0000-00-00 00:00:00', 1, 0),
(2, 'Reng', '2021-06-21 02:23:39', '0000-00-00 00:00:00', 1, 0),
(3, 'Galvalume', '2021-06-21 02:23:48', '0000-00-00 00:00:00', 1, 0),
(4, 'Hollow', '2021-06-21 02:25:04', '0000-00-00 00:00:00', 1, 0),
(5, 'Bondek', '2021-06-21 02:25:13', '0000-00-00 00:00:00', 1, 0),
(6, 'Wiremesh', '2021-06-21 02:25:22', '0000-00-00 00:00:00', 1, 0),
(7, 'Genteng', '2021-06-21 02:25:30', '0000-00-00 00:00:00', 1, 0),
(8, 'Gypsun', '2021-06-21 02:25:39', '0000-00-00 00:00:00', 1, 0),
(9, 'Skrup', '2021-06-21 02:25:49', '0000-00-00 00:00:00', 1, 0),
(10, 'Bor', '2021-06-21 02:26:16', '0000-00-00 00:00:00', 1, 0),
(11, 'Dinabol', '2021-06-21 02:27:28', '0000-00-00 00:00:00', 1, 0),
(12, 'Lain - lain', '2021-06-21 02:27:42', '0000-00-00 00:00:00', 1, 0),
(13, 'Baru', '2021-11-08 11:30:12', '0000-00-00 00:00:00', NULL, 0),
(16, 'Aa Brand New category', '2021-11-22 04:44:08', '0000-00-00 00:00:00', NULL, 0),
(17, 'BaBrand New', '2021-12-13 03:40:39', '0000-00-00 00:00:00', NULL, 0),
(18, 'Test', '2021-12-27 07:03:33', '0000-00-00 00:00:00', NULL, 0),
(19, 'New Category', '2022-01-06 02:37:18', '0000-00-00 00:00:00', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_customer`
--

CREATE TABLE `tb_customer` (
  `ctm_id` int(11) NOT NULL,
  `ctm_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ctm_phone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ctm_email` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ctm_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ctm_status` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL,
  `last_updated_at` timestamp NULL DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_customer`
--

INSERT INTO `tb_customer` (`ctm_id`, `ctm_name`, `ctm_phone`, `ctm_email`, `ctm_address`, `ctm_status`, `created_at`, `created_by`, `last_updated_at`, `last_updated_by`) VALUES
(1, 'Customer A', '1', 'email@email.com', '1', '0', '2021-06-23 05:08:27', 1, '2021-06-23 06:16:53', 1),
(2, 'Customer B', '', '', '', '0', '2021-06-23 05:37:16', 1, NULL, NULL),
(3, 'Customer C', '1', 'email@email.com', 'asas', '1', '2021-06-23 05:37:38', 1, '2021-06-23 06:17:48', 1),
(4, 'Customer C', '', '', '', 'Y', '2021-06-25 08:33:28', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_invoice`
--

CREATE TABLE `tb_invoice` (
  `inv_id` int(11) NOT NULL,
  `ts_id_fk` int(11) NOT NULL,
  `inv_code` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inv_date` date NOT NULL,
  `inv_payment_due` date NOT NULL,
  `inv_status` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inv_type` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inv_periode_a` int(11) DEFAULT NULL,
  `inv_periode_b` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_product`
--

CREATE TABLE `tb_product` (
  `prd_id` int(11) NOT NULL,
  `prd_code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prd_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `prd_category_id_fk` int(11) DEFAULT 0,
  `prd_purchase_price` decimal(10,2) NOT NULL,
  `prd_selling_price` decimal(10,2) NOT NULL,
  `prd_unit_id_fk` int(11) DEFAULT NULL,
  `prd_contains` int(11) DEFAULT NULL,
  `prd_initial_g_stock` int(11) NOT NULL DEFAULT 0,
  `prd_initial_ng_stock` int(11) NOT NULL DEFAULT 0,
  `prd_initial_op_stock` int(11) NOT NULL DEFAULT 0,
  `prd_description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `prd_image` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prd_status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(3) NOT NULL,
  `last_updated_by` int(3) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_product`
--

INSERT INTO `tb_product` (`prd_id`, `prd_code`, `prd_name`, `prd_category_id_fk`, `prd_purchase_price`, `prd_selling_price`, `prd_unit_id_fk`, `prd_contains`, `prd_initial_g_stock`, `prd_initial_ng_stock`, `prd_initial_op_stock`, `prd_description`, `prd_image`, `prd_status`, `created_at`, `last_updated_at`, `created_by`, `last_updated_by`, `deleted_at`, `deleted_by`) VALUES
(2, NULL, 'C75 0,75 G-NET', NULL, '74500.00', '82000.00', 1, 1, 0, 0, 0, '', NULL, 0, '2021-06-21 02:31:28', NULL, 0, NULL, NULL, NULL),
(3, '', 'C75 0,75 WIRAMA', 1, '68500.00', '77000.00', 1, 1, 0, 0, 0, '', NULL, 0, '2021-06-21 02:32:04', NULL, 0, NULL, NULL, NULL),
(4, '', 'C75 0,75 MAXI', 1, '66500.00', '73000.00', 1, 1, 0, 0, 0, '', NULL, 0, '2021-06-21 02:32:31', NULL, 0, NULL, NULL, NULL),
(5, '', 'C75 0,70 A-PLUS (motif)', 1, '66000.00', '72000.00', 1, 1, 0, 0, 0, '', NULL, 0, '2021-06-21 02:34:58', NULL, 0, NULL, NULL, NULL),
(6, '', 'C75 0,70 A-PLUS (polos)', 1, '65000.00', '71000.00', 1, 1, 0, 0, 0, '', NULL, 0, '2021-06-21 02:35:25', NULL, 0, NULL, NULL, NULL),
(11, '2', '1 edited', 16, '9.00', '8.00', 17, 7, 7, 8, 9, '65', 'assets/uploaded_files/product_img/96f50b0fa38282d2f7af5f0b03c859d5.jpg', 0, '2021-12-27 04:21:38', NULL, 0, NULL, '2021-12-31 05:38:05', 0),
(12, '', 'Aa Complete new product', 16, '1.00', '1.00', 17, 1, 1, 1, 1, '1', NULL, 0, '2021-12-27 07:04:16', NULL, 0, NULL, NULL, NULL),
(13, 'q1', 'ZZnew', 13, '1.00', '1.00', 1, 1, 1, 1, 1, '1', NULL, 0, '2022-01-04 00:41:39', NULL, 0, NULL, NULL, NULL),
(14, 'AAn1', 'AAnew Product edited', 16, '0.01', '1.00', 17, 1, 10, 9, 8, '1qwerty edited', NULL, 0, '2022-01-06 02:32:24', NULL, 0, NULL, NULL, NULL);

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
  `pfl_id` int(11) NOT NULL,
  `pfl_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pfl_logo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pfl_email` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pfl_telp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pfl_fax` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pfl_address` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_profile`
--

INSERT INTO `tb_profile` (`pfl_id`, `pfl_name`, `pfl_logo`, `pfl_email`, `pfl_telp`, `pfl_fax`, `pfl_address`) VALUES
(1, 'Toko 1', 'assets/dist/img/94334252d6528aa79e1c398cb2ae4d9d.png', 'email@eamial.com', '0289292929', '0289323232', 'Jl. Alamat Toko no. 1, Kelurahan Alamat, Kecamatan Toko, Kota NomorSatu ');

-- --------------------------------------------------------

--
-- Table structure for table `tb_stock_mutation`
--

CREATE TABLE `tb_stock_mutation` (
  `sm_id` int(11) NOT NULL,
  `sm_prd_id_fk` int(11) NOT NULL,
  `sm_date` date NOT NULL,
  `sm_stock_from` varchar(3) NOT NULL,
  `sm_stock_to` varchar(3) NOT NULL,
  `sm_qty` int(5) NOT NULL,
  `sm_post_script` longtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_stock_mutation`
--

INSERT INTO `tb_stock_mutation` (`sm_id`, `sm_prd_id_fk`, `sm_date`, `sm_stock_from`, `sm_stock_to`, `sm_qty`, `sm_post_script`, `created_at`, `created_by`) VALUES
(1, 2, '2022-01-06', 'SG', 'SNG', 1, '1212', '2022-01-05 22:45:50', 0),
(2, 2, '2022-01-09', 'SG', 'SNG', 1, 'qwerty', '2022-01-06 00:58:02', 0),
(3, 2, '2022-01-07', 'SG', 'SO', 8, 'zxcvbn', '2022-01-06 01:06:47', 0),
(4, 2, '2022-01-11', 'SO', 'SNG', 3, 'asdfg', '2022-01-06 01:07:42', 0),
(5, 3, '2022-01-06', 'SG', 'SO', 9, 'qwerty', '2022-01-06 01:16:47', 0),
(6, 3, '2022-01-07', 'SG', 'SNG', 8, 'asdfgh', '2022-01-06 01:17:35', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_supplier`
--

CREATE TABLE `tb_supplier` (
  `supp_id` int(11) NOT NULL,
  `supp_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supp_contact_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supp_email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supp_telp` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supp_address` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `supp_status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL,
  `last_updated_at` timestamp NULL DEFAULT NULL,
  `last_updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_supplier`
--

INSERT INTO `tb_supplier` (`supp_id`, `supp_name`, `supp_contact_name`, `supp_email`, `supp_telp`, `supp_address`, `supp_status`, `created_at`, `created_by`, `last_updated_at`, `last_updated_by`) VALUES
(1, 'Supplier A', 'Pak Prasetyo A', '', '', '', 0, '2021-06-23 02:45:08', 1, NULL, NULL),
(2, 'Supplier B', 'Anwar S', 'email@email.com', '1', 'a', 0, '2021-06-23 03:11:23', 1, '2021-06-23 03:11:46', 1),
(3, 'Untuk Dihapus', 'aa', '', '', '', 1, '2021-06-23 03:14:36', 1, '2021-06-23 03:18:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_unit`
--

CREATE TABLE `tb_unit` (
  `unit_id` int(11) NOT NULL,
  `unit_name` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_unit`
--

INSERT INTO `tb_unit` (`unit_id`, `unit_name`) VALUES
(1, 'Batang'),
(3, 'Botol'),
(4, 'Piece'),
(5, 'Meter'),
(6, 'Meter kubik'),
(7, 'sak'),
(17, 'A Test'),
(18, 'ZZZ');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `u_id` int(11) NOT NULL,
  `u_username` varchar(50) NOT NULL,
  `u_password` text NOT NULL,
  `u_name` varchar(50) NOT NULL,
  `u_level` varchar(4) NOT NULL,
  `u_status` varchar(2) NOT NULL DEFAULT 'A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`u_id`, `u_username`, `u_password`, `u_name`, `u_level`, `u_status`) VALUES
(1, 'administrator', '$2y$10$GDIp1vbzYQy/yXYMqcyHXeuRLBfZ.VzR1ZeM2/VDWGkIja1B2E.ly', 'Administrator', 'uAll', 'A'),
(2, 'kasir1', '$2y$10$WmUlf.Yj8.ToyNM/sVMdIOaVaSYfuuGZpRnL.p9wFA026TajYg63C', 'Kasir 1', 'uK', 'A'),
(3, 'owner', '$2y$10$ThVej2/YTKLF1Ro/6ZKK0ea3Ft16Tw478up5ZoHDJgze50IuPZj.2', 'Akun Owner', 'uO', 'A'),
(4, 'gudang', '$2y$10$4Yb8/bdFyZ/WHZiO39FTgOAMSFijef/c0I/EjDN39u6SaYwPPz5kq', 'Akun Gudang', 'uG', 'A'),
(5, 'purchasing', '$2y$10$b2grq/gg9cmPKODohcRLse3Z9OsOcT6NQqEYZvwiNhucETzs2YlQG', 'Staff Purchasing', 'uP', 'A'),
(6, 'kasir2', '$2y$10$0VAUTtnrkVWOPJoj6SUTE.knZ7sQgm62ulJbAPF1RkwAUUthjE2xK', 'Kasir 2', 'uK', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `temp_purchases`
--

CREATE TABLE `temp_purchases` (
  `tp_id` int(11) NOT NULL,
  `tp_product_fk` int(11) NOT NULL,
  `tp_product_amount` int(11) NOT NULL,
  `tp_purchase_price` decimal(10,2) NOT NULL,
  `tp_total_paid` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `temp_sales`
--

CREATE TABLE `temp_sales` (
  `temps_id` int(11) NOT NULL,
  `temps_product_fk` int(11) NOT NULL,
  `temps_product_amount` int(11) NOT NULL,
  `temps_sale_price` decimal(10,2) NOT NULL,
  `temps_discount` decimal(10,2) NOT NULL,
  `temps_total_paid` decimal(10,2) NOT NULL,
  `cart_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trans_expenses`
--

CREATE TABLE `trans_expenses` (
  `te_id` int(11) NOT NULL,
  `te_necessity` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `te_date` date NOT NULL,
  `te_payment_method` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `te_payment` decimal(10,2) NOT NULL,
  `te_note_code` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `te_account_id_fk` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `te_note_file` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trans_expenses`
--

INSERT INTO `trans_expenses` (`te_id`, `te_necessity`, `te_date`, `te_payment_method`, `te_payment`, `te_note_code`, `te_account_id_fk`, `te_note_file`, `created_at`, `created_by`) VALUES
(1, 'Perbaikan', '2021-07-06', 'TN', '500000.00', '202107060001', '', 'assets/uploaded_files/expense_note/93f174dd98976fd4d987e825265ef8cd.jpg', '2021-07-06 06:28:46', 5),
(2, 'Imbuse', '2021-03-06', 'TF', '200000.00', '202103060001', '1', 'assets/uploaded_files/expense_note/2a8942565b0cc0242006db4589f01186.jpg', '2021-07-06 06:29:53', 5);

-- --------------------------------------------------------

--
-- Table structure for table `trans_purchases`
--

CREATE TABLE `trans_purchases` (
  `tp_id` int(11) NOT NULL,
  `tp_note_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tp_note_file` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tp_date` date NOT NULL,
  `tp_supplier_fk` int(11) NOT NULL,
  `tp_payment_method` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tp_additional_cost` decimal(10,2) DEFAULT 0.00,
  `tp_total_cost` decimal(10,2) NOT NULL,
  `tp_account_fk` int(11) DEFAULT NULL,
  `tp_paid` decimal(10,2) NOT NULL,
  `tp_payment_status` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tp_tenor` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tp_tenor_periode` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tp_installment` decimal(10,2) DEFAULT NULL,
  `tp_due_date` date DEFAULT NULL,
  `tp_delete` int(11) NOT NULL DEFAULT 0,
  `tp_post_script` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tp_return_status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trans_purchases`
--

INSERT INTO `trans_purchases` (`tp_id`, `tp_note_code`, `tp_note_file`, `tp_date`, `tp_supplier_fk`, `tp_payment_method`, `tp_additional_cost`, `tp_total_cost`, `tp_account_fk`, `tp_paid`, `tp_payment_status`, `tp_tenor`, `tp_tenor_periode`, `tp_installment`, `tp_due_date`, `tp_delete`, `tp_post_script`, `tp_return_status`, `created_at`, `created_by`) VALUES
(1, '202107010001', 'assets/uploaded_files/purchase_note/ce2ba7d65b8b7c09b81178bdc55980fc.jpg', '2021-01-07', 1, 'TN', '150000.00', '4240000.00', 0, '4240000.00', 'T', '', '', '0.00', '0000-00-00', 0, 'Qwerty', 0, '2021-07-06 06:11:02', 5),
(2, '202107020001', 'assets/uploaded_files/purchase_note/e7a4abb23c95ef57894d574563e2b623.jpg', '2021-02-07', 2, 'TF', '0.00', '985000.00', 1, '985000.00', 'T', '', '', '0.00', '0000-00-00', 0, '', 0, '2021-07-06 06:13:10', 5),
(3, '202107040001', 'assets/uploaded_files/purchase_note/ed663f067e7bb0353d54e29c08304c47.jpg', '2021-04-07', 1, 'TN', '198000.00', '2000000.00', 0, '500000.00', 'K', '5', 'M', '350000.00', '2021-05-07', 0, '', 0, '2021-07-06 06:18:13', 5),
(4, '202107070001', 'assets/uploaded_files/purchase_note/ac48de9d5861b8f7fb49ff01bcbc8bf7.jpg', '2021-07-07', 1, 'TF', '10000.00', '1500000.00', 2, '1500000.00', 'T', '', '', '0.00', '0000-00-00', 0, '', 0, '2021-07-06 06:22:16', 5),
(5, '202107080001', 'assets/uploaded_files/purchase_note/ef2b568e8bb4b12d2656f70b2bec6a71.jpg', '2021-08-07', 2, 'TN', '0.00', '6440000.00', 0, '0.00', 'K', '10', 'M', '700000.00', '2021-09-07', 0, '', 0, '2021-07-06 06:23:27', 5),
(6, '202107110001', 'assets/uploaded_files/purchase_note/23fcf598addf1f92cd97a581ebcbc1cc.jpg', '2021-11-08', 1, 'TN', '0.00', '1292500.00', 0, '1292500.00', 'T', '', '', '0.00', '0000-00-00', 0, '', 0, '2021-07-06 06:27:20', 5);

-- --------------------------------------------------------

--
-- Table structure for table `trans_revenues`
--

CREATE TABLE `trans_revenues` (
  `tr_id` int(11) NOT NULL,
  `tr_trans_code` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tr_source` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tr_date` date NOT NULL,
  `tr_payment_method` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tr_payment` decimal(10,2) NOT NULL,
  `tr_account_id_fk` int(11) DEFAULT NULL,
  `tr_post_script` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trans_sales`
--

CREATE TABLE `trans_sales` (
  `ts_id` int(11) NOT NULL,
  `ts_trans_code` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ts_date` date NOT NULL,
  `ts_customer_fk` int(11) NOT NULL,
  `ts_payment_method` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ts_delivery_method` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ts_delivery_fee` decimal(10,2) DEFAULT 0.00,
  `ts_total_sales` decimal(10,2) NOT NULL,
  `ts_account_fk` int(11) DEFAULT NULL,
  `ts_payment` decimal(10,2) NOT NULL,
  `ts_payment_status` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ts_tenor` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ts_tenor_periode` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ts_installment` decimal(10,2) DEFAULT NULL,
  `ts_due_date` date DEFAULT NULL,
  `ts_return` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ts_invoice` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ts_cancel` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trans_sales`
--

INSERT INTO `trans_sales` (`ts_id`, `ts_trans_code`, `ts_date`, `ts_customer_fk`, `ts_payment_method`, `ts_delivery_method`, `ts_delivery_fee`, `ts_total_sales`, `ts_account_fk`, `ts_payment`, `ts_payment_status`, `ts_tenor`, `ts_tenor_periode`, `ts_installment`, `ts_due_date`, `ts_return`, `ts_invoice`, `ts_cancel`, `created_at`, `created_by`) VALUES
(1, 'TK220210706000001', '2021-01-06', 1, 'TN', 'E', '75500.00', '2119000.00', NULL, '21119000.00', 'T', NULL, NULL, NULL, NULL, 'N', NULL, 0, '2021-07-06 06:32:57', 2);

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
-- Indexes for table `det_return_supplier`
--
ALTER TABLE `det_return_supplier`
  ADD PRIMARY KEY (`drs_id`);

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
  ADD PRIMARY KEY (`rc_id`),
  ADD UNIQUE KEY `rc_ts_id_fk` (`rc_ts_id_fk`),
  ADD UNIQUE KEY `rc_code` (`rc_code`);

--
-- Indexes for table `return_supplier`
--
ALTER TABLE `return_supplier`
  ADD PRIMARY KEY (`rs_id`),
  ADD KEY `rs_tp_id_fk` (`rs_tp_id_fk`) USING BTREE;

--
-- Indexes for table `tb_bank_account`
--
ALTER TABLE `tb_bank_account`
  ADD PRIMARY KEY (`acc_id`),
  ADD UNIQUE KEY `acc_number` (`acc_number`);

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
  ADD KEY `prd_barcode` (`prd_code`) USING BTREE,
  ADD KEY `category_fk` (`prd_category_id_fk`),
  ADD KEY `unit_fk` (`prd_unit_id_fk`);

--
-- Indexes for table `tb_profile`
--
ALTER TABLE `tb_profile`
  ADD PRIMARY KEY (`pfl_id`);

--
-- Indexes for table `tb_stock_mutation`
--
ALTER TABLE `tb_stock_mutation`
  ADD PRIMARY KEY (`sm_id`);

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
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`u_id`),
  ADD UNIQUE KEY `u_username` (`u_username`);

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
-- Indexes for table `trans_expenses`
--
ALTER TABLE `trans_expenses`
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
  MODIFY `stk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `det_return_customer`
--
ALTER TABLE `det_return_customer`
  MODIFY `drc_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `det_return_supplier`
--
ALTER TABLE `det_return_supplier`
  MODIFY `drs_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `det_trans_purchases`
--
ALTER TABLE `det_trans_purchases`
  MODIFY `dtp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `det_trans_sales`
--
ALTER TABLE `det_trans_sales`
  MODIFY `dts_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `installment_purchases`
--
ALTER TABLE `installment_purchases`
  MODIFY `ip_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `installment_sales`
--
ALTER TABLE `installment_sales`
  MODIFY `is_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ref_bank`
--
ALTER TABLE `ref_bank`
  MODIFY `bank_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `return_customer`
--
ALTER TABLE `return_customer`
  MODIFY `rc_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `return_supplier`
--
ALTER TABLE `return_supplier`
  MODIFY `rs_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_bank_account`
--
ALTER TABLE `tb_bank_account`
  MODIFY `acc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_category`
--
ALTER TABLE `tb_category`
  MODIFY `ctgr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tb_customer`
--
ALTER TABLE `tb_customer`
  MODIFY `ctm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_invoice`
--
ALTER TABLE `tb_invoice`
  MODIFY `inv_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_product`
--
ALTER TABLE `tb_product`
  MODIFY `prd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tb_profile`
--
ALTER TABLE `tb_profile`
  MODIFY `pfl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_stock_mutation`
--
ALTER TABLE `tb_stock_mutation`
  MODIFY `sm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_supplier`
--
ALTER TABLE `tb_supplier`
  MODIFY `supp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_unit`
--
ALTER TABLE `tb_unit`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `temp_purchases`
--
ALTER TABLE `temp_purchases`
  MODIFY `tp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temp_sales`
--
ALTER TABLE `temp_sales`
  MODIFY `temps_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trans_expenses`
--
ALTER TABLE `trans_expenses`
  MODIFY `te_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `trans_purchases`
--
ALTER TABLE `trans_purchases`
  MODIFY `tp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `trans_revenues`
--
ALTER TABLE `trans_revenues`
  MODIFY `tr_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trans_sales`
--
ALTER TABLE `trans_sales`
  MODIFY `ts_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `det_product_stock`
--
ALTER TABLE `det_product_stock`
  ADD CONSTRAINT `product_id_fk` FOREIGN KEY (`stk_product_id_fk`) REFERENCES `tb_product` (`prd_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_product`
--
ALTER TABLE `tb_product`
  ADD CONSTRAINT `category_fk` FOREIGN KEY (`prd_category_id_fk`) REFERENCES `tb_category` (`ctgr_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `unit_fk` FOREIGN KEY (`prd_unit_id_fk`) REFERENCES `tb_unit` (`unit_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
