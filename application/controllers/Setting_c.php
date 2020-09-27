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

}