<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Report_c extends MY_Controller{

    function __construct(){
		parent::__construct();
		$this->load->model('Sales_m');
		$this->load->model('Purchases_m');
		$this->load->model('Account_m');
		$this->load->model('Installment_m');
		$this->load->model('Return_m');
		$this->load->model('Expenses_m');
		$this->load->model('Revenues_m');
    }

	public function index(){
	  /* Data yang akan dikirim ke view */
	  	$this->pageData = array(
	  		'title' => 'PoS | Laporan',
	  		'assets' =>array('icheck')
	  	);

	  /* Load file view */
	  	$this->page = 'report/report_form_v';

	  /* Call function layout dari my controller */
	  	$this->layout();
	}
}