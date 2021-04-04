<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Customer_c extends MY_Controller{

  	public function __construct(){
  		parent::__construct();
  		$this->load->model('Customer_m');
  	}

    /** Fuction : List customer */
    public function index(){
    	/* Proses tampil halaman */
    	$this->pageData = array(
    		'title'       => 'PoS | Pelanggan',
        'assets'      => array('sweetalert2', 'contact', 'f_confirm'),
        'contact_url'  => site_url('Customer_c/listCustomerAjax/')
    	);

      /* View file */
    	$this->page = "contact/list_customer_v";

      /* Call function layout dari MY_Controller Class */
    	$this->layout();
    }

    /** Function : Ajax list customer */
    function listCustomerAjax(){
      /** Load Library */
      $this->load->library('pagination');
  
      /** Konfigurasi tambahan untuk pagination */
      $page       = $this->uri->segment(3);
      $config['base_url']         = site_url('Customer_c/listCustomerAjax/');
      $config['use_page_numbers'] = TRUE;
      $config['total_rows']       = $this->Customer_m->selectCustomer(0, 0, 0, $this->input->get('filter_keyword'), $this->input->get('filter_order'))->num_rows(); // limit (param1), offset (param2), status (param3)
      $config['per_page']         = 9;
      $config['full_tag_open']    = '<ul class="pagination justify-content-center m-0">';
      $config['full_tag_close']   = '</ul>';
      $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
      $config['num_tag_close']    = '</span></li>';
      $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link"><a class="text-white" href="#/'.$page.'">';
      $config['cur_tag_close']    = '</a></span></li>';
      $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
      $config['prev_tag_close']   = '</span></li>';
      $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
      $config['next_tag_close']   = '</span></li>';
      $config['prev_link']        = '<i class="fas fa-backward"></i>';
      $config['next_link']        = '<i class="fas fa-forward"></i>';
      $config['first_link']       = '&laquo; First';
      $config['last_link']        = 'Last &raquo;';
      $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
      $config['last_tag_close']   = '</span></li>';
      $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
      $config['first_tag_close']  = '</span></li>';
      $start_from = (intval($page) > 0)? ($page - 1) * $config['per_page'] : 0;
      $this->pagination->initialize($config);
  
      /** Prepare Data */
        $i = 0;
        foreach ($this->Customer_m->selectCustomer($config['per_page'], $start_from, 0, $this->input->get('filter_keyword'), $this->input->get('filter_order'))->result_array() as $showCtm):
          $ctmData[$i]['data_id']    = urlencode(base64_encode($showCtm['ctm_id']));
          $ctmData[$i]['data_name']  = '';
          $ctmData[$i]['data_contact']  = ($showCtm['ctm_name'])? $showCtm['ctm_name'] : '<i class="fas fa-minus"></i>';
          $ctmData[$i]['data_telp']    = ($showCtm['ctm_phone'])? $showCtm['ctm_phone'] : '<i class="fas fa-minus"></i>';
          $ctmData[$i]['data_email']   = ($showCtm['ctm_email'])? $showCtm['ctm_email'] : '<i class="fas fa-minus"></i>';
          $ctmData[$i]['data_address'] = ($showCtm['ctm_address'])? $showCtm['ctm_address'] : '<i class="fas fa-minus"></i>';
          $i++;
        endforeach;
        
        $data['pagination']   = $this->pagination->create_links();
        $data['contact_data'] = $ctmData;
        $data['page']         = $page;
        $data['type']         = 'ctm';
        $data['modal']        = 'modal-edit-customer';
        $data['url_detail']   = site_url('Customer_c/getCustomer/');
        $data['delete_type']  = 'soft-ctm';
        $data['delete_url']   = site_url('Customer_c/deleteCustomer/soft');
  
      header('Content-Type: application/json');
      echo json_encode($data);
    }

    /** Function : Input customer proses */
    function addCustomerProses(){
      /** Run form validation */
      if ($this->_formValidation() == FALSE) {
        $arrReturn = array(
          'error'    => TRUE,
          'errorCtmNama'   => form_error('postCtmNama'),
          'errorCtmTelp'    => form_error('postCtmTelp'),
          'errorCtmEmail'  => form_error('postCtmEmail')
        );
      } else {
        /** Get post data dari form data */
          $postData = array(
            'ctm_name'  => $this->input->post('postCtmNama'),
            'ctm_phone' => $this->input->post('postCtmTelp'),
            'ctm_email' => $this->input->post('postCtmEmail'),
            'ctm_address' => $this->input->post('postCtmAddress')
          );

        /** Insert data */
          $inputCtm = $this->Customer_m->insertCustomer($postData);

        /** Return value */
        if ($inputCtm > 0) {
          $arrReturn = array(
            'success'    => TRUE,
            'status'    => 'successInsert',
            'statusMsg' => 'Berhasil menambahkan data kontak !',
            'statusIcon' => 'success'
          );
        } else {
          $arrReturn = array(
            'success'    => TRUE,
            'status'    => 'failedInsert',
            'statusMsg' => 'Gagal menambahkan data kontak !',
            'statusIcon' => 'error'
          );
        }
      }

      header('Content-Type: application/json');
      echo json_encode($arrReturn);
    }

    /** Function : get customer berdasar customer id / customer nama */
    function getCustomer(){
      $ctmID = base64_decode(urldecode($this->input->get('id')));
      $ctmData = $this->Customer_m->selectCustomerOnID($ctmID);

      $returnData = array(
        'data_name'    => $ctmData[0]['ctm_name'],
        'data_phone'   => $ctmData[0]['ctm_phone'],
        'data_email'   => $ctmData[0]['ctm_email'],
        'data_address' => $ctmData[0]['ctm_address']
      );

      echo json_encode($returnData);
    }

    /** Function : Autocomplete customer */
    function searchCustomer($field){
      /* Decalare variable untuk output */
        $output = '';
      
      /* Percabangan untuk jenis output
        /* jika sales, output merupakan card untuk page list customer */
        if($this->input->post('type') == 'ctm'){
          /* Check kata yang dicari */
            if($this->input->post('keyword')){
              $data = $this->Customer_m->searchCustomer($field, $this->input->post('keyword'));
            } else { 
              $data = 0;
            }

        /* jika ctm, output merupakan option untuk page add sales */
        } else if($this->input->post('type') == 'sales') {
          /* Check kata yang dicari */
            if($this->input->post('keyword')){
              $data = $this->Customer_m->searchCustomer($field, $this->input->post('keyword'));
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
                '<div class="col-lg-6">
                  <button class="btn btn-block btn-flat btn-outline-info" data-dismiss="modal" style="margin: 5px;" onclick="ctmSelected(\'nctm\')" value="nctm"><font style="font-weight: bold">Pelanggan Baru</font></button>
                </div>
                <div class="col-lg-6">
                  <button class="btn btn-block btn-flat btn-outline-info" data-dismiss="modal" style="margin: 5px;" onclick="ctmSelected(\'gctm\')" value="gctm"><font style="font-weight: bold">Pelanggan Umum</font></button>
                </div>
                <div class="col-lg-12">
                  <div class="text-center alert alert-danger" style="margin: 10px;">
                    <b> Data pelanggan tidak ditemukan ! </b>
                  </div>
                </div>';
            }

        }

        /* Tampilkan output */
        echo $output;
    }

    /** Function : Proses Edit customer */
    function editCustomerProses(){
      /** Run form validation */
      if ($this->_formValidation('edit') == FALSE) {
        $arrReturn = array(
          'error'    => TRUE,
          'errorCtmID'    => form_error('postCtmID'),
          'errorCtmNama'  => form_error('postCtmNama'),
          'errorCtmTelp'  => form_error('postCtmTelp'),
          'errorCtmEmail' => form_error('postCtmEmail')
        );
      } else {
        /** Get data post id & decode */
          $ctmID = base64_decode(urldecode($this->input->post('postCtmID')));
          $postData = array(
            'ctm_name'  => $this->input->post('postCtmNama'),
            'ctm_phone' => $this->input->post('postCtmTelp'),
            'ctm_email' => $this->input->post('postCtmEmail'),
            'ctm_address' => $this->input->post('postCtmAddress')
          );

        /** update data di database */
          $editCustomer = $this->Customer_m->updateCustomer($postData, $ctmID);

        /** Set session dan redirect */
          if($editCustomer > 0){
            $arrReturn = array(
              'success'    => TRUE,
              'status'    => 'successUpdate',
              'statusMsg' => 'Berhasil mengubah data kontak !',
              'statusIcon' => 'success'
            );
          } else {
            $arrReturn = array(
              'success'    => TRUE,
              'status'    => 'failedUpdate',
              'statusMsg' => 'Gagal mengubah data kontak !',
              'statusIcon' => 'error'
            );
          }
      }
  
      header('Content-Type: application/json');
      echo json_encode($arrReturn);
    }

    /** Function : Delete customer */
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
 
    /** Function : validasi */
    private function _formValidation($from = 'add'){
      /** Load library & Helper */
      $this->load->library('form_validation');
  
      /** Set rules form validation */
      $config = array(
        array(
          'field'  => 'postCtmNama',
          'label'  => 'Nama Pelanggan',
          'rules'  => 'trim|required',
          'errors'  => array(
            'required' => 'Nama pelanggan tidak boleh kosong'
          )
        ),
        array(
          'field'  => 'postCtmTelp',
          'label'  => 'No. Telp',
          'rules'  => 'trim|numeric',
          'errors'  => array(
            'numeric'  => 'Nomor telp tidak valid'
          )
        ),
        array(
          'field'  => 'postCtmEmail',
          'label'  => 'E-mail',
          'rules'  => 'trim|valid_email',
          'errors'  => array(
            'valid_email'  => 'Alamat e-mail tidak valid'
          )
        ),
        array(
          'field'  => 'postCtmAddress',
          'label'  => 'Alamat',
          'rules'  => 'trim'
        )
      );
  
      if($from == 'edit'){
        array_push(
          $config, 
          array(
            'field'  => 'postCtmID',
            'label'  => 'ID Customer',
            'rules'  => 'trim|required',
            'errors'  => array(
              'required' => 'Customer tidak ditemukan !'
            )
          )
        );
      }
  
      $this->form_validation->set_rules($config);
  
      return $this->form_validation->run();
    }

}