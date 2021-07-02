<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_c extends MY_Controller {

	public function index(){
		switch($this->session->userdata('logedInLevel')){
			case "uO" :
				$this->page = "dashboard/owner_dashboard_v";
				break;
			case "uG" :
				$this->dashboardGudang();
				break;
			case "uP" :
				$this->page = "dashboard/admp_dashboard_v";
				break;
			case "uK" :
				$this->dashboardKasir();
				break;
			case "uAll" :
				$this->page = "dashboard/administrator_dashboard_v";
				break;
			case ""	:
				redirect('Auth_c');
		}
	}

  /** Function : Not Allowed Page */
	public function notAllowedPage(){
    	$this->pageData = array(
    		'title'       => 'PoS | Pelanggan',
			'assets'      => array(),
    	);

    	$this->page = "errors/not_allowed_v";

    	$this->layout();
	}

  /** Function : Dashboard */
	/** Dashboard : Gudang */
	public function dashboardGudang(){
	  /** Check allowed user */
		$this->auth_user(['uG']);

	  /** Load model */
		$this->load->model('Product_m');

    	$this->pageData = array(
    		'title'    => 'PoS | Pelanggan',
			'assets'   => array('chart', 'dashboard'),
			'infoPrd'  => $this->Product_m->selectProduct()->num_rows(),
			'infoCtgr' => $this->Product_m->selectCategory()->num_rows(),
			'infoMutasi' => $this->Product_m->count_all_mutation(),
			'FEStock'  => $this->Product_m->emergencyProductStock(5, 0)->result_array(),
			'chartUrl' => site_url('Page_c/doughnatCategoryG/'),
    	);
		$this->page = "dashboard/gudang_dashboard_v";
    	$this->layout();
	}

	/** Dashboard : Kasir */
	public function dashboardKasir(){
		/** Check allowed user */
		  $this->auth_user(['uK']);
  
		/** Load model */
		  $this->load->model('Product_m');
  
		  $this->pageData = array(
			  'title'    => 'PoS | Pelanggan',
			  'assets'   => array('chart', 'dashboard'),
			  'infoPrd'  => $this->Product_m->selectProduct()->num_rows(),
			  'infoCtgr' => $this->Product_m->selectCategory()->num_rows(),
			  'infoMutasi' => $this->Product_m->count_all_mutation(),
			  'FEStock'  => $this->Product_m->emergencyProductStock(5, 0)->result_array(),
			  'chartUrl' => site_url('Page_c/doughnatCategoryG/'),
		  );
		  $this->page = "dashboard/kasir_dashboard_v";
		  $this->layout();
	}

  /** Function : Chart */
	/** Function : Chart Data Product by Category */
	public function doughnatCategoryG(){
	  /** Load Helper */
		$this->load->helper('random_color');

	  /** Load model */
		$this->load->model('Product_m');

		foreach($this->Product_m->selectCategory()->result_array() as $show){
			$label[] 	= $show['ctgr_name'];
			$dataPrd[]	= $show['ctgr_count_prd'];
			$color[]	= generateRandomColor();
		}

		$returnData = array(
			'chart_type' => 'doughnut',
			'canvas'	 => '#category-chart-canvas',
			'label'		 => $label,
			'product'	 => $dataPrd,
			'color'		 => $color
		);

		header('Content-Type: application/json');
		echo json_encode($returnData);
	}
}
