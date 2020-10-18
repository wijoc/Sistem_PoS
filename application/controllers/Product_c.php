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
			'assets'  => array('sweetalert2', 'page_add_product'),
			'optCtgr' => $this->Product_m->getCategory(), // Get semua kategori untuk option
			'optUnit' => $this->Product_m->getUnit() // Get semua satuan untuk option
		);
		$this->page = 'product/add_product_v';
		$this->layout();
	}

	/* Function : List product */
	public function listProductPage(){
		$this->pageData = array(
			'title'  => 'PoS | List Product',
			'assets' => array('datatables', 'sweetalert2', 'f_confirm', 'page_product'),
			'dataProduct' => $this->Product_m->getAllowedProduct() 
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
			'assets'  => array('sweetalert2'),
			'detailPrd' => $this->Product_m->getProductOnID($prdID), // Get data berdasar produk id
			'optCtgr' => $this->Product_m->getCategory(), // Get semua kategori untuk option
			'optUnit' => $this->Product_m->getUnit() // Get semua satuan untuk option
		);
		$this->page = 'product/edit_product_v';
		$this->layout();
	}

	/* Function : Proses input product */
	function addProductProses(){
	  /* Get post data dari form */
		$postData = array(
			'prd_barcode'		 => $this->input->post('postBarcodePrd'),
			'prd_name' 			 => $this->input->post('postNamaPrd'),
			'prd_category_id_fk' => $this->input->post('postKategoriPrd'),
			'prd_purchase_price' => $this->input->post('postHargaBeli'),
			'prd_selling_price'	 => $this->input->post('postHargaJual'),
			'prd_unit_id_fk' 	 => $this->input->post('postSatuan'),
			'prd_containts' 	 => $this->input->post('postIsi'),
			'prd_initial_g_stock'	 	=> $this->input->post('postStokAwalG'),
			'prd_initial_ng_stock'	 	=> $this->input->post('postStokAwalNG'),
			'prd_initial_return_stock'	=> $this->input->post('postStokAwalR'),
			'prd_description' 	 => $this->input->post('postDeskripsiPrd')
		);


	  /* Insert ke Database */
		$inputPrd = $this->Product_m->insertProduct($postData);

	  /* Return dan redirect */
	  	if($inputPrd['resultInsert'] > 0){
			$inputStock = $this->Product_m->insertProductStock($postData, $inputPrd['insertID']); // Insert ke table stok
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
			'prd_name' 			 => $this->input->post('postNamaPrd'),
			'prd_category_id_fk' => $this->input->post('postKategoriPrd'),
			'prd_purchase_price' => $this->input->post('postHargaBeli'),
			'prd_selling_price'  => $this->input->post('postHargaJual'),
			'prd_unit_id_fk' 	 => $this->input->post('postSatuan'),
			'prd_containts'		 => $this->input->post('postIsi'),
			'prd_initial_stock'	 => $this->input->post('postStokAwal'),
			'prd_description' 	 => $this->input->post('postDeskripsiPrd')
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

	/* Function : Proses hapus / delete product */
	function deleteProductProses(){
	  /* Get posted id and decode proses */
	  	$prdID = base64_decode(urldecode($this->input->post('postID')));

	  /* Proses delete data di database */
	  	$delPrd = $this->Product_m->deleteProduct($prdID);

	  /* Return Value */
	  	if($delPrd > 0){
	  		echo "successDelete";
	  	} else {
	  		echo "failedDelete";
	  	}
	}

	/* Function : Proses soft delete product (hide product dari user, namun masih tersimpan di database) */
	function softdeleteProductProses(){
	  /* Get posted id and decode proses */
	  	$prdID = base64_decode(urldecode($this->input->post('postID')));

	  /* Proses delete data di database */
	  	$delPrd = $this->Product_m->softdeleteProduct($prdID);

	  /* Return Value */
	  	if($delPrd > 0){
	  		echo "successDelete";
	  	} else {
	  		echo "failedDelete";
	  	}
	}

	/* Function : AutoComplete untuk page transaksi */
	public function autocompleteProduct(){
		if($this->input->get('term')){
			$data = $this->Product_m->searchProduct($this->input->get('term'));
			if(count($data) > 0){
				foreach($data as $row)
					$prdData[] = array(
						'label' => $row['prd_name'],
						'prd_id' => $row['prd_id'],
						'prd_barcode' => $row['prd_barcode'],
						'prd_harga_beli' => $row['prd_purchase_price']
					);
					echo json_encode($prdData);
			}
		}
		//print("<pre>".print_r($prdData, true)."</pre>");
	} 

  /* Function CRUD Kategori & Satuan */
	/* Function : List kategori dan satuan */
	public function listCatUnitPage(){
	  /* Get data kategori dan Satuan dari database */
		$dataCategory = $this->Product_m->getCategory();
		$dataUnit 	  = $this->Product_m->getUnit();

	  /* Proses tampil halaman */
		$this->pageData = array(
			'title'  => 'PoS | List Kategori',
			'assets' => array('datatables', 'sweetalert2', 'page_catunit', 'f_confirm'),
			'dataCtgr' => $dataCategory,
			'dataUnit' => $dataUnit
		);
		$this->page = 'product/list_category_unit_v';
		$this->layout();
	}

	/* Function : Add Kategori Proses */
	function addCategoryProses(){
	  /* Get data post dari form */
	  	$postData = array(
	  		'ctgr_name' => $this->input->post('postCtgrName')
	  	);

	  /* Insert proses */
	  	$inputCategory = $this->Product_m->insertCategory($postData);

	  /* return & redirect */ 
	  	/* Set Session untuk alert */
	  	if($inputCategory > 0){
	  		$this->session->set_flashdata('flashStatus', 'successInsert');
	  		$this->session->set_flashdata('flashMsg', 'Berhasil menambahkan kategori');
	  	} else {
	  		$this->session->set_flashdata('flashStatus', 'failedInsert');
	  		$this->session->set_flashdata('flashMsg', 'Gagal menambahkan kategori');
	  	}
	  		$this->session->set_flashdata('flashInput', 'category');

	  	/* Redirect list kategori dan satuan */
	  	redirect('Product_c/listCatUnitPage');
	}

	/* Function : Edit Kategori Proses */
	function editCategoryProses(){
		$editData = array(
			'ctgr_id' 	=> $this->input->post('postID'),
			'ctgr_name' => $this->input->post('postName')
		);
		
		$editCategori = $this->Product_m->updateCategory($editData);

	  /* return & redirect */ 
	  	/* Set Session untuk alert */
	  	if($editCategori > 0){
	  		$this->session->set_flashdata('flashStatus', 'successUpdate');
	  		$this->session->set_flashdata('flashMsg', 'Success mengubah data kategori !');
	  	} else {
	  		$this->session->set_flashdata('flashStatus', 'failedUpdate');
	  		$this->session->set_flashdata('flashMsg', 'Failed mengubah data kategori !');
	  	}
	  		$this->session->set_flashdata('flashInput', 'category');

	  	/* Redirect list kategori dan satuan */
	  	redirect('Product_c/listCatUnitPage');
	}

	/* Function : Delete Kategori */
	function deleteCategoryProses(){
	  /* Get posted id and decode */
		$ctgrID = base64_decode(urldecode($this->input->post('postID')));

	  /* Proses delete data di database */
	  	$delCtgr = $this->Product_m->deleteCategory($ctgrID);

	  /* return value */
	  	if($delCtgr > 0){
	  		echo 'successDelete';
	  	} else {
	  		echo 'failedDelete';
	  	}
	}

	/* Function : add Satuan Proses */
	function addUnitProses(){
	  /* Get data post dari form */
	  	$postData = array(
	  		'unit_name' => $this->input->post('postSatuanNama')
	  	);

	  /* Insert proses */
	  	$inputSatuan = $this->Product_m->insertUnit($postData);

	  /* return & redirect */ 
	  	/* Set Session untuk alert */
	  	if($inputSatuan > 0){
	  		$this->session->set_flashdata('flashStatus', 'successInsert');
	  		$this->session->set_flashdata('flashMsg', 'Success insert satuan');
	  	} else {
	  		$this->session->set_flashdata('flashStatus', 'failedInsert');
	  		$this->session->set_flashdata('flashMsg', 'Failed insert satuan');
	  	}
	  		$this->session->set_flashdata('flashInput', 'unit');

	  	/* Redirect list kategori dan satuan */
	  	redirect('Product_c/listCatUnitPage');
	}

	/* Function : edit Satuan Proses */
	function editUnitProses(){
	  /* Get data dari form */
		$editData = array(
			'unit_id' 	=> $this->input->post('postID'),
			'unit_nama' => $this->input->post('postName')
		);

		$editUnit = $this->Product_m->updateUnit($editData);

	  /* return & redirect */ 
	  	/* Set Session untuk alert */
	  	if($editUnit > 0){
	  		$this->session->set_flashdata('flashStatus', 'successUpdate');
	  		$this->session->set_flashdata('flashMsg', 'Berhasil mengubah data satuan');
	  	} else {
	  		$this->session->set_flashdata('flashStatus', 'failedUpdate');
	  		$this->session->set_flashdata('flashMsg', 'Gagal mengubah data satuan');
	  	}
	  		$this->session->set_flashdata('flashInput', 'unit');

	  	/* Redirect list kategori dan satuan */
	  	redirect('Product_c/listCatUnitPage');
	}

	/* Function : Delete Satuan */
	function deleteUnitProses(){
	  /* Get posted id and decode */
		$unitID = base64_decode(urldecode($this->input->post('postID')));

	  /* Proses delete data di database */
	  	$delUnit = $this->Product_m->deleteUnit($unitID);

	  /* return value */
	  	if($delUnit > 0){
	  		echo 'successDelete';
	  	} else {
	  		echo 'failedDelete';
	  	}
	}
}