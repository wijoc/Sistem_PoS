<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_c extends MY_Controller {

	public function index(){
		switch($this->session->userdata('logedInLevel')){
			case "uO" :
				$this->dashboardOwner();
				break;
			case "uG" :
				$this->dashboardGudang();
				break;
			case "uP" :
				$this->dashboardAdmp();
				break;
			case "uK" :
				$this->dashboardKasir();
				break;
			case "uAll" :
				$this->dashboardAdministrator();
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
		$this->load->model('Sales_m');
		$this->load->model('Revenues_m');
		$this->load->model('Expenses_m');

	  /** Get info box data */
		$todaySales = $this->Sales_m->totalSalesByDate(date('Y-m-d'), base64_decode(urldecode($this->session->userdata('userID'))), 'day')->result_array();
		$todayRevenues = $this->Revenues_m->totalRevenuesByDate(date('Y-m-d'), base64_decode(urldecode($this->session->userdata('userID'))), 'day')->result_array();
		$todayExpenses = $this->Expenses_m->totalExpensesByDate(date('Y-m-d'), base64_decode(urldecode($this->session->userdata('userID'))), 'day')->result_array();
		
		$this->pageData = array(
			'title'    => 'PoS | Pelanggan',
			'assets'   => array('chart'),
			'infoSales' => ($todaySales[0]['total_sales'] == NULL)? '0' : number_format($todaySales[0]['total_sales'], 2),
			'infoRevenues' => ($todayRevenues[0]['total_revenues'] == NULL)? '0' : number_format($todayRevenues[0]['total_revenues'], 2),
			'infoExpenses' => ($todayExpenses[0]['total_expenses'] == NULL)? '0' : number_format($todayExpenses[0]['total_expenses'], 2),
			
		);
		$this->page = "dashboard/kasir_dashboard_v";
		$this->layout();
	}

	/** Dashboard : Admin Purchasing */
	public function dashboardAdmp(){
	  /** Check allowed user */
		$this->auth_user(['uP']);
  
	  /** Load model */
		$this->load->model('Purchases_m');
		$this->load->model('Revenues_m');
		$this->load->model('Expenses_m');

	  /** Get info box data */
		$todayPurchases = $this->Purchases_m->totalPurchasesByDate(date('Y-m-d'), base64_decode(urldecode($this->session->userdata('userID'))), 'day')->result_array();
		$todayRevenues = $this->Revenues_m->totalRevenuesByDate(date('Y-m-d'), base64_decode(urldecode($this->session->userdata('userID'))), 'day')->result_array();
		$todayExpenses = $this->Expenses_m->totalExpensesByDate(date('Y-m-d'), base64_decode(urldecode($this->session->userdata('userID'))), 'day')->result_array();
		
		$this->pageData = array(
			'title'    => 'PoS | Pelanggan',
			'assets'   => array('chart'),
			'infoPurchases' => ($todayPurchases[0]['total_purchases'] == NULL)? '0' : number_format($todayPurchases[0]['total_purchases'], 2),
			'infoRevenues' => ($todayRevenues[0]['total_revenues'] == NULL)? '0' : number_format($todayRevenues[0]['total_revenues'], 2),
			'infoExpenses' => ($todayExpenses[0]['total_expenses'] == NULL)? '0' : number_format($todayExpenses[0]['total_expenses'], 2),
			
		);
		$this->page = "dashboard/admp_dashboard_v";
		$this->layout();
	}

	/** Dashboard : Owner */
	public function dashboardOwner(){
	  /** Check allowed user */
		$this->auth_user(['uO']);
  
	  /** Load model */
		$this->load->model('Product_m');
		$this->load->model('Sales_m');
		$this->load->model('Purchases_m');
		$this->load->model('Revenues_m');
		$this->load->model('Expenses_m');

	  /** Get info box data */
		$todaySales = $this->Sales_m->totalSalesByDate(date('Y-m-d'), 'all', 'day')->result_array();
		$todayPurchases = $this->Purchases_m->totalPurchasesByDate(date('Y-m-d'), 'all', 'day')->result_array();
		$todayRevenues = $this->Revenues_m->totalRevenuesByDate(date('Y-m-d'), 'all', 'day')->result_array();
		$todayExpenses = $this->Expenses_m->totalExpensesByDate(date('Y-m-d'), 'all', 'day')->result_array();
		
		$this->pageData = array(
			'title'    => 'PoS | Dashboard',
			'assets'   => array('chart', 'dashboard'),
			'infoSales'		=> ($todaySales[0]['total_sales'])? '0' : number_format($todaySales[0]['total_sales'], 2),
			'infoPurchases' => ($todayPurchases[0]['total_purchases'] == NULL)? '0' : number_format($todayPurchases[0]['total_purchases'], 2),
			'infoRevenues' => ($todayRevenues[0]['total_revenues'] == NULL)? '0' : number_format($todayRevenues[0]['total_revenues'], 2),
			'infoExpenses' => ($todayExpenses[0]['total_expenses'] == NULL)? '0' : number_format($todayExpenses[0]['total_expenses'], 2),
			'FEStock'  => $this->Product_m->emergencyProductStock(5, 0)->result_array(),
			'chartUrl'	=> site_url('Page_c/lineTrans/owner')
		);
		$this->page = "dashboard/owner_dashboard_v";
		$this->layout();
	}

	/** Dashboard : Administrator */
	public function dashboardAdministrator(){
	  /** Check allowed user */
		$this->auth_user(['uAll']);

	  /** Load model */
		$this->load->model('User_m');

	  /** Data user */
		foreach($this->User_m->countUserPerRole()->result_array() as $show){
			$datauser[$show['u_level']] = $show['count_user'];
		}

    	$this->pageData = array(
    		'title'    => 'PoS | Pelanggan',
			'assets'   => array('chart'),
			'info_user' => $datauser
    	);
		$this->page = "dashboard/administrator_dashboard_v";
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
			'user'		 => 'g',
			'chart_type' => 'doughnut',
			'canvas'	 => '#category-chart-canvas',
			'label'		 => $label,
			'product'	 => $dataPrd,
			'color'		 => $color
		);

		header('Content-Type: application/json');
		echo json_encode($returnData);
	}

	/** Function Data Trans, param1 = user */
	public function lineTrans($user){
	  /** Load model */
		$this->load->model('Sales_m');
		$this->load->model('Purchases_m');
		$this->load->model('Revenues_m');
		$this->load->model('Expenses_m');
		
	  /** Set data */
		for($m = 1; $m <= 12; $m++){ 
			$monthlySales[$m] = 0; 
			$monthlyPurchases[$m] = 0; 
			$monthlyRevenues[$m] = 0; 
			$monthlyExpenses[$m] = 0; 
		}

	  /** Monthly sales */
		foreach($this->Sales_m->monthlyTotalSales(date('Y'))->result_array() as $show){
			$monthlySales[$show['s_month']] = $show['total_sales'];
		}

	  /** Monthly purchase */
		foreach($this->Purchases_m->monthlyTotalPurchases(date('Y'))->result_array() as $show){
			$monthlyPurchases[$show['s_month']] = $show['total_purchases'];
		}

	  /** Monthly Revenues */
		foreach($this->Revenues_m->monthlyTotalRevenues(date('Y'))->result_array() as $show){
			$monthlyRevenues[$show['s_month']] = $show['total_revenues'];
		}

	  /** Monthly Expenses */
		foreach($this->Expenses_m->monthlyTotalExpenses(date('Y'))->result_array() as $show){
			$monthlyExpenses[$show['s_month']] = $show['total_expenses'];
		}
		
		$returnData = array(
			'user'		=> 'o',
			'monthlySP'	=> array(
				'canvas' => '#trans-chart-canvas',
				'legend' => true,
				'labels' =>	array('JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AUG', 'SEP', 'OKT', 'NOV', 'DES'),
				'type'	 => 'bar',
				'data'	 => array(
					array(
						'label' 	=> 'Penjualan',
						'data'		=> array_values($monthlySales),
						'backgroundColor' => '#007bff',
						'borderColor'     => '#007bff',
					),
					array(
						'label' 	=> 'Pembelian',
						'data'		=> array_values($monthlyPurchases),
						'backgroundColor' => '#f9c827',
						'borderColor'     => '#f9c827',
					),
				),
			),
			'monthlyRE'	=> array(
				'canvas' => '#rne-chart-canvas',
				'legend' => true,
				'labels' =>	array('JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AUG', 'SEP', 'OKT', 'NOV', 'DES'),
				'type'	 => 'bar',
				'data'	 => array(
					array(
						'label' 	=> 'Pendapatan (non-penjualan)',
						'data'		=> array_values($monthlyRevenues),
						'backgroundColor' => '#36b22a',
						'borderColor'     => '#36b22a',
					),
					array(
						'label' 	=> 'Pengeluaran (non-pembelian)',
						'data'		=> array_values($monthlyExpenses),
						'backgroundColor' => '#d61117',
						'borderColor'     => '#d61117',
					),
				),
			),
		);

		header('Content-Type: application/json');
		echo json_encode($returnData);
	}
}
