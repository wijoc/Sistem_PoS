<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Transaksi_c extends MY_Controller{
	
	function __construct(){
		parent::__construct();
		//$this->load->model('Penjualan_m');
		//$this->load->model('Pembelian_m');
	}

	public function index(){
	  /* Data yang akan dikirim ke view */
	  	$this->pageData = array(
	  		'title' => 'PoS | Transaksi',
	  		'assets' =>array()
	  	);

	  /* Load file view */
	  	$this->page = 'trans/index_trans_v';

	  /* Call function layout dari my controller */
	  	$this->layout();
	}

  /* Fungsi untuk CRUD Pembelian */
	/* Function : Form tambah trans pembelian */
	public function addBuyingPage(){
	  /* Load Model supplier untuk option supplier */
	  	$this->load->model('Supplier_m');

	  /* Data yang ditampilkan ke view */
		$this->pageData = array(
			'title' => 'PoS | Trans Pembelian',
			'assets' => array(),
			'optSupp' => $this->Supplier_m->getAllSupplier()
		);
		$this->page = 'trans/add_trans_beli_v';
		$this->layout();
	}

	/* Function : List trans pembelian */
	public function listBuyingPage(){
	  /* Data yang ditampilkan ke view */
		$this->pageData = array(
			'title' => 'PoS | Trans Pembelian',
			'assets' => array(),
		);
		$this->page = 'trans/list_trans_beli_v';
		$this->layout();
	}

	/* Function : Form update pembelian */
	/* Function : Proses tambah trans pembelian */
	/* Function : Proses update trans pembelian */
	/* Function : Proses delete trans pembelian */

  /* Fungsi untuk CRUD Penjualan */
	/* Function : Form tambah trans penjualan */
	/* Function : List trans penjualan */
	/* Function : Form update penjualan */
	/* Function : Proses tambah trans penjualan */
	/* Function : Proses update trans penjualan */
	/* Function : Proses delete trans penjualan */

  /* Fungsi untuk CRUD Biaya Operasional */
  /* Fungsi untuk CRUD Pemasukan Lainnya */
}