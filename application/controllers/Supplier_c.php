<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Supplier_c extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('Supplier_m');
	}

  /* Fuction : List supplier */
  public function index(){
    /* Load Library */
    $this->load->library('pagination'); // Lib pagination

    /* Konfigurasi tambahan untuk pagination */
    $config['base_url']   = site_url('Supplier_c/index');
    $config['total_rows'] = $this->Supplier_m->getAllowedSupplier(0, 0)->num_rows(); // limit (param1), offset (param2)
    $config['per_page']         = 9;
    $config['full_tag_open']    = '<ul class="pagination justify-content-center m-0">';
    $config['full_tag_close']   = '</ul>';
    $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
    $config['num_tag_close']    = '</span></li>';
    $config['cur_tag_open']     = '<li class="page-item active"><a class="page-link" href="#">';
    $config['cur_tag_close']    = '</a></li>';
    $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['prev_tag_close']   = '</span></li>';
    $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['next_tag_close']   = '</span></li>';
    $config['prev_link']        = '<i class="fas fa-backward"></i>';
    $config['next_link']        = '<i class="fas fa-forward"></i>';
    $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['last_tag_close']   = '</span></li>';
    $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
    $config['first_tag_close']  = '</span></li>';
    $startfrom = $this->uri->segment(3);
    $this->pagination->initialize($config);

    /* Data yang akan dikirim ke view */
    $this->pageData = array(
      'title' => 'PoS | Supplier',
      'assets' => array('sweetalert2', 'f_confirm', 'page_contact'),
      'dataSupplier' => $this->Supplier_m->getAllowedSupplier($config['per_page'], $startfrom)->result_array()
    );

    /* View file */
    $this->page = "contact/list_supplier_v";

    /* Call function layout dari MY_Controller Class */
    $this->layout();
  }

  /* Function : Input supplier proses */
  function addSupplierProses(){
    /* Get data post dari form */
      $postData = array(
    		'supp_name' => $this->input->post('postSuppNama'),
    		'supp_contact_name'   => $this->input->post('postSuppKontak'),
    		'supp_email'  => $this->input->post('postSuppEmail'),
    		'supp_telp'   => $this->input->post('postSuppTelp'),
    		'supp_address' => $this->input->post('postSuppAlamat'),
      );

    /* Insert ke database */
      $inputSupp = $this->Supplier_m->insertSupplier($postData);

    /* Set session dan redirect */
      if($inputSupp > 0){
	  		$this->session->set_flashdata('flashStatus', 'successInsert');
	  		$this->session->set_flashdata('flashMsg', 'Berhasil menambahkan kontak Supplier !');
	  	} else {
	  		$this->session->set_flashdata('flashStatus', 'failedInsert');
	  		$this->session->set_flashdata('flashMsg', 'Gagal menambahkan kontak Supplier !');
	  	}

		  redirect('Supplier_c');
  }

  /* Function : Delete supplier */
  function deleteSupplier($deltype){
    /* Decode id */
      $suppID = base64_decode(urldecode($this->input->post('postID')));

    /* Delete dari database */
      if($deltype === 'soft'){
        $delSupp = $this->Supplier_m->softdeleteSupplier($suppID);
      } else if ($deltype === 'hard'){
        $delSupp = $this->Supplier_m->deleteSupplier($suppID);
      }

    /* Set session & redirect */
      if($delSupp > 0){
        echo 'successDelete';
      } else {
        echo 'failedDelete';
      }
  }

}