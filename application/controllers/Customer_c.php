<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Customer_c extends MY_Controller{

  	public function __construct(){
  		parent::__construct();
  		$this->load->model('Customer_m');
  	}

    /* Fuction : List customer */
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

    /* Function : Input customer proses */
    function addCustomerProses(){
      /* Get data post dari form */
      	$postData = array(
      		'ctm_name'  => $this->input->post('postCtmNama'),
      		'ctm_phone'  => $this->input->post('postCtmTelp'),
      		'ctm_email' => $this->input->post('postCtmEmail'),
          'ctm_address' => $this->input->post('postCtmAddress'),
          'ctm_discount_type' => $this->input->post('postCtmDiscountType'),
          'ctm_discount_price' => ($this->input->post('postCtmDiscountType') == 'ptg')? $this->input->post('postCtmDiscount') : NULL,
          'ctm_discount_percent' => ($this->input->post('postCtmDiscountType') == 'prc')? $this->input->post('postCtmDiscount') : NULL,
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

    /* Function : get customer berdasar customer id / customer nama */
    function getCustomer(){
      $ctmID = base64_decode(urldecode($this->input->post('id')));
      $ctmData = $this->Customer_m->getCustomerOnID($ctmID);

      $returnData = array(
        'edit_id'      => $this->input->post('id'),
        'edit_name'    => $ctmData[0]['ctm_name'],
        'edit_phone'   => $ctmData[0]['ctm_phone'],
        'edit_email'   => $ctmData[0]['ctm_email'],
        'edit_address' => $ctmData[0]['ctm_address'],
        'edit_discount_type'    => $ctmData[0]['ctm_discount_type'],
        'edit_discount'   => ($ctmData[0]['ctm_discount_type'] == 'prc')? $ctmData[0]['ctm_discount_percent'] : $ctmData[0]['ctm_discount_price']
      );

      echo json_encode($returnData);
    }

    /* Function : Autocomplete customer */
    function searchCustomer($field){
      /* Decalare variable */
        $output = '';

      /* Check kata yang dicari */
        if($this->input->post('term')){
          $data = $this->Customer_m->searchCustomer($field, $this->input->post('term'));
        } else { 
          $data = $this->Customer_m->getAllowedCustomer(0, 0)->result_array();
        }

      /* set output */
        if(count($data) > 0){
          foreach($data as $row){
            $output .= 
              '<div class="col-lg-6">
                <button class="btn btn-block btn-flat btn-outline-info ctm-btn" data-dismiss="modal" style="margin: 5px;" onclick="ctmSelected(\''.urlencode(base64_encode($row['ctm_id'])).'\')" value="'.urlencode(base64_encode($row['ctm_id'])).'">
                  <font style="font-weight: bold">'.$row['ctm_name'].'</font>
                </button>
              </div>';
          }
        } else {
          $output .= 
            '<div class="col-lg-12 text-center">
              <div class="alert alert-danger" style="margin: 5px;"><b> Data pelanggan tidak ditemukan ! </b></div>
            </div>';
        }

        echo $output;
    }

    /* Function : Proses Edit customer */
    function editCustomerProses(){
      /* Get data post id & decode */
        $ctmID = base64_decode(urldecode($this->input->post('postCtmID')));
      
      /* Get data post dari form */
        $postData = array(
          'ctm_name'  => $this->input->post('postCtmNama'),
          'ctm_phone'  => $this->input->post('postCtmTelp'),
          'ctm_email' => $this->input->post('postCtmEmail'),
          'ctm_address' => $this->input->post('postCtmAddress'),
          'ctm_discount_type' => $this->input->post('postCtmDiscountType'),
          'ctm_discount_price' => ($this->input->post('postCtmDiscountType') == 'ptg')? $this->input->post('postCtmDiscount') : NULL,
          'ctm_discount_percent' => ($this->input->post('postCtmDiscountType') == 'prc')? $this->input->post('postCtmDiscount') : NULL
        );

      /* update data di database */
        $editCustomer = $this->Customer_m->updateCustomer($postData, $ctmID);

      /* Set session dan redirect */
        if($editCustomer > 0){
          $this->session->set_flashdata('flashStatus', 'successUpdate');
          $this->session->set_flashdata('flashMsg', 'Berhasil mengubah kontak pelanggan !');
        } else {
          $this->session->set_flashdata('flashStatus', 'failedUpdate');
          $this->session->set_flashdata('flashMsg', 'Gagal mengubah kontak pelanggan !');
        }

        redirect('Customer_c');
    }

    /* Function : Delete customer */
    function deleteCustomer($deltype){
      /* Decode id */
        $ctmID = base64_decode(urldecode($this->input->post('postID')));

      /* Delete dari database */
        if($deltype === 'hard'){
         $deleteCustomer = $this->Customer_m->deleteCustomer($ctmID);
        } else if ($deltype === 'soft'){
         $deleteCustomer = $this->Customer_m->softdeleteCustomer($ctmID);
        }

      /* Set return value */
        if($deleteCustomer > 0){
          echo 'successDelete';
        } else {
          echo 'failedDelete';
        }
    }

}