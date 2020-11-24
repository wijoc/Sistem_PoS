<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Customer_c extends MY_Controller{

  	public function __construct(){
  		parent::__construct();
  		$this->load->model('Customer_m');
  	}

    /* Fuction : List member */
    public function index(){
      /* Load Library */
      $this->load->library('pagination'); // Lib pagination

      /* Konfigurasi tambahan untuk pagination */
      $config['base_url']   = site_url('Customer_c/index');
      $config['total_rows'] = $this->Customer_m->getAllowedCustomer(0, 0)->num_rows(); // limit (param1), offset (param2)
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
    		'title' => 'PoS | Pelanggan',
        'assets' => array('sweetalert2', 'f_confirm', 'page_contact'),
    		'dataCtm' => $this->Customer_m->getAllowedCustomer($config['per_page'], $startfrom)->result_array()
    	);
    	$this->page = "contact/list_customer_v";
    	$this->layout();
    }

    /* Function : Input member proses */
    function addCustomerProses(){
      /* Get data post dari form */
      	$postData = array(
      		'ctm_name'  => $this->input->post('postPlgNama'),
      		'ctm_phone'  => $this->input->post('postPlgTelp'),
      		'ctm_email' => $this->input->post('postPlgEmail'),
          'ctm_address' => $this->input->post('postPlgAddress'),
          'ctm_discount_type' => $this->input->post('postPlgDiscountType'),
          'ctm_discount_price' => ($this->input->post('postPlgDiscountType') == 'ptg')? $this->input->post('postPlgDiscount') : NULL,
          'ctm_discount_percent' => ($this->input->post('postPlgDiscountType') == 'prc')? $this->input->post('postPlgDiscount') : NULL,
          'ctm_status' => 'Y'
      	);

      /* Insert ke database */
        $inputMbr = $this->Customer_m->insertCustomer($postData);

      /* Set session dan redirect */
        if($inputMbr > 0){
          $this->session->set_flashdata('flashStatus', 'successInsert');
          $this->session->set_flashdata('flashMsg', 'Berhasil menambahkan data pelanggan !');
        } else {
          $this->session->set_flashdata('flashStatus', 'failedInsert');
          $this->session->set_flashdata('flashMsg', 'Gagal menambahkan data pelanggan !');
        }

      redirect('Customer_c');
    }

    /* Function : get member berdasar member id */
    function getMember(){
      $memberID = base64_decode(urldecode($this->input->post('id')));

      $memberData = $this->Customer_m->getMemberOnID($memberID);
      $returnData = array(
        'edit_id'      => $this->input->post('id'),
        'edit_name'    => $memberData[0]['member_name'],
        'edit_status'  => $memberData[0]['member_status'],
        'edit_discount' => $memberData[0]['member_discount']
      );

      echo json_encode($returnData);
    }

    /* Function : Proses Edit member */
    function editMemberProses(){
      /* Get data post id & decode */
        $memberID = base64_decode(urldecode($this->input->post('postMemberID')));
      
      /* Get data post dari form */
        $postData = array(
          'member_name' => $this->input->post('postMemberNama'),
          'member_status'   => $this->input->post('postMemberStatus'),
          'member_discount'  => $this->input->post('postMemberDiscount')
        );

      /* Insert ke database */
        $editMember = $this->Customer_m->updateMember($postData, $memberID);

      /* Set session dan redirect */
        if($editMember > 0){
          $this->session->set_flashdata('flashStatus', 'successUpdate');
          $this->session->set_flashdata('flashMsg', 'Berhasil mengubah kontak Member !');
        } else {
          $this->session->set_flashdata('flashStatus', 'failedUpdate');
          $this->session->set_flashdata('flashMsg', 'Gagal mengubah kontak Member !');
        }

        redirect('Customer_c');
    }

    /* Function : Delete member */
    function deleteMember($deltype){
      /* Decode id */
        $mbrID = base64_decode(urldecode($this->input->post('postID')));

      /* Delete dari database */
        if($deltype === 'hard'){
         $delMbr = $this->Customer_m->deleteMember($mbrID);
        } else if ($deltype === 'soft'){
         $delMbr = $this->Customer_m->softdeleteMember($mbrID);
        }

      /* Set return value */
        if($delMbr > 0){
          echo 'successDelete';
        } else {
          echo 'failedDelete';
        }
    }

}