<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Product_c extends MY_Controller {

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
	/* Function : Form add product */
	public function addProductPage(){

	  /* Proses tampil halaman */
		$this->pageData = array(
			'title'   => 'PoS | Input Product',
			'assets'  => array('sweetalert2', 'page_addprd'),
			'optKtgr' => $this->Product_m->getKategori(), // Get semua kategori untuk option
			'optSatuan' => $this->Product_m->getSatuan() // Get semua satuan untuk option
		);
		$this->page = 'product/add_product_v';
		$this->layout();
	}

	/* Function : List product */
	public function listProductPage(){
		$this->pageData = array(
			'title'  => 'PoS | List Product',
			'assets' => array('datatables'),
			'dataProduct' => $this->Product_m->getAllProduct() 
		);
		$this->page = 'product/list_product_v';
		$this->layout();
	}

	/* Function : Form edit product */
	public function editProductPage($id){
	  /* Decode produk id */
		$prdID = base64_decode(urldecode($id));
	  
	  /* Proses tampil halaman */
		$this->pageData = array(
			'title'   => 'PoS | Edit Product',
			'assets'  => array('sweetalert2', 'page_addprd'),
			'detailPrd' => $this->Product_m->getProductOnID($prdID), // Get data berdasar produk id
			'optKtgr' => $this->Product_m->getKategori(), // Get semua kategori untuk option
			'optSatuan' => $this->Product_m->getSatuan() // Get semua satuan untuk option
		);
		$this->page = 'product/edit_product_v';
		$this->layout();
	}

	/* Function : Proses input product */
	function addProductProses(){
	  /* Get post data dari form */
		$postData = array(
			'prd_barcode'		 => $this->input->post('postBarcodeBrg'),
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
	  		$this->session->set_flashdata('flashMsg', 'Berhasil menambahkan produk !');
	  	} else {
	  		$this->session->set_flashdata('flashStatus', 'failedInsert');
	  		$this->session->set_flashdata('flashMsg', 'Gagal menambahkan produk !');
	  	}
	  	$this->session->set_flashdata('flashRedirect', 'Product_c/listProductPage');

		redirect('Product_c/addProductPage');
	}

	/* Function : Proses edit / update product */
	function editProductProses(){
	  /* Get post data dari form */
	  	$prdID = base64_decode(urldecode($this->input->post('postId')));
		$postData = array(
			'prd_nama' 			 => $this->input->post('postNamaBrg'),
			'prd_kategori_id_fk' => $this->input->post('postKategoriBrg'),
			'prd_harga_beli'     => $this->input->post('postHargaBeli'),
			'prd_harga_jual'   	 => $this->input->post('postHargaJual'),
			'prd_satuan_id_fk' 	 => $this->input->post('postSatuan'),
			'prd_isi_per_satuan' => $this->input->post('postIsi'),
			'prd_deskripsi' 	 => $this->input->post('postDeskripsiBrg')
		);

	  /* Update ke database */
	  	$editPrd = $this->Product_m->updateProduct($prdID, $postData);

	  /* Return dan redirect */
	  	if($editPrd > 0){
	  		$this->session->set_flashdata('flashStatus', 'successUpdate');
	  		$this->session->set_flashdata('flashMsg', 'Berhasil mengubah detail produk !');
	  	} else {
	  		$this->session->set_flashdata('flashStatus', 'failedUpdate');
	  		$this->session->set_flashdata('flashMsg', 'Gagal mengubah detail produk !');
	  	}
	  	$this->session->set_flashdata('flashRedirect', 'Product_c/listProductPage');

		redirect('Product_c/editProductPage/'.$this->input->post('postId'));
	}

	public function autocompleteProduct(){
		if($this->input->get('term')){
			$data = $this->Product_m->searchProduct($this->input->get('term'));
			if(count($data) > 0){
				foreach($data as $row)
					$prdData[] = array(
						'label' => $row['prd_nama'],
						'prd_id' => $row['prd_id'],
						'prd_barcode' => $row['prd_barcode'],
						'prd_harga_beli' => $row['prd_harga_beli']
					);
					echo json_encode($prdData);
			}
		}
		//print("<pre>".print_r($prdData, true)."</pre>");
	} 

  /* Function CRUD Kategori & Satuan */
	/* Function : List kategori dan satuan */
	public function listKatSatPage(){
	  /* Get data kategori dan Satuan dari database */
		$dataKategori = $this->Product_m->getKategori();
		$dataSatuan = $this->Product_m->getSatuan();

	  /* Proses tampil halaman */
		$this->pageData = array(
			'title'  => 'PoS | List Kategori',
			'assets' => array('datatables', 'page_katsat', 'sweetalert2'),
			'dataKategori' => $dataKategori,
			'dataSatuan' => $dataSatuan
		);
		$this->page = 'product/list_kategori_satuan_v';
		$this->layout();
	}

	/* Function : Add Kategori Proses */
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
	  		$this->session->set_flashdata('flashMsg', 'Berhasil menambahkan kategori');
	  	} else {
	  		$this->session->set_flashdata('flashStatus', 'failedInsert');
	  		$this->session->set_flashdata('flashMsg', 'Gagal menambahkan kategori');
	  	}
	  		$this->session->set_flashdata('flashInput', 'kategori');

	  	/* Redirect list kategori dan satuan */
	  	redirect('Product_c/listKatSatPage');
	}

	/* Function : Edit Kategori Proses */
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
	  		$this->session->set_flashdata('flashInput', 'satuan');

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