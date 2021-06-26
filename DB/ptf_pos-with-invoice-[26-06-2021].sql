-- phpMyAdmin SQL Dump
-- version 5.2.0-dev+20210518.4dec56d883
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 26, 2021 at 05:06 PM
-- Server version: 10.3.29-MariaDB-0ubuntu0.20.04.1
-- PHP Version: 8.0.7

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
(1, 1, 10, 0, 0),
(2, 2, 10, 0, 0),
(3, 3, 111, -2, 0),
(4, 4, 62, -4, 0),
(5, 5, 23, -6, 0),
(6, 6, 10, 0, 0),
(7, 7, 10, 0, 0),
(8, 8, 10, 0, 0);

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

--
-- Dumping data for table `det_return_customer`
--

INSERT INTO `det_return_customer` (`drc_id`, `drc_rc_id_fk`, `drc_product_id_fk`, `drc_return_qty`) VALUES
(1, 1, 3, 1),
(2, 1, 4, 2),
(3, 1, 5, 3);

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

--
-- Dumping data for table `det_return_supplier`
--

INSERT INTO `det_return_supplier` (`drs_id`, `drs_rs_id_fk`, `drs_product_id_fk`, `drs_return_qty`) VALUES
(1, 1, 3, 1),
(2, 1, 4, 2),
(3, 1, 5, 3),
(4, 2, 3, 1),
(5, 2, 4, 2),
(6, 2, 5, 3);

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
(1, '1', 3, 100, '68500.00', '6850000.00'),
(2, '1', 4, 50, '66500.00', '3325000.00'),
(3, '1', 5, 11, '66000.00', '726000.00');

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
(2, '1', 4, 10, '66500.00', '0.00', '665000.00'),
(3, '1', 5, 10, '66000.00', '0.00', '660000.00');

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

--
-- Dumping data for table `return_customer`
--

INSERT INTO `return_customer` (`rc_id`, `rc_code`, `rc_ts_id_fk`, `rc_date`, `rc_status`, `rc_cash`, `rc_post_script`, `created_at`, `created_by`) VALUES
(1, 'RC112021062600001', 1, '2021-06-28 17:00:00', 'U', '100000.00', '', '2021-06-26 02:24:06', 1);

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

--
-- Dumping data for table `return_supplier`
--

INSERT INTO `return_supplier` (`rs_id`, `rs_tp_id_fk`, `rs_date`, `rs_status`, `rs_cash_out`, `rs_cash_in`, `rs_post_script`, `created_at`, `created_by`) VALUES
(1, 1, '2021-06-27', 'R', '0.00', '0.00', 'qwerty', '2021-06-26 09:55:11', 1),
(2, 1, '2021-06-28', 'U', '0.00', '50000.00', '', '2021-06-26 09:55:45', 1);

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
(12, 'Lain - lain', '2021-06-21 02:27:42', '0000-00-00 00:00:00', 1, 0);

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
  `prd_barcode` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prd_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `prd_category_id_fk` int(11) DEFAULT NULL,
  `prd_purchase_price` decimal(10,2) NOT NULL,
  `prd_selling_price` decimal(10,2) NOT NULL,
  `prd_unit_id_fk` int(11) DEFAULT NULL,
  `prd_containts` int(11) DEFAULT NULL,
  `prd_initial_g_stock` int(11) NOT NULL DEFAULT 0,
  `prd_initial_ng_stock` int(11) NOT NULL DEFAULT 0,
  `prd_initial_op_stock` int(11) NOT NULL DEFAULT 0,
  `prd_description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `prd_image` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prd_status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(3) NOT NULL,
  `last_updated_by` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_product`
--

