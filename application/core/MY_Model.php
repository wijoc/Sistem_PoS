<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {
  
    /** Table Product */
        protected $prd_tb = 'tb_product';
        protected $prd_f  = array(
            '0' => 'prd_id',
            '1' => 'prd_code',
            '2' => 'prd_name',
            '3' => 'prd_category_id_fk',
            '4' => 'prd_purchase_price',
            '5' => 'prd_selling_price',
            '6' => 'prd_unit_id_fk',
            '7' => 'prd_contains',
            '8' => 'prd_initial_g_stock',
            '9' => 'prd_initial_ng_stock',
            '10' => 'prd_initial_op_stock',
            '11' => 'prd_description',
            '12' => 'prd_status',
            '13' => 'prd_image',
            '14' => 'created_at',
            '15' => 'created_by',
            '16' => 'last_updated_at',
            '17' => 'last_updated_by',
            '18' => 'deleted_at',
            '19' => 'deleted_by'
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
    
    /** Table Mutasi Stock */
        protected $sm_tb = 'tb_stock_mutation';
        protected $sm_f  = array(
            '0' => 'sm_id',
            '1' => 'sm_prd_id_fk',
            '2' => 'sm_stock_from',
            '3' => 'sm_stock_to',
            '4' => 'sm_qty',
            '5' => 'sm_post_script',
            '6' => 'created_at',
            '7' => 'created_by',
            '8' => 'sm_date'
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
            '6' => 'supp_status',
            '7' => 'created_at',
            '8' => 'created_by',
            '9' => 'last_updated_at',
            '10' => 'last_updated_by'
        );
	
    /** Table Customer */
        protected $ctm_tb = 'tb_customer';
        protected $ctm_f  = array(
            '0' => 'ctm_id',
            '1' => 'ctm_name',
            '2' => 'ctm_phone',
            '3' => 'ctm_email',
            '4' => 'ctm_address',
            '5' => 'ctm_status',
            '6' => 'created_at',
            '7' => 'created_by',
            '8' => 'last_updated_at',
            '9' => 'last_updated_by'
        );

    /** Table Transaksi purchases */
        protected $tp_tb = 'trans_purchases';
        protected $tp_f  = array(
            '0' => 'tp_id',
            '1' => 'tp_date',
            '2' => 'tp_supplier_fk',
            '3' => 'tp_payment_method',
            '4' => 'tp_total_cost',
            '5' => 'tp_account_fk', // Allow Null
            '6' => 'tp_paid',
            '7' => 'tp_payment_status',
            '8' => 'tp_tenor', // Allow Null
            '9' => 'tp_tenor_periode', // Allow Null
            '10' => 'tp_due_date', // Allow Null
            '11' => 'tp_delete', // as defined 0
            '12' => 'tp_note_code',
            '13' => 'tp_installment',
            '14' => 'tp_note_file',
            '15' => 'tp_additional_cost',
            '16' => 'tp_post_script',
            '17' => 'created_at',
            '18' => 'created_by',
            '19' => 'tp_return_status'
        );

    /** Table Detail transaksi purchases */
        protected $dtp_tb = 'det_trans_purchases';
        protected $dtp_f  = array(
            '0' => 'dtp_id',
            '1' => 'dtp_tp_fk',
            '2' => 'dtp_product_fk',
            '3' => 'dtp_product_amount',
            '4' => 'dtp_purchase_price',
            '5' => 'dtp_total_price'
        );

    /** Table keranjang purchases */
        protected $cp_tb = 'temp_purchases';
        protected $cp_f  = array(
            '0' => 'tp_id', 
            '1' => 'tp_product_fk', 
            '2' => 'tp_product_amount', 
            '3' => 'tp_purchase_price',
            '4' => 'tp_total_paid'
        );

	/** Table installment Purcahse */
        protected $ip_tb = 'installment_purchases';
        protected $ip_f  = array(
            '0' => 'ip_id',
            '1' => 'ip_trans_id_fk',
            '2' => 'ip_periode_begin',
            '3' => 'ip_periode_end',
            '4' => 'ip_date',
            '5' => 'ip_payment',
            '6' => 'ip_note_code',
            '7' => 'ip_note_file',
            '8' => 'ip_post_script'
        );

    /** Table Trans Sales */
        protected $ts_tb = 'trans_sales';
        protected $ts_f  = array(
            '0' => 'ts_id',
            '1' => 'ts_trans_code',
            '2' => 'ts_date',
            '3' => 'ts_customer_fk',
            '4' => 'ts_payment_method',
            '5' => 'ts_total_sales',
            '6' => 'ts_account_fk',
            '7' => 'ts_payment',
            '8' => 'ts_payment_status',
            '9' => 'ts_tenor',
            '10' => 'ts_tenor_periode',
            '11' => 'ts_installment',
            '12' => 'ts_due_date',
            '13' => 'ts_cancel',
            '14' => 'ts_delivery_method',
            '15' => 'ts_delivery_fee',
            '16' => 'ts_return',
            '17' => 'created_at',
            '18' => 'created_by'
        );

    /** Table Detail Trans Sales */
        protected $dts_tb = 'det_trans_sales';
        protected $dts_f  = array(
            '0' => 'dts_id',
            '1' => 'dts_ts_id_fk',
            '2' => 'dts_product_fk',
            '3' => 'dts_product_amount',
            '4' => 'dts_sale_price',
            '5' => 'dts_discount',
            '6' => 'dts_total_price'
        );

    /** Table temp / keranjang trans Sales */
        protected $cs_tb = 'temp_sales';
        protected $cs_f  = array(
            '0' => 'temps_id',
            '1' => 'temps_product_fk',
            '2' => 'temps_product_amount',
            '3' => 'temps_sale_price',
            '4' => 'temps_discount',
            '5' => 'temps_total_paid',
            '6' => 'cart_by'
        );

    /** Table installment Sales */
        protected $is_tb = 'installment_sales';
        protected $is_f  = array(
            '0' => 'is_id',
            '1' => 'is_trans_id_fk',
            '2' => 'is_code',
            '3' => 'is_periode',
            '4' => 'is_due_date',
            '5' => 'is_payment',
            '6' => 'is_payment_date',
            '7' => 'is_status',
            '8' => 'is_post_script'
        );

    /** Table Expenses */
        protected $te_tb = 'trans_expenses';
        protected $te_f  = array(
            '0' => 'te_id',
            '1' => 'te_necessity',
            '2' => 'te_date',
            '3' => 'te_payment_method',
            '4' => 'te_payment',
            '5' => 'te_note_code',
            '6' => 'te_account_id_fk',
            '7' => 'te_note_file',
            '8' => 'created_at',
            '9' => 'created_by'
        );
	
	/** Table Revenues */
        protected $tr_tb = 'trans_revenues';
        protected $tr_f  = array(
            '0' => 'tr_id',
            '1' => 'tr_trans_code',
            '2' => 'tr_source',
            '3'	=> 'tr_date',
            '4' => 'tr_payment_method',
            '5' => 'tr_payment',
            '6' => 'tr_account_id_fk',
            '7' => 'tr_post_script',
            '8' => 'created_at',
            '9' => 'created_by'
        );

    /** Table Return Supplier */
        protected $rs_tb = 'return_supplier';
        protected $rs_f  = array(
            '0' => 'rs_id',
            '1' => 'rs_tp_id_fk',
            '2' => 'rs_date',
            '3' => 'rs_status',
            '4' => 'rs_cash_out',
            '5' => 'rs_cash_in',
            '6' => 'rs_post_script',
            '7' => 'created_at',
            '8' => 'creted_by'
        );

    /** Table Detail Return Supplier */
        protected $drs_tb = 'det_return_supplier';
        protected $drs_f  = array(
            '0' => 'drs_id',
            '1' => 'drs_rs_id_fk',
            '2' => 'drs_product_id_fk',
            '3' => 'drs_return_qty'
        );

    /** Table Return Customer */
        protected $rc_tb = 'return_customer';
        protected $rc_f  = array(
            '0' => 'rc_id',
            '1' => 'rc_ts_id_fk',
            '2' => 'rc_date',
            '3' => 'rc_status',
            '4' => 'rc_cash',
            '5' => 'rs_post_script',
            '6' => 'created_at',
            '7' => 'creted_by',
            '8' => 'rc_code'
        );

    /** Table Detail Return Customer */
        protected $drc_tb = 'det_return_customer';
        protected $drc_f  = array(
            '0' => 'drc_id',
            '1' => 'drc_rc_id_fk',
            '2' => 'drc_product_id_fk',
            '3' => 'drc_return_qty'
        );

	/** Table Rekening */
        protected $acc_tb = 'tb_bank_account';
        protected $acc_f = array(
            '0' => 'acc_id',
            '1' => 'acc_bank_id_fk',
            '2' => 'acc_number',
            '3' => 'acc_name',
            '4' => 'acc_status'
        );

	/** Table Bank */
        protected $bank_tb = 'ref_bank';
        protected $bank_f = array(
            '0' => 'bank_id',
            '1' => 'bank_code',
            '2' => 'bank_name'
        );
    
    /** Table User */
        protected $u_tb = 'tb_user';
        protected $u_f  = array(
            '0' => 'u_id',
            '1' => 'u_username',
            '2' => 'u_password',
            '3' => 'u_name',
            '4' => 'u_level',
            '5' => 'u_status'
        );

	public function __construct(){
		parent::__construct();
	}
}