<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Product_c extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Product_m');
	}

	public function index(){
	  /** Data yang akan dikirim ke view */
		$this->pageData = array(
			'title'  => 'PoS | List Product',
			'assets' => array(),
		);

      /** View file */
		$this->page = 'product/index_product_v';

      /** Call function layout dari MY_Controller Class */
        $this->layout();
	}

  /** CRUD Product */
	/** Function : Halaman form tambah product */
	public function addProductPage(){
	  /** Check allowed user */
		$this->auth_user(['uAll', 'uO', 'uG']);

	  /** Proses tampil halaman */
		$this->pageData = array(
			'title'   => 'PoS | Input Product',
			'assets'  => array('sweetalert2', 'dropify', 'add_product'),
			'optCtgr' => $this->Product_m->selectCategory()->result_array(), // Get semua kategori untuk option
			'optUnit' => $this->Product_m->selectUnit()->result_array() // Get semua satuan untuk option
		);
		$this->page = 'product/add_product_v';
		$this->layout();
	}

	/** Function : List product */
	public function listProductPage(){
	  /** Check allowed user */
		$this->auth_user(['uAll', 'uO', 'uG', 'uK', 'uP']);

		$this->pageData = array(
			'title'  => 'PoS | List Product',
			'assets' => array('datatables', 'sweetalert2', 'list_product', 'f_confirm'),
			'prdAjaxUrl' => site_url('Product_c/listProductAjax/All')
		);
		$this->page = 'product/list_product_v';
		$this->layout();
	}

	/** Function : Ajax list product */
	public function listProductAjax($type, $id = NULL){
	  /** Check allowed user */
		$this->auth_user(['uAll', 'uO', 'uG', 'uK', 'uP']);
		
		if($type == 'All'){
			$getData = $this->Product_m->selectProduct($this->input->post('length'), $this->input->post('start'));
		} else if($type == 'Category') {
			$getData = $this->Product_m->selectProductOnCtgr(base64_decode(urldecode($id)), $this->input->post('length'), $this->input->post('start'));
		}
		$prdData	= array();
		$no			= $this->input->post('start');
		foreach($getData->result_array() as $show){
			$no++;
			$row = array();
			$row[] = ($show['prd_barcode'])? $show['prd_barcode'] : '<i class="fas fa-minus" style="color: red;"></i>';
			$row[] = $show['prd_name'];
			$row[] = $show['ctgr_name'];
			( in_array($this->session->userdata('logedInLevel'), ['uAll', 'uO', 'uP']) == TRUE )? $row[] = $show['prd_purchase_price'] : '';
			( in_array($this->session->userdata('logedInLevel'), ['uAll', 'uO', 'uK']) == TRUE )? $row[] = $show['prd_selling_price'] : '';
			$row[] = $show['unit_name'];
			$row[] = '0';
			if( in_array($this->session->userdata('logedInLevel'), ['uAll', 'uO', 'uG']) == TRUE ){
				$row[] = '<a class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title="Detail produk" href="'.site_url("Product_c/detailProductPage/").urlencode(base64_encode($show['prd_id'])).'" data-toggle="tooltip" data-placement="top" title="Detail Produk"><i class="fas fa-search"></i></a>
					<a class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="Ubah produk" href="'.site_url('Product_c/editProductPage/').urlencode(base64_encode($show['prd_id'])).'" data-toggle="tooltip" data-placement="top" title="Edit Produk"><i class="fas fa-edit"></i></a>
					<a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus produk" onclick="confirmDelete(\'soft-prd\', \' '.urlencode(base64_encode($show['prd_id'])).' \', \' '.site_url('Product_c/softdeleteProductProses').' \')" data-toggle="tooltip" data-placement="top" title="Hapus Produk"><i class="fas fa-trash"></i></a>';
			}
			$prdData[] = $row;
		}

		$output = array(
			'draw'			  => $this->input->post('draw'),
			'recordsTotal'	  => $this->Product_m->count_all(),
			'recordsFiltered' => $this->Product_m->count_filtered($this->input->post('length'), $this->input->post('start')),
			'data'			  => $prdData
		);

		header('Content-Type: application/json');
		echo json_encode($output);
	}

	/** Function : List product berdasar kategori */
	public function listProductOnCatPage($encoded_cat_id){
	  /** Check allowed user */
		$this->auth_user(['uAll', 'uO', 'uG', 'uK', 'uP']);

		$catID = base64_decode(urldecode($encoded_cat_id));
		$this->pageData = array(
			'title'  => 'PoS | List Product',
			'assets' => array('datatables', 'sweetalert2', 'f_confirm', 'list_product'),
			'prdAjaxUrl' => site_url('Product_c/listProductAjax/Category/'.$encoded_cat_id),
			'dataCtgr'	=> $this->Product_m->selectCategoryByID($catID)->result_array()
		);
		$this->page = 'product/list_product_v';
		$this->layout();
	}

	/** Function : Stock product */
	public function stockProductPage(){
	  /** Check allowed user */
		$this->auth_user(['uAll', 'uO', 'uG']);

		$this->pageData = array(
			'title' 	=> 'PoS | Stock Product',
			'assets'	=> array('datatables', 'sweetalert2', 'stock_product')
		);

		/** Set view file */
		$this->page = 'product/stock_product_v';
		$this->layout();
	}

	/** Function : Ajax stock product */
	public function stockProductAjax(){
		$prdData	= array();
		foreach($this->Product_m->selectProductStock($this->input->post('length'), $this->input->post('start'))->result_array() as $show){
			$actionBtn = '<a class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title="Detail Produk" href="'.site_url('Product_c/detailProductPage/').urlencode(base64_encode($show['prd_id'])).'"> <i class="fas fa-search"></i> </a>';
			if( in_array($this->session->userdata('logedInLevel'), ['uAll', 'uG']) == TRUE ){
				$actionBtn .= '&nbsp;<a class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="Mutasi Stok" href="'.site_url('Product_c/stockMutationProductPage/'.urlencode(base64_encode($show['prd_id']))).'"><i class="fas fa-people-carry"></i></a>';
			}

			$row = array();
			$row[] = ($show['prd_barcode'])? $show['prd_barcode'] : '<i class="fas fa-minus" style="color: red;"></i>';
			$row[] = $show['prd_name'];
			$row[] = $show['prd_initial_g_stock'];
			$row[] = $show['stk_good'];
			$row[] = $show['prd_initial_ng_stock'];
			$row[] = $show['stk_not_good'];
			$row[] = $show['prd_initial_op_stock'];
			$row[] = $show['stk_opname'];
			$row[] = $actionBtn;
		
			$prdData[] = $row;
		}

		$output = array(
			'draw'			  => $this->input->post('draw'),
			'recordsTotal'	  => $this->Product_m->count_all('stock'),
			'recordsFiltered' => $this->Product_m->count_filtered($this->input->post('length'), $this->input->post('start'), 'stock'),
			'data'			  => $prdData
		);

		echo json_encode($output);
	}

	/** Function : Mutasi stock product */
	public function stockMutationProductPage($encoded_prd_id){
	  /** Check allowed user */
		$this->auth_user(['uAll', 'uG']);

	  /** Decode produk id */
		$prdID = base64_decode(urldecode($encoded_prd_id));

		$this->pageData = array(
			'title' 	=> 'PoS | Mutasi Stock Product',
			'assets'	=> array('sweetalert2', 'add_product'),
			'detailPrd' => $this->Product_m->selectProductByID($prdID)->result_array(), // Get data berdasar produk id
		);
		
		$this->page = 'product/stock_mutation_product_v';
		$this->layout();
	}

	/** Function : Proses Mutasi stock */
	public function stockMutationProses(){
	  /** Load library & Helper */
		$this->load->library('form_validation'); 
		  
	  /** Set rules form validation */
		$configValidation = array(
			array(
				'field'	=> 'postPrdID',
				'label'	=> 'Produk',
				'rules'	=> 'trim|required|callback__validation_product',
				'errors'	=> array(
					'required' => 'Produk tidak boleh kosong'
				)
			),
			array(
				'field'	=> 'postStockDate',
				'label'	=> 'Tgl Mutasi',
				'rules'	=> 'trim|required|callback__validation_date',
				'errors'	=> array(
					'required' => 'Tgl mutasi tidak boleh kosong',
					'_validation_date' => 'Tgl tidak valid'
				)
			),
			array(
				'field'	=> 'postStockA',
				'label'	=> 'Dari stok',
				'rules'	=> 'trim|required|in_list[SG,SNG,SO]',
				'errors'	=> array(
					'required' => 'Asal stok tidak boleh kosong',
					'in_list' => 'Pilih opsi yang tersedia'
				)
			),
			array(
				'field'	=> 'postStockB',
				'label'	=> 'Dari stok',
				'rules'	=> 'trim|required|in_list[SG,SNG,SO]',
				'errors'	=> array(
					'required' => 'Asal stok tidak boleh kosong',
					'in_list' => 'Pilih opsi yang tersedia'
				)
			),
			array(
				'field'	=> 'postStockQty',
				'label'	=> 'Jumlah mutasi',
				'rules'	=> 'trim|required|numeric|greater_than[0]',
				'errors'	=> array(
					'required' => 'Jumlah tidak boleh kosong',
					'numeric' => 'Jumlah tidak valid',
					'greater_than' => 'Jumlah harus lebih dari 0'
				)
			),
			array(
				'field'	=> 'postStockPS',
				'label'	=> 'Catatan',
				'rules'	=> 'trim'
			),
		);
		$this->form_validation->set_rules($configValidation);

	  /** Run form validation */
		if($this->form_validation->run() == FALSE) {
			$arrReturn = array(
				'error'			=> TRUE,
				'errorPrdID' 	=> form_error('postPrdID'),
				'errorStockDate' => form_error('postStockDate'),
				'errorStockA' 	=> form_error('postStockA'),
				'errorStockB' 	=> form_error('postStockB'),
				'errorStockQty' => form_error('postStockQty'),
				'errorStockPS'	=> form_error('postStockPS')
			);
		} else {
			$encoded_prd_id = $this->input->post('postPrdID');
			$postData = array(
				'sm_prd_id_fk' 	=> base64_decode(urldecode($this->input->post('postPrdID'))),
				'sm_date' 		=> $this->input->post('postStockDate'),
				'sm_stock_from' => $this->input->post('postStockA'),
				'sm_stock_to' 	=> $this->input->post('postStockB'),
				'sm_qty' 		=> $this->input->post('postStockQty'),
				'sm_post_script' => $this->input->post('postStockPS'),
				'created_at'	=> date('Y-m-d H:i:s'),
				'created_by'	=> base64_decode(urldecode($this->session->userdata('userID')))
			);
			
			/** Set asal field mutation */
			$from = $this->setStockField($this->input->post('postStockA'));
			$to = $this->setStockField($this->input->post('postStockB'));

			/** Input ke database */
			$inputSM = $this->Product_m->insertStockMutation($postData, $from, $to);

			/** Proses simpan data */
			if($inputSM == TRUE){
				/** Result to return */
				$arrReturn = array(
					'success'	=> TRUE,
					'status'	=> 'successInsert',
					'statusMsg' => 'Berhasil menambahkan data mutasi !',
					'statusIcon' => 'success',
					'redirect'	=> site_url('Product_c/detailProductPage/'.$encoded_prd_id)
				);
			} else {
				/** Result to return */
				$arrReturn = array(
					'success'	=> TRUE,
					'status'	=> 'failedInsert',
					'statusMsg' => 'Gagal menambahkan data mutasi !',
					'statusIcon' => 'error'
				);
			}
		}

		header('Content-Type: application/json');
		echo json_encode($arrReturn);
	}

	/** Function : List Stock mutation */
	public function listMutationPage(){
	  /** Check allowed user */
		$this->auth_user(['uAll', 'uO', 'uG']);

		$this->pageData = array(
			'title'  => 'PoS | List Mutasi Stok',
			'assets' => array('datatables', 'list_product'),
			'prdAjaxUrl' => site_url('Product_c/listStockMutationAjax/')
		);
		$this->page = 'product/list_stock_mutation_v';
		$this->layout();
	}

	/** Function : Ajax Stock Mutation */
	public function listStockMutationAjax(){
		$smData	= array();
		foreach($this->Product_m->selectStockMutation($this->input->post('length'), $this->input->post('start'))->result_array() as $show){
			switch ($show['sm_stock_from']){
				case 'SG' :
					$stock_from = '<span class="badge badge-info">Stok Bagus</span>';
					break;  
				case 'SNG' :
					$stock_from = '<span class="badge badge-danger">Stok Rusak</span>';
					break;
				case 'SO' :
					$stock_from = '<span class="badge badge-warning">Stok Opname</span>';
					break;
			}
			switch ($show['sm_stock_to']){
				case 'SG' :
					$stock_to = '<span class="badge badge-info">Stok Bagus</span>';
					break;  
				case 'SNG' :
					$stock_to = '<span class="badge badge-danger">Stok Rusak</span>';
					break;
				case 'SO' :
					$stock_to = '<span class="badge badge-warning">Stok Opname</span>';
					break;
			}

			$row = array();
			$row[] = date('d-m-Y', strtotime($show['sm_date']));
			$row[] = $show['prd_name'];
			$row[] = $stock_from;
			$row[] = $stock_to;
			$row[] = $show['sm_qty'];
			$row[] = "<small>".$show['sm_post_script']."</small>";
		
			$smData[] = $row;
		}

		$output = array(
			'draw'			  => $this->input->post('draw'),
			'recordsTotal'	  => $this->Product_m->count_all_mutation(),
			'recordsFiltered' => $this->Product_m->selectStockMutation($this->input->post('length'), $this->input->post('start'))->num_rows(),
			'data'			  => $smData
		);

		echo json_encode($output);
	}

	/** Function : Detail product page */
	public function detailProductPage($encoded_prd_id){
	  /** Check allowed user */
		$this->auth_user(['uAll', 'uO', 'uG']);

	  /** Decode produk id */
		$prdID = base64_decode(urldecode($encoded_prd_id));
	  
	  /** Proses tampil halaman */
		$this->pageData = array(
			'title'   => 'PoS | Detail Product',
			'assets'  => array(),
			'detailPrd' => $this->Product_m->selectProductByID($prdID)->result_array(), // Get data berdasar produk id
			'detailMutation' => $this->Product_m->selectMutationByProductID($prdID)->result_array(), // Get data mutasi berdasar produk id
		);
		$this->page = 'product/detail_product_v';
		$this->layout();
	}

	/** Function : Form edit product */
	public function editProductPage($id){
	  /** Check allowed user */
		$this->auth_user(['uAll', 'uO', 'uG']);

	  /** Decode produk id */
		$prdID = base64_decode(urldecode($id));
	  
	  /** Proses tampil halaman */
		$this->pageData = array(
			'title'   => 'PoS | Edit Product',
			'assets'  => array('sweetalert2', 'dropify', 'p_edit_product'),
			'detailPrd' => $this->Product_m->selectProductOnID($prdID), // Get data berdasar produk id
			'optCtgr' => $this->Product_m->selectCategory()->result_array(), // Get semua kategori untuk option
			'optUnit' => $this->Product_m->selectUnit()->result_array() // Get semua satuan untuk option
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
		$configValidation = array(
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
		$this->form_validation->set_rules($configValidation);

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
				  /** Load lib dan helper */
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

		header('Content-Type: application/json');
		echo json_encode($arrReturn);
	}

	/* Function : Proses edit / update product */
	function editProductProses(){
		/** Load library & Helper */
			$this->load->library('form_validation'); 

		/** Get post data dari form */
			$prdID = base64_decode(urldecode($this->input->post('postId')));
			$postData = array(
				'prd_barcode'			=> $this->input->post('postBarcode'),
				'prd_name'				=> $this->input->post('postNama'),
				'prd_category_id_fk'	=> $this->input->post('postKategori'),
				'prd_purchase_price'	=> $this->input->post('postHargaBeli'),
				'prd_selling_price'		=> $this->input->post('postHargaJual'),
				'prd_unit_id_fk' 	 	=> $this->input->post('postSatuan'),
				'prd_containts' 	 	=> $this->input->post('postIsi'),
				'prd_initial_g_stock'	=> $this->input->post('postStockG'),
				'prd_initial_ng_stock'	=> $this->input->post('postStockNG'),
				'prd_initial_op_stock'	=> $this->input->post('postStockOP'),
				'prd_description'		=> $this->input->post('postDeskripsi'),
				'prd_image'				=> $this->input->post('postOldImg')
			);

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
				/** Check gambar baru */
				if($_FILES['postImg']['name']){
					/** Load lib dan helper */
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

							/** Delete gambar lama */
							if($this->input->post('postOldImg') != ''){ unlink($this->input->post('postOldImg')); }
			
							/** Set value */
							$postData['prd_image'] = $config['upload_path'].$uploadData['file_name'];
							$errorUpload = NULL;
						} else {
							$errorUpload = $this->upload->display_errors();
						}
				}

				if(isset($errorUpload) && $errorUpload != NULL){
					$arrReturn['error']	   = TRUE;
					$arrReturn['errorImg'] = $errorUpload;
				} else {
					/** Update data */
	  					$editPrd = $this->Product_m->updateProduct($prdID, $postData);

					/** Return dan redirect */
						if($editPrd && $editPrd > 0){
							  /** Result to return */
							  $arrReturn = array(
								  'success'	=> TRUE,
								  'status'	=> 'successUpdate',
								  'statusMsg' => 'Berhasil mengubah data produk !',
								  'statusIcon' => 'success',
								  'redirect'	=> site_url('Product_c/listProductPage')
							  );
						} else {
							/** unlink new image */
							unlink($postData['prd_image']);

							/** Result to return */
							$arrReturn = array(
								'success'	=> TRUE,
								'status'	=> 'failedUpdate',
								'statusMsg' => 'Gagal mengubah data produk !',
								'statusIcon' => 'error',
								'redirect'	=> site_url('Product_c/listProductPage')
							);
						} 
				}
			}

			header('Content-Type: application/json');
			echo json_encode($arrReturn);
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
			$data = $this->Product_m->searchProduct($this->input->get('term'), '0');
			if(count($data) > 0){
				foreach($data as $row)
					$prdData[] = array(
						'label' => $row['prd_name'],
						'prd_id' => urlencode(base64_encode($row['prd_id'])),
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
	  /** Check allowed user */
		$this->auth_user(['uAll', 'uO', 'uG', 'uK', 'uP']);

		$this->pageData = array(
			'title'  => 'PoS | List Kategori',
			'assets' => array('datatables', 'sweetalert2', 'ctgr_unit', 'f_confirm')
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
			$actionBtn = '<a class="btn btn-xs btn-info" href="'.site_url('Product_c/listProductOnCatPage/').urlencode(base64_encode($show['ctgr_id'])).'"><i class="fas fa-list"></i></a>';
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $show['ctgr_name'];
			$row[] = $show['ctgr_count_prd'];

			if( in_array($this->session->userdata('logedInLevel'), ['uAll', 'uO', 'uG']) == TRUE ){
				$actionBtn .= '&nbsp;<a class="btn btn-xs btn-warning" onclick="editCtgrUnit(\'ctgr\', \''.urlencode(base64_encode($show['ctgr_id'])).'\', \''.$show['ctgr_name'].'\')"><i class="fas fa-edit"></i></a>
				<a class="btn btn-xs btn-danger" onclick="confirmDelete(\'ctgr\', \''.urlencode(base64_encode($show['ctgr_id'])).'\', \''.site_url('Product_c/deleteCategoryProses').'\')"><i class="fas fa-trash"></i></a>  
				';
			}
			$row[] = $actionBtn;
		
			$ctgrData[] = $row;
		}

		$output = array(
			'draw'			  => $this->input->post('draw'),
			'recordsTotal'	  => $this->Product_m->count_all(),
			'recordsFiltered' => $this->Product_m->count_filtered($this->input->post('length'), $this->input->post('start')),
			'data'			  => $ctgrData
		);

		echo json_encode($output);
	}

	/* Function : Add Kategori Proses */
	function addCategoryProses(){
		/** Load library & Helper */
		  $this->load->library('form_validation'); 
			
		/** Set rules form validation */
		  $configValidation = array(
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
		  $this->form_validation->set_rules($configValidation);
  
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
		$unitData	= array();
		$no			= $this->input->post('start');
		foreach($getData->result_array() as $show){
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $show['unit_name'];
			$row[] = $show['unit_count_prd'];

			if( in_array($this->session->userdata('logedInLevel'), ['uAll', 'uO', 'uG']) == TRUE ){
				$row[] = '
				<a class="btn btn-xs btn-warning" onclick="editCtgrUnit(\'unit\', \''.urlencode(base64_encode($show['unit_id'])).'\', \''.$show['unit_name'].'\')"><i class="fas fa-edit"></i></a>
				<a class="btn btn-xs btn-danger" onclick="confirmDelete(\'unit\', \''.urlencode(base64_encode($show['unit_id'])).'\', \''.site_url('Product_c/deleteUnitProses').'\')"><i class="fas fa-trash"></i></a>  
				';
			}
		
			$unitData[] = $row;
		}

		$output = array(
			'draw'			  => $this->input->post('draw'),
			'recordsTotal'	  => $this->Product_m->count_all(),
			'recordsFiltered' => $this->Product_m->count_filtered($this->input->post('length'), $this->input->post('start')),
			'data'			  => $unitData
		);

		echo json_encode($output);
	}

	/** Function : add Satuan Proses */
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

	/** Function : edit Satuan Proses */
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

	/** Function : Delete Satuan */
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

  /** Lainnya */
	/** Set field stock */
	private function setStockField($post){
		switch ($post){
			case 'SG' :
				return 2;
				break;  
			case 'SNG' :
				return 3;
				break;
			case 'SO' :
				return 4;
				break;
		}
	}
  
  /** Validation */
	/** Validation : Validation product id */
	function _validation_product($post){
		if($this->Product_m->selectProductByID(base64_decode(urldecode($post)))->num_rows() > 0){
			return TRUE;
		} else {
			$this->form_validation->set_message('_validation_product', 'Product tidak ditemukan !');
			return FALSE;
		}
	}
	  
	/** Validation : date */
	  function _validation_date($post){
		  /** preg_match pattern for input format YYYY-mm-dd */
		  if(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $post)){
			  /** checkdate(month, day, year) for input format YYYY-mm-dd */
			  if(checkdate(substr($post, 5, 2), substr($post, 8, 2), substr($post, 0, 4))){
				  return TRUE;
			  } else {
				  return FALSE;
			  }
		  } else {
			  return FALSE;
		  }
	  }
}