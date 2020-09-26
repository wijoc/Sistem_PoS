<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Supplier_c extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('Supplier_m');
	}

	public function index(){
	  /* Data yang akan dikirim ke view */
		$this->pageData = array(
			'title'  => 'PoS | Supplier',
			'assets' => array()
		); 

      /* View file */
        $this->page = "contact/index_supplier_v";

      /* Call function layout dari MY_Controller Class */
        $this->layout();
	}

    /* Fuction : List supplier */
    public function listSupplierPage(){
    	/* Proses tampil halaman */
    	$this->pageData = array(
    		'title' => 'PoS | Supplier',
    		'assets' => array(),
    		'dataSupplier' => $this->Supplier_m->getAllSupplier()
    	);
    	$this->page = "contact/list_supplier_v";
    	$this->layout();
    }

    /* Function : input Supplier */
    function addSupplierProses(){
      /* Get data post dari form */
      	$postData = array(
      		'supp_nama_supplier' => $this->input->post('postSuppNama'),
      		'supp_nama_kontak'   => $this->input->post('postSuppKontak'),
      		'supp_email'  => $this->input->post('postSuppEmail'),
      		'supp_telp'   => $this->input->post('postSuppTelp'),
      		'supp_alamat' => $this->input->post('postSuppAlamat'),
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

		redirect('Supplier_c/listSupplierPage');
    }

}