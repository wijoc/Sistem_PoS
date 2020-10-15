<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Supplier_c extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('Supplier_m');
	}

  /* Fuction : List supplier */
  public function index(){
    /* Data yang akan dikirim ke view */
    $this->pageData = array(
    	'title' => 'PoS | Supplier',
    	'assets' => array('sweetalert2', 'f_confirm', 'page_contact'),
    	'dataSupplier' => $this->Supplier_m->getAllowedSupplier()
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