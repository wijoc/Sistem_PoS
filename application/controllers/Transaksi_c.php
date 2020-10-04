<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Transaksi_c extends MY_Controller{
	
	function __construct(){
		parent::__construct();
		//$this->load->model('Penjualan_m');
		$this->load->model('Pembelian_m');
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

  /* Function untuk menyimpan daftar barang transaksi ke table temp. Harus diganti ke session keranjang */
	public function addTransProduct($trans){
		$postData = array(
			'post_product_id' => $this->input->post('postIdPrd'),
			'post_harga_satuan' => $this->input->post('postHargaPrd'),
			'post_product_jumlah' => $this->input->post('postJumlahPrd'),
			'post_total_bayar' => $this->input->post('postTotalPrd')
		);

		if($trans === 'Purchase'){
			$inputTemp = $this->Pembelian_m->insertTemp($postData);
			$this->addPurchasePage();
		} else if ($trans === 'Sales'){
			$inputTemp = $this->Penjualan_m->insertTemp($postData);
			$this->addSalesPage();
		}
	}

  /* Fungsi untuk CRUD Pembelian */
	/* Function : Form tambah trans pembelian */
	public function addPurchasePage(){
	  /* Load Model supplier untuk option supplier */
	  	$this->load->model('Supplier_m');

	  /* Set no transaksi seanjutnya */
	  	$nextAI = $this->Pembelian_m->getNextIncrement(); // Get next auto increment table transaksi masuk
	  	switch(strlen($nextAI['0']['AUTO_INCREMENT'])){
	  		case ($nextAI['0']['AUTO_INCREMENT'] > 5):
	  			$nol = '';
	  			break;
	  		case '4':
	  			$nol = '0';
	  			break;
	  		case '3':
	  			$nol = '00';
	  			break;
	  		case '2':
	  			$nol = '00';
	  			break;
	  		case '3':
	  			$nol = '000';
	  			break;
	  		default :
	  			$nol = '0000';
	  	}
	  	$nextTransCode = 'TM'.date('Ymd').$nol.$nextAI['0']['AUTO_INCREMENT'];

	  /* Data yang ditampilkan ke view */
		$this->pageData = array(
			'title' => 'PoS | Trans Pembelian',
			'assets' => array('jqueryui', 'page_addtb'),
			'optSupp' => $this->Supplier_m->getAllSupplier(),
			'nextTransCode' => $nextTransCode,
			'daftarPrd' => $this->Pembelian_m->getTemp()
		);
		$this->page = 'trans/add_trans_beli_v';
		$this->layout();
	}

	/* Function : List trans pembelian */
	public function listPurchasePage(){
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