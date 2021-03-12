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

	public function __construct(){
		parent::__construct();
	}
}