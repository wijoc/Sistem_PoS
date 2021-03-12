<?php
defined('BASEPATH') or exit('No direct script access allowed !');

class Supplier_c extends MY_Controller
{

  public function __construct(){
    parent::__construct();
    $this->load->model('Supplier_m');
  }

  /** Function : List Supplier */
  public function index(){

    /* Data yang akan dikirim ke view */
    $this->pageData = array(
      'title' => 'PoS | Supplier',
      'assets' => array('sweetalert2', 'f_confirm', 'page_contact')
    );

    /* View file */
    $this->page = "contact/list_supplier_v";

    /* Call function layout dari MY_Controller Class */
    $this->layout();
  }

  /** Function : Ajax list supplier */
  function listSupplierAjax(){
    /** Load Library */
    $this->load->library('pagination');

    /** Konfigurasi tambahan untuk pagination */
    $page       = $this->uri->segment(3);
    $config['base_url']         = site_url('Supplier_c/listSupplierAjax/');
    $config['use_page_numbers'] = TRUE;
    $config['total_rows']       = $this->Supplier_m->selectSupplier(0, 0, 0, $this->input->get('supp_keyword'), $this->input->get('supp_order'))->num_rows(); // limit (param1), offset (param2), status (param3)
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
      foreach ($this->Supplier_m->selectSupplier($config['per_page'], $start_from, 0, $this->input->get('supp_keyword'), $this->input->get('supp_order'))->result_array() as $showSupp):
        $suppData[$i]['data_id']    = urlencode(base64_encode($showSupp['supp_id']));
        $suppData[$i]['data_name']  = ($showSupp['supp_name'])? $showSupp['supp_name'] : '<i class="fas fa-minus"></i>';
        $suppData[$i]['data_contact'] = ($showSupp['supp_contact_name'])? $showSupp['supp_contact_name'] : '<i class="fas fa-minus"></i>';
        $suppData[$i]['data_telp']    = ($showSupp['supp_telp'])? $showSupp['supp_telp'] : '<i class="fas fa-minus"></i>';
        $suppData[$i]['data_email']   = ($showSupp['supp_email'])? $showSupp['supp_email'] : '<i class="fas fa-minus"></i>';
        $suppData[$i]['data_address'] = ($showSupp['supp_address'])? $showSupp['supp_address'] : '<i class="fas fa-minus"></i>';
        $i++;
      endforeach;
      
      $data['pagination'] = $this->pagination->create_links();
      $data['supp_data']  = $suppData;
      $data['page']       = $page;
      $data['url_detail'] = site_url('Supplier_c/getSupplier/');
      $data['delete_type'] = 'soft-supp';
      $data['delete_url'] = site_url('Supplier_c/deleteSupplier/soft');

    header('Content-Type: application/json');
    echo json_encode($data);
  }

  /* Function : Get detail supplier */
  function getSupplier(){
    $suppID = base64_decode(urldecode($this->input->get('id')));

    $suppData = $this->Supplier_m->selectSupplierOnID($suppID);
    $returnData = array(
      'edit_name'    => $suppData[0]['supp_name'],
      'edit_contact' => $suppData[0]['supp_contact_name'],
      'edit_email'   => $suppData[0]['supp_email'],
      'edit_telp'    => $suppData[0]['supp_telp'],
      'edit_address' => $suppData[0]['supp_address']
    );

    echo json_encode($returnData);
  }

  /* Function : Input supplier proses */
  function addSupplierProses(){
    /** Run form validation */
    if ($this->_formValidation() == FALSE) {
      $arrReturn = array(
        'error'    => TRUE,
        'errorSuppNama'   => form_error('postSuppNama'),
        'errorSuppKontak'  => form_error('postSuppKontak'),
        'errorSuppTelp'    => form_error('postSuppTelp'),
        'errorSuppEmail'  => form_error('postSuppEmail')
      );
    } else {
      /** Get data post dari form */
      $postData = array(
        'supp_name' => $this->input->post('postSuppNama'),
        'supp_contact_name'   => $this->input->post('postSuppKontak'),
        'supp_email'  => $this->input->post('postSuppEmail'),
        'supp_telp'   => $this->input->post('postSuppTelp'),
        'supp_address' => $this->input->post('postSuppAlamat'),
      );

      /** Insert ke database */
      $inputSupp = $this->Supplier_m->insertSupplier($postData);

      /** Return value */
      if ($inputSupp > 0) {
        $arrReturn = array(
          'success'    => TRUE,
          'status'    => 'successInsert',
          'statusMsg' => 'Berhasil menambahkan data kontak !',
          'statusIcon' => 'success',
          'redirect'  => site_url('Supplier_c/')
        );
      } else {
        $arrReturn = array(
          'success'    => TRUE,
          'status'    => 'failedInsert',
          'statusMsg' => 'Gagal menambahkan data kontak !',
          'statusIcon' => 'error',
          'redirect'  => site_url('Supplier_c/')
        );
      }
    }

    header('Content-Type: application/json');
    echo json_encode($arrReturn);
  }

