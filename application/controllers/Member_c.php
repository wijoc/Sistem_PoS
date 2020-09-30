<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Member_c extends MY_Controller{

  	public function __construct(){
  		parent::__construct();
  		$this->load->model('Member_m');
  	}

    /* Fuction : List member */
    public function index(){
    	/* Proses tampil halaman */
    	$this->pageData = array(
    		'title' => 'PoS | Member',
      'assets' => array('sweetalert2', 'page_contact'),
    		'dataMember' => $this->Member_m->getAllMember()
    	);
    	$this->page = "contact/list_member_v";
    	$this->layout();
    }

    /* Function : Input member proses */
    function addMemberProses(){
      /* Get data post dari form */
      	$postData = array(
      		'member_nama' => $this->input->post('postMemberNama'),
      		'member_status'   => $this->input->post('postMemberStatus'),
      		'member_discount'  => $this->input->post('postMemberDiscount')
      	);

      /* Insert ke database */
      	$inputMbr = $this->Member_m->insertMember($postData);

      /* Set session dan redirect */
      	if($inputMbr > 0){
  	  		$this->session->set_flashdata('flashStatus', 'successInsert');
  	  		$this->session->set_flashdata('flashMsg', 'Berhasil menambahkan member !');
  	  	} else {
  	  		$this->session->set_flashdata('flashStatus', 'failedInsert');
  	  		$this->session->set_flashdata('flashMsg', 'Gagal menambahkan member !');
  	  	}

		  redirect('Member_c');
    }

    /* Function : Delete member */
    function delMember($id){
      /* Decode id */
    	$mbrID = base64_decode(urldecode($id));

      /* Delete dari database */
      	$delMbr = $this->Member_m->deleteMember($mbrID);

      /* Set session & redirect */
      	if($delMbr > 0){
  	  		$this->session->set_flashdata('flashStatus', 'successDelete');
  	  		$this->session->set_flashdata('flashMsg', 'Berhasil menghapus member !');
  	  	} else {
  	  		$this->session->set_flashdata('flashStatus', 'failedDelete');
  	  		$this->session->set_flashdata('flashMsg', 'Gagal menghapus member !');
  	  	}

  		redirect('Member_c');
    }

}