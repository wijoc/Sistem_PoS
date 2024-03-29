<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Transaction_c extends MY_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->model('Sales_m');
		$this->load->model('Purchases_m');
		$this->load->model('Account_m');
		$this->load->model('Installment_m');
		$this->load->model('Return_m');
		$this->load->model('Expenses_m');
		$this->load->model('Revenues_m');
	}

	public function index(){
	  /** Data yang akan dikirim ke view */
	  	$this->pageData = array(
	  		'title' => 'PoS | Transaksi',
	  		'assets' =>array()
	  	);

	  /** Load file view */
	  	$this->page = 'trans/index_trans_v';

	  /** Call function layout dari my controller */
	  	$this->layout();
	}

  /** CRUD Cart / Keranjang */
	/** Function : Tambah data keranjang */
	public function addCart($trans){
	  /** Load library & Helper */
		$this->load->library('form_validation');
	
	  /** Set rules form validation */
		$configValidation = array(
		  array(
			'field'  => 'postIdPrd',
			'label'  => 'ID Product',
			'rules'  => 'trim|required',
			'errors'  => array(
				'required' => 'Product tidak boleh kosong'
			)
		  ),
		  array(
			'field'  => 'postCartPrice',
			'label'  => 'Harga Satuan',
			'rules'  => 'trim|numeric|greater_than[0]|required',
			'errors'  => array(
				'numeric'	=> 'Harga tidak valid',
				'required'	=> 'Harga tidak boleh kosong',
				'greater_than' => 'Harga tidak boleh kurang dari 0'
			)
		  ),
		  array(
			'field'  => 'postCartQty',
			'label'  => 'Qty',
			'rules'  => 'trim|numeric|greater_than[0]|required',
			'errors'  => array(
				'numeric'	=> 'Quantity tidak valid',
				'required'	=> 'Qty tidak boleh kosong',
				'greater_than' => 'Qty tidak boleh kurang dari 0'
			)
		  )
		);
	
		$this->form_validation->set_rules($configValidation);
	
	  /** Run validate */
		if($this->form_validation->run() == FALSE){
			$arrReturn	= array(
				'error'     => TRUE,
				'errorID'	=> (form_error('postIdPrd'))? form_error('postIdPrd') : '',
				'errorQty'	=> (form_error('postCartQty'))? form_error('postCartQty') : '',
				'errorHrg'	=> (form_error('postCartPrice'))? form_error('postCartPrice') : ''
			);
		} else {
			/** Get data post dari form */
			$postData = array(
				'post_product_id' 	  => base64_decode(urldecode($this->input->post('postIdPrd'))),
				'post_price' => $this->input->post('postCartPrice'),
				'post_qty' 	 => $this->input->post('postCartQty'),
				'post_total' => floatval($this->input->post('postCartPrice')) * intval($this->input->post('postCartQty')),
				'cart_by'	 => base64_decode(urldecode($this->session->userdata('userID')))
			);

			if($trans === 'Purchases'){
				/** Cek product di keranjang */
				$checkTemp = $this->Purchases_m->getCartonPrdId(base64_decode(urldecode($this->input->post('postIdPrd'))));
				if(count($checkTemp) > 0 && $checkTemp[0]['tp_purchase_price'] == $postData['post_price']){
					$newAmount = $checkTemp[0]['tp_product_amount'] + intval($postData['post_qty']);
					$newTotal  = $checkTemp[0]['tp_total_paid'] + floatval($postData['post_total']);
	
					$updateId = $checkTemp[0]['tp_id'];
					$newInputData = array(
						'tp_product_fk'	=> $checkTemp[0]['tp_product_fk'],
						'tp_product_amount' => $newAmount,
						'tp_purchase_price' => $checkTemp[0]['tp_purchase_price'],
						'tp_total_paid'		=> $newTotal
					);
					$inputTemp = $this->Purchases_m->updateCart($newInputData, $updateId);
				} else {
					$inputTemp = $this->Purchases_m->insertCart($postData);
				}

				/** return value */
				if($inputTemp){
					$arrReturn = array(
						'success'	=> TRUE,
						'successMsg' => 'Product ditambahkan ke keranjang'
					);
				} else {
					$arrReturn = array(
						'success'	=> TRUE,
						'successMsg' => 'Gagal menambahkan product ke keranjang'
					);
				}
			} else if ($trans === 'Sales'){
				$this->form_validation->set_rules('postCartDiscount','Potongan','numeric');
				if($this->form_validation->run() == FALSE){
					$arrReturn	= array(
						'error'     => TRUE,
						'errorDisc'	=> (form_error('postCartDiscount'))? form_error('postCartDiscount') : ''
					);
				}else{
					/** Calc total */
					$postData['post_discount'] = $this->input->post('postCartDiscount');
					$postData['post_total'] = floatval($this->input->post('postCartPrice')) * intval($this->input->post('postCartQty')) - floatval($this->input->post('postCartDiscount'));

					/** Cek product di keranjang */
					$checkTemp = $this->Sales_m->getCartonPrdID(base64_decode(urldecode($this->input->post('postIdPrd'))), base64_decode(urldecode($this->session->userdata('userID'))))->result_array();
					if(count($checkTemp) > 0 && $checkTemp[0]['temps_sale_price'] == $postData['post_price']){
						$newAmount = $checkTemp[0]['temps_product_amount'] + intval($postData['post_qty']);
						$newDiscount  = $checkTemp[0]['temps_discount'] + floatval($postData['post_discount']);
						$newTotal  = $checkTemp[0]['temps_total_paid'] + floatval($postData['post_total']);
		
						$updateId = $checkTemp[0]['temps_id'];
						$newInputData = array(
							'temps_product_fk'	=> $checkTemp[0]['temps_product_fk'],
							'temps_product_amount' => $newAmount,
							'temps_sale_price' => $checkTemp[0]['temps_sale_price'],
							'temps_discount'   => $newDiscount,
							'temps_total_paid' => $newTotal
						);
						$inputTemp = $this->Sales_m->updateCart($newInputData, $updateId);
					} else {
						$inputTemp = $this->Sales_m->insertCart($postData);
					}

					/** return value */
					if($inputTemp){
						$arrReturn = array(
							'success'	=> TRUE,
							'successMsg' => 'Product ditambahkan ke keranjang'
						);
					} else {
						$arrReturn = array(
							'success'	=> TRUE,
							'successMsg' => 'Gagal menambahkan product ke keranjang'
						);
					}
				}
			}
		}

		header('Content-Type: application/json');
		echo json_encode($arrReturn);
	}

	/** Function : Hapus data keranjang */
	public function deleteCart($trans){
		if($trans === 'Purchases'){
			$delCart = $this->Purchases_m->deleteCart(base64_decode(urldecode($this->input->post('postId'))), $this->input->post('postPrice'));
			if($delCart > 0){
				$arrReturn = array(
					'success'	=> TRUE,
					'successMsg' => 'Product dihapus dari keranjang'
				);
			} else {
				$arrReturn = array(
					'success'	=> TRUE,
					'successMsg' => 'Product gagal dihapus dari keranjang'
				);
			}
		} else if ($trans === 'Sales') {
			$delCart = $this->Sales_m->deleteCart(base64_decode(urldecode($this->session->userdata('userID'))), base64_decode(urldecode($this->input->post('postId'))), $this->input->post('postPrice'));
			if($delCart > 0){
				$arrReturn = array(
					'success'	=> TRUE,
					'successMsg' => 'Product dihapus dari keranjang'
				);
			} else {
				$arrReturn = array(
					'success'	=> TRUE,
					'successMsg' => 'Product gagal dihapus dari keranjang'
				);
			}
		}

		header('Content-Type: application/json');
		echo json_encode($arrReturn);
	}

	/** Function : Daftar keranjang */
	public function listCartAjax($trans){
		if($trans == 'Purchases'){
			$cartData = $this->Purchases_m->selectCart(base64_decode(urldecode($this->session->userdata('userID'))))->result_array();
			$returnData = array(
				'trans_type' => 'Purchases', 
				'delete_url' => site_url('Transaction_c/deleteCart/Purchases/'),
				'cart_list'	 => null,
				'total_payment' => 0
			);
			$i = 0;
			foreach($cartData as $showData):
				$returnData['cart_list'][$i] = array(
					'cart_id' 	 => urlencode(base64_encode($showData['tp_product_fk'])),
					'cart_name'	 => $showData['prd_name'],
					'cart_amount' => $showData['tp_product_amount'],
					'cart_price' => $showData['tp_purchase_price'],
					'cart_total' => $showData['tp_total_paid']
				);
				$returnData['total_payment'] += $showData['tp_total_paid'];
				$i++;
			endforeach;
		} else if($trans == 'Sales'){
			$cartData = $this->Sales_m->selectCart(base64_decode(urldecode($this->session->userdata('userID'))))->result_array();
			$returnData = array(
				'trans_type' => 'Sales', 
				'delete_url' => site_url('Transaction_c/deleteCart/Sales/'),
				'cart_list'	 => null,
				'total_payment' => 0
			);
			$i = 0;
			foreach($cartData as $showData):
				$returnData['cart_list'][$i] = array(
					'cart_id' 	 => urlencode(base64_encode($showData['temps_product_fk'])),
					'cart_name'	 => $showData['prd_name'],
					'cart_amount' => $showData['temps_product_amount'],
					'cart_price' => $showData['temps_sale_price'],
					'cart_discount' => $showData['temps_discount'],
					'cart_total' => $showData['temps_total_paid']
				);
				$returnData['total_payment'] += $showData['temps_total_paid'];
				$i++;
			endforeach;
		}

		header('Content-Type: application/json');
		echo json_encode($returnData);
	}

  /** CRUD Purchases */
	/** Function : Page add purchasing */
	public function addPurchasesPage(){
	  /** Check allowed user */
		$this->auth_user(['uAll', 'uO', 'uP']);

	  /** Load Model supplier untuk option supplier */
	  	$this->load->model('Supplier_m');

	  /** Data yang ditampilkan ke view */
		$this->pageData = array(
			'title'   => 'PoS | Trans Pembelian',
			'assets'  => array('jqueryui', 'custominput', 'toastr', 'sweetalert2', 'add_transaction'),
			'optSupp' => $this->Supplier_m->selectSupplier(0, 0, 0)->result_array(),
			'optAcc'  => $this->Account_m->selectAccount(),
			'cartUrl' => site_url('Transaction_c/listCartAjax/Purchases/')
		);
		$this->page = 'trans/purchases/add_purchases_v';
		$this->layout();
	}

	/** Function : Proses add trans purchase */
	public function addPurchasesProses(){
	  /** Load lib dan helper */
		$this->load->helper('file');
		$this->load->library('form_validation');

	  /** Set rules form validation */
		$configValidation = array(
			array(
			  'field'  => 'postPDate',
			  'label'  => 'Tgl Transaksi',
			  'rules'  => 'trim|required|callback__validation_date',
			  'errors'  => array(
				  'required'	=> 'Tanggal tidak boleh kosong',
				  '_validation_date' => 'Tanggal tidak valid'
			  )
			),
			array(
			  'field'  => 'postPNote',
			  'label'  => 'No. Nota Pembelian',
			  'rules'  => 'trim|is_unique[trans_purchases.tp_note_code]|required',
			  'errors'  => array(
				  'is_unique' => 'Nomor Nota sudah digunakan',
				  'required' => 'Nomor Nota tidak boleh kosong'
			  )
			),
			array(
			  'field'  => 'postNoteFile',
			  'label'  => 'File nota',
			  'rules'  => 'callback__validation_file'
			),
			array(
			  'field'  => 'postPSupplier',
			  'label'  => 'Supplier',
			  'rules'  => 'trim|required|callback__validation_supplier',
			  'errors'  => array(
				  'required'	=> 'Supplier tidak boleh kosong',
				  '_validation_supplier' => 'Supplier tidak ditemukan'
			  )
			),
			array(
			  'field'  => 'postStatus',
			  'label'  => 'Status Pembayaran',
			  'rules'  => 'trim|required|in_list[K,T]',
			  'errors'  => array(
				  'required' => 'Status pembayaran tidak boleh kosong',
				  'in_list'  => 'Pilih opsi status yang tersedia'
			  )
			),
			array(
			  'field'  => 'postPTenor',
			  'label'  => 'Tenor',
			  'rules'  => 'trim|numeric|greater_than[0]|callback__validation_credit',
			  'errors'  => array(
				  'numeric' => 'Harus berinilai angka',
				  '_validation_credit' => 'Tenor tidak boleh kosong',
				  'greater_than[0]'	=> 'Tenor harus lebih dari 0'
			  )
			),
			array(
			  'field'  => 'postPTenorPeriode',
			  'label'  => 'Periode tenor',
			  'rules'  => 'in_list[D,W,M,Y]|callback__validation_credit',
			  'errors'  => array(
				'in_list'  => 'Pilih opsi periode yang tersedia',
				'_validation_credit' => 'Periode tidak boleh kosong',
			  )
			),
			array(
			  'field'  => 'postPInstallment',
			  'label'  => 'Angsuran',
			  'rules'  => 'trim|greater_than[0]|numeric|callback__validation_credit',
			  'errors'  => array(
				'numeric'  => 'Nilai angsuran tidak valid',
				'greater_than' => 'Nilai harus lebih dari 0',
				'_validation_credit' => 'Angsuran tidak boleh kosong',
			  )
			),
			array(
			  'field'  => 'postPDue',
			  'label'  => 'Tempo',
			  'rules'  => 'trim|callback__validation_credit|callback__validation_due',
			  'errors'  => array(
				'_validation_credit' => 'Tempo tidak boleh kosong',
			  )
			),
			array(
			  'field'  => 'postMethod',
			  'label'  => 'Metode pembayaran',
			  'rules'  => 'trim|required|in_list[TF,TN]',
			  'errors'  => array(
				'required' => 'Metode tidak boleh kosong',
				'in_list' => 'Pilih opsi metode yang tersedia'
			  )
			),
			array(
			  'field'  => 'postAccount',
			  'label'  => 'Rekening',
			  'rules'  => 'trim|callback__validation_account'
			),
			array(
			  'field'  => 'postPPayment',
			  'label'  => 'Pembayaran',
			  'rules'  => 'trim|required|numeric',
			  'errors' => array(
				'required'	=> 'Pembayaran tidak boleh kosong',
				'numeric'	=> 'Pembayaran tidak valid, harus berformat angka'
			  )
			),
			array(
				'field'	=> 'postPAdditional',
				'label'	=> 'Biaya tambahan',
				'rules'	=> 'trim|numeric',
				'errors' => array(
					'numeric'	=> 'Biaya tambahan tidak valid, harus berformat angka'
				)
			)
		);
	  
		$this->form_validation->set_rules($configValidation);

	  /** Run Validation */
		if($this->form_validation->run() == FALSE) {
			$arrReturn = array(
				'error'		=> TRUE,
				'errorPNote' 	=> form_error('postPNote'),
				'errorFilenote'	=> form_error('postNoteFile'),
				'errorPDate' 	=> form_error('postPDate'),
				'errorPSupp' 	=> form_error('postPSupplier'),
				'errorPStatus'	=> form_error('postStatus'),
				'errorPTenor'	=> form_error('postPTenor'),
				'errorPTenorPeriode' => form_error('postPTenorPeriode'),
				'errorPInstallment'	 => form_error('postPInstallment'),
				'errorPDue'		=> form_error('postPDue'),
				'errorPMethod'	=> form_error('postMethod'),
				'errorPAccount'	=> form_error('postAccount'),
				'errorPPayment' => form_error('postPPayment'),
				'errorPAdditional' => form_error('postPAdditional')
			);
		} else {
		  /** Upload Lib */
			$this->load->library('upload');

		  /** Post data */
			$totalCart = $this->Purchases_m->sumCartPrice()->result_array();
			$postData = array(
				'tp_note_code'	 => $this->input->post('postPNote'),
				'tp_note_file'	 => NULL,
				'tp_date'	  	 => $this->input->post('postPDate'),
				'tp_supplier_fk' => base64_decode(urldecode($this->input->post('postPSupplier'))),
				'tp_payment_status'	=> $this->input->post('postStatus'),
				'tp_tenor' 		 	=> ($this->input->post('postStatus') == 'K')? $this->input->post('postPTenor') : '',
				'tp_tenor_periode' 	=> ($this->input->post('postStatus') == 'K')? $this->input->post('postPTenorPeriode') : '',
				'tp_installment' 	=> ($this->input->post('postStatus') == 'K')? $this->input->post('postPInstallment') : '',
				'tp_due_date' 		=> ($this->input->post('postStatus') == 'K')? $this->input->post('postPDue') : '',
				'tp_payment_method' => $this->input->post('postMethod'),
				'tp_account_fk' 	=> ($this->input->post('postMethod') == 'TF')? base64_decode(urldecode($this->input->post('postAccount'))) : '',
				'tp_additional_cost' => $this->input->post('postPAdditional'),
				'tp_total_cost'	 => $totalCart[0]['tp_total_paid'] + floatval($this->input->post('postPAdditional')),
				'tp_paid' 		 => $this->input->post('postPPayment'),
				'tp_post_script' => htmlspecialchars($this->input->post('postPPS')),
				'created_at'	=> date('Y-m-d H:i:s'),
				'created_by'	=> base64_decode(urldecode($this->session->userdata('userID')))
			);
		
		  /** Prepare config tambahan */
			$config['upload_path']   = 'assets/uploaded_files/purchase_note/';
			$config['allowed_types'] = 'jpeg|jpg|png|pdf|doc|docx';
			$config['max_size']		 = '2048';
			$config['encrypt_name']  = TRUE;
			  
			$arrayFile = explode('.', $_FILES['postNoteFile']['name']);
			$extension = end($arrayFile);
			$this->upload->initialize($config);

		  /** Upload proses dan Simpan file ke database */
			$upload = $this->upload->do_upload('postNoteFile');
			if($upload){
				/** Uploaded file data */
				$uploadData = $this->upload->data();

				/** Set path ke postData */
				$postData['tp_note_file'] = $config['upload_path'].$uploadData['file_name'];

				$inputTP = $this->Purchases_m->insertPurchase($postData);
				if($inputTP['resultInsert'] > 0){
					/** Get data dari cart purchases */
					foreach ($this->Purchases_m->selectCart(base64_decode(urldecode($this->session->userdata('userID'))))->result_array() as $row) {
						$dataDetail[] = array(
							'dtp_tp_fk'		 	 => $inputTP['insertID'],
							'dtp_product_fk'	 => $row['tp_product_fk'],
							'dtp_product_amount' => $row['tp_product_amount'],
							'dtp_purchase_price' => $row['tp_purchase_price'],
							'dtp_total_price'	 => $row['tp_total_paid']
						);
					}

					$inputDetTP = $this->Purchases_m->insertBatchDetTP($dataDetail);
					if($inputDetTP > 0){
						$this->Purchases_m->truncateCart();
						$arrReturn = array(
							'success'	=> TRUE,
							'status'	=> 'successInsert',
							'statusIcon' => 'success',
							'statusMsg'	 => 'Berhasil menambahkan transaksi pembelian',
						);
					} else {
						$this->Purchases_m->deletePurchase($inputTP['insertID']);
						unlink($postData['tp_note_file']);
						$arrReturn = array(
							'success'	=> TRUE,
							'status'	=> 'failedInsert',
							'statusIcon' => 'warning',
							'statusMsg'	 => 'Gagal menambahkan detail transaksi pembelian',
						);
					}
				} else {
					unlink($postData['tp_note_file']);
					$arrReturn = array(
						'success'	=> TRUE,
						'status'	=> 'failedInsert',
						'statusIcon' => 'error',
						'statusMsg'	 => 'Gagal menambahkan transaksi pembelian',
					);
				}
			} else {
				$arrReturn = array(
					'success'	=> TRUE,
					'status'	=> 'failedInsert',
					'statusIcon' => 'error',
					'statusMsg'	 => 'Gagal menyimpan file nota pembelian, transaksi pembelian batal ditambahkan. Error : '.$this->upload->display_errors(),
				);
			}
		}

		header('Content-Type: application/json');
		echo json_encode($arrReturn);
	}

	/** Function : Page list trans pembelian */
	public function listPurchasesPage(){
	  /** Check allowed user */
		$this->auth_user(['uAll', 'uO', 'uP']);

		$this->pageData = array(
			'title' => 'PoS | Trans Pembelian',
			'assets' => array('datatables', 'list_transaction'),
			'transactionUrl' => site_url('Transaction_c/listPurchaseAjax')
		);
		$this->page = 'trans/purchases/list_purchases_v';
		$this->layout();
	}

	/** Function : Ajax list trans purchase */
	public function listPurchaseAjax(){
		$tpData	= array();
		$no			= $this->input->post('start');
		foreach($this->Purchases_m->selectPurchase('all', 0, $this->input->post('length'), $this->input->post('start'))->result_array() as $show){
			$actionBtn = '<a class="btn btn-xs btn-success" target="_blank" href="'.base_url().$show['tp_note_file'].'"><i class="fa fa-file-download"></i></a>
				<a class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title="Detail Transaksi Pembelian" href="'.site_url('Transaction_c/detailPurchasesPage/').urlencode(base64_encode($show['tp_id'])).'"> <i class="fas fa-search"></i> </a>
				<a class="btn btn-xs btn-secondary" data-toggle="tooltip" data-placement="top" title="Transaksi Retur Terkait" href="'.site_url('Transaction_c/addRSPage/').urlencode(base64_encode($show['tp_id'])).'"> <i class="fas fa-exchange-alt"></i> </a>';
			if($show['tp_payment_status'] == 'K'){ 
				$showStatus = '<span class="badge badge-danger">Kredit - Belum Lunas</span>';
				$actionBtn .= '&nbsp<a class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="Bayar Angsuran Pembelian" href="'.site_url('Transaction_c/installmentPurchasesPage/').urlencode(base64_encode($show['tp_id'])).'"> <i class="fas fa-cash-register"></i> </a>';
			} else if($show['tp_payment_status'] == 'T'){
				$showStatus = '<span class="badge badge-success">Tunai - Lunas</span>';
			} else if($show['tp_payment_status'] == 'L'){
				$showStatus = '<span class="badge badge-success">Kredit - Lunas</span>';
			}

			$no++;
			$row = array();
			$row[] = ($show['created_by'] == base64_decode(urldecode($this->session->userdata('userID'))))? '<i class="fas fa-user"></i>' : '';
			$row[] = date('Y-m-d', strtotime($show['tp_date']));
			$row[] = $show['tp_note_code'];
			$row[] = $show['supp_name'];
			$row[] = $show['tp_total_cost'];
			$row[] = $showStatus;
			$row[] = ($show['tp_payment_status'] == 'K')? $show['tp_due_date'] : '<i style="color:red" class="fas fa-minus"></i>';
			$row[] = $actionBtn;
		
			$tpData[] = $row;
		}

		$output = array(
			'draw'			  => $this->input->post('draw'),
			'recordsTotal'	  => $this->Purchases_m->count_all(),
			'recordsFiltered' => $this->Purchases_m->selectPurchase('all', 0, $this->input->post('length'), $this->input->post('start'))->num_rows(),
			'data'			  => $tpData
		);

		echo json_encode($output);
	}

	/** Function : Detail trans purchase */
	public function detailPurchasesPage($encoded_trans_id){
	  /** Check allowed user */
		$this->auth_user(['uAll', 'uO', 'uP']);

	  /** Get detail retur */
		$dataRS = $this->Return_m->selectRSByTPID(base64_decode(urldecode($encoded_trans_id)))->result_array();
		$detailRS = array();

		foreach($dataRS as $showRS){
			$detailRS[$showRS['rs_id']]['show_date']	= $showRS['rs_date'];
			$detailRS[$showRS['rs_id']]['show_status']	= ($showRS['rs_status'] == 'R')? '<span class="badge badge-success">Tukar Barang</span>' : '<span class="badge badge-info">Retur Uang</span>';
			$detailRS[$showRS['rs_id']]['show_cash_in'] = $showRS['rs_cash_in'];
			$detailRS[$showRS['rs_id']]['show_cash_out'] = $showRS['rs_cash_out'];
			$detailRS[$showRS['rs_id']]['show_ps'] 		 = $showRS['rs_post_script'];
			$detailRS[$showRS['rs_id']]['detail_rs'][] 	 = array(
				'retur_product' => '<small>'.$showRS['prd_name'].'</small>',
				'retur_qty'		=> $showRS['drs_return_qty']
			);
		}

		foreach($detailRS as $key => $value){
			$detailRS[$key]['count_prd'] = count($value['detail_rs']);
		}

		$this->pageData = array(
			'title' 	=> 'PoS | Trans Pembelian',
			'assets' 	=> array(),
			'detailTrans' => $this->Purchases_m->selectPurchaseOnID(base64_decode(urldecode($encoded_trans_id)))->result_array(),
			'detailCart'  => $this->Purchases_m->selectDetTP(base64_decode(urldecode($encoded_trans_id)))->result_array(),
			'detailIP' 	  => $this->Installment_m->selectIPonID(base64_decode(urldecode($encoded_trans_id)))->result_array(),
			'detailRetur' => $detailRS
		);
		$this->page = 'trans/purchases/detail_purchases_v';
		$this->layout();
	}

	/** Function : Page pembayaran angsuran trans purchase */
	public function installmentPurchasesPage($encoded_trans_id){
	  /** Check allowed user */
		$this->auth_user(['uAll', 'uO', 'uP']);

		$minTenor = ($this->Installment_m->selectLastPeriodeIP(base64_decode(urldecode($encoded_trans_id)))->num_rows() <= 0)? 1 : intval($this->Installment_m->selectLastPeriodeIP(base64_decode(urldecode($encoded_trans_id)))->result_array()[0]['ip_periode_end']) + 1;
		$detailData = $this->Purchases_m->selectPurchaseOnID(base64_decode(urldecode($encoded_trans_id)))->result_array();
		
		$this->pageData = array(
			'title'		  	=> 'PoS | Trans Pembelian',
			'assets'		=> array('datatables', 'custominput', 'sweetalert2', 'installment'),
			'detailTrans'	=> $detailData,
			'iListUrl'		=> site_url('Transaction_c/installmentPurchasesAjax/'.$encoded_trans_id),
			'minLimitI'		=> $minTenor,
			'maxLimitI'		=> $detailData[0]['tp_tenor']
		);
		$this->page = 'trans/purchases/installment_purchase_v';
		$this->layout();
	}

	/** Function : Ajax list installment */
	function installmentPurchasesAjax($encoded_trans_id){
		/** dataType */
		$returnData['i_type'] = 'purchases';

		if($this->Installment_m->selectIPonID(base64_decode(urldecode($encoded_trans_id)))->num_rows() <= 0 ){
			$returnData['count_rows'] = $this->Installment_m->selectIPonID(base64_decode(urldecode($encoded_trans_id)))->num_rows();
		} else {
			$returnData['count_rows'] = $this->Installment_m->selectIPonID(base64_decode(urldecode($encoded_trans_id)))->num_rows();
			$i = 0;
			foreach($this->Installment_m->selectIPonID(base64_decode(urldecode($encoded_trans_id)))->result_array() as $showIP){
				$returnData['i_data'][$i]['i_periode'] = ($showIP['ip_periode_end'] == $showIP['ip_periode_begin'])? $showIP['ip_periode_begin'] : $showIP['ip_periode_begin'].' - '.$showIP['ip_periode_end'];
				$returnData['i_data'][$i]['i_date'] 	 = date('d-m-Y', strtotime($showIP['ip_date']));
				$returnData['i_data'][$i]['i_payment'] = number_format($showIP['ip_payment'], 2);
				$returnData['i_data'][$i]['i_note'] = $showIP['ip_note_code'];
				$returnData['i_data'][$i]['i_file'] = '<a class="btn btn-xs btn-success" target="_blank" href="'.base_url().$showIP['ip_note_file'].'"><i class="fas fa-file-download"></i></a>';
				$returnData['i_data'][$i]['i_ps']	 = '<p>'.$showIP['ip_post_script'].'</p>';
				$i++;
			}
		}

		header('Content-Type: application/json');
		echo json_encode($returnData);
	}

	/** Function : Proses pay installment trans purchase */
	function installmentPurchasesProses($encoded_trans_id){
	  /** Load lib dan helper */
		$this->load->helper('file');
		$this->load->library('form_validation');
  
	  /** Set rules form validation */
		$configValidation = array(
			array(
			  'field'  => 'postIPDate',
			  'label'  => 'Tgl Pembayaran',
			  'rules'  => 'trim|required|callback__validation_date',
			  'errors'  => array(
				  'required'	=> 'Tanggal tidak boleh kosong',
				  '_validation_date' => 'Tanggal tidak valid'
			  )
			),
			array(
			  'field'  => 'postIPNote',
			  'label'  => 'No. Nota Pembayaran',
			  'rules'  => 'trim|required',
			  'errors'  => array(
				  'required'	=> 'Tanggal tidak boleh kosong'
			  )
			),
			array(
			  'field'  => 'postIPNoteFile',
			  'label'  => 'File nota',
			  'rules'  => 'callback__validation_installment_file'
			),
			array(
			  'field'  => 'postIPPeriodeStart',
			  'label'  => 'Periode',
			  'rules'  => 'trim|required|numeric',
			  'errors'  => array(
				  'required' => 'Periode tidak boleh kosong',
				  'numeric'  => 'Pilih option yang tersedia'
			  )
			),
			array(
			  'field'  => 'postIPPeriodeEnd',
			  'label'  => 'Periode',
			  'rules'  => 'trim|required|numeric',
			  'errors'  => array(
				  'required' => 'Periode tidak boleh kosong',
				  'numeric'  => 'Pilih option yang tersedia'
			  )
			),
			array(
			  'field'  => 'postIPInstallment',
			  'label'  => 'Angsuran',
			  'rules'  => 'trim|required|greater_than[0]|numeric',
			  'errors'  => array(
				  'required' => 'Angsuran tidak boleh kosong',
				  'greater_than' => 'Angsuran harus lebih dari 0',
				  'numeric'  => 'Angsuran tidak valid'
			  )
			),
			array(
			  'field'  => 'postIPStatus',
			  'label'  => 'Status Pembayaran',
			  'rules'  => 'trim|required|in_list[BL,L]',
			  'errors'  => array(
				  'required' => 'Status pembayaran tidak boleh kosong',
				  'in_list'  => 'Pilih opsi status yang tersedia'
			  )
			),
			array(
			  'field'  => 'postIPDue',
			  'label'  => 'Tempo',
			  'rules'  => 'trim|callback__validation_installment_due'
			),
		);
	  
		$this->form_validation->set_rules($configValidation);

	  /** Run Valudation */
		if($this->form_validation->run() == FALSE) {
			$arrReturn = array(
				'error'				  => TRUE,
				'errorIPDate' 		  => form_error('postIPDate'),
				'errorIPNote'		  => form_error('postIPNote'),
				'errorIPNoteFile'	  => form_error('postIPNoteFile'),
				'errorIPPeriodeStart' => form_error('postIPPeriodeStart'),
				'errorIPPeriodeEnd'	  => form_error('postIPPeriodeEnd'),
				'errorIPInstallment'  => form_error('postIPInstallment'),
				'errorIPStatus' 	  => form_error('postIPStatus'),
				'errorIPDue'	 	  => form_error('postIPDue')
			);
		} else {
		  /** Upload Lib */
			$this->load->library('upload');
		
		  /** Get post data */
			$postData = array(
				'ip_trans_id_fk' => base64_decode(urldecode($encoded_trans_id)),
				'ip_date' 		 => $this->input->post('postIPDate'),
				'ip_note_code' 	 => $this->input->post('postIPNote'),
				'ip_note_file' 	 => null,
				'ip_periode_begin' => $this->input->post('postIPPeriodeStart'),
				'ip_periode_end' => $this->input->post('postIPPeriodeEnd'),
				'ip_payment' 	 => $this->input->post('postIPInstallment'),
				'ip_post_script' => $this->input->post('postIPPS')
			);

		  /** Prepare config tambahan */
			$config['upload_path']   = 'assets/uploaded_files/purchase_note/p_installment/';
			$config['allowed_types'] = 'jpeg|jpg|png|pdf|doc|docx';
			$config['max_size']		 = '2048';
			$config['encrypt_name']  = TRUE;
			  
			$arrayFile = explode('.', $_FILES['postIPNoteFile']['name']);
			$extension = end($arrayFile);
			$this->upload->initialize($config);

		  /** Upload proses dan Simpan file ke database */
			$upload = $this->upload->do_upload('postIPNoteFile');

			if($upload){
				/** Uploaded file data */
				$uploadData = $this->upload->data();

				/** Set path ke postData */
				$postData['ip_note_file'] = $config['upload_path'].$uploadData['file_name'];

				$inputIP = $this->Installment_m->insertIP($postData);
				if($inputIP > 0){
					/** get last tenor */
					$lastTenor = $this->Installment_m->selectLastPeriodeIP(base64_decode(urldecode($encoded_trans_id)))->result_array();

					/** Data untuk update table tb_purchases */
					if($this->input->post('postIPStatus') == 'L' && $this->input->post('postIPPeriodeEnd') == $lastTenor[0]['tp_tenor']){
						$updateData = array(
							'tp_due_date' => date('Y-m-d', strtotime('0000-00-00')),
							'tp_payment_status'	  => 'L'
						);	
					} else if($this->input->post('postIPStatus') == 'BL'){
						$updateData = array(
							'tp_due_date' => $this->input->post('postIPDue')
						);
					}
	            	$updateTP = $this->Purchases_m->updatePurchaseOnID($updateData, base64_decode(urldecode($encoded_trans_id)));
					$limitIP = $this->Installment_m->selectLastPeriodeIP(base64_decode(urldecode($encoded_trans_id)))->result_array();
					$detailTrans = $this->Purchases_m->selectPurchaseOnID(base64_decode(urldecode($encoded_trans_id)))->result_array();

					if($updateTP > 0){
						$arrReturn = array(
							'success'	=> TRUE,
							'status'	=> 'successInsert',
							'statusIcon' => 'success',
							'statusMsg'	 => 'Berhasil menambahkan data pembayaran angsuran',
						);
					} else {
						$arrReturn = array(
							'success'	=> TRUE,
							'status'	=> 'failedInsert',
							'statusIcon' => 'warning',
							'statusMsg'	 => 'Data pembayaran angsuran ditambahkan, gagal memperbarui jatuh tempo',
						);
					}
					$arrReturn['min_tenor'] = intval($limitIP[0]['ip_periode_end']) + 1;
					$arrReturn['max_tenor'] = intval($detailTrans[0]['tp_tenor']);
				} else {
					unlink($postData['ip_note_file']);
					$arrReturn = array(
						'success'	=> TRUE,
						'status'	=> 'failedInsert',
						'statusIcon' => 'error',
						'statusMsg'	 => 'Gagal menambahkan data pembayaran angsuran',
					);
				}
			} else {
				$arrReturn = array(
					'success'	=> TRUE,
					'status'	=> 'failedInsert',
					'statusIcon' => 'error',
					'statusMsg'	 => 'Gagal menyimpan file nota pembayaran, transaksi pembayaran angsuran batal ditambahkan. Error : '.$this->upload->display_errors(),
				);
			}
		}

		header('Content-Type: application/json');
		echo json_encode($arrReturn);
	}

  /** CRUD Sales */
	/** Function : Page add trans sales */
	public function addSalesPage(){
		$this->auth_user(['uAll', 'uO', 'uK']);

		/** Load model customer untuk option customer */
		$this->load->model('Customer_m');
			
		$this->pageData = array(
			'title'	  => 'PoS | Trans Penjualan',
			'assets'  => array('jqueryui', 'toastr', 'sweetalert2', 'add_transaction', 'add_sales'),
			'cartUrl' => site_url('Transaction_c/listCartAjax/Sales/'),
			'optAcc'	=> $this->Account_m->selectAccount(),
			'optCtm'	=> $this->Customer_m->selectCustomer(0, 0, 0)->result_array()
		);
		$this->page = 'trans/sales/add_sales_v';
		$this->layout();
	}

	/** Function : Proses add trans sales */
	public function addSalesProses(){
	  /** Load lib dan helper */
		$this->load->library('form_validation');
  
	  /** Set rules form validation */
		$configValidation = array(
			array(
				'field'  => 'postSTotalSale',
				'label'  => '',
				'rules'  => 'trim|required|numeric',
				'errors' => array(
					'required'	=> 'Total belanja tidak boleh kosong',
					'numeric'	=> 'Total belanja tidak valid, harus berformat angka'
				)
			),
			array(
				'field'  => 'postSCtm',
				'label'  => '',
				'rules'  => 'trim|required|callback__validation_ctm',
				'errors'  => array(
					'required'	=> 'Pelanggan tidak boleh kosong'
				)
			),
			array(
				'field'  => 'postSDate',
				'label'  => 'Tgl Transaksi',
				'rules'  => 'trim|required|callback__validation_date',
				'errors'  => array(
					'required'	=> 'Tanggal tidak boleh kosong',
					'_validation_date' => 'Tanggal tidak valid'
				)
			),
			array(
				'field'  => 'postStatus',
				'label'  => 'Status Pembayaran',
				'rules'  => 'trim|required|in_list[T,K]',
				'errors'  => array(
					'required' => 'Status pembayaran tidak boleh kosong',
					'in_list'  => 'Pilih opsi status yang tersedia'
				)
			),
			array(
				'field'  => 'postSDue',
				'label'  => 'Tempo',
				'rules'  => 'trim|callback__validation_due|callback__validation_credit',
				'errors'  => array(
					'_validation_credit' => 'Tempo tidak boleh kosong',
				)
			),
			array(
				'field'  => 'postSTenor',
				'label'  => 'Tenor',
				'rules'  => 'trim|numeric|greater_than[0]|callback__validation_credit',
				'errors'  => array(
					'numeric'  => 'Tenor tidak valid, harus bernilai angka',
					'in_list'  => 'Pilih opsi status yang tersedia',
					'greater_than' => 'Tenor harus lebih dari 0',
					'_validation_credit' => 'Tenor tidak boleh kosong'
				)
			),
			array(
				'field'  => 'postSTenorPeriode',
				'label'  => 'Periode Tenor',
				'rules'  => 'trim|in_list[D,W,M,Y]|callback__validation_credit',
				'errors'  => array(
					'in_list'  => 'Pilih opsi status yang tersedia',
					'_validation_credit' => 'Tenor tidak boleh kosong'
				)
			),
			array(
				'field'  => 'postSInstallment',
				'label'  => 'Angsuran',
				'rules'  => 'trim|greater_than[0]|numeric|callback__validation_credit',
				'errors'  => array(
					'numeric'  => 'Angsuran tidak valid',
					'greater_than' => 'Angsuran harus lebih dari 0',
					'_validation_credit' => 'Angsuran tidak boleh kosong',
				)
			),
			array(
				'field'  => 'postSDelivery',
				'label'  => 'Pengiriman',
				'rules'  => 'trim|required|in_list[N,E,T]',
				'errors'  => array(
					'required' => 'Pengiriman tidak boleh kosong',
					'in_list'  => 'Pilih opsi status yang tersedia'
				)
			),
			array(
				'field'  => 'postSPostalFee',
				'label'  => 'Ongkir',
				'rules'  => 'trim|greater_than[0]|numeric|callback__validation_postal_fee',
				'errors'  => array(
					'numeric' => 'Ongkir tidak valid, harus berformat angka',
					'greater_than'	=> 'Ongkir harus lebih dari 0',
				)
			),
			array(
				'field'  => 'postSPayment',
				'label'  => 'Pembayaran',
				'rules'  => 'trim|required|numeric',
				'errors' => array(
					'required'	=> 'Pembayaran tidak boleh kosong',
					'numeric'	=> 'Pembayaran tidak valid, harus berformat angka'
				)
			),
			array(
				'field'  => 'postMethod',
				'label'  => 'Metode pembayaran',
				'rules'  => 'trim|required|in_list[TF,TN]',
				'errors'  => array(
					'required' => 'Metode tidak boleh kosong',
					'in_list' => 'Pilih opsi metode yang tersedia'
				)
			),
			array(
				'field'  => 'postAccount',
				'label'  => 'Metode pembayaran',
				'rules'  => 'trim|callback__validation_account'
			),
		);
		
		$this->form_validation->set_rules($configValidation);

	  /** Run Valudation */
		if($this->form_validation->run() == FALSE) {
			$arrReturn = array(
				'error'		=> TRUE,
				'errorSTotalSale' => form_error('postSTotalSale'),
				'errorSCtm' 	  => form_error('postSCtm'),
				'errorSDate' 	  => form_error('postSDate'),
				'errorStatus' 	  => form_error('postStatus'),
				'errorSTenor' 	  => form_error('postSTenor'),
				'errorSDue' 	  => form_error('postSDue'),
				'errorSTenorPeriode' => form_error('postSTenorPeriode'),
				'errorSInstallment'  => form_error('postSInstallment'),
				'errorSDelivery'  => form_error('postSDelivery'),
				'errorSPostalFee' => form_error('postSPostalFee'),
				'errorSPayment'   => form_error('postSPayment'),
				'errorSMethod'	  => form_error('postMethod'),
				'errorSAccount'   => form_error('postAccount'),
			);
		} else {
		  /** Load model customer_m */
			$this->load->model('Customer_m');

		  /** Inputan customer */
			if($this->input->post('postSCtm') == 'nctm'){ 
				/** get posted data customer baru */
				$ctmPost = array(
					'ctm_name'  => htmlspecialchars($this->input->post('postCtmName')),
					'ctm_phone'  => $this->input->post('postCtmPhone'),
					'ctm_email' => htmlspecialchars($this->input->post('postCtmEmail')),
					'ctm_address' => htmlspecialchars($this->input->post('postCtmAddress')),
					'ctm_status' => 'Y'
				);
				$ctmID = $this->Customer_m->insertCustomer($ctmPost, 'id');
			} else if ($this->input->post('postSCtm') == '0000'){
				$ctmID = $this->input->post('postSCtm');
			} else {
				$ctmID = base64_decode(urldecode($this->input->post('postSCtm')));
			}
  
		  /** Set nomor transaksi selanjutnya */
			if($this->Sales_m->getNextIncrement()->num_rows() > 0){
				$nextAI = $this->Sales_m->getNextIncrement()->result_array(); // Get next auto increment table transaksi penjualan
				$nol = '';
				for($n = 5; $n >= strlen($nextAI['0']['AUTO_INCREMENT']); $n--){
					$nol .= '0';
				}
				$nextCode = 'TK'.base64_decode(urldecode($this->session->userdata('userID'))).date('Ymd').$nol.$nextAI['0']['AUTO_INCREMENT'];
			} else {
				$nextCode = 'TK'.base64_decode(urldecode($this->session->userdata('userID'))).date('Ymd').'00001';
			}

		  /** Insert proses */
		  	$postData = array(
				'ts_trans_code'	 => $nextCode,
				'ts_total_sales' => $this->input->post('postSTotalSale'),
				'ts_customer_fk' => $ctmID,
				'ts_date'		 => $this->input->post('postSDate'),
				'ts_payment_status' => $this->input->post('postStatus'),
				'ts_due_date'	    => ( $this->input->post('postStatus') == 'K' )? $this->input->post('postSDue') : NULL,
				'ts_tenor'		    => ( $this->input->post('postStatus') == 'K' )? $this->input->post('postSTenor') : NULL,
				'ts_tenor_periode'  => ( $this->input->post('postStatus') == 'K' )? $this->input->post('postSTenorPeriode') : NULL,
				'ts_installment'    => ( $this->input->post('postStatus') == 'K' )? $this->input->post('postSInstallment') : NULL,
				'ts_delivery_method' => $this->input->post('postSDelivery'),
				'ts_delivery_fee'	=> ( $this->input->post('postSDelivery') == 'E' || $this->input->post('postSDelivery') == 'T' )? $this->input->post('postSPostalFee') : NULL,
				'ts_payment'		=> $this->input->post('postSPayment'),
				'ts_payment_method' => $this->input->post('postMethod'),
				'ts_account_fk'  	=> ( $this->input->post('postMethod') == 'TF' )? $this->input->post('postAccount') : NULL,
				'ts_return'			=> 'N',
				'created_at'		=> date('Y-m-d H:i:s'),
				'created_by'		=> base64_decode(urldecode($this->session->userdata('userID')))
			);
			$inputTS = $this->Sales_m->insertSale($postData);

			/** Insert trans installment && detail cart */
			if($inputTS['resultInsert'] > 0){
				/** Insert Detail Cart */
				foreach ($this->Sales_m->selectCart(base64_decode(urldecode($this->session->userdata('userID'))))->result_array() as $row) {
					$dataDetail[] = array(
						'dts_ts_id_fk'		 => $inputTS['insertID'],
						'dts_product_fk'	 => $row['temps_product_fk'],
						'dts_product_amount' => $row['temps_product_amount'],
						'dts_sale_price' 	 => $row['temps_sale_price'],
						'dts_discount'	 	 => $row['temps_discount'],
						'dts_total_price'	 => $row['temps_total_paid']
					); 
				}
				$inputDetTS = $this->Sales_m->insertBatchDetTS($dataDetail);

				/** Insert Installment */
				if($this->input->post('postStatus') == 'K'){
					/** Get 1st installment due date */
					$stDueDate	= date('Y-m-d', strtotime($this->input->post('postSDate')));
					$stYear 	= date('Y', strtotime($this->input->post('postSDate')));
					$stMonth	= date('m', strtotime($this->input->post('postSDate')));
					$stDate		= date('d', strtotime($this->input->post('postSDate')));

					/** Check tenor_periode. D = Daily/Harian, W = Weekly/Mingguan, M = Monthly/Bulanan, Y = Annual/Tahunan */
					if($postData['ts_tenor_periode'] == 'D'){
						for($prd = 1; $prd <= $postData['ts_tenor']; $prd++){
						$installmentData[$prd]['is_trans_id_fk'] = $inputTS['insertID'];
						$installmentData[$prd]['is_periode']	 = $prd;

							if($prd > 1){
								$lastIndex = $prd-1;
								$installmentData[$prd]['is_due_date'] = date('Y-m-d', strtotime('+1 days', strtotime($installmentData[$lastIndex]['is_due_date'])));
							} else {
								$installmentData[$prd]['is_due_date'] = $stDueDate;
							}
						}

					} else if($postData['ts_tenor_periode'] == 'W'){
						for($prd = 1; $prd <= $postData['ts_tenor']; $prd++){
						$installmentData[$prd]['is_trans_id_fk'] = $inputTS['insertID'];
						$installmentData[$prd]['is_periode']	 = $prd;

							if($prd > 1){
								$lastIndex = $prd-1;
								$installmentData[$prd]['is_due_date'] = date('Y-m-d', strtotime('+1 weeks', strtotime($installmentData[$lastIndex]['is_due_date'])));	  					
							} else {
								$installmentData[$prd]['is_due_date'] = $stDueDate;
							}
						}

					} else if($postData['ts_tenor_periode'] == 'M'){
						for($prd = 1; $prd <= $postData['ts_tenor']; $prd++){
							$installmentData[$prd]['is_trans_id_fk'] = $inputTS['insertID'];
							$installmentData[$prd]['is_periode']	 = $prd;
							
							if($prd > 1){
								$lastIndex = $prd-1;

								/* Var ini berisi duw date saat ini */
								$newDueDate = date('Y-m-d', strtotime('+1 month', strtotime($installmentData[$lastIndex]['is_due_date'])));

								/* Get data di index sebelumnya */
								$monthBefore = date('m', strtotime($installmentData[$lastIndex]['is_due_date']));
								$dateBefore = date('d', strtotime($installmentData[$lastIndex]['is_due_date']));

								if($monthBefore == 1){
									if($stDate == 29 || $stDate == 30 || $stDate == 31){
										/* Check data untuk menentukan due date khusus bulan february */
										$newYear	= date('Y', strtotime($newDueDate));
										$installmentData[$prd]['is_due_date']	= date('Y-m-t', strtotime($newYear.'-02-01'));	
									} else {
										$installmentData[$prd]['is_due_date'] = $newDueDate;
									}
								} else if ($dateBefore == 31){ 
									/* Check data untuk menentukan due date khusus bulan dengan tanggal sampai 30 */
									$newYear	= date('Y', strtotime($newDueDate));
									$newMonth	= ($monthBefore < 12)? $monthBefore+1 : 1;
									$installmentData[$prd]['is_due_date']	= date('Y-m-t', strtotime($newYear.'-'.$newMonth.'-01'));
								} else {
									$installmentData[$prd]['is_due_date'] = $newDueDate;
								}
							} else {
								$installmentData[$prd]['is_due_date'] = $stDueDate;
							}

						}

					} else if($postData['ts_tenor_periode'] == 'Y'){
						for($prd = 1; $prd <= $postData['ts_tenor']; $prd++){
						$installmentData[$prd]['is_trans_id_fk'] = $inputTS['insertID'];
						$installmentData[$prd]['is_periode']	 = $prd;

							if($prd > 1){
								$lastIndex = $prd-1;
								$installmentData[$prd]['is_due_date'] = date('Y-m-d', strtotime('+1 years', strtotime($installmentData[$lastIndex]['is_due_date'])));	  					
							} else {
								$installmentData[$prd]['is_due_date'] = $stDueDate;
							}
						}	  			
					}
					
					$inputIS = $this->Installment_m->insertIS($installmentData);
				}

				/** Set return value */
				if($inputDetTS > 0){
					if(!empty($inputIS) && $inputTS < 0){
						/** Batalkan data penjualan yang disimpan (Hapus) */
						$this->Sales_m->deleteSale($inputTS['insertID']);
						$this->Sales_m->deleteDetTS($inputTS['insertID']);

						$arrReturn = array(
							'success'	=> TRUE,
							'status'	=> 'failedInsert',
							'statusIcon' => 'error',
							'statusMsg'	 => 'Gagal menambahkan data angsuran transaksi penjualan !'
						);
					} else {
						$this->Sales_m->truncateCart();
						$arrReturn = array(
							'success'	=> TRUE,
							'status'	=> 'successInsert',
							'statusIcon' => 'success',
							'statusMsg'	 => 'Berhasil menambahkan data transaksi penjualan !'
						);
					}
				} else {
					/** Batalkan data penjualan yang disimpan (Hapus) */
					$this->Sales_m->deleteSale($inputTS['insertID']);
					$arrReturn = array(
						'success'	=> TRUE,
						'status'	=> 'failedInsert',
						'statusIcon' => 'error',
						'statusMsg'	 => 'Gagal menambahkan keranjang data transaksi penjualan !'
					);
				}
			} else {
				/* Hapus pelanggan yang ditambahkan */
				if($this->input->post('postSCtm') == 'nctm'){
					$this->Customer_m->deleteCustomer($ctmID);
				}

				$arrReturn = array(
					'success'	=> TRUE,
					'status'	=> 'failedInsert',
					'statusIcon' => 'error',
					'statusMsg'	 => 'Gagal menambahkan data transaksi penjualan !'
				);
			}
		}

		header('Content-Type: application/json');
		echo json_encode($arrReturn);
	}

	/** Function : Page list trans penjualan */
	public function listSalesPage(){
		$this->auth_user(['uAll', 'uO', 'uK']);
		$this->pageData = array(
			'title' => 'PoS | Trans Penjualan',
			'assets' => array('datatables', 'list_transaction'),
			'transactionUrl' => site_url('Transaction_c/listSalesAjax')
		);
		$this->page = 'trans/sales/list_sales_v';
		$this->layout();
	}

	/** Function : Ajax list trans Sales */
	public function listSalesAjax(){
		$tsData	= array();
		$no			= $this->input->post('start');
		foreach($this->Sales_m->selectSales($this->input->post('length'), $this->input->post('start'), 0, 0)->result_array() as $show){
			$actionBtn = '<a class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title="Detail Transaksi Penjualan" href="'.site_url('Transaction_c/detailSalesPage/').urlencode(base64_encode($show['ts_id'])).'"> <i class="fas fa-search"></i> </a>';
			
			if($show['ts_payment_status'] == 'K'){ 
				$showStatus = '<span class="badge badge-danger">Kredit - Belum Lunas</span>';

				if( in_array($this->session->userdata('logedInLevel'), ['uAll', 'uK']) == TRUE ){
					$actionBtn .= '&nbsp<a class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="Bayar Angsuran Penjualan" href="'.site_url('Transaction_c/installmentSalesPage/').urlencode(base64_encode($show['ts_id'])).'"> <i class="fas fa-cash-register"></i> </a>';
				}
			} else if($show['ts_payment_status'] == 'T'){
				$showStatus = '<span class="badge badge-success">Tunai - Lunas</span>';
			} else if($show['ts_payment_status'] == 'L'){
				$showStatus = '<span class="badge badge-success">Kredit - Lunas</span>';
			}

			if($show['ts_return'] != 'Y'){
				if( in_array($this->session->userdata('logedInLevel'), ['uAll', 'uK']) == TRUE){
					$actionBtn .= '&nbsp<a class="btn btn-xs btn-secondary" data-toggle="tooltip" data-placement="top" title="Transaksi Retur Terkait" href="'.site_url('Transaction_c/addRCPage/').urlencode(base64_encode($show['ts_id'])).'"> <i class="fas fa-exchange-alt"></i> </a>';
				}
				$returnStatus = "<span class=\"badge badge-secondary\">Belum Retur</span>";
			} else {
				$returnStatus = "<span class=\"badge badge-warning\">Sudah Retur</span>";
			}

			$no++;
			$row = array();
			$row[] = ($show['created_by'] == base64_decode(urldecode($this->session->userdata('userID'))))? '<i class="fas fa-user"></i>' : '';
			$row[] = date('Y-m-d', strtotime($show['ts_date']));
			$row[] = $show['ts_trans_code'];
			$row[] = ($show['ts_customer_fk'] == 0)? 'Pelanggan Umum' : $show['ctm_name'];
			$row[] = $show['ts_total_sales'];
			$row[] = $showStatus;
			$row[] = $returnStatus;
			$row[] = ($show['ts_payment_status'] == 'K')? $show['ts_due_date'] : '<i style="color:red" class="fas fa-minus"></i>';
			
			$row[] = $actionBtn;
		
			$tsData[] = $row;
		}

		$output = array(
			'draw'			  => $this->input->post('draw'),
			'recordsTotal'	  => $this->Sales_m->count_all(),
			'recordsFiltered' => $this->Sales_m->selectSales('all', 0, $this->input->post('length'), $this->input->post('start'))->num_rows(),
			'data'			  => $tsData
		);

		echo json_encode($output);
	}

	/** Function : Detail trans Sales */
	public function detailSalesPage($encoded_trans_id){
		$this->auth_user(['uAll', 'uO', 'uK']);

	  /** Get detail retur */
		$dataRC = $this->Return_m->selectRCByTSID(base64_decode(urldecode($encoded_trans_id)))->result_array();
		$detailRC = array();

		foreach($dataRC as $showRC){
			$detailRC[$showRC['rc_id']]['show_code']	= $showRC['rc_code'];
			$detailRC[$showRC['rc_id']]['show_date']	= date('Y-m-d', strtotime($showRC['rc_date']));
			$detailRC[$showRC['rc_id']]['show_status']	= ($showRC['rc_status'] == 'R')? '<span class="badge badge-success">Tukar Barang</span>' : '<span class="badge badge-info">Pengembalian Dana</span>';
			$detailRC[$showRC['rc_id']]['show_cash']	= ($showRC['rc_status'] == 'U')? number_format($showRC['rc_cash'], 2) : 0;
			$detailRC[$showRC['rc_id']]['show_ps'] 		 = $showRC['rc_post_script'];
			$detailRC[$showRC['rc_id']]['detail_rc'][] 	 = array(
				'retur_product' => '<small>'.$showRC['prd_name'].'</small>',
				'retur_qty'		=> $showRC['drc_return_qty']
			);
		}

		foreach($detailRC as $key => $value){
			$detailRC[$key]['count_prd'] = count($value['detail_rc']);
		}

		$this->pageData = array(
			'title' 	=> 'PoS | Trans Penjualan',
			'assets' 	=> array(),
			'id'		=> base64_decode(urldecode($encoded_trans_id)),
			'detailTrans' => $this->Sales_m->selectSalesOnID(base64_decode(urldecode($encoded_trans_id)))->result_array(),
			'detailCart'  => $this->Sales_m->selectDetTS(base64_decode(urldecode($encoded_trans_id)))->result_array(),
			'detailIS' 	  => $this->Installment_m->selectISOnID(base64_decode(urldecode($encoded_trans_id)))->result_array(),
			'detailRS'	  => $detailRC
		);
		$this->page = 'trans/sales/detail_sales_v';
		$this->layout();
	}

	/** Function : Page pembayaran angsuran trans sales */
	public function installmentSalesPage($encoded_trans_id){
		$this->auth_user(['uAll', 'uO', 'uK']);

		/** Detail Trans */
		$detailData = $this->Sales_m->selectSalesOnID(base64_decode(urldecode($encoded_trans_id)))->result_array();
		
		$this->pageData = array(
			'title'			=> 'PoS | Trans Penjualan',
			'assets'		=> array('sweetalert2', 'installment'),
			'detailTrans'	=> $detailData,
			'iListUrl'		=> site_url('Transaction_c/installmentSalesAjax/'.$encoded_trans_id),
			'minLimitI'		=> $this->Installment_m->selectLastPeriodeIS(base64_decode(urldecode($encoded_trans_id)))->result_array()[0]['is_periode'],
			'maxLimitI'		=> $detailData[0]['ts_tenor']
		);
		$this->page = 'trans/sales/installment_sales_v';
		$this->layout();
	}

	/** Function : Ajax list installment */
	function installmentSalesAjax($encoded_trans_id){
		/** dataType */
		$returnData['i_type'] = 'sales';

		if($this->Installment_m->selectISOnID(base64_decode(urldecode($encoded_trans_id)))->num_rows() <= 0 ){
			$returnData['count_rows'] = $this->Installment_m->selectISOnID(base64_decode(urldecode($encoded_trans_id)))->num_rows();
		} else {
			$returnData['count_rows'] = $this->Installment_m->selectISOnID(base64_decode(urldecode($encoded_trans_id)))->num_rows();
			$i = 0;
			foreach($this->Installment_m->selectISOnID(base64_decode(urldecode($encoded_trans_id)))->result_array() as $showIS){
				$returnData['i_data'][$i]['i_periode']		 = $showIS['is_periode'];
				$returnData['i_data'][$i]['i_due_date'] 	 = '<font class="font-weight-bold">'.date('d/m/y', strtotime($showIS['is_due_date']))."</font>";
				$returnData['i_data'][$i]['i_code']			 = ($showIS['is_code'] != '')? '<font color="green">'.$showIS['is_code'].'</font>' : '-';
				$returnData['i_data'][$i]['i_payment'] 	 	 = ($showIS['is_payment'] != '')? '<font color="green">'.number_format($showIS['is_payment'], 2).'</font>' : '-';
				$returnData['i_data'][$i]['i_payment_date']  = ($showIS['is_payment_date'] != '')? '<font color="green">'.date('d/m/y',strtotime($showIS['is_payment_date'])).'</font>' : '-';
				$returnData['i_data'][$i]['i_ps']	 		 = ($showIS['is_post_script'] != '')? '<small>'.$showIS['is_post_script'].'</small>' : '';
				$i++;
			}
		}

		header('Content-Type: application/json');
		echo json_encode($returnData);
	}

	/** Function : Input proses installment sales */
	function installmentSalesProses($encoded_trans_id){
	  /** Load lib & helper */
		$this->load->library('form_validation');
	
	  /** Set rules form validation */
		$configValidation = array(
			array(
				'field'  => 'postISDate',
				'label'  => 'Tgl Pembayaran',
				'rules'  => 'trim|required|callback__validation_date',
				'errors'  => array(
					'required'	=> 'Tanggal tidak boleh kosong',
					'_validation_date' => 'Tanggal tidak valid'
				)
			),
			array(
				'field'  => 'postISPeriodeStart',
				'label'  => 'Periode',
				'rules'  => 'trim|required|numeric',
				'errors'  => array(
					'required' => 'Periode tidak boleh kosong',
					'numeric'  => 'Pilih option yang tersedia'
				)
			),
			array(
				'field'  => 'postISPeriodeEnd',
				'label'  => 'Periode',
				'rules'  => 'trim|required|numeric',
				'errors'  => array(
					'required' => 'Periode tidak boleh kosong',
					'numeric'  => 'Pilih option yang tersedia'
				)
			),
			array(
				'field'  => 'postISInstallment',
				'label'  => 'Angsuran',
				'rules'  => 'trim|required|greater_than[0]|numeric',
				'errors'  => array(
					'required' => 'Angsuran tidak boleh kosong',
					'greater_than' => 'Angsuran harus lebih dari 0',
					'numeric'  => 'Angsuran tidak valid'
				)
			),
			array(
				'field'  => 'postISPS',
				'label'  => 'Catatan tambahan',
				'rules'  => 'trim'
			)
		);
		
		$this->form_validation->set_rules($configValidation);
  
	  /** Run validation */
		if($this->form_validation->run() == FALSE){
			$arrReturn = array(
				'error'				  => TRUE,
				'errorISDate' 		  => form_error('postISDate'),
				'errorISPeriodeStart' => form_error('postISPeriodeStart'),
				'errorISPeriodeEnd'   => form_error('postISPeriodeEnd'),
				'errorISInstallment'  => form_error('postISInstallment'),
				'errorISPS' 		  => form_error('postISPS')
			);
		} else {
		  /** Set next payment code */
			if( $this->Installment_m->selectLastISCode(base64_decode(urldecode($encoded_trans_id)))->num_rows() > 0 ){
				$lastCode = $this->Installment_m->selectLastISCode(base64_decode(urldecode($encoded_trans_id)))->result_array();
			  
				$nol = '';
				$current = substr($lastCode[0]['is_code'], -5);
				for($n = 5; $n > strlen( intval($current) ); $n--){
					$nol .= '0';
				}
				$next = intval($current) + 1;
				$nextISCode = 'IS'.date('Ymd').$nol.$next;
			} else {
				$nextISCode = 'IS'.date('Ymd').'00001';
			}
  
		  /** Insert proses */
			$updateStatus = 0; // status update pembayaran installment;
  
			for($i = $this->input->post('postISPeriodeStart'); $i <= $this->input->post('postISPeriodeEnd'); $i++){
				/** Get post data */
				$postData = array(
					'is_code' 		  => $nextISCode,
					'is_payment_date' => $this->input->post('postISDate'),
					'is_payment'  	  => $this->input->post('postISInstallment'),
					'is_post_script'  => $this->input->post('postISPS'),
					'is_status'		  => 1
				);
  
				/** Update proses */
				$updateIS = $this->Installment_m->updatePaymentIS($postData, base64_decode(urldecode($encoded_trans_id)), $i);
				if($updateIS > 0){
					$updateStatus = $i;
				}
			}
  
			if($updateStatus == $this->input->post('postISPeriodeEnd')){
				$arrReturn = array(
					'success'	=> TRUE,
					'status'	=> 'successInsert',
					'statusIcon' => 'success',
					'statusMsg'	 => 'Pembayaran angsuran berhasil disimpan !'
				);
			} else {
				/** Reset value */
				for($i = $this->input->post('postISPeriodeStart'); $i <= $this->input->post('postISPeriodeEnd'); $i++){
					$postData = array(
						'is_code' 		  => NULL,
						'is_payment_date' => NULL,
						'is_payment'  	  => NULL,
						'is_post_script'  => NULL,
						'is_status'		  => 0
					);
	  
					/** Update proses */
					$updateIS = $this->Installment_m->updatePaymentIS($postData, base64_decode(urldecode($encoded_trans_id)), $i);
				}

				$arrReturn = array(
					'success'	=> TRUE,
					'status'	=> 'failedInsert',
					'statusIcon' => 'error',
					'statusMsg'	 => 'Gagal menambahkan data pembayaran angsuran transaksi penjualan !'
				);
			}
  
			$detailData = $this->Sales_m->selectSalesOnID(base64_decode(urldecode($encoded_trans_id)))->result_array();
			$arrReturn['min_tenor'] = $this->Installment_m->selectLastPeriodeIS(base64_decode(urldecode($encoded_trans_id)))->result_array()[0]['is_periode'];
			$arrReturn['max_tenor'] = $detailData[0]['ts_tenor'];
		}
  
		header('Content-Type: application/json');
		echo json_encode($arrReturn);
	}

  /** CRUD Pengeluaran / Expenses */
  	/** Function : Page list expenses */
  	public function listExpensesPage(){
		$this->auth_user(['uAll', 'uO', 'uK', 'uP']);
		$this->pageData = array(
			'title'   => 'PoS | Trans Pengeluaran',
			'assets'  => array('datatables', 'jqueryui', 'custominput', 'sweetalert2', 'list_transaction', 'add_revenues_expenses'),
			'transactionUrl' => site_url('Transaction_c/listExpensesAjax'),
			'optAcc'  => $this->Account_m->selectAccount()
		);
		$this->page = 'trans/other/expense_v';
		$this->layout();
	}

	/** Function : Ajax list expense */
	public function listExpensesAjax(){
  	  /** Load model */
		$teData = array();
		$no = $this->input->post('start');
		foreach($this->Expenses_m->selectExpenses($this->input->post('length'), $this->input->post('start'))->result_array() as $show){
			$no++;
			$row = array();
			$row[] = date('Y-m-d', strtotime($show['te_date']));
			$row[] = $show['te_note_code'];
			$row[] = $show['te_necessity'];
			$row[] = ($show['te_payment_method'] == 'TN')? 'Cash / Uang Tunai' : 'Transfer';
			$row[] = $show['te_payment'];
			$row[] = '<a class="btn btn-xs btn-success" target="_blank" href="'.base_url().$show['te_note_file'].'"><i class="fa fa-file-download"></i></a>
					<a class="btn btn-xs btn-info" onclick="detailER(\''.urlencode(base64_encode($show['te_id'])).'\', \''.site_url('Transaction_c/detailExpenses/').'\')"><i class="fa fa-search"></i></a>';
		
			$teData[] = $row;
		}

		$output = array(
			'draw'			  => $this->input->post('draw'),
			'recordsTotal'	  => $this->Expenses_m->countAllExpenses(),
			'recordsFiltered' => $this->Expenses_m->selectExpenses($this->input->post('length'), $this->input->post('start'))->num_rows(),
			'data'			  => $teData
		);

		echo json_encode($output);
	}

	/** Function : Detail expense */
	public function detailExpenses(){
		$detailData = $this->Expenses_m->selectExpensesOnID(base64_decode(urldecode($this->input->get('transID'))))->result_array();
		$returnData = array(
			'type'			=> 'expenses',
			'det_note'		=> $detailData[0]['te_note_code'],
			'det_necessity' => $detailData[0]['te_necessity'],
			'det_date'		=> $detailData[0]['te_date'],
			'det_method'	=> ($detailData[0]['te_payment_method'] == 'TN')? 'Tunai / Cash' : 'Transfer',
			'det_expense'	=> $detailData[0]['te_payment'],
			'det_account'	=> $detailData[0]['bank_name'].' - '.$detailData[0]['acc_number'].' a/n '.$detailData[0]['acc_name'],
			'det_file'		=> '<a class="btn btn-sm btn-success" target="_blank" href="'.base_url().$detailData[0]['te_note_file'].'"><i class="fa fa-file-download"></i>&nbsp; Download File Nota</a>'
		);

		header('Content-Type: application/json');
		echo json_encode($returnData);
	}

	/** Fuction : Add expenses proses */
	public function addExpensesProses(){
	  /** Load lib dan helper */
		$this->load->helper('file');
		$this->load->library('form_validation');

	  /** Set rules for validation */
		$configValidation = array(
			array(
			  'field'  => 'postEDate',
			  'label'  => 'Tgl Transaksi',
			  'rules'  => 'trim|required|callback__validation_date',
			  'errors'  => array(
				  'required'	=> 'Tanggal tidak boleh kosong',
				  '_validation_date' => 'Tanggal tidak valid'
			  )
			),
			array(
			  'field'  => 'postENecessity',
			  'label'  => 'Keperluan',
			  'rules'  => 'trim|required',
			  'errors'  => array(
				  'required'	=> 'Keperluan tidak boleh kosong'
			  )
			),
			array(
			  'field'  => 'postENote',
			  'label'  => 'No. Nota',
			  'rules'  => 'trim|is_unique[trans_expenses.te_note_code]|required',
			  'errors'  => array(
				  'is_unique' => 'Nomor Nota sudah digunakan',
				  'required' => 'Nomor Nota tidak boleh kosong'
			  )
			),
			array(
			  'field'  => 'postNoteFile',
			  'label'  => 'File nota',
			  'rules'  => 'callback__validation_file'
			),
			array(
			  'field'  => 'postMethod',
			  'label'  => 'Metode pembayaran',
			  'rules'  => 'trim|required|in_list[TF,TN]',
			  'errors'  => array(
				'required' => 'Metode tidak boleh kosong',
				'in_list' => 'Pilih opsi metode yang tersedia'
			  )
			),
			array(
			  'field'  => 'postAccount',
			  'label'  => 'Rekening',
			  'rules'  => 'trim|callback__validation_account'
			),
			array(
			  'field'  => 'postEPayment',
			  'label'  => 'Pembayaran',
			  'rules'  => 'trim|required|numeric',
			  'errors' => array(
				'required'	=> 'Pembayaran tidak boleh kosong',
				'numeric'	=> 'Pembayaran tidak valid, harus berformat angka'
			  )
			),
		);
	  
		$this->form_validation->set_rules($configValidation);

	  /** Proses input */
		if($this->form_validation->run() == FALSE) {
			$arrReturn = array(
				'error'		=> TRUE,
				'errorEDate' 	  	=> form_error('postEDate'),
				'errorEPayment'   	=> form_error('postEPayment'),
				'errorEMethod'	  	=> form_error('postMethod'),
				'errorEAccount'   	=> form_error('postAccount'),
				'errorENecessity'	=> form_error('postENecessity'),
				'errorENote'		=> form_error('postENote'),
				'errorEFileNote'	=> form_error('postNoteFile')
			);
		} else {
		  /** Upload Lib */
			$this->load->library('upload');
  
		  /** Post data */
			$postData = array(
				'te_date'		=> $this->input->post('postEDate'),
				'te_necessity'	=> $this->input->post('postENecessity'),
				'te_note_code'	=> $this->input->post('postENote'),
				'te_note_file'	=> NULL,
				'te_payment'	=> $this->input->post('postEPayment'),
				'te_payment_method'	=> $this->input->post('postMethod'),
				'te_account_id_fk'	=> base64_decode(urldecode($this->input->post('postAccount'))),
				'created_at'	=> date('Y-m-d H:i:s'),
				'created_by'	=> base64_decode(urldecode($this->session->userdata('userID')))
			);
		
		  /** Prepare config tambahan */
			$config['upload_path']   = 'assets/uploaded_files/expense_note/';
			$config['allowed_types'] = 'jpeg|jpg|png|pdf|doc|docx';
			$config['max_size']		 = '2048';
			$config['encrypt_name']  = TRUE;
			  
			$arrayFile = explode('.', $_FILES['postNoteFile']['name']);
			$extension = end($arrayFile);
			$this->upload->initialize($config);

		  /** Upload proses dan Simpan file ke database */
			$upload = $this->upload->do_upload('postNoteFile');
			if($upload){
				/** Uploaded file data */
				$uploadData = $this->upload->data();

				/** Set path ke postData */
				$postData['te_note_file'] = $config['upload_path'].$uploadData['file_name'];

				$inputTE = $this->Expenses_m->insertExpenses($postData);
				if($inputTE > 0){
					$arrReturn = array(
						'success'	=> TRUE,
						'status'	=> 'successInsert',
						'statusIcon' => 'success',
						'statusMsg'	 => 'Berhasil menambahkan transaksi pengeluaran',
					);
				} else {
					unlink($postData['te_note_file']);
					$arrReturn = array(
						'success'	=> TRUE,
						'status'	=> 'failedInsert',
						'statusIcon' => 'error',
						'statusMsg'	 => 'Gagal menambahkan transaksi pengeluaran',
					);
				}
			} else {
				$arrReturn = array(
					'success'	=> TRUE,
					'status'	=> 'failedInsert',
					'statusIcon' => 'error',
					'statusMsg'	 => 'Gagal menyimpan file nota pengeluaran, transaksi pengeluaran batal ditambahkan. Error : '.$this->upload->display_errors(),
				);
			}
		}

		header('Content-Type: application/json');
		echo json_encode($arrReturn);
	}

  /** CRUD Pemasukan / Revenues */
	/** Function : Page list revenues */
	public function listRevenuesPage(){
		$this->auth_user(['uAll', 'uO', 'uK', 'uP']);

		$this->pageData = array(
			'title'   => 'PoS | Trans Pendapatan',
			'assets'  => array('datatables', 'jqueryui', 'custominput', 'sweetalert2', 'list_transaction', 'add_revenues_expenses'),
			'transactionUrl' => site_url('Transaction_c/listRevenuesAjax'),
			'optAcc'  => $this->Account_m->selectAccount()
		);
		$this->page = 'trans/other/revenues_v';
		$this->layout();
	}

	/** Function : Ajax list revenues */
	public function listRevenuesAjax(){
  	  /** Load model */
		$teData = array();
		$no = $this->input->post('start');
		foreach($this->Revenues_m->selectRevenues($this->input->post('length'), $this->input->post('start'))->result_array() as $show){
			$no++;
			$row = array();
			$row[] = date('Y-m-d', strtotime($show['tr_date']));
			$row[] = $show['tr_trans_code'];
			$row[] = $show['tr_source'];
			$row[] = ($show['tr_payment_method'] == 'TN')? 'Cash / Uang Tunai' : 'Transfer';
			$row[] = 'Rp'.number_format($show['tr_payment'], 2);
			$row[] = '<a class="btn btn-xs btn-info" onclick="detailER(\''.urlencode(base64_encode($show['tr_id'])).'\', \''.site_url('Transaction_c/detailRevenues/').'\')"><i class="fa fa-search"></i></a>';
		
			$teData[] = $row;
		}

		$output = array(
			'draw'			  => $this->input->post('draw'),
			'recordsTotal'	  => $this->Revenues_m->countAllRevenues(),
			'recordsFiltered' => $this->Revenues_m->selectRevenues($this->input->post('length'), $this->input->post('start'))->num_rows(),
			'data'			  => $teData
		);

		echo json_encode($output);
	}

	/** Function : Detail Revenues */
	public function detailRevenues(){
		$detailData = $this->Revenues_m->selectRevenuesOnID(base64_decode(urldecode($this->input->get('transID'))))->result_array();
		$returnData = array(
			'type'	=> 'revenues',
			'det_trans_code' => $detailData[0]['tr_trans_code'],
			'det_source'	 => $detailData[0]['tr_source'],
			'det_date'		 => $detailData[0]['tr_date'],
			'det_method'	 => $detailData[0]['tr_payment_method'],
			'det_income'	 => $detailData[0]['tr_payment'],
			'det_account'	 => $detailData[0]['bank_name'].' - '.$detailData[0]['acc_number'].' a/n '.$detailData[0]['acc_name'],
			'det_post_script'	=> $detailData[0]['tr_post_script'],
		);

		header('Content-Type: application/json');
		echo json_encode($returnData);
	}

	/** Function : Add revenues proses */
	public function addRevenuesProses(){
	  /** Load lib dan helper */
		$this->load->library('form_validation');
  
	  /** Set rules for validation */
		$configValidation = array(
			array(
				'field'  => 'postRDate',
				'label'  => 'Tgl Transaksi',
				'rules'  => 'trim|required|callback__validation_date',
				'errors'  => array(
					'required'	=> 'Tanggal tidak boleh kosong',
					'_validation_date' => 'Tanggal tidak valid'
				)
			),
			array(
				'field'  => 'postRIncomeSource',
				'label'  => 'Sumber pemasukan',
				'rules'  => 'trim|required',
				'errors'  => array(
					'required'	=> 'Sumber pemasukan tidak boleh kosong'
				)
			),
			array(
				'field'  => 'postMethod',
				'label'  => 'Metode pembayaran',
				'rules'  => 'trim|required|in_list[TF,TN]',
				'errors'  => array(
				  'required' => 'Metode tidak boleh kosong',
				  'in_list' => 'Pilih opsi metode yang tersedia'
				)
			),
			array(
				'field'  => 'postAccount',
				'label'  => 'Rekening',
				'rules'  => 'trim|callback__validation_account'
			),
			array(
				'field'  => 'postRPayment',
				'label'  => 'Biaya',
				'rules'  => 'trim|required|numeric',
				'errors' => array(
				  'required'	=> 'Biaya tidak boleh kosong',
				  'numeric'	=> 'Biaya tidak valid, harus berformat angka'
				)
			),
		);
		
		$this->form_validation->set_rules($configValidation);

	  /** Proses input */
		if($this->form_validation->run() == FALSE) {
			$arrReturn = array(
				'error'		=> TRUE,
				'errorRDate'	=> form_error('postRDate'),
				'errorRSource'	=> form_error('postRIncomeSource'),
				'errorMethod'	=> form_error('postMethod'),
				'errorAccount'	=> form_error('postAccount'),
				'errorRPayment'	=> form_error('postRPayment')
			);
		} else {
		  /** Set trans code */
			if($this->Revenues_m->getNextIncrement()->num_rows() > 1){
				$nextAI = $this->Revenues_m->getNextIncrement()->result_array(); // Get next auto increment table transaksi penjualan
				$nol = '';
				for($n = 5; $n >= strlen($nextAI['0']['AUTO_INCREMENT']); $n--){
					$nol .= '0';
				}
				$nextCode = 'TK'.date('Ymd').$nol.$nextAI['0']['AUTO_INCREMENT'];
			} else {
				$nextCode = 'TR'.date('Ymd').'00001';
			}

		  /** Get post data */
			$postData = array(
				'tr_trans_code'		=> $nextCode,
				'tr_source'			=> htmlspecialchars($this->input->post('postRIncomeSource'), ENT_QUOTES),
				'tr_date'			=> $this->input->post('postRDate'),
				'tr_payment_method' => $this->input->post('postMethod'),
				'tr_payment'		=> $this->input->post('postRPayment'),
				'tr_account_id_fk'	=> base64_decode(urldecode($this->input->post('postAccount'))),
				'tr_post_script'	=> htmlspecialchars($this->input->post('postRPS'), ENT_QUOTES),
				'created_at'	=> date('Y-m-d H:i:s'),
				'created_by'	=> base64_decode(urldecode($this->session->userdata('userID')))
			);

		  /** Proses input */
			$inputTR = $this->Revenues_m->insertRevenues($postData);

			if($inputTR > 0){
				$arrReturn = array(
					'success'	=> TRUE,
					'status'	=> 'successInsert',
					'statusIcon' => 'success',
					'statusMsg'	 => 'Berhasil menambahkan transaksi pemasukan',
				);
			} else {
				$arrReturn = array(
					'success'	=> TRUE,
					'status'	=> 'failedInsert',
					'statusIcon' => 'error',
					'statusMsg'	 => 'Gagal menambahkan transaksi pemasukan'
				);
			}
		}

		header('Content-Type: application/json');
		echo json_encode($arrReturn);
	}

  /** CRUD Return Supplier */
	/** Function : Page add return */
	public function addRSPage($encoded_trans_id){
	  /** Check allowed user */
		$this->auth_user(['uAll', 'uO', 'uP']);

	  /** Get detail retur */
		$dataRS = $this->Return_m->selectRSByTPID(base64_decode(urldecode($encoded_trans_id)))->result_array();
		$detailRS = array();

		foreach($dataRS as $showRS){
			$detailRS[$showRS['rs_id']]['show_date']	= $showRS['rs_date'];
			$detailRS[$showRS['rs_id']]['show_status']	= ($showRS['rs_status'] == 'R')? '<span class="badge badge-success">Tukar Barang</span>' : '<span class="badge badge-info">Retur Uang</span>';
			$detailRS[$showRS['rs_id']]['show_cash_in'] = $showRS['rs_cash_in'];
			$detailRS[$showRS['rs_id']]['show_cash_out'] = $showRS['rs_cash_out'];
			$detailRS[$showRS['rs_id']]['show_ps'] 		= $showRS['rs_post_script'];
			$detailRS[$showRS['rs_id']]['detail_rs'][] = array(
				'retur_product' => '<small>'.$showRS['prd_name'].'</small>',
				'retur_qty'		=> $showRS['drs_return_qty']
			);
		}

		foreach($detailRS as $key => $value){
			$detailRS[$key]['count_prd'] = count($value['detail_rs']);
		}

		$this->pageData = array(
			'title'   => 'PoS | Retur Supplier',
			'assets'  => array('jqueryui', 'sweetalert2', 'add_return'),
			'detailCart'  => $this->Purchases_m->selectDetTP(base64_decode(urldecode($encoded_trans_id)))->result_array(),
			'detailRetur' => $detailRS,
			'transID'	  => $encoded_trans_id
		);
		$this->page = 'trans/return/add_return_supp_v';
		$this->layout();
	}

	/** Function : Proses add return supplier */
	public function addRSProses(){
	  /** Load lib & helper */
		$this->load->library('form_validation');

	  /** Load model */
		$this->load->model('Product_m');

	  /** Set rules form validation */
		$configValidation = array(
			array(
			  'field'  => 'postTPID',
			  'label'  => 'ID TP',
			  'rules'  => 'trim|required|callback__validation_return_tpid',
			  'errors'  => array(
				  'required'	=> 'Kode Transaksi tidak boleh kosong',
			  )
			),
			array(
			  'field'  => 'postRSDate',
			  'label'  => 'Tgl Transaksi',
			  'rules'  => 'trim|required|callback__validation_date',
			  'errors'  => array(
				  'required'	=> 'Tanggal tidak boleh kosong',
				  '_validation_date' => 'Tanggal tidak valid'
			  )
			),
			array(
			  'field'  => 'postRSStatus',
			  'label'  => 'Status Return',
			  'rules'  => 'trim|required|in_list[R,U]',
			  'errors'  => array(
				  'required' => 'Status pembayaran tidak boleh kosong',
				  'in_list'  => 'Pilih opsi status yang tersedia'
			  )
			),
			array(
			  'field'  => 'postRSCashOut',
			  'label'  => 'Biaya Retur',
			  'rules'  => 'trim|numeric',
			  'errors'  => array(
				  'numeric'  => 'Biaya retur tidak valid, harus berupa angka'
			  )
			),
			array(
			  'field'  => 'postRSCashIn',
			  'label'  => 'Pengembalian Dana (Dana Masuk)',
			  'rules'  => 'trim|numeric|callback__validation_return_cash',
			  'errors'  => array(
				  'numeric'  => 'Dana masuk tidak valid, harus berupa angka'
			  )
			),
			array(
			  'field'  => 'postRSPS',
			  'label'  => 'Keterangan',
			  'rules'  => 'trim'
			),
		);
	  
		$this->form_validation->set_rules($configValidation);

	  /** Run Valudation */
		if($this->form_validation->run() == FALSE) {
			$arrReturn = array(
				'error'		=> TRUE,
				'errorRSTPID'	=> form_error('postTPID'),
				'errorRSDate'	=> form_error('postRSDate'),
				'errorRSStatus'	=> form_error('postRSStatus'),
				'errorRSCashIn'	=> form_error('postRSCashIn'),
				'errorRSCashOut' => form_error('postRSCashOut')
			);
		} else {
			
		  /** Get form post data */
			$postData = array(
			    'rs_tp_id_fk' 	=> base64_decode(urldecode($this->input->post('postTPID'))),
				'rs_date' 		=> $this->input->post('postRSDate'),
				'rs_status'		=> $this->input->post('postRSStatus'),
				'rs_cash_in'	=> ($this->input->post('postRSCashIn') == '')? 0 : $this->input->post('postRSCashIn'),
				'rs_cash_out'	=> ($this->input->post('postRSCashOut') == '')? 0 : $this->input->post('postRSCashOut'),
				'rs_post_script' => $this->input->post('postRSPS'),
				'created_at'	=> date('Y-m-d H:i:s'),
				'created_by'	=> base64_decode(urldecode($this->session->userdata('userID')))
			);

			$detailData = array();
			foreach($this->input->post('postRSItem') as $prdID => $prdAmount){
				if($prdAmount != NULL || $prdAmount > 0 || $prdAmount != ''){
					$returnPrd[$prdID] = $prdAmount;
					$detailData[] = array(
						'drs_rs_id_fk'		=> NULL,
						'drs_product_id_fk' => $prdID,
						'drs_return_qty'	=> $prdAmount
					);
				}
			}

			if($detailData == NULL){
				$arrReturn = array(
					'error' => TRUE,
					'errorRSCart' => 'Keranjang retur tidak boleh kosong'
				);
			} else {	
			  /** Input Proses */
				$inputRS = $this->Return_m->insertReturnSupplier($postData, $detailData, $returnPrd);
				if($inputRS == TRUE) {
					$arrReturn = array(
						'success'	=> TRUE,
						'status'	=> 'successInsert',
						'statusIcon' => 'success',
						'statusMsg'	 => 'Berhasil menambahkan transaksi retur',
						'redirect'	 => site_url('Transaction_c/detailPurchasesPage/'.urlencode(base64_encode($postData['rs_tp_id_fk'])))
					);
				} else {
					$arrReturn = array(
						'success'	=> TRUE,
						'status'	=> 'failedInsert',
						'statusIcon' => 'error',
						'statusMsg'	 => 'Gagal menambahkan transaksi retur',
					);
				}
			}
		}

		header('Content-Type: application/json');
		echo json_encode($arrReturn);
	}

	/** Function : List retur Customer */
	public function listRSPage(){
		$this->auth_user(['uAll', 'uO', 'uP']);
		$this->pageData = array(
			'title' => 'PoS | Retur Pembelian',
			'assets' => array('datatables', 'list_transaction'),
			'transactionUrl' => site_url('Transaction_c/listRSAjax')
		);
		$this->page = 'trans/return/list_return_supp_v';
		$this->layout();
	}

	/** Function : Ajax retur supplier */
	public function listRSAjax(){
		$rsData	= array();
		$no		= $this->input->post('start');
		foreach( $this->Return_m->selectRS( $this->input->post('length'), $this->input->post('start') )->result_array() as $showRS ){
			$row = array();
			$row[]	= date('Y-m-d', strtotime($showRS['rs_date']));
			$row[]	= $showRS['tp_note_code'];
			$row[]	= $showRS['supp_name'];
			$row[]	= ($showRS['rs_status'] == 'R')? '<span class="badge badge-warning">Tukar Barang</span>' : '<span class="badge badge-danger">Pengembalian Dana</span>';
			$row[]	= number_format($showRS['rs_cash_out'], 2);
			$row[]	= number_format($showRS['rs_cash_in'], 2);
			$row[]	= '<small>'.$showRS['rs_post_script'].'</small>';
			$row[]	= '<a class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title="Detail Transaksi Pembelian" href="'.site_url('Transaction_c/detailPurchasesPage/'.urlencode(base64_encode($showRS['rs_tp_id_fk']))).'"><i class="fas fa-search"></i></a>';

			$rsData[] = $row;
		}

		$output = array(
			'draw'			  => $this->input->post('draw'),
			'recordsTotal'	  => $this->Return_m->count_all_rs(),
			'recordsFiltered' => $this->Return_m->selectRS( $this->input->post('length'), $this->input->post('start') )->num_rows(),
			'data'			  => $rsData
		);

		header('Content-Type: application/json');
		echo json_encode($output);
	}

  /** CRUD Return Costumer */
	/** Function : Page add return costumer */
	public function addRCPage($encoded_trans_id){
		$this->auth_user(['uAll', 'uO', 'uK']);

		$this->pageData = array(
			'title'   => 'PoS | Retur Pelanggan',
			'assets'  => array('jqueryui', 'sweetalert2', 'add_return'),
			'detailCart'  => $this->Sales_m->selectDetTS(base64_decode(urldecode($encoded_trans_id)))->result_array(),
			'transID'	  => $encoded_trans_id
		);
		$this->page = 'trans/return/add_return_ctm_v';
		$this->layout();
	}

	/** Function : Proses add return costumer */
	public function addRCProses(){
	  /** Load lib & helper */
		$this->load->library('form_validation');
  
	  /** Load model */
		$this->load->model('Product_m');
  
	  /** Set rules form validation */
		$configValidation = array(
			array(
				'field'  => 'postTSID',
				'label'  => 'ID TP',
				'rules'  => 'trim|required|callback__validation_return_tsid',
				'errors'  => array(
					'required'	=> 'Kode Transaksi tidak boleh kosong'
				)
			),
			array(
				'field'  => 'postRCDate',
				'label'  => 'Tgl Transaksi',
				'rules'  => 'trim|required|callback__validation_date',
				'errors'  => array(
					'required'	=> 'Tanggal tidak boleh kosong',
					'_validation_date' => 'Tanggal tidak valid'
				)
			),
			array(
				'field'  => 'postRCStatus',
				'label'  => 'Status Return',
				'rules'  => 'trim|required|in_list[R,U]',
				'errors'  => array(
					'required' => 'Status pembayaran tidak boleh kosong',
					'in_list'  => 'Pilih opsi status yang tersedia'
				)
			),
			array(
				'field'  => 'postRCCash',
				'label'  => 'Biaya Retur',
				'rules'  => 'trim|numeric|callback__validation_cash',
				'errors'  => array(
					'numeric'  => 'Biaya retur tidak valid, harus berupa angka'
				)
			),
			array(
				'field'  => 'postRCPS',
				'label'  => 'Keterangan',
				'rules'  => 'trim'
			),
		);
		
		$this->form_validation->set_rules($configValidation);
  
	  /** Run Valudation */
		if($this->form_validation->run() == FALSE) {
			$arrReturn = array(
				'error'		=> TRUE,
				'errorRCTSID'	=> form_error('postTSID'),
				'errorRCDate'	=> form_error('postRCDate'),
				'errorRCStatus'	=> form_error('postRCStatus'),
				'errorRCCash'	=> form_error('postRCCash')
			);
		} else {
		  /** Set rc code */
			if($this->Return_m->getNextIncrement()->num_rows() > 0){
				$nextAI = $this->Return_m->getNextIncrement()->result_array(); // Get next auto increment table transaksi penjualan
				$nol = '';
				for($n = 4; $n >= strlen($nextAI['0']['AUTO_INCREMENT']); $n--){
					$nol .= '0';
				}
				$nextCode = 'RC'.base64_decode(urldecode($this->session->userdata('userID'))).base64_decode(urldecode($this->input->post('postTSID'))).date('Ymd').$nol.$nextAI['0']['AUTO_INCREMENT'];
			} else {
				$nextCode = 'RC'.base64_decode(urldecode($this->session->userdata('userID'))).base64_decode(urldecode($this->input->post('postTSID'))).date('Ymd').'0001';
			}

		  /** Get form post data */
			$postData = array(
				'rc_code'		=> $nextCode,
				'rc_ts_id_fk' 	=> base64_decode(urldecode($this->input->post('postTSID'))),
				'rc_date' 		=> $this->input->post('postRCDate'),
				'rc_status'		=> $this->input->post('postRCStatus'),
				'rc_cash'		=> ($this->input->post('postRCCash') == '')? 0 : $this->input->post('postRCCash'),
				'rc_post_script' => $this->input->post('postRCPS'),
				'created_at'	=> date('Y-m-d H:i:s'),
				'created_by'	=> base64_decode(urldecode($this->session->userdata('userID')))
			);

			$detailData = array();
			foreach($this->input->post('postRCItem') as $prdID => $prdAmount){
				if($prdAmount != NULL || $prdAmount > 0 || $prdAmount != ''){
					$returnPrd[$prdID] = $prdAmount;
					$detailData[] = array(
						'drc_rc_id_fk'		=> NULL,
						'drc_product_id_fk' => $prdID,
						'drc_return_qty'	=> $prdAmount
					);
				}
			}

		  /** Input Proses */			
			if($detailData == NULL){
				$arrReturn = array(
					'error' => TRUE,
					'errorRCCart' => 'Keranjang retur tidak boleh kosong'
				);
			} else {	
			  /** Input Proses */
				$inputRS = $this->Return_m->insertReturnCustomer($postData, $detailData, $returnPrd);
				if($inputRS == TRUE) {
					$dataUpdate = array('ts_return' => 'Y');
					$updateTS = $this->Sales_m->updateTs($dataUpdate, $postData['rc_ts_id_fk']);
					$arrReturn = array(
						'success'	=> TRUE,
						'status'	=> 'successInsert',
						'statusIcon' => 'success',
						'statusMsg'	 => 'Berhasil menambahkan transaksi retur',
						'redirect'	 => site_url('Transaction_c/detailSalesPage/'.urlencode(base64_encode($postData['rc_ts_id_fk'])))
					);
				} else {
					$arrReturn = array(
						'success'	=> TRUE,
						'status'	=> 'failedInsert',
						'statusIcon' => 'error',
						'statusMsg'	 => 'Gagal menambahkan transaksi retur',
					);
				}
			}
		}

		header('Content-Type: application/json');
		echo json_encode($arrReturn);
	}

	/** Function : List retur Customer */
	public function listRCPage(){
		$this->auth_user(['uAll', 'uO', 'uK']);
		$this->pageData = array(
			'title' => 'PoS | Retur Penjualan',
			'assets' => array('datatables', 'list_transaction'),
			'transactionUrl' => site_url('Transaction_c/listRCAjax')
		);
		$this->page = 'trans/return/list_return_ctm_v';
		$this->layout();
	}

	/** Function : Ajax retur customer */
	public function listRCAjax(){
		$rcData	= array();
		$no		= $this->input->post('start');
		foreach( $this->Return_m->selectRC( $this->input->post('length'), $this->input->post('start') )->result_array() as $showRC ){
			$row = array();
			$row[]	= date('Y-m-d', strtotime($showRC['rc_date']));
			$row[]	= $showRC['ts_trans_code'];
			$row[]	= $showRC['ctm_name'];
			$row[]	= ($showRC['rc_status'] == 'R')? '<span class="badge badge-warning">Tukar Barang</span>' : '<span class="badge badge-danger">Pengembalian Dana</span>';
			$row[]	= ($showRC['rc_status'] == 'U')? number_format($showRC['rc_cash'], 2) : '';
			$row[]	= '<a class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title="Detail Transaksi Penjualan" href="'.site_url('Transaction_c/detailSalesPage/'.urlencode(base64_encode($showRC['rc_ts_id_fk']))).'"><i class="fas fa-search"></i></a>';

			$rcData[] = $row;
		}

		$output = array(
			'draw'			  => $this->input->post('draw'),
			'recordsTotal'	  => $this->Return_m->count_all_rc(),
			'recordsFiltered' => $this->Return_m->selectRC( $this->input->post('length'), $this->input->post('start') )->num_rows(),
			'data'			  => $rcData
		);

		header('Content-Type: application/json');
		echo json_encode($output);
	}

  /** Custom Form Validation */
	/** Validation Contact */
		function _validation_supplier($post){
			/** Load Model supplier */
			$this->load->model('Supplier_m');

			if($this->Supplier_m->selectSupplierByID(base64_decode(urldecode($post)))->num_rows() > 0){
				return TRUE;
			} else {
				return FALSE;
			}
		}
		function _validation_ctm($post){
			if($post != '0000' && $post != 'nctm'){
				if(trim($post, " ") != ''){
					/** Load model customer */
					$this->load->model('Customer_m');

					if($this->Customer_m->selectCustomerOnID(base64_decode(urldecode($post)))->num_rows() > 0){
						return TRUE;
					} else {
						$this->form_validation->set_message('_validation_ctm', 'Pelanggan tidak ditemukan');
						return FALSE;
					}
				} else {
					$this->form_validation->set_message('_validation_ctm', 'Silahkan pilih pelanggan');
					return FALSE;
				}
			} else {
				return TRUE;
			}
		}

	  /** Validation : file */
		function _validation_file($post){
			/** Load lib dan helper */
			$this->load->helper('file');
			/** buat mime type : 
			$allowedMime = array('application/pdf','image/gif','image/jpeg','image/pjpeg','image/png','image/x-png') */
			$allowedExt	= array('pdf', 'doc', 'docx', 'jpeg', 'jpg', 'png');
			if($_FILES['postNoteFile']['name']){
				if(in_array(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION), $allowedExt)){
					return TRUE;
				} else {
					$this->form_validation->set_message('_validation_file', 'File nota harus berformat pdf/jpeg/jpg/png');
					return FALSE;
				}
			} else {
				$this->form_validation->set_message('_validation_file', 'File nota tidak boleh kosong');
				return FALSE;
			}
		}
		function _validation_installment_file($post){
			/** Load lib dan helper */
			$this->load->helper('file');
			/** buat mime type : 
			$allowedMime = array('application/pdf','image/gif','image/jpeg','image/pjpeg','image/png','image/x-png') */
			$allowedExt	= array('pdf', 'doc', 'docx', 'jpeg', 'jpg', 'png');
			if($_FILES['postIPNoteFile']['name']){
				if(in_array(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION), $allowedExt)){
					return TRUE;
				} else {
					$this->form_validation->set_message('_validation_installment_file', 'File nota harus berformat pdf/jpeg/jpg/png');
					return FALSE;
				}
			} else {
				$this->form_validation->set_message('_validation_installment_file', 'File nota tidak boleh kosong');
				return FALSE;
			}
		}
	
	  /** Validation : kredit */
		function _validation_credit($post){
			if($this->input->post('postStatus') == 'K'){
				if(trim($post, " ") != ''){
					return TRUE;
				} else {
					return FALSE;
				}
			} else {
				return TRUE;
			}
		}

	  /** Validation : Tempo */
		function _validation_due($post){
			if($this->input->post('postStatus') == 'K'){
				if(trim($post, " ") != ''){
					if($this->_validation_date($post) == TRUE){
						return TRUE;
					} else {
						$this->form_validation->set_message('_validation_due', 'Tanggal tempo tidak valid');
						return FALSE;
					}
				} else {
					$this->form_validation->set_message('_validation_due', 'Tanggal tempo tidak boleh kosong');
					return FALSE;
				}
			} else {
				return TRUE;
			}
		}
		function _validation_installment_due($post){
			if($this->input->post('postIPStatus') == 'BL'){
				if(trim($post, " ") != ''){
					if($this->_validation_date($post) == TRUE){
						return TRUE;
					} else {
						$this->form_validation->set_message('_validation_installment_due', 'Tanggal tempo tidak valid');
						return FALSE;
					}
				} else {
					$this->form_validation->set_message('_validation_installment_due', 'Tanggal tempo tidak boleh kosong');
					return FALSE;
				}
			} else {
				return TRUE;
			}
		}

	  /** Validation : Account */
		function _validation_account($post){
			if($this->input->post('postMethod') == 'TF'){
				if(trim($post, " ") != ''){
					$this->load->model('Account_m');
					if( $this->Account_m->selectAccountOnID(base64_decode(urldecode($post)))->num_rows() > 0 ){
						return TRUE;
					} else {
						$this->form_validation->set_message('_validation_account', 'Rekening tidak ditemukan, Silahkan pilih opsi tersedia');
						return FALSE;
					}
				} else {
					$this->form_validation->set_message('_validation_account', 'Mohon pilih rekening');
					return FALSE;
				}
			} else {
				return TRUE;
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

	  /** Validation : Postal Fee */
		function _validation_postal_fee($post){
			if($this->input->post('postSDelivery') == 'T' || $this->input->post('postSDelivery') == 'E'){
				if(trim($post, " ") != ''){
					return TRUE;
				} else {
					$this->form_validation->set_message('_validation_postal_fee', 'Ongkir tidak boleh kosong');
					return FALSE;
				}
			} else {
				return TRUE;
			}
		}
	  
	  /** Validation : Pengembalian dana retur */
		function _validation_return_cash($post){
			if($this->input->post('postRSStatus') == 'U'){
				if(trim($post, "") != ''){
					return TRUE;
				} else {
					$this->form_validation->set_message('_validation_return_cash', 'Dana masuk tidak boleh kosong');
					return FALSE;
				}
			} else {
				return TRUE;
			}
		}

	  /** Validation : TP ID di form retur */
		function _validation_return_tpid($post){
			$checkTPID = $this->Purchases_m->selectPurchaseOnID(base64_decode(urldecode($post)))->num_rows();
			if($checkTPID > 0){
				return TRUE;
			} else {
				$this->form_validation->set_message('_validation_return_tpid', 'Transaksi Pembelian tidak ditemukan !');
				return FALSE;
			}
		}

	  /** Validation : TS ID di form retur */
		function _validation_return_tsid($post){
			$checkTPID = $this->Sales_m->selectSalesOnID(base64_decode(urldecode($post)))->num_rows();
			if($checkTPID > 0){
				if($this->Return_m->selectRCByTSID(base64_decode(urldecode($post)))->num_rows() > 0){
					$this->form_validation->set_message('_validation_return_tsid', 'Retur sudah pernah dilakukan, batas retur hanya 1 kali !');
					return FALSE;
				} else {
					return TRUE;
				}
			} else {
				$this->form_validation->set_message('_validation_return_tsid', 'Transaksi Penjualan tidak ditemukan !');
				return FALSE;
			}
		}

	  /** Validation : RC Cash */
		function _validation_cash($post){
			if($this->input->post('postRCStatus') == 'U'){
				if(trim($post, "") != ''){
					return TRUE;
				} else {
					$this->form_validation->set_message('_validation_cash', 'Biaya retur tidak boleh kosong !');
					return FALSE;
				}
			} else {
				return TRUE;
			}
		}
}