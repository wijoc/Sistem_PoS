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
			'optCtgr' => $this->Product_m->selectCategory(), // Get semua kategori untuk option
			'optUnit' => $this->Product_m->selectUnit() // Get semua satuan untuk option
		);
		$this->page = 'product/add_product_v';
		$this->layout();
	}

	/** Function : List product */
	public function listProductPage(){
		$this->pageData = array(
			'title'  => 'PoS | List Product',
			'assets' => array('datatables', 'sweetalert2', 'p_list_product', 'f_confirm'),
		);
		$this->page = 'product/list_product_v';
		$this->layout();
	}

	/** Function : Ajax list product */
	public function listProductAjax(){
		$getData	= $this->Product_m->selectProduct($this->input->post('length'), $this->input->post('start'));
		$prdData	= array();
		$no			= $this->input->post('start');
		foreach($getData->result_array() as $show){
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $show['prd_name'];
			$row[] = $show['ctgr_name'];
			$row[] = $show['prd_purchase_price'];
			$row[] = $show['prd_selling_price'];
			$row[] = $show['unit_name'];
			$row[] = '0';
			$row[] = '<a class="btn btn-xs btn-info" href="'.site_url("Product_c/detailProductPage/").urlencode(base64_encode($show['prd_id'])).'" data-toggle="tooltip" data-placement="top" title="Detail Produk"><i class="fas fa-search"></i></a>
			<a class="btn btn-xs btn-warning" href="'.site_url('Product_c/editProductPage/').urlencode(base64_encode($show['prd_id'])).'" data-toggle="tooltip" data-placement="top" title="Edit Produk"><i class="fas fa-edit"></i></a>
			<a class="btn btn-xs btn-danger" onclick="confirmDelete(\'soft-prd\', \' '.urlencode(base64_encode($show['prd_id'])).' \', \' '.site_url('Product_c/softdeleteProductProses').' \')" data-toggle="tooltip" data-placement="top" title="Hapus Produk"><i class="fas fa-trash"></i></a>';
		
			$prdData[] = $row;
		}

		$output = array(
			'draw'			  => $this->input->post('draw'),
			'recordsTotal'	  => $this->Product_m->count_all(),
			'recordsFiltered' => $this->Product_m->count_filtered($this->input->post('length'), $this->input->post('start')),
			'data'			  => $prdData
		);

		echo json_encode($output);
	}

	/** Function : List product berdasar kategori */
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
			'detailPrd' => $this->Product_m->selectProductOnID($prdID), // Get data berdasar produk id
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
			'assets'  => array('sweetalert2', 'dropify', 'page_add_product'),
			'detailPrd' => $this->Product_m->selectProductOnID($prdID), // Get data berdasar produk id
			'optCtgr' => $this->Product_m->selectCategory(), // Get semua kategori untuk option
			'optUnit' => $this->Product_m->selectUnit() // Get semua satuan untuk option
		);
		$this->page = 'product/edit_product_v';
		$this->layout();
	}

	/* Function : Proses input product */
	function addProductProses(){
	  /** Load library & Helper */
		  $this->load->library('form_validation'); 
		  $this->load->helper('file');
		  $this->load->library('upload');
		  
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
	  /** Get posted id and decode proses */
		  $prdID = base64_decode(urldecode($this->input->post('postID')));
		  //$prdID = base64_decode(urldecode('Mw%3D%3D '));

	  /** Proses delete data di database */
	  	$delPrd = $this->Product_m->softdeleteProduct($prdID); 

	  /** Return Value */
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

  /** CRUD Kategori & Satuan */
	/** Function : List kategori dan satuan */
	public function listCatUnitPage(){
		$this->pageData = array(
			'title'  => 'PoS | List Kategori',
			'assets' => array('datatables', 'sweetalert2', 'p_ctgr_unit', 'page_catunit', 'f_confirm')
		);
		$this->page = 'product/list_category_unit_v';
		$this->layout();
	}

	/** Function : Ajax list kategori dan satuan */
	public function listCategoryAjax(){
		$getData	= $this->Product_m->selectCategory($this->input->post('length'), $this->input->post('start'));
		$ctgrData	= array();
		$no			= $this->input->post('start');
		foreach($getData->result_array() as $show){
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $show['ctgr_name'];
			$row[] = $show['ctgr_count_prd'];
			$row[] = '
			<a class="btn btn-xs btn-info" href="'.site_url('Product_c/listProductOnCatPage/').urlencode(base64_encode($show['ctgr_id'])).'"><i class="fas fa-list"></i></a>
			<a class="btn btn-xs btn-warning" onclick="editCtgrUnit(\'ctgr\', \''.urlencode(base64_encode($show['ctgr_id'])).'\', \''.$show['ctgr_name'].'\')"><i class="fas fa-edit"></i></a>
			<a class="btn btn-xs btn-danger" onclick="confirmDelete(\'ctgr\', \''.urlencode(base64_encode($show['ctgr_id'])).'\', \''.site_url('Product_c/deleteCategoryProses').'\')"><i class="fas fa-trash"></i></a>  
			';
		
			$prdData[] = $row;
		}

		$output = array(
			'draw'			  => $this->input->post('draw'),
			'recordsTotal'	  => $this->Product_m->count_all(),
			'recordsFiltered' => $this->Product_m->count_filtered($this->input->post('length'), $this->input->post('start')),
			'data'			  => $prdData
		);

		echo json_encode($output);
	}

	/* Function : Add Kategori Proses */
	function addCategoryProses(){
		/** Load library & Helper */
		  $this->load->library('form_validation'); 
			
		/** Set rules form validation */
		  $config = array(
			  array(
				  'field'	=> 'postCtgrName',
				  'label'	=> 'Nama Kategori',
				  'rules'	=> 'trim|required|is_unique[tb_category.ctgr_name]',
				  'errors'	=> array(
					  'is_unique'	=> 'Kategori sudah tersedia',
					  'required'	=> 'Kategori tidak boleh kosong'
				  )
			  )
		  );
		  $this->form_validation->set_rules($config);
  
		/** Run form validation */
		  if($this->form_validation->run() == FALSE) {
			  $arrReturn = array(
				  'error'			=> TRUE,
				  'errorCtgr' 	=> form_error('postCtgrName')
			  );
		  } else {
			  /** Get data post dari form */
				  $postData = array(
					  'ctgr_name' => $this->input->post('postCtgrName')
				  );
			  
			  /** insert ke database */
				  $inputCtgr = $this->Product_m->insertCategory($postData);
  
			  /** Set return value */
			  if($inputCtgr > 0){
				  /** Result to return */
				  $arrReturn = array(
					  'success'	=> TRUE,
					  'status'	=> 'successInsert',
					  'statusMsg' => 'Berhasil Menambahkan kategori !',
					  'statusIcon' => 'success'
				  );
			  } else {
				  /** Result to return */
				  $arrReturn = array(
					  'success'	=> FALSE,
					  'status'	=> 'failedInsert',
					  'statusMsg' => 'Gagal Menambahkan kategori !',
					  'statusIcon' => 'error'
				  );
			  }
		  }
		
		header('Content-Type: application/json');
		echo json_encode($arrReturn);
	}

	/* Function : Edit Kategori Proses */
	function editCategoryProses(){
		$editData = array(
			'ctgr_id' 	=> base64_decode(urldecode($this->input->post('postID'))),
			'ctgr_name' => $this->input->post('postName')
		);
		
		$editCategori = $this->Product_m->updateCategory($editData);

		/** Return value */
		if($editCategori > 0){
			$arrReturn = array(
				'success'	=> TRUE,
				'status'	=> 'successUpdate',
				'statusMsg' => 'Berhasil mengubah data kategori !',
				'statusIcon' => 'success',
				'type'		=> 'ctgr'
			);
		} else {
			$arrReturn = array(
				'success'	=> TRUE,
				'status'	=> 'failedUpdate',
				'statusMsg' => 'Gagal mengubah data kategori !',
				'statusIcon' => 'error',
				'type'		=> 'ctgr'
			);
		}
		
		header('Content-Type: application/json');
		echo json_encode($arrReturn);
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

	/** Function : Ajax list satuan dan satuan */
	public function listUnitAjax(){
		$getData	= $this->Product_m->selectUnit($this->input->post('length'), $this->input->post('start'));
		$ctgrData	= array();
		$no			= $this->input->post('start');
		foreach($getData->result_array() as $show){
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $show['unit_name'];
			$row[] = $show['unit_count_prd'];
			$row[] = '
			<a class="btn btn-xs btn-warning" onclick="editCtgrUnit(\'unit\', \''.urlencode(base64_encode($show['unit_id'])).'\', \''.$show['unit_name'].'\')"><i class="fas fa-edit"></i></a>
			<a class="btn btn-xs btn-danger" onclick="confirmDelete(\'unit\', \''.urlencode(base64_encode($show['unit_id'])).'\', \''.site_url('Product_c/deleteUnitProses').'\')"><i class="fas fa-trash"></i></a>  
			';
		
			$prdData[] = $row;
		}

		$output = array(
			'draw'			  => $this->input->post('draw'),
			'recordsTotal'	  => $this->Product_m->count_all(),
			'recordsFiltered' => $this->Product_m->count_filtered($this->input->post('length'), $this->input->post('start')),
			'data'			  => $prdData
		);

		echo json_encode($output);
	}

	/* Function : add Satuan Proses */
	function addUnitProses(){
		/** Load library & Helper */
		  $this->load->library('form_validation'); 
			
		/** Set rules form validation */
		  $config = array(
			  array(
				  'field'	=> 'postUnitName',
				  'label'	=> 'Nama Satuan',
				  'rules'	=> 'trim|required|is_unique[tb_unit.unit_name]',
				  'errors'	=> array(
					  'is_unique'	=> 'Satuan sudah tersedia',
					  'required'	=> 'Satuan tidak boleh kosong'
				  )
			  )
		  );
		  $this->form_validation->set_rules($config);
  
		/** Run form validation */
		  if($this->form_validation->run() == FALSE) {
			  $arrReturn = array(
				  'error'		=> TRUE,
				  'errorUnit' 	=> form_error('postUnitName')
			  );
		  } else {
			/** Get data post dari form */
			$postData = array(
				'unit_name' => $this->input->post('postUnitName')
			);
	  
			/** Insert ke database */
			$inputUnit = $this->Product_m->insertUnit($postData);
	  
			/** Return Value */
			if($inputUnit > 0){
				/** Result to return */
				$arrReturn = array(
					'success'	=> TRUE,
					'status'	=> 'successInsert',
					'statusMsg' => 'Berhasil Menambahkan data satuan !',
					'statusIcon' => 'success'
				);
			} else {
				/** Result to return */
				$arrReturn = array(
					'success'	=> FALSE,
					'status'	=> 'failedInsert',
					'statusMsg' => 'Gagal Menambahkan data satuan !',
					'statusIcon' => 'error'
				);
			} 
		  }
		
		header('Content-Type: application/json');
		echo json_encode($arrReturn);
	}

	/* Function : edit Satuan Proses */
	function editUnitProses(){
		/** Get data dari form */
		$editData = array(
		  'unit_id' 	=> base64_decode(urldecode($this->input->post('postID'))),
		  'unit_nama' => $this->input->post('postName')
		);

		$editUnit = $this->Product_m->updateUnit($editData);

		/** Return value */
		if($editUnit > 0){
			$arrReturn = array(
				'success'	=> TRUE,
				'status'	=> 'successUpdate',
				'statusMsg' => 'Berhasil mengubah data satuan !',
				'statusIcon' => 'success',
				'type'		=> 'unit'
			);
		} else {
			$arrReturn = array(
				'success'	=> FALSE,
				'status'	=> 'failedUpdate',
				'statusMsg' => 'Gagal mengubah data satuan !',
				'statusIcon' => 'error',
				'type'		=> 'unit'
			);
		}
		
		header('Content-Type: application/json');
		echo json_encode($arrReturn);
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