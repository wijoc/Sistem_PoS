<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Member_c extends MY_Controller{

  	public function __construct(){
  		parent::__construct();
  		$this->load->model('Member_m');
  	}

    /* Fuction : List member */
    public function index(){
      /* Load Library */
      $this->load->library('pagination'); // Lib pagination

      /* Konfigurasi tambahan untuk pagination */
      $config['base_url']   = site_url('Member_c/index');
      $config['total_rows'] = $this->Member_m->getAllowedMember(0, 0)->num_rows(); // limit (param1), offset (param2)
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

    	/* Proses tampil halaman */
    	$this->pageData = array(
    		'title' => 'PoS | Member',
        'assets' => array('sweetalert2', 'f_confirm', 'page_contact'),
    		'dataMember' => $this->Member_m->getAllowedMember($config['per_page'], $startfrom)->result_array()
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
    function deleteMember($deltype){
      /* Decode id */
        $mbrID = base64_decode(urldecode($this->input->post('postID')));

      /* Delete dari database */
        if($deltype === 'hard'){
         $delMbr = $this->Member_m->deleteMember($mbrID);
        } else if ($deltype === 'soft'){
         $delMbr = $this->Member_m->softdeleteMember($mbrID);
        }

      /* Set return value */
        if($delMbr > 0){
          echo 'successDelete';
        } else {
          echo 'failedDelete';
        }
    }

}