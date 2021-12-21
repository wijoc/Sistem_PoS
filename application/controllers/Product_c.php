<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Product_c extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Product_m', 'prd');
	}

	public function index(){
	  /** Data yang akan dikirim ke view */
		$this->pageData = array(
			'title'  => 'PoS | List Product',
			'assets' => array(),
		);

      /** View file */
		$this->page = 'product/index_product_v';

      /** Call function layout dari MY_Controller Class */
        $this->layout();
	}

  /** CRUD Product */
	/** Function : Page List Product */
	public function productList(){
	  	/** Check allowed user */
		$this->auth_user(['uAll', 'uO', 'uG', 'uK', 'uP']);
  
		$this->pageData = array(
			'title'  		=> 'PoS | List Product',
			'assets' 		=> array('datatables', 'sweetalert2', 'list_product', 'f_confirm'),
			'prdListApi' 	=> site_url('api/Product_api')
		);
		$this->page = 'product/list_product_v';
		$this->layout();
	}

	/** Function : Halaman form tambah product */
	public function productAdd(){
		/** Check allowed user */
		$this->auth_user(['uAll', 'uO', 'uG']);
  
		/** Proses tampil halaman */
		$this->pageData = array(
			'title'   => 'PoS | Input Product',
			'assets'  => array('sweetalert2', 'dropify', 'add_product'),
			'optCtgr' => $this->prd->selectCategory()->result_array(), // Get semua kategori untuk option
			'optUnit' => $this->prd->selectUnit()->result_array(), // Get semua satuan untuk option
			'prdInputApi' => site_url('api/Product_api')
		);
		$this->page = 'product/add_product_v';
		$this->layout();
	}

  /** CRUD : Category */
	public function catUnitList(){
	  	/** Check allowed user */
		$this->auth_user(['uAll', 'uO', 'uG', 'uK', 'uP']);

		$this->pageData = array(
			'title'  => 'PoS | List Kategori & Unit',
			'assets' => array('datatables', 'sweetalert2', 'ctgr_unit', 'confirm_delete'),
			'catApi' => site_url('api/Product_api/getCategory'),
			'unitApi' => site_url('api/Product_api/getUnit'),
		);
		$this->page = 'product/list_category_unit_v';
		$this->layout();
	}

}