<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Setting_c extends MY_Controller{

	public function __construct(){
		parent::__construct();
	}

	public function index(){
	  /* Data yang akan dikirim ke view */
		$this->pageData = array(
			'title'  => 'PoS | Pengaturan',
			'assets' => array()
		); 

      /* View file */
        $this->page = "setting/index_setting_v";

      /* Call function layout dari MY_Controller Class */
        $this->layout();
	}

  /* Functions Management User */
  /** CRUD Rekening Bank */
  	/** Function : List account */
  	public function listAccountPage(){
  		$this->load->model('Account_m');

      /* Data untuk view */
  		$this->pageData = array(
  			'title' => 'PoS | Rekening',
  			'assets' => array('sweetalert2', 'datatables', 'p_setting'),
        'optBank' => $this->Account_m->selectBank(),
        'ajaxUrl' => site_url('Setting_c/listAccountAjax/')
  		);
  		$this->page = 'setting/stg_account_v';
  		$this->layout();
  	} 

  	/** Function : Ajax list account */
    function listAccountAjax(){
  		/* Load model rekening */
  		$this->load->model('Account_m');
      $getData	= $this->Account_m->selectAccount($this->input->post('length'), $this->input->post('start'));
      $accData	= array();
      $no			  = $this->input->post('start');
      foreach($getData->result_array() as $show){
        $no++;
        $row = array();
        $row[] = $no;
        $row[] = $show['bank_name'];
        $row[] = $show['acc_number'];
        $row[] = $show['acc_name'];
        $row[] = '<a class="btn btn-xs btn-warning"><i class="fas fa-edit"></i></a>
                  <a class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></a>';
      
        $accData[] = $row;
      }

      $output = array(
        'draw'			  => $this->input->post('draw'),
        'recordsTotal'	  => $this->Account_m->count_all(),
        'recordsFiltered' => $this->Account_m->count_filtered($this->input->post('length'), $this->input->post('start')),
        'data'			  => $accData
      );

      echo json_encode($output);
    }

  	/* Function : Add account proses */
    function addAccountProses(){
      $this->load->model('Account_m');
      $this->load->library('form_validation');

      /** Set rules form validation */
      $config = array(
        array(
          'field'  => 'postAccBank',
          'label'  => 'Kode bank',
          'rules'  => 'trim|required|callback__validation_bank',
          'errors'  => array(
            'required'	=> 'Bank tidak boleh kosong'
          )
        ),
        array(
          'field'  => 'postAccountName',
          'label'  => 'Atas nama Rekening',
          'rules'  => 'trim|required',
          'errors'  => array(
            'required'	=> 'Atas nama tidak boleh kosong'
          )
        ),
        array(
          'field'  => 'postAccNumber',
          'label'  => 'Nomor Rekening',
          'rules'  => 'trim|required|numeric',
          'errors'  => array(
            'required' => 'Nomor rekening tidak boleh kosong',
            'numeric'  => 'Nomor rekening tidak valid'
          )
        )
      );
      
      $this->form_validation->set_rules($config);
  
      if($this->form_validation->run() == FALSE) {
        $arrReturn = array(
          'error' => TRUE,
          'errorBank' => form_error('postAccBank'),
          'errorName' => form_error('postAccountName'),
          'errorNumber' => form_error('postAccNumber')
        );
      } else {
        $inputAcc = $this->Account_m->insertAccount();
  
        /** Return value */
          if($inputAcc > 0){
            $arrReturn = array(
              'success' => TRUE,
              'status'  => 'successInsert',
              'statusIcon' => 'success',
              'statusMsg' => 'Berhasil menambahkan data rekening' 
            );
          } else {
            $arrReturn = array(
              'success' => TRUE,
              'status'  => 'failedInsert',
              'statusIcon' => 'error',
              'statusMsg' => 'Gagal menambahkan data rekening' 
            );
          }
        }

      header('Content-Type: application/json');
      echo json_encode($arrReturn);
    }
  	
    /* Function : Proses edit rekening */
  	/* Function : Proses delete rekening */
    /** Function : Custom Validation */
      /** Function : Validation Bank */
      function _validation_bank($post){
        if(trim($post, " ") != ''){
          if($this->Account_m->selectBankOnID(base64_decode(urldecode($post)))->num_rows() > 0){
            return TRUE;
          } else {
            $this->form_validation->set_message('_validation_bank', 'Kode bank tidak ditemukan');
            return FALSE;
          }
        } else {
          $this->form_validation->set_message('_validation_bank', 'Silahkan pilih bank');
          return FALSE;
        }
      }

  /* Functions Management Profil Toko */
    /* Function : management profil toko */
    public function settingProfile(){
      /* Load model Profile */
      $this->load->model('Profile_m');

      /* Data untuk view */
      $this->pageData = array(
        'title'   => 'PoS | Profile',
        'assets'  => array('sweetalert2', 'custominput', 'page_profile'),
        'dataProfile'   => $this->Profile_m->getProfile(1)
      );
      $this->page = 'setting/stg_profile_v';
      $this->layout();
    }

    /* Function proses edit profile */
    function editProfileProses($encoded_pfl_id){
      /* Decode id */
        $pflID = base64_decode(urldecode($encoded_pfl_id));

      /* post data dari form */
        // $this->input->post('postPflOldLogo'); // Untuk logo saat ini / sebelum diganti
        $postData = array(
          'pfl_name' => $this->input->post('postPflName'),
          'pfl_telp' => $this->input->post('postPflTelp'),
          'pfl_fax'  => $this->input->post('postPflFax'),
          'pfl_email' => $this->input->post('postPflEmail'),
          'pfl_address' => $this->input->post('postPflAddress'),
        );

      /* Proses Update */
        if(empty($_FILES['postPflLogo']['name'])){
          $updateProfile = $this->Profile_m->updateProfile($postData, $pflID);
        } else {
          /* Load lib dan helper untuk upload */
            $this->load->helper('file');
            $this->load->library('upload');

          /* Prepare config tambahan */
            $config['upload_path']   = 'assets/dist/img/'; // Path folder untuk upload file
            $config['allowed_types'] = 'jpeg|jpg|png|bmp|svg'; // Allowed types 
            $config['max_size']    = '2048'; // Max size in KiloBytes
            $config['encrypt_name']  = TRUE; // Encrypt nama file ketika diupload
            $this->upload->initialize($config); /* initialize config

          /* Upload proses dan Simpan file ke database */
            $upload = $this->upload->do_upload('postPflLogo');

            if($upload){
              /* Get data upload file */
              $uploadData = $this->upload->data();

              /* Delete last logo */
              unlink($this->input->post('postPflOldLogo'));

              /* Set new update logo */
              $postData['pfl_logo'] = $config['upload_path'].$uploadData['file_name']; // Logo Baru / Pengganti
              $updateProfile = $this->Profile_m->updateProfile($postData, $pflID);
            } else {
              $this->session->set_flashdata('flashStatus', 'failedInsert');
              $this->session->set_flashdata('flashMsg', $this->upload->display_errors());
            }
        }

        /* Set Session and redirect */
        if($updateProfile > 0){
          $this->session->set_flashdata('flashStatus', 'successUpdate');
          $this->session->set_flashdata('flashMsg', 'Berhasil mengubah profile toko !');
        } else {
          $this->session->set_flashdata('flashStatus', 'failedUpdate');
          $this->session->set_flashdata('flashMsg', 'Gagal mengubah profile toko !');
        }

        /* redirect ke page add purchase */
        redirect('Setting_c/settingProfile');
    }

}