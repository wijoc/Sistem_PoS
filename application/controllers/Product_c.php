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
		$this->pageData = array(
			'title'  => 'PoS | Input Product',
			'assets' => array()
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
	  		'ktgr_nama' => $this->input->post('postKategori')
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

	/* Function : add Satuan Proses */
	function addSatuanProses(){
	  /* Get data post dari form */
	  	$postData = array(
	  		'satuan_nama' => $this->input->post('postSatuan')
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
}