<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Setting_c extends MY_Controller{

	public function __construct(){
		parent::__construct();
    $this->load->model('Setting_m');
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
  /* Functions Management Rekening Bank */
  	/* Function : List rekening */
  	public function listRekeningPage(){
  		/* Load model rekening */
  		$this->load->model('Rekening_m');

      /* Data untuk view */
  		$this->pageData = array(
  			'title' => 'PoS | Rekening',
  			'assets' => array(),
  			'dataRekening' => $this->Rekening_m->getALlRekening(),
        'optBank' => $this->Rekening_m->getAllBank(),
  		);
  		$this->page = 'rekening/list_rekening_v';
  		$this->layout();
  	} 

  	/* Function : Form edit rekening */
  	/* Function : Proses tambah rekening */
    function addRekeningProses(){
      /* Load model rekening */
      $this->load->model('Rekening_m');

      /* Get data post dari form */
        $postData = array(
          'rek_kode_bank' => $this->input->post('postRekBank'),
          'rek_atas_nama' => $this->input->post('postRekAN'),
          'rek_nomor' => $this->input->post('postRekNomor')
        );

      /* Insert ke database */
        $inputRek = $this->Rekening_m->insertRekening($postData);

      /* Set session dan Redirect */
        if($inputRek > 0){
          $this->session->set_flashdata('flashStatus', 'successInsert');
          $this->session->set_flashdata('flashMsg', 'Berhasil menambahkan rekening baru !');
        } else {
          $this->session->set_flashdata('flashStatus', 'failedInsert');
          $this->session->set_flashdata('flashMsg', 'Gagal menambahkan rekening baru !');
        }

        redirect('Setting_c/listRekeningPage');
    }
  	
    /* Function : Proses edit rekening */
  	/* Function : Proses delete rekening */

  /* Functions Management Profil Toko */
    /* Function : management profil toko */
    public function settingProfile(){
      /* Load model setting */
      $this->load->model("Setting_m");

      /* Data untuk view */
      $this->pageData = array(
        'title'   => 'PoS | Profile',
        'assets'  => array('sweetalert2', 'custominput', 'page_profile'),
        'dataProfile'   => $this->Setting_m->getProfile(1)
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
          $updateProfile = $this->Setting_m->updateProfile($postData, $pflID);
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
              $updateProfile = $this->Setting_m->updateProfile($postData, $pflID);
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