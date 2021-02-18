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

  /** CRUD Product */
	/** Function : Halaman form tambah product */
	public function addProductPage(){
	  /** Proses tampil halaman */
		$this->pageData = array(
			'title'   => 'PoS | Input Product',
			'assets'  => array('sweetalert2', 'dropify', 'p_add_product'),
			'optCtgr' => $this->Product_m->getCategory(), // Get semua kategori untuk option
			'optUnit' => $this->Product_m->getUnit() // Get semua satuan untuk option
		);
		$this->page = 'product/add_product_v';
		$this->layout();
	}

	/** Function : List product */
	public function listProductPage(){
		$this->pageData = array(
			'title'  => 'PoS | List Product',
			'assets' => array('datatables', 'sweetalert2', 'f_confirm'),
			'dataProduct' => $this->Product_m->getAllowedProduct() // Get semua data product
		);
		$this->page = 'product/list_product_v';
		$this->layout();
	}

	/* Function : List product berdasar kategori */
	public function listProductOnCatPage($encoded_cat_id){
		$catID = base64_decode(urldecode($encoded_cat_id));
		$this->pageData = array(
			'title'  => 'PoS | List Product',
			'assets' => array('datatables', 'sweetalert2', 'f_confirm', 'page_product'),
			'dataProduct' => $this->Product_m->getProductOnCat($catID),
			'dataKtgr'	=> $this->Product_m->getCategoryOnID($catID)
		);
		$this->page = 'product/list_product_v';
		$this->layout();
	}

	/* Function : List stock product */
	public function listStockProductPage(){
		/* set data yang akan ditampilkan */
		$this->pageData = array(
			'title' 	=> 'PoS | Stock Product',
			'assets'	=> array('datatables', 'sweetalert2', 'page_product'),
			'dataStock' => $this->Product_m->getStockProduct()
		);

		/* Set view file */
		$this->page = 'product/list_stock_product_v';
		$this->layout();
	}

	/* Function : Detail product page */
	public function detailProductPage($id){
	  /* Decode produk id */
		$prdID = base64_decode(urldecode($id));
	  
	  /* Proses tampil halaman */
		$this->pageData = array(
			'title'   => 'PoS | Detail Product',
			'assets'  => array(),
			'detailPrd' => $this->Product_m->getProductOnID($prdID), // Get data berdasar produk id
		);
		$this->page = 'product/detail_product_v';
		$this->layout();
	}

	/* Function : Form edit product */
	public function editProductPage($id){
	  /* Decode produk id */
		$prdID = base64_decode(urldecode($id));
	  
	  /* Proses tampil halaman */
		$this->pageData = array(
			'title'   => 'PoS | Edit Product',
			'assets'  => array('sweetalert2', 'page_add_product'),
			'detailPrd' => $this->Product_m->getProductOnID($prdID), // Get data berdasar produk id
			'optCtgr' => $this->Product_m->getCategory(), // Get semua kategori untuk option
			'optUnit' => $this->Product_m->getUnit() // Get semua satuan untuk option
		);
		$this->page = 'product/edit_product_v';
		$this->layout();
	}

	/* Function : Proses input product */
	function addProductProses(){
	  /** Load library & Helper */
		  $this->load->library('form_validation'); // Libray form validation 
		  $this->load->helper('file'); // Helper upload file
		  $this->load->library('upload'); // Library upload file
		  
	  /** Set rules form validation */
		$config = array(
			array(
				'field'	=> 'postBarcode',
				'label'	=> 'Barcode Produk',
				'rules'	=> 'trim'
			),
			array(
				'field'	=> 'postNama',
				'label'	=> 'Nama Produk',
				'rules'	=> 'trim|required',
				'errors'	=> array(
					'required' => 'Nama produk tidak boleh kosong'
				)
			),
			array(
				'field'	=> 'postKategori',
				'label'	=> 'Kategori Produk',
				'rules'	=> 'trim|required|numeric',
				'errors'	=> array(
					'required'	=> 'Kategori produk tidak boleh kosong',
					'numeric'	=> 'Pilih option tersedia'
				)
			),
			array(
				'field'	=> 'postHargaBeli',
				'label'	=> 'Harga Beli',
				'rules'	=> 'trim|required|greater_than_equal_to[0]|numeric',
				'errors'	=> array(
					'required' 	=> 'Harga beli tidak boleh kosong',
					'numeric'	=> 'Harga tidak sesuai format',
					'greater_than_equal_to' => 'Harga harus lebih dari 0' 
				)
			),
			array(
				'field'	=> 'postHargaJual',
				'label'	=> 'Harga Jual',
				'rules'	=> 'trim|required|greater_than_equal_to[0]|numeric',
				'errors'	=> array(
					'required' 	=> 'Harga Jual tidak boleh kosong',
					'numeric'	=> 'Harga tidak sesuai format',
					'greater_than_equal_to' => 'Harga harus lebih dari 0' 
				)
			),
			array(
				'field'	=> 'postSatuan',
				'label'	=> 'Satuan',
				'rules'	=> 'trim|required|numeric',
				'errors'	=> array(
					'required'	=> 'Satuan produk tidak boleh kosong',
					'numeric'	=> 'Satuan tidak sesuai format'
				)
			),
			array(
				'field'	=> 'postIsi',
				'label'	=> 'Isi per satuan',
				'rules'	=> 'trim|required|numeric',
				'errors'	=> array(
					'required'	=> 'Isi tidak boleh kosong',
					'numeric'	=> 'Isi tidak sesuai format'
				)
			),
			array(
				'field'	=> 'postStockG',
				'label'	=> 'Stok awal',
				'rules'	=> 'trim|required|numeric',
				'errors'	=> array(
					'numeric'	=> 'tidak sesuai format',
					'required'	=> 'Stok awal tidak boleh kosong'
				)
			),
			array(
				'field'	=> 'postStockNG',
				'label'	=> 'Stok awal rusak',
				'rules'	=> 'trim|required|numeric',
				'errors'	=> array(
					'numeric'	=> 'tidak sesuai format',
					'required'	=> 'Stok awal tidak boleh kosong'
				)
			),
			array(
				'field'	=> 'postStockOP',
				'label'	=> 'Stok awal opname',
				'rules'	=> 'trim|required|numeric',
				'errors'	=> array(
					'numeric'	=> 'tidak sesuai format',
					'required'	=> 'Stok awal tidak boleh kosong'
				)
			),
			array(
				'field'	=> 'postDeskripsi',
				'label'	=> 'Deskripsi Produk',
				'rules'	=> 'trim'
			)
		);
		$this->form_validation->set_rules($config);

	  /** Run form validation */
		if($this->form_validation->run() == FALSE) {
			$arrReturn = array(
				'error'		=> TRUE,
				'errorNama' 	=> form_error('postNama'),
				'errorKategori'	=> form_error('postKategori'),
				'errorHrgBeli'	=> form_error('postHargaBeli'),
				'errorHrgJual'	=> form_error('postHargaJual'),
				'errorSatuan'	=> form_error('postSatuan'),
				'errorIsi'		=> form_error('postIsi'),
				'errorStockG'	=> form_error('postStockG'),
				'errorStockNG' => form_error('postStockNG'),
				'errorStockOP' => form_error('postStockOP')			
			);
		} else {
			/** Get post data dari form */
				$postData = array(
					'prd_barcode'			=> $this->input->post('postBarcode'),
					'prd_name'			=> $this->input->post('postNama'),
					'prd_category_id_fk'	=> $this->input->post('postKategori'),
					'prd_purchase_price'	=> $this->input->post('postHargaBeli'),
					'prd_selling_price'	=> $this->input->post('postHargaJual'),
					'prd_unit_id_fk' 	 	=> $this->input->post('postSatuan'),
					'prd_containts' 	 	=> $this->input->post('postIsi'),
					'prd_initial_g_stock'	=> $this->input->post('postStockG'),
					'prd_initial_ng_stock'	=> $this->input->post('postStockNG'),
					'prd_initial_op_stock'	=> $this->input->post('postStockOP'),
					'prd_description'		=> $this->input->post('postDeskripsi'),
					'prd_image'			=> NULL
				);

			/** Proses Upload file */
				if($_FILES['postImg']['name']){
				  /** Load lib dan helper untuk upload */
					$this->load->helper('file');
					$this->load->library('upload');

				  /** Prepare config tambahan */
					$config['upload_path']   = 'assets/uploaded_files/product_img/'; // Path folder untuk upload file
					$config['allowed_types'] = 'jpeg|jpg|png|bmp|svg'; // Allowed types
					$config['max_size']    	 = '2048'; // Max size in KiloBytes
					$config['encrypt_name']  = TRUE; // Encrypt nama file ketika diupload
					$this->upload->initialize($config); // Initialize config

				  /** Upload proses dan Simpan file ke database */
					$upload = $this->upload->do_upload('postImg');
					
				  /** Set nilai untuk simpan ke database */
					if($upload){
					  /** Get data upload file */
					  $uploadData = $this->upload->data();
		
					  /** Set value */
					  $postData['prd_image'] = $config['upload_path'].$uploadData['file_name'];
					} else {
						$errorUpload = $this->upload->display_errors();
					}
				}

			/** Proses simpan data */
				if(isset($errorUpload)){
					$arrReturn['error']	   = TRUE;
					$arrReturn['errorImg'] = $errorUpload;
				} else {
					$inputPrd = $this->Product_m->insertProduct($postData);

					/** Return dan redirect */
						if($inputPrd && $inputPrd['resultInsert'] > 0){
							/** Insert stock product */
							$inputStock = $this->Product_m->insertProductStock($postData, $inputPrd['insertID']); // Insert ke table stok
					
							/** Result to return */
							$arrReturn = array(
								'success'	=> TRUE,
								'status'	=> 'successInsert',
								'statusMsg' => 'Berhasil Menambahkan produk !',
								'statusIcon' => 'success',
								'redirect'	=> site_url('Product_c/listProductPage')
							);
						} else {
							/** Result to return */
							$arrReturn = array(
								'success'	=> TRUE,
								'status'	=> 'failedInsert',
								'statusMsg' => 'Gagal Menambahkan produk !',
								'statusIcon' => 'error',
								'redirect'	=> site_url('Product_c/listProductPage')
							);
						}
				}
		}

		//print("<pre>".print_r($arrReturn, true)."</pre><hr>");
		//var_dump($this->upload->display_errors());
		header('Content-Type: application/json');
		echo json_encode($arrReturn);
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
			'prd_initial_g_stock'	   => $this->input->post('postStokAwalG'),
			'prd_initial_ng_stock'	   => $this->input->post('postStokAwalNG'),
			'prd_initial_return_stock' => $this->input->post('postStokAwalR'),
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