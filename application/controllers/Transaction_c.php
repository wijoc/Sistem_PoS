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

  /** Function : Keranjang. Harus diganti ke session keranjang */
	/** Function : Tambah data keranjang */
	public function addCart($trans){
	  /** Load library & Helper */
		$this->load->library('form_validation');
	
	  /** Set rules form validation */
		$config = array(
		  array(
			'field'  => 'postIdPrd',
			'label'  => 'ID Product',
			'rules'  => 'trim|required',
			'errors'  => array(
				'required' => 'Product tidak boleh kosong'
			)
		  ),
		  array(
			'field'  => 'postHargaPrd',
			'label'  => 'Harga Satuan',
			'rules'  => 'trim|numeric|greater_than[0]|required',
			'errors'  => array(
				'numeric'	=> 'Harga tidak valid',
				'required'	=> 'Harga tidak boleh kosong',
				'greater_than' => 'Harga tidak boleh kurang dari 0'
			)
		  ),
		  array(
			'field'  => 'postJumlahPrd',
			'label'  => 'Qty',
			'rules'  => 'trim|numeric|greater_than[0]|required',
			'errors'  => array(
				'numeric'	=> 'Quantity tidak valid',
				'required'	=> 'Qty tidak boleh kosong',
				'greater_than' => 'Qty tidak boleh kurang dari 0'
			)
		  )
		);
	
		$this->form_validation->set_rules($config);
	
	  /** Run validate */
		if($this->form_validation->run() == FALSE){
			$arrReturn	= array(
				'error'     => TRUE,
				'errorID'	=> (form_error('postIdPrd'))? form_error('postIdPrd') : '',
				'errorQty'	=> (form_error('postJumlahPrd'))? form_error('postJumlahPrd') : '',
				'errorHrg'	=> (form_error('postHargaPrd'))? form_error('postHargaPrd') : ''
			);
		} else {
			/** Get data post dari form */
			$postData = array(
				'post_product_id' 	  => base64_decode(urldecode($this->input->post('postIdPrd'))),
				'post_harga_satuan'   => $this->input->post('postHargaPrd'),
				'post_product_jumlah' => $this->input->post('postJumlahPrd'),
				'post_total_bayar' 	  => ($this->input->post('postTotalPrd') > 0)? $this->input->post('postTotalPrd') : $this->input->post('postHargaPrd')*$this->input->post('postJumlahPrd')
			);

			if($trans === 'Purchases'){
				/** Cek product di keranjang */
				$checkTemp = $this->Purchases_m->getTemponPrdId(base64_decode(urldecode($this->input->post('postIdPrd'))));
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
					$inputTemp = $this->Purchases_m->updateCart($newInputData, $updateId);
				} else {
					$inputTemp = $this->Purchases_m->insertCart($postData);
				}

				/** return value */
				if($inputTemp){
					$arrReturn = array(
						'success'	=> TRUE,
						'successMsg' => 'Data ditambahkan ke keranjang'
					);
				} else {
					$arrReturn = array(
						'success'	=> TRUE,
						'successMsg' => 'Gagal menambahkan data ke keranjang'
					);
				}
			} else if ($trans === 'Sales'){}
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
			$delTemp = $this->Sales_m->deleteTemp($base64_decode(urldecode($this->input->post('postId'))));
			redirect('Transaksi_c/addSalesPage');
		}

		header('Content-Type: application/json');
		echo json_encode($arrReturn);
	}

	/** Function : Daftar keranjang */
	public function listCardAjax($trans){
		if($trans == 'Purchases'){
			$cartData = $this->Purchases_m->selectCart();
			$returnData = array(
				'delete_url' => site_url('Transaksi_c/deleteCart/Purchases/'),
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
		}

		header('Content-Type: application/json');
		echo json_encode($returnData);
	}

  /** CRUD Purchasing */
	/** Function : Page add purchasing */
	public function addPurchasesPage(){
	  /** Load Model supplier untuk option supplier */
	  	$this->load->model('Supplier_m');

	  /** Data yang ditampilkan ke view */
		$this->pageData = array(
			'title'   => 'PoS | Trans Pembelian',
			'assets'  => array('jqueryui', 'custominput', 'toastr', 'sweetalert2', 'page_add_trans', 'p_purchases'),
			'optSupp' => $this->Supplier_m->selectSupplier(0, 0, 0)->result_array(),
			'optAcc'  => $this->Account_m->selectAccount()
		);
		$this->page = 'trans/purchases/add_trans_purchases_v';
		$this->layout();
	}

	/* Function : List trans pembelian */
	public function listPurchasesPage(){
	  /* Data yang ditampilkan ke view */
		$this->pageData = array(
			'title' => 'PoS | Trans Pembelian',
			'assets' => array('datatables', 'page_list_trans'),
			'dataTrans' => $this->Purchases_m->getAllTransPurchase()
		);
		$this->page = 'trans/list_trans_purchases_v';
		$this->layout();
	}

	/* Function : Detail trans pembelian */
	public function detailPurchasesPage($encoded_trans_id){
	  /* Decode id */
		$transId = base64_decode(urldecode($encoded_trans_id));

	  /* Data yang ditampilkan ke view */
		$this->pageData = array(
			'title' => 'PoS | Trans Pembelian',
			'assets' => array('datatables', 'page_list_trans'),
			'detailTrans' => $this->Purchases_m->getTransPurchaseonID($transId),
			'detailPayment' => $this->Installment_m->getInstallmentPurchase($transId),
		);
		$this->page = 'trans/detail_trans_purchases_v';
		$this->layout();
	}

	/* Function : Form pembayaran angsuran transaksi pembelian */
	public function payPurchasesInstallmentPage($encoded_trans_id){
	  /* Decode id */
		$transId = base64_decode(urldecode($encoded_trans_id));

	  /* Data yang ditampilkan ke view */
		$this->pageData = array(
			'title' => 'PoS | Trans Pembelian',
			'assets' => array('datatables', 'custominput', 'sweetalert2', 'page_installment'),
			'detailTrans' => $this->Purchases_m->getTransPurchaseonID($transId),
			'detailPayment' => $this->Installment_m->getInstallmentPurchase($transId),
		);
		$this->page = 'trans/pay_installment_purchase_v';
		$this->layout();
	}

	/** Function : Proses tambah trans pembelian */
	function addPurchasesProses(){
	  /** Load lib dan helper */
		$this->load->helper('file');
		$this->load->library('form_validation');

	  /** Set rules form validation */
		$configValidation = array(
			array(
			  'field'  => 'postPurchaseDate',
			  'label'  => 'Tgl Transaksi',
			  'rules'  => 'trim|required|callback__validation_date',
			  'errors'  => array(
				  'required'	=> 'Tanggal tidak boleh kosong',
				  '_validation_date' => 'Tanggal tidak valid'
			  )
			),
			array(
			  'field'  => 'postPurchaseNote',
			  'label'  => 'No. Nota Pembelian',
			  'rules'  => 'trim|required',
			  'errors'  => array(
				  'required' => 'Nomor Nota tidak boleh kosong'
			  )
			),
			array(
			  'field'  => 'postPurchaseNoteFile',
			  'label'  => 'File nota',
			  'rules'  => 'callback__validation_file'
			),
			array(
			  'field'  => 'postPurchaseSupplier',
			  'label'  => 'Supplier',
			  'rules'  => 'trim|required|callback__validation_supplier',
			  'errors'  => array(
				  'required'	=> 'Supplier tidak boleh kosong',
				  '_validation_supplier' => 'Supplier tidak ditemukan'
			  )
			),
			array(
			  'field'  => 'postPurchaseStatus',
			  'label'  => 'Status Pembayaran',
			  'rules'  => 'trim|required|in_list[K,T]',
			  'errors'  => array(
				  'required' => 'Status pembayaran tidak boleh kosong',
				  'in_list'  => 'Pilih opsi status yang tersedia'
			  )
			),
			array(
			  'field'  => 'postPurchaseTenor',
			  'label'  => 'Tenor',
			  'rules'  => 'trim|numeric|greater_than[0]|callback__validation_kredit',
			  'errors'  => array(
				  'numeric' => 'Harus berinilai angka',
				  '_validation_kredit' => 'Tenor tidak boleh kosong',
				  'greater_than[0]'	=> 'Tenor harus lebih dari 0'
			  )
			),
			array(
			  'field'  => 'postPurchaseTenorPeriode',
			  'label'  => 'Periode tenor',
			  'rules'  => 'in_list[D,W,M,Y]',
			  'errors'  => array(
				'in_list'  => 'Pilih opsi periode yang tersedia'
			  )
			),
			array(
			  'field'  => 'postPurchaseInstallment',
			  'label'  => 'Angsuran',
			  'rules'  => 'trim|greater_than[0]|numeric|callback__validation_kredit',
			  'errors'  => array(
				'numeric'  => 'Nilai angsuran tidak valid',
				'greater_than' => 'Nilai harus lebih besar dari 0',
				'_validation_kredit' => 'Angsuran tidak boleh kosong',
			  )
			),
			array(
			  'field'  => 'postPurchaseDue',
			  'label'  => 'Tempo',
			  'rules'  => 'trim|callback__validation_due'
			),
			array(
			  'field'  => 'postPurchaseMethod',
			  'label'  => 'Metode pembayaran',
			  'rules'  => 'trim|required|in_list[TF,TN]',
			  'errors'  => array(
				'in_list' => 'Pilih opsi metode yang tersedia'
			  )
			),
			array(
			  'field'  => 'postPurchaseAccount',
			  'label'  => 'Metode pembayaran',
			  'rules'  => 'trim|callback__validation_account'
			),
			array(
			  'field'  => 'postPurchasePayment',
			  'label'  => 'Pembayaran',
			  'rules'  => 'trim|required|numeric',
			  'errors' => array(
				'required'	=> 'Pembayaran tidak boleh kosong',
				'numeric'	=> 'Pembayaran tidak valid'
			  )
			)
		);
	  
		$this->form_validation->set_rules($configValidation);

	  /** Run Valudation */
		if($this->form_validation->run() == FALSE) {
			$arrReturn = array(
				'error'		=> TRUE,
				'errorPnote' 	=> form_error('postPurchaseNote'),
				'errorFilenote'	=> form_error('postPurchaseNoteFile'),
				'errorPDate' 	=> form_error('postPurchaseDate'),
				'errorPSupp' 	=> form_error('postPurchaseSupplier'),
				'errorPStatus'	=> form_error('postPurchaseStatus'),
				'errorPTenor'	=> form_error('postPurchaseTenor'),
				'errorPTenorPeriode' => form_error('postPurchaseTenorPeriode'),
				'errorPInstallment'	 => form_error('postPurchaseInstallment'),
				'errorPDue'		=> form_error('postPurchaseDue'),
				'errorPMethod'	=> form_error('postPurchaseMethod'),
				'errorPAccount'	=> form_error('postPurchaseAccount'),
				'errorPPayment' => form_error('postPurchasePayment')
			);
		} else {
		  /** Upload Lib */
			$this->load->library('upload');
		  
		  /** Get form data */
			$postData = array(
				'tp_note_code'	 => $this->input->post('postPurchaseNote'),
				'tp_note_file'	 => NULL,
				'tp_date'	  	 => $this->input->post('postPurchaseDate'),
				'tp_supplier_fk' => base64_decode(urldecode($this->input->post('postPurchaseSupplier'))),
				'tp_status' 	 => $this->input->post('postPurchaseStatus'),
				'tp_tenor' 		 => ($this->input->post('postPurchaseStatus') == 'K')? $this->input->post('postPurchaseTenor') : '',
				'tp_tenor_periode' 	=> ($this->input->post('postPurchaseStatus') == 'K')? $this->input->post('postPurchaseTenorPeriode') : '',
				'tp_installment' 	=> ($this->input->post('postPurchaseStatus') == 'K')? $this->input->post('postPurchaseInstallment') : '',
				'tp_due_date' 		=> ($this->input->post('postPurchaseStatus') == 'K')? $this->input->post('postPurchaseDue') : '',
				'tp_payment_method' => $this->input->post('postPurchaseMethod'),
				'tp_account_fk' 	=> ($this->input->post('postPurchaseMethod') == 'TF')? $this->input->post('postPurchaseAccount') : '',
				'tp_paid' 			=> $this->input->post('postPurchasePayment'),
			);
		
		  /** Prepare config tambahan */
			$config['upload_path']   = 'assets/uploaded_files/purchase_note/';
			$config['allowed_types'] = 'jpeg|jpg|png|pdf|doc|docx';
			$config['max_size']		 = '2048';
			$config['encrypt_name']  = TRUE;
			  
			$arrayFile = explode('.', $_FILES['postPurchaseNoteFile']['name']);
			$extension = end($arrayFile);
			$this->upload->initialize($config);

		  /** Upload proses dan Simpan file ke database */
			$upload = $this->upload->do_upload('postPurchaseNoteFile');
			if($upload){
				/** Uploaded file data */
				$uploadData = $this->upload->data();

				/** Set path ke postData */
				$postData['tp_note_file'] = $config['upload_path'].$uploadData['file_name'];

				$inputTP = $this->Purchases_m->insertPurchase($postData);
				if($inputTP['resultInsert'] > 0){
					/** Get data dari cart purchases */
					$tempPrd = $this->Purchases_m->selectCart();
					foreach ($tempPrd as $row) {
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

	/* Function : Proses pay installment trans pembelian */
	function installmentPurchasesProses($encoded_trans_id){
	  /* Load lib dan helper untuk upload */
		$this->load->helper('file');
		$this->load->library('upload');

	  /* Decode */
		$transId = base64_decode(urldecode($encoded_trans_id));

	  /* Get posted data */
	  	/* untuk disimpan ke table installment_purchase */
		$postData = array(
			'ip_trans_id_fk'  => $transId,
			'ip_periode' 	  => $this->input->post('postAngsuranAwal'),
			'ip_periode_end'  => ($this->input->post('postAngsuranAkhir') == '0')? $this->input->post('postAngsuranAkhir') : $this->input->post('postAngsuranAwal'),
			'ip_date' 		  => $this->input->post('postTglBayar'),
			'ip_payment' 	  => $this->input->post('postBayar'),
			'ip_invoice_code' => $this->input->post('postTransNota'),
			'ip_invoice_file' => NULL,
		);

		/* Untuk update data di table tb_purchase */
		if($this->input->post('postStatus') == 'L'){
			$updateData = array(
				'tp_due_date' => date('Y-m-d', strtotime('0000-00-00')),
				'tp_status'	  => 'L'
			);	
		} else if($this->input->post('postStatus') == 'BL'){
			$updateData = array(
				'tp_due_date' => $this->input->post('postNextTempo')
			);
		}

		if(!empty($_FILES['postTransFileNota']['name'])){
	  	  /* Prepare config tambahan */
            $config['upload_path']   = 'assets/imported_files/purchase_nota/installment/'; // Path folder untuk upload file
            $config['allowed_types'] = 'jpeg|jpg|png|pdf|doc|docx'; // Allowed types 
            $config['max_size']		 = '2048'; // Max size in KiloBytes
            $config['encrypt_name']  = TRUE; // Encrypt nama file ketika diupload

		  /* Get file format / file extention */
            $arrayFile = explode('.', $_FILES['postTransFileNota']['name']); //Ubah nama file menjadi array
            $extension = end($arrayFile); // Get ext dari array nama file, index terakhir array
            $this->upload->initialize($config);

          /* Upload proses dan Simpan file ke database */
            $upload = $this->upload->do_upload('postTransFileNota');
            if($upload){
              /* Get data upload file */
            	$uploadData = $this->upload->data();

              	/* Set path untuk simpan ke table installment_purchase */
            	$postData['ip_invoice_file'] = $config['upload_path'].$uploadData['file_name'];

            	/* Proses simpan ke table intallment_purchase */
            	$inputIP = $this->Installment_m->insertInstallmentPurchase($postData);

            	if($inputIP > 0){
	            	/* Proses update tempo_selanjutnya table tb_purchase */
	            	$updatePurchase = $this->Purchases_m->updateTransPurchase($updateData, $transId);
	            	if($updatePurchase > 0){
			  	  		$this->session->set_flashdata('flashStatus', 'successInsert');
			  	  		$this->session->set_flashdata('flashMsg', 'Berhasil menyimpan histori pembayaran angsuran !');
	            	} else {
			  	  		$this->session->set_flashdata('flashStatus', 'failedInsert');
			  	  		$this->session->set_flashdata('flashMsg', 'Gagal memperbarui tempo selanjutnya !');
		  	  		}
            	} else {
		  	  		$this->session->set_flashdata('flashStatus', 'failedInsert');
		  	  		$this->session->set_flashdata('flashMsg', 'Gagal menyimpan histori pembayaran angsuran !');
            	}
            } else {
	  	  		$this->session->set_flashdata('flashStatus', 'failedInsert');
	  	  		$this->session->set_flashdata('flashMsg', $this->upload->display_errors());
	  	  	}
		} else {
  	  		$this->session->set_flashdata('flashStatus', 'failedInsert');
  	  		$this->session->set_flashdata('flashMsg', 'File Nota Pembelian tidak boleh kosong !');
  	  	}

	  	/* Link redirect ke list Transaksi Purchase */
  	  	$this->session->set_flashdata('flashRedirect', 'Transaksi_c/detailPurchasesPage/'.$encoded_trans_id.'');

  	  	/* redirect ke page add purchase */
	  	redirect('Transaksi_c/payPurchasesInstallmentPage/'.$encoded_trans_id);
	}

	/** Function - Custom Form Validation */
	  /** Validation Supplier */
		function _validation_supplier($post){
			/** Load Model supplier untuk option supplier */
			$this->load->model('Supplier_m');

			if($this->Supplier_m->selectSupplierOnID(base64_decode(urldecode($post)))->num_rows() > 0){
				return TRUE;
			} else {
				return FALSE;
			}
		}

	  /** Validation : file */
		function _validation_file($post){
			/** Load lib dan helper */
			$this->load->helper('file');
			/** buat mime type : 
			$allowedMime = array('application/pdf','image/gif','image/jpeg','image/pjpeg','image/png','image/x-png') */
			$allowedExt	= array('pdf','jpeg', 'jpg', 'png');
			if($_FILES['postPurchaseNoteFile']['name']){
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
	
	  /** Validation : kredit */
		function _validation_kredit($post){
			if($this->input->post('postPurchaseStatus') == 'K'){
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
			if($this->input->post('postPurchaseStatus') == 'K'){
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

	  /** Validation : Account */
		function _validation_account($post){
			if($this->input->post('postPurchaseMethod') == 'TF'){
				if(trim($post, " ") != ''){
					$this->load->model('Account_m');
					if( $this->Account_m->selectAccountOnID(base64_decode(urldecode($post)))->num_rows() > 0 ){
						return TRUE;
					} else {
						$this->form_validation->set_message('_validation_account', 'Rekening tidak ditemukan');
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

  /* Fungsi untuk CRUD Penjualan */
	/* Function : Form tambah trans penjualan */
	public function addSalesPage(){
	  /* Load model customer untuk option customer */
	  	$this->load->model('Customer_m');

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
	  		'assets'	=> array('jqueryui', 'sweetalert2', 'datatables', 'page_add_trans', 'page_add_sales'), //, 'page_add_trans'
			'optRek'	=> $this->Rekening_m->getAllRekening(),
			'nextTransCode' => $nextTransCode,
			'daftarPrd' => $this->Sales_m->getTemp(),
			'optCtm'	=> $this->Customer_m->selectCustomer()->result_array()
	  	);
	  	$this->page = 'trans/add_trans_sales_v';
	  	$this->layout();
	}

	/* Function : List trans penjualan */
	public function listSalesPage(){
	  /* Data yang ditampilkan ke view */
		$this->pageData = array(
			'title' => 'PoS | Trans Penjualan',
			'assets' => array('datatables', 'page_list_trans'),
			'dataTrans' => $this->Sales_m->getAvailableTransSales()
		);
		$this->page = 'trans/list_trans_sales_v';
		$this->layout();
	}

	/* Function : Form detail penjualan */
	public function detailSalesPage($encoded_trans_id){
	  /* Decode id */
		$transSaleId = base64_decode(urldecode($encoded_trans_id));

	  /** Get data transaksi sales */
	  	$salesData = $this->Sales_m->getTransSalesonID($transSaleId);

	  /* Data yang ditampilkan ke view */
		$this->pageData = array(
			'title'		=> 'PoS | Trans Pembelian',
			'assets'	=> array('datatables', 'sweetalert2', 'alert'),
			'detailTrans' => $salesData,
			'detailPayment' => $this->Installment_m->getInstallmentSales($transSaleId),
			'detailReturn'	=> ($salesData[0]['ts_return'] == 'Y')? $this->Return_m->getReturnOnID($salesData[0]['ts_id']) : NULL
		);
		$this->page = 'trans/detail_trans_sales_v';
		$this->layout();
	}

	/* Function : Form bayar cicilan penjualan */
	public function paySalesInstallmentPage($encoded_trans_id){
	  /* Decode id */
		$transSaleId = base64_decode(urldecode($encoded_trans_id));

	  /* Data yang ditampilkan ke view */
		$this->pageData = array(
			'title'		=> 'PoS | Trans Pembelian',
			'assets'	=> array('datatables', 'sweetalert2', 'page_list_trans'),
			'paymentCode'	=> 'IS'.$transSaleId.date('Ydmhis'),
			'detailTrans'	=> $this->Sales_m->getTransSalesonID($transSaleId),
			'detailPayment' => $this->Installment_m->getInstallmentSales($transSaleId)
		);
		$this->page = 'trans/pay_installment_sales_v';
		$this->layout();
	}
	  
	/* Function : Receipt Page */
	public function receiptPage($encoded_trans_id){
	  /* Load Model Setting */
	  	$this->load->model('Profile_m');

	  /* Decode id */
		$transSaleId = base64_decode(urldecode($encoded_trans_id));
			
	  /* Data yang akan dikirim ke view */
		$this->pageData = array(
		  	'title' => 'PoS | Transaksi',
		  	'assets' =>array('receipt'),
			'detailTrans' => $this->Sales_m->getTransSalesonID($transSaleId),
			'dataProfile' => $this->Profile_m->getProfile(1)
	 	);

	  /* Load file view */
		$this->page = 'trans/receipt_v';

	  /* Call function layout dari my controller */
		$this->layout();
	}

	/* Function : Proses tambah trans penjualan */
	function addSalesProses(){
	  /* Load model customer_m */
	  	$this->load->model('Customer_m');

	  /* Inputan customer */
		if($this->input->post('postTransCtm') == 'nctm'){ // Jika nilai postCustomer == nctm, input customer baru
			/* get posted data customer baru */
			$ctmPost = array(
	      		'ctm_name'  => $this->input->post('postCtmNama'),
	      		'ctm_phone'  => $this->input->post('postCtmTelp'),
	      		'ctm_email' => $this->input->post('postCtmEmail'),
		        'ctm_address' => $this->input->post('postCtmAddress'),
		        'ctm_status' => 'Y'
			);
			$ctmID = $this->Customer_m->insertCustomer($ctmPost, 'id');
		} else if ($this->input->post('postTransCtm') == '0000'){
			$ctmID = $this->input->post('postTransCtm');
		} else {
			$ctmID = base64_decode(urldecode($this->input->post('postTransCtm')));
		}

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

	  /* Get posted data dari form */ 
		$postData = array(
			'ts_trans_code' => $nextTransCode,
			'ts_date'	  	=> $this->input->post('postTransTgl'),
			'ts_customer_fk' 	=> $ctmID,
			'ts_payment_metode' => $this->input->post('postTransMetode'),
			'ts_delivery_metode' => $this->input->post('postTransDelivery'),
			'ts_delivery_payment' => ($this->input->post('postTransDelivery') == 'N')? '0' : $this->input->post('postTransOngkir'),
			'ts_sales_price' 	=> $this->input->post('postTransTotalBayar'),
			'ts_account_fk' 	=> ($this->input->post('postTransMetode') == 'TF')? $this->input->post('postTransRek') : '',
			'ts_paid' 			=> $this->input->post('postTransPembayaran'),
			'ts_status' 		=> $this->input->post('postTransStatus'),
			'ts_tenor' 			=> ($this->input->post('postTransStatus') == 'K')? $this->input->post('postTransTenor') : '',
			'ts_tenor_periode' 	=> ($this->input->post('postTransStatus') == 'K')? $this->input->post('postTransTenorPeriode') : '',
			'ts_installment' 	=> ($this->input->post('postTransStatus') == 'K')? $this->input->post('postTransAngsuran') : '',
			'ts_due_date' 		=> ($this->input->post('postTransStatus') == 'K')? $this->input->post('postTransTempo') : '',
			'ts_inovice'		=> ($this->input->post('postTransStatus') == 'K')? 'Y' : ''
		);

	  /* Input data transaksi ke database */
		$inputTS = $this->Sales_m->insertTransSales($postData);

	  /* Cek proses insert, Set session dan redirect */
	  	if($inputTS['resultInsert'] > 0){ // Jika proses input transaksi berhasil 
			/** Get data dari temp table dan insert ke det trans purchase table */
				$tempPrd = $this->Sales_m->getTemp();
				foreach ($tempPrd as $row) {
					$dataDetail[] = array(
						'dts_ts_id_fk'		 => $inputTS['insertID'],
						'dts_product_fk'	 => $row['temps_product_fk'],
						'dts_product_amount' => $row['temps_product_amount'],
						'dts_sale_price' 	 => $row['temps_sale_price'],
						'dts_discount'	 	 => $row['temps_discount'],
						'dts_total_price'	 => $row['temps_total_paid']
					); 
				}

			/** Input detail */
				$inputDetTS = $this->Sales_m->insertBatchDetTS($dataDetail);
			
			/* Proses insert angsuran */
				if ($this->input->post('postTransStatus') == 'K'){
					/* Get angsuran pertama */
					$stDueDate	= date('Y-m-d', strtotime($postData['ts_due_date']));
					$stYear 	= date('Y', strtotime($postData['ts_due_date']));
					$stMonth	= date('m', strtotime($postData['ts_due_date']));
					$stDate		= date('d', strtotime($postData['ts_due_date']));

					/* check periode tenor. D = Daily/Harian, W = Weekly/Mingguan, M = Monthly/Bulanan, Y = Annual/Tahunan */
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
				}

			/* Input data angsurang ke database */
		  		if ($this->input->post('postTransStatus') == 'K'){
		  			$inputIS = $this->Installment_m->insertInstallmentSales($installmentData);
				}
			
			/** Check proses insert */
				if($inputDetTS > 0){
					/** hapus data di table temp */
					$this->Sales_m->truncateTemp();

					/** Set flash session */
					$this->session->set_flashdata('flashStatus', 'successInsert');
					$this->session->set_flashdata('flashMsg', 'Berhasil menambahkan transaksi penjualan !');
				} else {
					/** Batalkan data penjualan yang disimpan (Hapus) */
					$this->Sales_m->deleteTransSales($inputTS['insertID']);

					/** Set flash session */
					$this->session->set_flashdata('flashStatus', 'failedInsert');
					$this->session->set_flashdata('flashMsg', 'Gagal menambahkan transaksi penjualan !');
				}
	  	} else { // Jika proses input transaksi gagal
	  		/* Hapus pelanggan yang ditambahkan */
	  		if($this->input->post('postTransCtm') == 'nctm'){
	  			$this->Customer_m->deleteCustomer($ctmID);
	  		}
	  		
  	  		$this->session->set_flashdata('flashStatus', 'failedInsert');
  	  		$this->session->set_flashdata('flashMsg', 'Gagal menambahkan transaksi penjualan !');
	  	}
		
		$this->session->set_flashdata('flashRedirect', 'Transaksi_c/listSalesPage');
		redirect('Transaksi_c/addSalesPage');
	}

	/* Function : Proses pay installment trans penjualan */
	function installmentSalesProses($encoded_trans_id){
	  /* Decode id */
		$transSaleId = base64_decode(urldecode($encoded_trans_id));

	  /* Get post data form */
		$postData = array(
			'post_code' => $this->input->post('postPayCode'),
			'post_periode' => $this->input->post('postAngsuranAwal'),
			'post_periode_end' => ($this->input->post('postAngsuranAkhir') != 0)? $this->input->post('postAngsuranAkhir') : $this->input->post('postAngsuranAwal'),
			'post_payment_date' => $this->input->post('postTglBayar'),
			'post_payment' => $this->input->post('postBayar'),
		);

	  /* Update data angsuran */
		for($i = $postData['post_periode']; $i <= $postData['post_periode_end']; $i++ ){
			$updateData[$i]['is_code']	= $postData['post_code'];
			$updateData[$i]['is_payment'] = $postData['post_payment'];
			$updateData[$i]['is_payment_date'] = $postData['post_payment_date'];
			$updateData[$i]['is_status']	= 1;
			
			$updateIS[$i] = $this->Installment_m->updateInstallmentSales($updateData[$i], $i, $transSaleId);
		}

	  /* Set session dan redirect */
		if(count($updateIS) == count(range($postData['post_periode'], $postData['post_periode_end']))){
			$this->session->set_flashdata('flashStatus', 'successInsert');
			$this->session->set_flashdata('flashMsg', 'Berhasil melakukan proses pembayaran angsuran !');
		} else {
			$this->session->set_flashdata('flashStatus', 'failedInsert');
			$this->session->set_flashdata('flashMsg', 'Gagal melakukan proses pembayaran angsuran !');
		}

	  	/* Link redirect ke list Transaksi Sales */
  	  	$this->session->set_flashdata('flashRedirect', 'Transaksi_c/detailSalesPage/'.$encoded_trans_id.'');

  	  	/* redirect ke page add sales */
	  	redirect('Transaksi_c/paySalesInstallmentPage/'.$encoded_trans_id);

	}

	/** Function : Proses delete trans penjualan */

  /* Fungsi untuk CRUD Pengeluaran Lainnya */
  	/* Function : Page add pengeluaran lainnya */
  	public function addExpensePage(){
  	  /* Load Model pengeluaran / expense */
  	  	$this->load->model('Expense_m');

	  /* Data yang ditampilkan ke view */
		$this->pageData = array(
			'title'   => 'PoS | Trans Pengeluaran',
			'assets'  => array('jqueryui', 'custominput', 'sweetalert2', 'page_add_trans'),
			'optRek'  => $this->Rekening_m->getAllRekening(),
			//'nextTransCode' => $nextTransCode
		);
		$this->page = 'trans/add_expense_v';
		$this->layout();
	}

  	/* Function : Page list pengeluaran lainnya */
  	public function listExpensePage(){
  	  /* Load Model pengeluaran / expense */
  	  	$this->load->model('Expense_m');

	  /* Data yang ditampilkan ke view */
		$this->pageData = array(
			'title'   => 'PoS | Trans Pengeluaran',
			'assets'  => array('datatables'),
			'dataTrans' => $this->Expense_m->getExpense()
		);
		$this->page = 'trans/list_expense_v';
		$this->layout();
	}

  	/* Function : proses add pengeluaran lainnya */
  	function addExpenseProses(){
  	  /* Load Model pengeluaran / expense */
  	  	$this->load->model('Expense_m');

  		/* Post data dari form */
  		$postData = array(
  			'te_date' 			=> $this->input->post('postTransTgl'),
  			'te_necessity'		=> $this->input->post('postTransKeperluan'),
  			'te_payment_method' => $this->input->post('postTransMetode'),
  			'te_payment'		=> $this->input->post('postTransTotalBayar'),
  			'te_note' 			=> $this->input->post('postTransNote'),
  			'te_account_id_fk'	=> ($this->input->post('postTransMetode') == "TF")? $this->input->post('postTransRek') : NULL,
  			'te_invoice' 		=> NULL,
  		);

  		if (!empty($_FILES['postTransFileNota']['name'])){
		  /* Load lib dan helper untuk upload */
			$this->load->helper('file');
			$this->load->library('upload');

	  	  /* Prepare config tambahan */
            $config['upload_path']   = 'assets/imported_files/expense_nota/'; // Path folder untuk upload file
            $config['allowed_types'] = 'jpeg|jpg|png|pdf|doc|docx'; // Allowed types 
            $config['max_size']		 = '2048'; // Max size in KiloBytes
            $config['encrypt_name']  = TRUE; // Encrypt nama file ketika diupload

		  /* Get file format / file extention */
            $arrayFile = explode('.', $_FILES['postTransFileNota']['name']); //Ubah nama file menjadi array
            $extension = end($arrayFile); // Get ext dari array nama file, index terakhir array
            $this->upload->initialize($config);

          /* Upload proses dan Simpan file ke database */
            $upload = $this->upload->do_upload('postTransFileNota');

            if($upload){
              	/* Get data upload file */
            	$uploadData = $this->upload->data();

              	/* Set path untuk simpan ke table installment_purchase */
            	$postData['te_invoice'] = $config['upload_path'].$uploadData['file_name'];
            } else {
            	$uploadError = 'Yes';
            	$uploadMsg	 = $this->upload->display_errors();
	  	  	}
  		}

  		/* Proses Insert */
  		if(isset($uploadError) && $uploadError == 'Yes') {
  			$this->session->set_flashdata('flashStatus', 'failedInsert');
	  	  	$this->session->set_flashdata('flashMsg', $uploadMsg);
  		} else {
  			/* Insert ke database */
  			$inputExpense = $this->Expense_m->insertExpense($postData);

  			if($inputExpense > 0){
	  			$this->session->set_flashdata('flashStatus', 'successInsert');
		  	  	$this->session->set_flashdata('flashMsg', 'Berhasil menambahkan data transaksi pengeluaran');
  			} else {
	  			$this->session->set_flashdata('flashStatus', 'successInsert');
		  	  	$this->session->set_flashdata('flashMsg', 'Berhasil menambahkan data transaksi pengeluaran');
		  	  	if ($postData['te_invoice'] != NULL){ unlink(base_url().$postData['te_invoice']); };
  			}
  		}

	  	/* Link redirect ke list Transaksi Purchase */
  	  	$this->session->set_flashdata('flashRedirect', 'Transaksi_c/listExpensePage');

  	  	/* redirect ke page add purchase */
	  	redirect('Transaksi_c/addExpensePage');

  		//print("<pre>".print_r($postData, true)."</pre>");
  	}

  /* Fungsi untuk CRUD Pemasukan Lainnya */
  	/* Function : Page add Pemasukan lainnua */
  	public function addRevenuesPage(){
  	  /* Load Model pengeluaran / expense */
  	  	$this->load->model('Revenues_m');

  	  /* Set next code */
  	  	$nextAI = $this->Revenues_m->getNextIncrement();
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
	  	$nextTransCode = 'TR'.date('Ymd').$nol.$nextAI['0']['AUTO_INCREMENT'];

	  /* Data yang ditampilkan ke view */
		$this->pageData = array(
			'title'   => 'PoS | Trans Pengeluaran',
			'assets'  => array('sweetalert2', 'page_add_trans'),
			'optRek'  => $this->Rekening_m->getAllRekening(),
			'nextTransCode' => $nextTransCode
		);
		$this->page = 'trans/add_revenues_v';
		$this->layout();
	}

  	/* Function : Page list Pemasukan lainnua */
  	public function listRevenuesPage(){
  	  /* Load Model pengeluaran / expense */
  	  	$this->load->model('Revenues_m');

	  /* Data yang ditampilkan ke view */
		$this->pageData = array(
			'title'   => 'PoS | Trans Pendapatan',
			'assets'  => array('datatables'),
			'dataTrans' => $this->Revenues_m->getRevenues()
		);
		$this->page = 'trans/list_revenues_v';
		$this->layout();
	}

  	/* Function : Proses add Pemasukan lainnya */
  	function addRevenuesProses(){
  	  /* Load Model pengeluaran / expense */
  	  	$this->load->model('Revenues_m');

  	  /* Post data dari form */
  	  	$postData = array(
  	  		'tr_trans_code'		=> $this->input->post('postTransKode'),
  	  		'tr_source' 		=> $this->input->post('postTransSumber'),
  	  		'tr_date' 			=> $this->input->post('postTransTgl'),
  	  		'tr_payment_method' => $this->input->post('postTransMetode'),
  	  		'tr_account_id_fk'  => ($this->input->post('postTransMetode') == "TF")? $this->input->post('postTransRek') : NULL,
  	  		'tr_payment'		=> $this->input->post('postTransTotalBayar'),
  	  		'tr_note' 			=> $this->input->post('postTransNote')
  	  	);

  	  /* Input Revenue */
  	  	$inputTR = $this->Revenues_m->insertRevenues($postData);

  	  /* Set session & redirect */
  	  	if($inputTR > 0){
			$this->session->set_flashdata('flashStatus', 'successInsert');
			$this->session->set_flashdata('flashMsg', 'Berhasil menambahkan data transaksi pendapatan lainnya !');
  	  	} else {
			$this->session->set_flashdata('flashStatus', 'failedInsert');
			$this->session->set_flashdata('flashMsg', 'Gagal menambahkan data transaksi pendapatan lainnya !');
  	  	}

	  /* Link redirect ke list Transaksi Purchase */
  	  	$this->session->set_flashdata('flashRedirect', 'Transaksi_c/listRevenuesPage');

  	  /* redirect ke page add purchase */
	  	redirect('Transaksi_c/addRevenuesPage');
  	}
	  
  /** Fungsi untuk CRUD Return */
	/** Function : Page return penjualan */
	public function returnSalesPage($encoded_trans_id){
		/* Decode id */
		  $transSaleId = base64_decode(urldecode($encoded_trans_id));
  
		/* Data yang ditampilkan ke view */
		  $this->pageData = array(
			  'title'		=> 'PoS | Trans Pembelian',
			  'assets'	=> array('datatables', 'sweetalert2', 'page_list_trans'),
			  'detailTrans' => $this->Sales_m->getTransSalesonID($transSaleId),
			  'detailPayment' => $this->Installment_m->getInstallmentSales($transSaleId)
		  );
		  $this->page = 'trans/sales/return_sales_v';
		  $this->layout();
	}

	/** Function : Page daftar return customer */
	public function listReturnSales(){
		$this->pageData = array(
			'title'		=> 'Retur | Sistem PoS',
			'assets'	=> array('datatable'),
			'dataReturn' => $this->Return_m->getAllRC()
		);

		$this->page = 'trans/sales/list_return_sales_v';
		$this->layout();
	}

	/** Function : Proses return penjualan */
	function returnSalesProses(){
		/** Get semua prd id */
		$id = $this->input->post('post_prd[]');

		/** Get post data dari form */
		$dataPost = array(
			'ts_id_fk' 	=> base64_decode(urldecode($this->input->post('returnSalesID'))), 
			'rc_date'	=> $this->input->post('returnDate'),
			'rc_paid'	=> $this->input->post('returnPayment'),
			'rc_note'	=> $this->input->post('returnNote')
		);
		
		/** Cek product yang di return */
		foreach ($id as $row){
			if ($this->input->post('returnQty-'.$row) > 0 || $this->input->post('returnQty-'.$row) != ''){
				$arrayPrd[] = array(
					'rc_id_fk'		=> NULL,
					'prd_id_fk'		=> base64_decode(urldecode($row)),
					'drc_qty'		=> $this->input->post('returnQty-'.$row), 
					'drc_status'	=> $this->input->post('returnStatus-'.$row)
				);
			}
		}

		/** Proses input data retur */
			/** Cek inputan return product. Jika produk sudah diinput */
			if (isset($arrayPrd) || $arrayPrd != null){
				$inputReturn = $this->Return_m->insertRC($dataPost);

				/** Input detail return product */
				if ($inputReturn['resultInsert'] > 0){
					for($i = 0; $i < count($arrayPrd); $i++){
						$arrayPrd[$i]['rc_id_fk'] = $inputReturn['insertID'];
					}

					/** Set field ts_retur = Y, sebagai penanda bahwa sudah pernah return */
					$returnData = array('ts_return' => 'Y');
					$updateTS 	= $this->Sales_m->updateTransSales(base64_decode(urldecode($this->input->post('returnSalesID'))), $returnData);

					/** Input detail product */
					$inputPrd = $this->Return_m->insertDetailRC($arrayPrd);

					if($inputPrd > 0 && $updateTS > 0) {
						$this->session->set_flashdata('flashStatus', 'success');
						$this->session->set_flashdata('flashMsg', 'Berhasil menambahkan transaksi retur !');
					}
				}
			} else {
				$this->session->set_flashdata('flashStatus', 'failed');
				$this->session->set_flashdata('flashMsg', 'Gagal menambahkan transaksi retur !');
			}
		
		redirect('Transaksi_c/detailSalesPage/'.$this->input->post('returnSalesID'));
		//print("<pre>".print_r($arrayPrd, true)."</pre>");
	}

}