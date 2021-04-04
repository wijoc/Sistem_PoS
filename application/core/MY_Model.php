<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {
  
    /** Table Product */
        protected $prd_tb = 'tb_product';
        protected $prd_f  = array(
            '0' => 'prd_id',
            '1' => 'prd_barcode',
            '2' => 'prd_name',
            '3' => 'prd_category_id_fk',
            '4' => 'prd_purchase_price',
            '5' => 'prd_selling_price',
            '6' => 'prd_unit_id_fk',
            '7' => 'prd_containts',
            '8' => 'prd_initial_g_stock',
            '9' => 'prd_initial_ng_stock',
            '10' => 'prd_initial_op_stock',
            '11' => 'prd_description',
            '12' => 'prd_status',
            '13' => 'prd_image'
        );
  
    /** Table Stock */
        protected $stk_tb = 'det_product_stock';
        protected $stk_f  = array(
            '0' => 'stk_id',
            '1' => 'stk_product_id_fk',
            '2' => 'stk_good',
            '3' => 'stk_not_good',
            '4' => 'stk_opname'
        );
  
    /** Table Kategori */
        protected $ctgr_tb = 'tb_category';
        protected $ctgr_f  = array(
            '0' => 'ctgr_id',
            '1' => 'ctgr_name'
        );
  
    /** Table Satuan */
        protected $unit_tb = 'tb_unit';
        protected $unit_f  = array(
             '0' => 'unit_id',
             '1' => 'unit_name'
        );

    /** Table Supplier */
        protected $supp_tb = 'tb_supplier';
        protected $supp_f  = array(
            '0' => 'supp_id',
            '1' => 'supp_name',
            '2' => 'supp_contact_name',
            '3' => 'supp_email',
            '4' => 'supp_telp',
            '5' => 'supp_address',
            '6' => 'supp_status'
        );
	
    /** Table Customer */
        protected $ctm_tb = 'tb_customer';
        protected $ctm_f  = array(
            '0' => 'ctm_id',
            '1' => 'ctm_name',
            '2' => 'ctm_phone',
            '3' => 'ctm_email',
            '4' => 'ctm_address',
            '5' => 'ctm_status'
        );

    /* Declare var table transaksi purchases */
        protected $tp_tb = 'trans_purchases';
        protected $tp_f  = array(
            '0' => 'tp_id',
            '1' => 'tp_date',
            '2' => 'tp_supplier_fk',
            '3' => 'tp_payment_method',
            '4' => 'tp_total_cost',
            '5' => 'tp_account_fk', // Allow Null
            '6' => 'tp_paid',
            '7' => 'tp_status',
            '8' => 'tp_tenor', // Allow Null
            '9' => 'tp_tenor_periode', // Allow Null
            '10' => 'tp_due_date', // Allow Null
            '11' => 'tp_delete', // as defined 0
            '12' => 'tp_note_code',
            '13' => 'tp_installment',
            '14' => 'tp_note_file',
            '15' => 'tp_additional_cost',
            '16' => 'tp_post_script'
        );

    /* Declare var table detail transaksi purchases */
        protected $dtp_tb = 'det_trans_purchases';
        protected $dtp_f  = array(
            '0' => 'dtp_id',
            '1' => 'dtp_tp_fk',
            '2' => 'dtp_product_fk',
            '3' => 'dtp_product_amount',
            '4' => 'dtp_purchase_price',
            '5' => 'dtp_total_price'
        );

    /* Declare var table keranjang purchases */
        protected $temp_tp = 'temp_purchases';
        protected $temp_f  = array(
            '0' => 'tp_id', 
            '1' => 'tp_product_fk', 
            '2' => 'tp_product_amount', 
            '3' => 'tp_purchase_price',
            '4' => 'tp_total_paid'
        );

	/** Declare var table rekening */
        protected $acc_tb = 'tb_bank_account';
        protected $acc_f = array(
            '0' => 'acc_id',
            '1' => 'acc_bank_code',
            '2' => 'acc_number',
            '3' => 'acc_name'
        );

	/** Declare var table bank */
        protected $bank_tb = 'ref_bank';
        protected $bank_f = array(
            '0' => 'bank_id',
            '1' => 'bank_code',
            '2' => 'bank_name'
        );

	public function __construct(){
		parent::__construct();
	}
}