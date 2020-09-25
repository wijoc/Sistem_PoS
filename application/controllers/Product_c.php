<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

class Product_c extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Product_m');
	}

	public function index(){
	  /* Data yang akan dikirim ke view */
		$this->pageData = array(
			'title'  => 'PoS | Product',
			'assets' => array()
		); 

      /* View file */
        $this->page = "product/index_product_v";

      /* Call function layout dari MY_Controller Class */
        $this->layout();
	}

  /* Function CRUD Product */
	/* Function : Form Add Product */
	public function addProductPage(){
	  /* Set kode automatis untuk kode product */
	  	$nextAI = $this->Product_m->getNextIncrement(); // Get next auto increment table product
	  	switch(strlen($nextAI['0']['AUTO_INCREMENT'])){
	  		case '3':
	  			$nol = '0';
	  			break;
	  		case '2':
	  			$nol = '00';
	  			break;
	  		case '1':
	  			$nol = '000';
	  			break;
	  		default :
	  			$nol = '0000';
	  	}
	  	$nextCode = 'PRD'.date('Ymd').$nol.$nextAI['0']['AUTO_INCREMENT'];

	  /* Proses tampil halaman */
		$this->pageData = array(
			'title'   => 'PoS | Input Product',
			'assets'  => array(),
			'prdKode' => $nextCode,
			'optKtgr' => $this->Product_m->getKategori(),
			'optSatuan' => $this->Product_m->getSatuan()
		);
		$this->page = 'product/add_product_v';
		$this->layout();
	}

	/* Function : List Product */
	public function listProductPage(){
		$this->pageData = array(
			'title'  => 'PoS | List Product',
			'assets' => array('datatable')
		);
		$this->page = 'product/list_product_v';
		$this->layout();
	}

	public function addProductProses(){
	  /* Get post data dari form */
		$postData = array(
			'prd_kode'		     => $this->input->post('postKodeBrg'),
			'prd_nama' 			 => $this->input->post('postNamaBrg'),
			'prd_kategori_id_fk' => $this->input->post('postKategoriBrg'),
			'prd_harga_beli'     => $this->input->post('postHargaBeli'),
			'prd_harga_jual'   	 => $this->input->post('postHargaJual'),
			'prd_satuan_id_fk' 	 => $this->input->post('postSatuan'),
			'prd_isi_per_satuan' => $this->input->post('postIsi'),
			'prd_deskripsi' 	 => $this->input->post('postDeskripsiBrg')
		);

	  /* Insert ke Database */
		$inputPrd = $this->Product_m->insertProduct($postData);

	  /* Return dan redirect */
	  	if($inputPrd > 0){
	  		$this->session->set_flashdata('flashStatus', 'successInsert');
	  		$this->session->set_flashdata('flashMsg', 'Success insert produk !');
	  	} else {
	  		$this->session->set_flashdata('flashStatus', 'failedInsert');
	  		$this->session->set_flashdata('flashMsg', 'Failed insert produk !');
	  	}

		redirect('Product_c/listProductPage');
	}

  /* Function CRUD Kategori & Satuan */
	/* Function : List Kategori dan Satuan */
	public function listKatSatPage(){
	  /* Get data kategori dan Satuan dari database */
		$dataKategori = $this->Product_m->getKategori();
		$dataSatuan = $this->Product_m->getSatuan();

	  /* Proses tampil halaman */
		$this->pageData = array(
			'title'  => 'PoS | List Kategori',
			'assets' => array('datatable','katsat'),
			'dataKategori' => $dataKategori,
			'dataSatuan' => $dataSatuan
		);
		$this->page = 'product/list_kategori_satuan_v';
		$this->layout();
	}

	/* Function : add Kategori Proses */
	function addKategoriProses(){
	  /* Get data post dari form */
	  	$postData = array(
	  		'ktgr_nama' => $this->input->post('postKategoriNama')
	  	);

	  /* Insert proses */
	  	$inputKategori = $this->Product_m->insertKategori($postData);

	  /* return & redirect */ 
	  	/* Set Session untuk alert */
	  	if($inputKategori > 0){
	  		$this->session->set_flashdata('flashStatus', 'successInsert');
	  		$this->session->set_flashdata('flashMsg', 'Success insert kategori');
	  	} else {
	  		$this->session->set_flashdata('flashStatus', 'failedInsert');
	  		$this->session->set_flashdata('flashMsg', 'Failed insert kategori');
	  	}

	  	/* Redirect list kategori dan satuan */
	  	redirect('Product_c/listKatSatPage');
	}

	/* Function : edit Kategori Proses */
	function editKategoriProses(){
		$editData = array(
			'ktgr_id' 	=> $this->input->post('postID'),
			'ktgr_nama' => $this->input->post('postNama')
		);
		//print("<pre>".print_r($editData, true)."</pre>");
		
		$editKategori = $this->Product_m->updateKategori($editData);

	  /* return & redirect */ 
	  	/* Set Session untuk alert */
	  	if($inputKategori > 0){
	  		$this->session->set_flashdata('flashStatus', 'successUpdate');
	  		$this->session->set_flashdata('flashMsg', 'Success insert kategori');
	  	} else {
	  		$this->session->set_flashdata('flashStatus', 'failedUpdate');
	  		$this->session->set_flashdata('flashMsg', 'Failed insert kategori');
	  	}

	  	/* Redirect list kategori dan satuan */
	  	redirect('Product_c/listKatSatPage');
	}

	/* Function : add Satuan Proses */
	function addSatuanProses(){
	  /* Get data post dari form */
	  	$postData = array(
	  		'satuan_nama' => $this->input->post('postSatuanNama')
	  	);

	  /* Insert proses */
	  	$inputSatuan = $this->Product_m->insertSatuan($postData);

	  /* return & redirect */ 
	  	/* Set Session untuk alert */
	  	if($inputSatuan > 0){
	  		$this->session->set_flashdata('flashStatus', 'successInsert');
	  		$this->session->set_flashdata('flashMsg', 'Success insert satuan');
	  	} else {
	  		$this->session->set_flashdata('flashStatus', 'failedInsert');
	  		$this->session->set_flashdata('flashMsg', 'Failed insert satuan');
	  	}

	  	/* Redirect list kategori dan satuan */
	  	redirect('Product_c/listKatSatPage');
	}

	/* Function : edit Satuan Proses */
	function editSatuanProses(){
		$editData = array(
			'satuan_id' 	=> $this->input->post('postID'),
			'satuan_nama' => $this->input->post('postNama')
		);
		print("<pre>".print_r($editData, true)."</pre>");

		$editSatuan = $this->Product_m->updateSatuan($editData);

	  /* return & redirect */ 
	  	/* Set Session untuk alert */
	  	if($inputKategori > 0){
	  		$this->session->set_flashdata('flashStatus', 'successUpdate');
	  		$this->session->set_flashdata('flashMsg', 'Success update satuan');
	  	} else {
	  		$this->session->set_flashdata('flashStatus', 'failedUpdate');
	  		$this->session->set_flashdata('flashMsg', 'Failed update satuan');
	  	}

	  	/* Redirect list kategori dan satuan */
	  	redirect('Product_c/listKatSatPage');
	}
}