  /* Function : Edit supplier proses */
  function editSupplierProses(){
    /** Run form validation */
    if ($this->_formValidation('edit') == FALSE) {
      $arrReturn = array(
        'error'    => TRUE,
        'errorSuppID'     => form_error('postSuppID'),
        'errorSuppNama'   => form_error('postSuppNama'),
        'errorSuppKontak'  => form_error('postSuppKontak'),
        'errorSuppTelp'    => form_error('postSuppTelp'),
        'errorSuppEmail'  => form_error('postSuppEmail')
      );
    } else {
      /** Get post data dari form */
        $postData = array(
          'supp_name' => $this->input->post('postSuppNama'),
          'supp_contact_name'   => $this->input->post('postSuppKontak'),
          'supp_email'  => $this->input->post('postSuppEmail'),
          'supp_telp'   => $this->input->post('postSuppTelp'),
          'supp_address' => $this->input->post('postSuppAlamat'),
        );

      /** Update row data */
        $updateSupp = $this->Supplier_m->updateSupplier($postData, base64_decode(urldecode($this->input->post('postSuppID'))));

      /** Return value */
        if ($updateSupp > 0) {
          $arrReturn = array(
            'success'    => TRUE,
            'status'    => 'successInsert',
            'statusMsg' => 'Berhasil mengubah data kontak !',
            'statusIcon' => 'success'
          );
        } else {
          $arrReturn = array(
            'success'    => TRUE,
            'status'    => 'failedInsert',
            'statusMsg' => 'Gagal mengubah data kontak !',
            'statusIcon' => 'error'
          );
        }

    }

    header('Content-Type: application/json');
    echo json_encode($arrReturn);
  }

  /* Function : Delete supplier */
  function deleteSupplier($deltype){
    /* Decode id */
    $suppID = base64_decode(urldecode($this->input->post('postID')));

    /* Delete dari database */
    if ($deltype === 'soft') {
      $delSupp = $this->Supplier_m->softdeleteSupplier($suppID);
    } else if ($deltype === 'hard') {
      $delSupp = $this->Supplier_m->deleteSupplier($suppID);
    }

    /* Set session & redirect */
    if ($delSupp > 0) {
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
        'field'  => 'postSuppNama',
        'label'  => 'Nama Supplier',
        'rules'  => 'trim|required',
        'errors'  => array(
          'required' => 'Nama supplier tidak boleh kosong'
        )
      ),
      array(
        'field'  => 'postSuppKontak',
        'label'  => 'Nama Kontak',
        'rules'  => 'trim|required',
        'errors'  => array(
          'required' => 'Nama kontak tidak boleh kosong'
        )
      ),
      array(
        'field'  => 'postSuppTelp',
        'label'  => 'No. Telp',
        'rules'  => 'trim|numeric',
        'errors'  => array(
          'numeric'  => 'Nomor telp tidak valid'
        )
      ),
      array(
        'field'  => 'postSuppEmail',
        'label'  => 'E-mail',
        'rules'  => 'trim|valid_email',
        'errors'  => array(
          'valid_email'  => 'Alamat e-mail tidak valid'
        )
      ),
      array(
        'field'  => 'postSuppAlamat',
        'label'  => 'Alamat',
        'rules'  => 'trim'
      )
    );

    if($from == 'edit'){
      array_push(
        $config, 
        array(
          'field'  => 'postSuppID',
          'label'  => 'ID Supplier',
          'rules'  => 'trim|required',
          'errors'  => array(
            'required' => 'Supplier tidak ditemukan !'
          )
        )
      );
    }

    $this->form_validation->set_rules($config);

    return $this->form_validation->run();
  }
}
