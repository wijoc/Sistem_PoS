-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 12, 2021 at 03:58 AM
-- Server version: 10.5.9-MariaDB
-- PHP Version: 8.0.2

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
  `stk_opname` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `det_product_stock`
--

INSERT INTO `det_product_stock` (`stk_id`, `stk_product_id_fk`, `stk_good`, `stk_not_good`, `stk_opname`) VALUES
(1, 1, 0, 0, 0),
(2, 2, 0, 0, 0),
(3, 3, 1, 1, 1),
(4, 6, 1, 1, 1),
(5, 7, 1, 1, 1),
(6, 8, 0, 0, 0),
(7, 9, 0, 0, 0),
(8, 4, 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `det_return_customer`
--

CREATE TABLE `det_return_customer` (
  `drc_id` int(5) NOT NULL,
  `rc_id_fk` int(5) NOT NULL,
  `prd_id_fk` int(5) NOT NULL,
  `drc_qty` int(3) NOT NULL,
  `drc_status` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `det_trans_purchases`
--

CREATE TABLE `det_trans_purchases` (
  `dtp_id` int(3) NOT NULL,
  `dtp_tp_fk` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dtp_product_fk` int(3) NOT NULL,
  `dtp_product_amount` int(5) NOT NULL,
  `dtp_purchase_price` decimal(10,2) NOT NULL,
  `dtp_total_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `return_customer`
--

CREATE TABLE `return_customer` (
  `rc_id` int(5) NOT NULL,
  `ts_id_fk` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rc_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `rc_paid` decimal(10,2) DEFAULT NULL,
  `rc_note` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `return_customer`
--

INSERT INTO `return_customer` (`rc_id`, `ts_id_fk`, `rc_date`, `rc_paid`, `rc_note`) VALUES
(1, '1', '2021-02-03 12:13:00', '1231231.00', 'asdasdasd');

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
(10, 'Bor'),
(11, 'Dinabol');

-- --------------------------------------------------------

--
-- Table structure for table `tb_customer`
--

CREATE TABLE `tb_customer` (
  `ctm_id` int(3) NOT NULL,
  `ctm_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ctm_phone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ctm_email` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ctm_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ctm_status` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_customer`
--

INSERT INTO `tb_customer` (`ctm_id`, `ctm_name`, `ctm_phone`, `ctm_email`, `ctm_address`, `ctm_status`) VALUES
(1, 'Pelanggan A', '', '', '', 'Y'),
(2, 'Pelanggan B', '', '', '', 'Y'),
(3, 'Pelanggan C', '', '', '', 'Y'),
(4, 'Pelanggan D', '088892349233', 'email@email.com', 'Alamat alamat kota alamat edited', 'Y'),
(5, 'Pelanggan E', '', 'emailsurel@surmail.com', '', 'Y'),
(6, 'Pelanggan F', '0897654321', '', 'Editeed', 'Y'),
(7, 'Pelanggan G', '08666666', 'GsixG@email.com', 'alamatpelanggan G', 'Y'),
(8, 'Pelanggan H', '011111111', '', '', 'Y'),
(9, 'Pelanggan I', '', '', '', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `tb_invoice`
--

CREATE TABLE `tb_invoice` (
  `inv_id` int(5) NOT NULL,
  `ts_id_fk` int(5) NOT NULL,
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
  `prd_initial_op_stock` int(6) NOT NULL DEFAULT 0,
  `prd_description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `prd_image` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prd_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_product`
--

INSERT INTO `tb_product` (`prd_id`, `prd_barcode`, `prd_name`, `prd_category_id_fk`, `prd_purchase_price`, `prd_selling_price`, `prd_unit_id_fk`, `prd_containts`, `prd_initial_g_stock`, `prd_initial_ng_stock`, `prd_initial_op_stock`, `prd_description`, `prd_image`, `prd_status`) VALUES
(1, '', 'C75 0,75 M-NET', 1, '70000.00', '85000.00', '1', 1, 0, 0, 0, 'Deskripsi', NULL, 0),
(2, '', 'C75 0,75 G-NET', 1, '74500.00', '82000.00', '1', 1, 0, 0, 0, 'Deskripsi', NULL, 0),
(3, '', 'Product to delete', 5, '1.00', '1.00', '3', 1, 1, 1, 1, 'asdasdasda', 'assets/uploaded_files/product_img/a4c720227a5543879883c7374ec3e5a2.png', 1),
(4, 'BPrdE', 'Produk Edited', 5, '99.00', '100.99', '2', 10, 0, 0, 0, 'Deskripsi product edited', 'assets/uploaded_files/product_img/bcb4f42bfa740438eb25ca7f80e07a3e.jpeg', 1),
(5, '', '1', 10, '1.00', '1.00', '1', 1, 1, 1, 1, '1', NULL, 1),
(6, '', '1', 10, '1.00', '1.00', '1', 1, 1, 1, 1, '1', NULL, 1),
(7, '', '99', 10, '1.00', '1.00', '1', 1, 1, 1, 1, '1', NULL, 1),
(8, '', 'C75 0,75 WIRAMA', 1, '68500.00', '77000.00', '1', 1, 0, 0, 0, 'Deskripsi', NULL, 0),
(9, '', 'C75 0,75 MAXI', 1, '66500.00', '73000.00', '1', 1, 0, 0, 0, '', NULL, 0);

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
  `pfl_id` int(5) NOT NULL,
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
(35, 'Untuk dihapus', 'Kontak', '', '', '', 1);

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
-- Table structure for table `temp_purchases`
--

CREATE TABLE `temp_purchases` (
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
-- Table structure for table `trans_expense`
--

CREATE TABLE `trans_expense` (
  `te_id` int(5) NOT NULL,
  `te_necessity` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `te_date` date NOT NULL,
  `te_payment_method` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `te_payment` decimal(10,2) NOT NULL,
  `te_note` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `te_account_id_fk` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `te_invoice` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trans_purchases`
--

CREATE TABLE `trans_purchases` (
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
  `tp_status` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tp_tenor` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tp_tenor_periode` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tp_installment` decimal(10,2) DEFAULT NULL,
  `tp_due_date` date DEFAULT NULL,
  `tp_delete` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trans_revenues`
--

CREATE TABLE `trans_revenues` (
  `tr_id` int(5) NOT NULL,
  `tr_trans_code` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tr_source` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tr_date` datetime NOT NULL,
  `tr_payment_method` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tr_payment` decimal(10,2) NOT NULL,
  `tr_account_id_fk` int(5) DEFAULT NULL,
  `tr_note` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trans_sales`
--

CREATE TABLE `trans_sales` (
  `ts_id` int(5) NOT NULL,
  `ts_trans_code` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ts_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ts_customer_fk` int(5) NOT NULL,
  `ts_payment_metode` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ts_delivery_metode` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ts_delivery_payment` decimal(10,2) NOT NULL,
  `ts_sales_price` decimal(10,2) NOT NULL,
  `ts_account_fk` int(3) DEFAULT NULL,
  `ts_paid` decimal(10,2) NOT NULL,
  `ts_status` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ts_tenor` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ts_tenor_periode` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ts_installment` decimal(10,2) DEFAULT NULL,
  `ts_due_date` date DEFAULT NULL,
  `ts_invoice` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ts_delete` int(2) NOT NULL DEFAULT 0,
  `ts_return` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL
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
  ADD UNIQUE KEY `tp_no_trans` (`tp_trans_code`);

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
  MODIFY `drc_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `det_trans_purchases`
--
ALTER TABLE `det_trans_purchases`
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
-- AUTO_INCREMENT for table `return_customer`
--
ALTER TABLE `return_customer`
  MODIFY `rc_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_category`
--
ALTER TABLE `tb_category`
  MODIFY `ctgr_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tb_customer`
--
ALTER TABLE `tb_customer`
  MODIFY `ctm_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_invoice`
--
ALTER TABLE `tb_invoice`
  MODIFY `inv_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_product`
--
ALTER TABLE `tb_product`
  MODIFY `prd_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_profile`
--
ALTER TABLE `tb_profile`
  MODIFY `pfl_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_rekening_bank`
--
ALTER TABLE `tb_rekening_bank`
  MODIFY `rek_id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_supplier`
--
ALTER TABLE `tb_supplier`
  MODIFY `supp_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tb_unit`
--
ALTER TABLE `tb_unit`
  MODIFY `unit_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `temp_purchases`
--
ALTER TABLE `temp_purchases`
  MODIFY `tp_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temp_sales`
--
ALTER TABLE `temp_sales`
  MODIFY `temps_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trans_expense`
--
ALTER TABLE `trans_expense`
  MODIFY `te_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trans_purchases`
--
ALTER TABLE `trans_purchases`
  MODIFY `tp_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trans_revenues`
--
ALTER TABLE `trans_revenues`
  MODIFY `tr_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trans_sales`
--
ALTER TABLE `trans_sales`
  MODIFY `ts_id` int(5) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