INSERT INTO `tb_product` (`prd_id`, `prd_barcode`, `prd_name`, `prd_category_id_fk`, `prd_purchase_price`, `prd_selling_price`, `prd_unit_id_fk`, `prd_containts`, `prd_initial_g_stock`, `prd_initial_ng_stock`, `prd_initial_op_stock`, `prd_description`, `prd_image`, `prd_status`, `created_at`, `last_updated_at`, `created_by`, `last_updated_by`) VALUES
(1, '', 'C75 0,75 M-NET', 1, '70000.00', '85000.00', 1, 1, 0, 0, 0, '', NULL, 0, '2021-06-21 02:30:33', NULL, 0, NULL),
(2, '', 'C75 0,75 G-NET', 1, '74500.00', '82000.00', 1, 1, 0, 0, 0, '', NULL, 0, '2021-06-21 02:31:28', NULL, 0, NULL),
(3, '', 'C75 0,75 WIRAMA', 1, '68500.00', '77000.00', 1, 1, 0, 0, 0, '', NULL, 0, '2021-06-21 02:32:04', NULL, 0, NULL),
(4, '', 'C75 0,75 MAXI', 1, '66500.00', '73000.00', 1, 1, 0, 0, 0, '', NULL, 0, '2021-06-21 02:32:31', NULL, 0, NULL),
(5, '', 'C75 0,70 A-PLUS (motif)', 1, '66000.00', '72000.00', 1, 1, 0, 0, 0, '', NULL, 0, '2021-06-21 02:34:58', NULL, 0, NULL),
(6, '', 'C75 0,70 A-PLUS (polos)', 1, '65000.00', '71000.00', 1, 1, 0, 0, 0, '', NULL, 0, '2021-06-21 02:35:25', NULL, 0, NULL),
(7, '', 'Galvalume 0,30 G-NET 4m', 3, '147200.00', '168000.00', 2, 1, 0, 0, 0, '', NULL, 0, '2021-06-21 02:36:10', NULL, 0, NULL),
(8, '', 'Galvalume 0,30 G-NET 5m', 3, '184000.00', '210000.00', 2, 1, 0, 0, 0, '', NULL, 0, '2021-06-21 02:36:41', NULL, 0, NULL);

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
(2, 'Lembar'),
(3, 'Botol'),
(4, 'Piece'),
(5, 'Meter'),
(6, 'Meter kubik'),
(7, 'sak');

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
(5, 'purchasing', '$2y$10$b2grq/gg9cmPKODohcRLse3Z9OsOcT6NQqEYZvwiNhucETzs2YlQG', 'Staff Purchasing', 'uP', 'A');

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
  `temps_total_paid` decimal(10,2) NOT NULL
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
  `te_note_file` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trans_purchases`
--

CREATE TABLE `trans_purchases` (
  `tp_id` int(11) NOT NULL,
  `tp_note_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tp_note_file` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tp_date` timestamp NOT NULL DEFAULT current_timestamp(),
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
(1, 'TP20210628000001', 'assets/uploaded_files/purchase_note/153346910f8800099a7bec9f3eb4f065.jpg', '2021-06-27 17:00:00', 1, 'TN', '599000.00', '11500000.00', 0, '11500000.00', 'T', '', '', '0.00', '0000-00-00', 0, '', 0, '2021-06-26 09:53:58', 1);

-- --------------------------------------------------------

--
-- Table structure for table `trans_revenues`
--

CREATE TABLE `trans_revenues` (
  `tr_id` int(11) NOT NULL,
  `tr_trans_code` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tr_source` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tr_date` datetime NOT NULL,
  `tr_payment_method` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tr_payment` decimal(10,2) NOT NULL,
  `tr_account_id_fk` int(11) DEFAULT NULL,
  `tr_post_script` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trans_sales`
--

CREATE TABLE `trans_sales` (
  `ts_id` int(11) NOT NULL,
  `ts_trans_code` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ts_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
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
  `ts_delete` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trans_sales`
--

INSERT INTO `trans_sales` (`ts_id`, `ts_trans_code`, `ts_date`, `ts_customer_fk`, `ts_payment_method`, `ts_delivery_method`, `ts_delivery_fee`, `ts_total_sales`, `ts_account_fk`, `ts_payment`, `ts_payment_status`, `ts_tenor`, `ts_tenor_periode`, `ts_installment`, `ts_due_date`, `ts_return`, `ts_invoice`, `ts_delete`, `created_at`, `created_by`) VALUES
(1, 'TK120210626000001', '2021-06-26 01:48:13', 1, 'TN', 'E', '90000.00', '2100000.00', NULL, '2100000.00', 'T', NULL, NULL, NULL, NULL, 'Y', NULL, 0, '2021-06-26 01:44:43', 1);

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
  ADD KEY `prd_barcode` (`prd_barcode`) USING BTREE,
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
  MODIFY `stk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `det_return_customer`
--
ALTER TABLE `det_return_customer`
  MODIFY `drc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `det_return_supplier`
--
ALTER TABLE `det_return_supplier`
  MODIFY `drs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `det_trans_purchases`
--
ALTER TABLE `det_trans_purchases`
  MODIFY `dtp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `det_trans_sales`
--
ALTER TABLE `det_trans_sales`
  MODIFY `dts_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `rc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `return_supplier`
--
ALTER TABLE `return_supplier`
  MODIFY `rs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_bank_account`
--
ALTER TABLE `tb_bank_account`
  MODIFY `acc_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_category`
--
ALTER TABLE `tb_category`
  MODIFY `ctgr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
  MODIFY `prd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_profile`
--
ALTER TABLE `tb_profile`
  MODIFY `pfl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_stock_mutation`
--
ALTER TABLE `tb_stock_mutation`
  MODIFY `sm_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_supplier`
--
ALTER TABLE `tb_supplier`
  MODIFY `supp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_unit`
--
ALTER TABLE `tb_unit`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `te_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trans_purchases`
--
ALTER TABLE `trans_purchases`
  MODIFY `tp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  ADD CONSTRAINT `category_fk` FOREIGN KEY (`prd_category_id_fk`) REFERENCES `tb_category` (`ctgr_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `unit_fk` FOREIGN KEY (`prd_unit_id_fk`) REFERENCES `tb_unit` (`unit_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
