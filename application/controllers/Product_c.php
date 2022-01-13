<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Product_c extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Product_m', 'product');
	}

	public function index(){
		/** Check allowed User */
		$cookieData = $this->auth_user();

	  	/** Data yang akan dikirim ke view */
		$this->pageData = array(
			'title'  => 'PoS | List Product',
			'assets' => array(),
			'info_user' => $cookieData
		);

      	/** View file */
		$this->page = 'product/index_product_v';

      	/** Call function layout dari MY_Controller Class */
        $this->layout();
	}

  /** CRUD Product */
	/** Function : Page Product */
	public function productList(){
	  	/** Check allowed user */
		$userData = $this->auth_user(['uAll', 'uO', 'uG', 'uK', 'uP']);
  
		$this->pageData = array(
			'title'  	=> 'PoS | List Product',
			'assets' 	=> array('datatables', 'sweetalert2', 'dropify', 'product', 'confirm_delete'),
			'info_user' => $userData,
			'prdsApi' 	=> site_url('api/Product_api/'),
		);
		
		if( in_array($userData->logedLevel, ['uAll', 'uO', 'uG']) == TRUE ) {
			$this->pageData['optCtgr'] = $this->product->selectCategory()->result_array();
			$this->pageData['optUnit'] = $this->product->selectUnit()->result_array();
		}

		$this->page = 'product/product_v';
		$this->layout();
	}

	/** Function : Page Stock */
	public function productStock(){
	  	/** Check allowed user */
		$userData = $this->auth_user(['uAll', 'uO', 'uG']);
  
		$this->pageData = array(
			'title' 	=> 'PoS | Stock Product',
			'assets'	=> array('datatables', 'sweetalert2', 'stock_product'),
			'info_user' => $userData,
			'stockApi'	=> site_url('api/Product_api/stocks/'),
			'mutationApi' => site_url('api/Product_api/mutation/')
		);
  
		/** Set view file */
		$this->page = 'product/stock_product_v';
		$this->layout();
	}

	/** Function : Page List Mutation */
	public function stockMutation(){
		/** Check allowed user */
	  $userData = $this->auth_user(['uAll', 'uO', 'uG']);
  
		$this->pageData = array(
			'title' 	=> 'PoS | Stock Product',
			'assets'	=> array('datatables', 'sweetalert2', 'stock_mutation'),
			'info_user' => $userData,
			'mutationApi' => site_url('api/Product_api/mutation/')
		);
  
		/** Set view file */
		$this->page = 'product/stock_mutation_v';
		$this->layout();
	}

  /** CRUD : Category */
	public function catUnitList(){
		/** Check allowed User */
		$cookieData = $this->auth_user(['uAll', 'uO', 'uG', 'uK', 'uP']);

		$this->pageData = array(
			'title'  => 'PoS | List Kategori & Unit',
			'assets' => array('datatables', 'sweetalert2', 'ctgr_unit', 'confirm_delete'),
			'catApi' => site_url('api/Product_api/categories/'),
			'unitApi' => site_url('api/Product_api/units/'),
			'info_user'	=> $cookieData
		);
		$this->page = 'product/category_unit_v';
		$this->layout();
	}

}