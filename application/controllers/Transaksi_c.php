<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Transaksi_c extends MY_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->model('Sales_m');
		$this->load->model('Purchases_m');
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
			/* Cek product di keranjang */
			$checkTemp = $this->Purchases_m->getTemponPrdId($this->input->post('postIdPrd'));
			if(count($checkTemp) > 0 && $checkTemp[0]['tp_purchase_price'] == $postData['post_harga_satuan']){
				$newAmount = $checkTemp[0]['tp_product_amount'] + $postData['post_product_jumlah'];
				$newTotal  = $checkTemp[0]['tp_total_paid'] + $postData['post_total_bayar'];

				$updateId = $checkTemp[0]['tp_id'];
				$newInputData = array(
					'tp_product_fk'	=> $checkTemp[0]['tp_product_fk'],
					'tp_product_amount' => $newAmount,
					'tp_purchase_price' => $checkTemp[0]['tp_purchase_price'],
					'tp_total_paid'		=> $newTotal
				);
				$inputTemp = $this->Purchases_m->updateTemp($newInputData, $updateId);
			} else {
				$inputTemp = $this->Purchases_m->insertTemp($postData);
			}
			redirect('Transaksi_c/addPurchasePage');
		} else if ($trans === 'Sales'){
			/* Input khusus untuk keranjang penjualan */
			$postData['post_potongan'] = $this->input->post('postPotonganPrd');

			/* Cek product di keranjang */
			$checkTemp = $this->Sales_m->getTemponPrdId($this->input->post('postIdPrd'));
			//print("<pre>".print_r($checkTemp, true)."</pre>");

			if(count($checkTemp) > 0 && $checkTemp[0]['temps_sale_price'] == $postData['post_harga_satuan'] && $checkTemp[0]['temps_discount'] == $postData['post_potongan']){
				$newAmount = $checkTemp[0]['temps_product_amount'] + $postData['post_product_jumlah'];
				$newTotal  = $checkTemp[0]['temps_total_paid'] + $postData['post_total_bayar'];

				$updateId 	  = $checkTemp[0]['temps_id'];
				$newInputData = array(
					'temps_product_fk'	=> $checkTemp[0]['temps_product_fk'],
					'temps_product_amount' => $newAmount,
					'temps_sale_price'	=> $checkTemp[0]['temps_sale_price'],
					'temps_total_paid'	=> $newTotal
				);
				$inputTemp = $this->Sales_m->updateTemp($newInputData, $updateId);
			} else {
				$inputTemp = $this->Sales_m->insertTemp($postData);
			}
			redirect('Transaksi_c/addSalesPage');
		}
	}

	public function deleteTransProduct($trans, $encoded_prd_id){
		$prdID = base64_decode(urldecode($encoded_prd_id));
		if($trans === 'Purchases'){
			$delTemp = $this->Purchases_m->deleteTemp($prdID);
			redirect('Transaksi_c/addPurchasePage');
		} else if ($trans === 'Sales') {
			$delTemp = $this->Sales_m->deleteTemp($prdID);
		}
	}

  /* Fungsi untuk CRUD Pembelian */
	/* Function : Form tambah trans pembelian */
	public function addPurchasePage(){
	  /* Load Model supplier untuk option supplier */
	  	$this->load->model('Supplier_m');

	  /* Set no transaksi seanjutnya */
	  	$nextAI = $this->Purchases_m->getNextIncrement(); // Get next auto increment table transaksi masuk
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
			'assets'  => array('jqueryui', 'page_addtrans', 'sweetalert2'),
			'optSupp' => $this->Supplier_m->getAllSupplier(),
			'optRek'  => $this->Rekening_m->getAllRekening(),
			'nextTransCode' => $nextTransCode,
			'daftarPrd' 	=> $this->Purchases_m->getTemp(),
		);
		$this->page = 'trans/add_trans_purchase_v';
		$this->layout();
	}

	/* Function : List trans pembelian */
	public function listPurchasePage(){
	  /* Data yang ditampilkan ke view */
		$this->pageData = array(
			'title' => 'PoS | Trans Pembelian',
			'assets' => array('datatables'),
			'dataTrans' => $this->Purchases_m->getAllTransPurchase()
		);
		$this->page = 'trans/list_trans_purchase_v';
		$this->layout();
	}

	/* Function : Form update pembelian */
	/* Function : Proses tambah trans pembelian */
	function addPurchaseProses(){
	  /* Set Var purchases product */
	  	$dataDetail = array();

	  /* Get posted data dari form */ 
		$postData = array(
			'tp_no_trans' => $this->input->post('postTransKode'),
			'tp_date'	  => $this->input->post('postTransTgl'),
			'tp_supplier_fk' 	=> $this->input->post('postTransSupp'),
			'tp_payment_metode' => $this->input->post('postTransMetode'),
			'tp_purchase_price' => $this->input->post('postTransTotalBayar'),
			'tp_account_fk' 	=> ($this->input->post('postTransMetode') == 'TF')? $this->input->post('postTransRek') : '',
			'tp_paid' 			=> $this->input->post('postTransPembayaran'),
			'tp_insufficient' 	=> $this->input->post('postTransKurang'),
			'tp_status' 		=> $this->input->post('postTransStatus'),
			'tp_tenor' 			=> ($this->input->post('postTransStatus') == 'BL')? $this->input->post('postTransTenor') : '',
			'tp_tenor_periode' 	=> ($this->input->post('postTransStatus') == 'BL')? $this->input->post('postTransTenorPeriode') : '',
			'tp_due_date' 		=> ($this->input->post('postTransStatus') == 'BL')? $this->input->post('postTransTempo') : ''
		);

	  /* Get data dari temp table dan insert ke det trans purchase table */
		$tempPrd = $this->Purchases_m->getTemp();
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
		  	$inputTP = $this->Purchases_m->insertTransPurchase($postData);

		  /* Input data product ke table det trans purchase */
		  	$inputDetTP = $this->Purchases_m->insertBatchDetTP($dataDetail);
	  	} else {
	  		$inputTP = 0;
	  		$inputDetTP = 0;
	  	}

	  /* Cek proses insert, Set session dan redirect */
	  	if($inputTP > 0 && $inputDetTP > 0){
	  		/* hapus data di table temp */
	  		$this->Purchases_m->truncateTemp();

  	  		$this->session->set_flashdata('flashStatus', 'successInsert');
  	  		$this->session->set_flashdata('flashMsg', 'Berhasil menambahkan transaksi pembelian !');
	  	} else {
  	  		$this->session->set_flashdata('flashStatus', 'failedInsert');
  	  		$this->session->set_flashdata('flashMsg', 'Gagal menambahkan transaksi pembelian !');
	  	}
  	  		$this->session->set_flashdata('flashRedirect', 'Transaksi_c/listPurchasePage');

	  	redirect('Transaksi_c/addPurchasePage');
	}

	/* Function : Proses update trans pembelian */
	/* Function : Proses delete trans pembelian */

  /* Fungsi untuk CRUD Penjualan */
	/* Function : Form tambah trans penjualan */
	public function addSalesPage(){
	  /* Load model member untuk option member */
	  	$this->load->model('Member_m');

	  /* Set nomor transaksi selanjutnya */
	  	$nextAI = $this->Sales_m->getNextIncrement(); // Get next auto increment table transaksi penjualan
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
	  	$nextTransCode = 'TK'.date('Ymd').$nol.$nextAI['0']['AUTO_INCREMENT'];

	  /* Data yang ditampilkan ke view */
	  	$this->pageData = array(
	  		'title'		=> 'PoS | Trans Penjualan',
	  		'assets'	=> array('jqueryui', 'sweetalert2', 'page_addtrans'),
			'optRek'	=> $this->Rekening_m->getAllRekening(),
			'nextTransCode' => $nextTransCode,
			'daftarPrd' => $this->Sales_m->getTemp(),
			'optMember'	=> $this->Member_m->getActiveMember()
	  	);
	  	$this->page = 'trans/add_trans_sales_v';
	  	$this->layout();
	}

	/* Function : List trans penjualan */
	public function listSalesPage(){
	  /* Data yang ditampilkan ke view */
		$this->pageData = array(
			'title' => 'PoS | Trans Penjualan',
			'assets' => array('datatables'),
			'dataTrans' => $this->Sales_m->getAvailableTransSales()
		);
		$this->page = 'trans/list_trans_sales_v';
		$this->layout();
	}

	/* Function : Form update penjualan */
	/* Function : Proses tambah trans penjualan */
	function addSalesProses(){
	  /* Get posted data dari form */ 
		$postData = array(
			'ts_trans_code' => $this->input->post('postTransKode'),
			'ts_date'	  	=> $this->input->post('postTransTgl'),
			'ts_member_fk' 	=> $this->input->post('postTransSupp'),
			'ts_payment_metode' => $this->input->post('postTransMetode'),
			'ts_sales_price' 	=> $this->input->post('postTransTotalBayar'),
			'ts_account_fk' 	=> ($this->input->post('postTransMetode') == 'TF')? $this->input->post('postTransRek') : '',
			'ts_paid' 			=> $this->input->post('postTransPembayaran'),
			'ts_insufficient' 	=> $this->input->post('postTransKurang'),
			'ts_status' 		=> $this->input->post('postTransStatus'),
			'ts_tenor' 			=> ($this->input->post('postTransStatus') == 'BL')? $this->input->post('postTransTenor') : '',
			'ts_tenor_periode' 	=> ($this->input->post('postTransStatus') == 'BL')? $this->input->post('postTransTenorPeriode') : '',
			'ts_due_date' 		=> ($this->input->post('postTransStatus') == 'BL')? $this->input->post('postTransTempo') : ''
		);

	  /* Get data dari temp table dan insert ke det trans purchase table */
		$tempPrd = $this->Sales_m->getTemp();
		foreach ($tempPrd as $row) {
			$dataDetail[] = array(
		  		'dts_ts_fk'			 => $this->input->post('postTransKode'),
		  		'dts_product_fk'	 => $row['temps_product_fk'],
		  		'dts_product_amount' => $row['temps_product_amount'],
		  		'dts_sale_price' 	 => $row['temps_sale_price'],
		  		'dts_discount'	 	 => $row['temps_discount'],
		    	'dts_total_price'	 => $row['temps_total_paid']
			); 
		}

	  /* Cek jika barang sudah ditambahkan */
	  	if(count($tempPrd) > 0){
		  /* Input data transaksi ke database */
		  	$inputTS = $this->Sales_m->insertTransSales($postData);

		  /* Input data product ke table det trans purchase */
		  	$inputDetTS = $this->Sales_m->insertBatchDetTS($dataDetail);
	  	} else {
	  		$inputTS = 0;
	  		$inputDetTS = 0;
	  	}

	  /* Cek proses insert, Set session dan redirect */
	  	if($inputTS > 0 && $inputDetTS > 0){
	  		/* hapus data di table temp */
	  		$this->Sales_m->truncateTemp();

  	  		$this->session->set_flashdata('flashStatus', 'successInsert');
  	  		$this->session->set_flashdata('flashMsg', 'Berhasil menambahkan transaksi penjualan !');
	  	} else {
  	  		$this->session->set_flashdata('flashStatus', 'failedInsert');
  	  		$this->session->set_flashdata('flashMsg', 'Gagal menambahkan transaksi penjualan !');
	  	}
  	  		$this->session->set_flashdata('flashRedirect', 'Transaksi_c/listSalesPage');

	  	redirect('Transaksi_c/addSalesPage');
	}

	/* Function : Proses update trans penjualan */
	/* Function : Proses delete trans penjualan */

  /* Fungsi untuk CRUD Biaya Operasional */
  /* Fungsi untuk CRUD Pemasukan Lainnya */
  /* Function untuk manipulasi stok */
}