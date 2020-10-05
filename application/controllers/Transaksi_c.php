<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Transaksi_c extends MY_Controller{
	
	function __construct(){
		parent::__construct();
		//$this->load->model('Penjualan_m');
		$this->load->model('Pembelian_m');
		$this->load->model('Rekening_m');
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
			'title'   => 'PoS | Trans Pembelian',
			'assets'  => array('jqueryui', 'page_addtb', 'sweetalert2'),
			'optSupp' => $this->Supplier_m->getAllSupplier(),
			'optRek'  => $this->Rekening_m->getAllRekening(),
			'nextTransCode' => $nextTransCode,
			'daftarPrd' 	=> $this->Pembelian_m->getTemp(),
		);
		$this->page = 'trans/add_trans_beli_v';
		$this->layout();
	}

	/* Function : List trans pembelian */
	public function listPurchasePage(){
	  /* Data yang ditampilkan ke view */
		$this->pageData = array(
			'title' => 'PoS | Trans Pembelian',
			'assets' => array('datatables'),
			'dataTrans' => $this->Pembelian_m->getAllTransPurchase()
		);
		$this->page = 'trans/list_trans_beli_v';
		$this->layout();
	}

	/* Function : Form update pembelian */
	/* Function : Proses tambah trans pembelian */
	function addPurchaseProses(){
	  /* Get posted data dari form */ 
		$postData = array(
			'tp_no_trans' => $this->input->post('postTransKode'),
			'tp_date'	  => $this->input->post('postTransTgl'),
			'tp_supplier_fk' 	=> $this->input->post('postTransSupp'),
			'tp_payment_metode' => $this->input->post('postTransMetode'),
			'tp_purchase_price' => $this->input->post('postTransBeli'),
			'tp_account_fk' 	=> ($this->input->post('postTransMetode') == 'TF')? $this->input->post('postTransRek') : '',
			'tp_paid' 			=> $this->input->post('postTransBayar'),
			'tp_insufficient' 	=> $this->input->post('postTransKurang'),
			'tp_status' 		=> $this->input->post('postTransStatus'),
			'tp_tenor' 			=> ($this->input->post('postTransStatus') == 'BL')? $this->input->post('postTransTenor') : '',
			'tp_tenor_periode' 	=> ($this->input->post('postTransStatus') == 'BL')? $this->input->post('postTransTenorPeriode') : '',
			'tp_due_date' 		=> ($this->input->post('postTransStatus') == 'BL')? $this->input->post('postTransTempo') : ''
		);

	  /* Get data dari temp table dan insert ke det trans purchase table */
		$tempPrd = $this->Pembelian_m->getTemp();
		foreach ($tempPrd as $row) {
			$dataDetail[] = array(
		  		'dtp_tp_fk'			 => $this->input->post('postTransKode'),
		  		'dtp_product_fk'	 => $row['tp_product_fk'],
		  		'dtp_product_amount' => $row['tp_product_amount'],
		  		'dtp_purchase_price' => $row['tp_purchase_price'],
		    	'dtp_total_price'	 => $row['tp_total_paid']
			); 
		}

	  /* Cek jika barang sudah ditambahkan */
	  	if(count($tempPrd) > 0){
		  /* Input data transaksi ke database */
		  	$inputTP = $this->Pembelian_m->insertTransPurchase($postData);

		  /* Input data product ke table det trans purchase */
		  	$inputDetTP = $this->Pembelian_m->insertBatchDetTP($dataDetail);
	  	} else {
	  		$inputTP = 0;
	  		$inputDetTP = 0;
	  	}

	  /* Cek proses insert, Set session dan redirect */
	  	if($inputTP > 0 && $inputDetTP > 0){
	  		/* hapus data di table temp */
	  		$this->Pembelian_m->truncateTemp();

  	  		$this->session->set_flashdata('flashStatus', 'successInsert');
  	  		$this->session->set_flashdata('flashMsg', 'Berhasil menambahkan transaksi pembelian !');
	  	} else {
  	  		$this->session->set_flashdata('flashStatus', 'failedInsert');
  	  		$this->session->set_flashdata('flashMsg', 'Gagal menambahkan transaksi pembelian !');
	  	}
  	  		$this->session->set_flashdata('flashRedirect', 'Transaksi_c/listPurchasePage');

	  	redirect('Transaksi_c/addPurchasePage');
		//print("<pre>".print_r($inputDetTP, true)."</pre>");
	}

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