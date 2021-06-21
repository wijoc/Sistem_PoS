<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Auth_c extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('User_m');
    }

    public function index(){
        $this->load->view("auth/login_v");
    }

    public function loginCheck(){
        /** Load Library form_validation */
          $this->load->library("form_validation");
  
        /** Set rules form validation */
          $configValidation = array(
              array(
                  'field'     => 'postUsername',
                  'label'     => 'Username',
                  'rules'     => 'trim|required|callback__validation_username',
                  'errors'    => array(
                      'required' => 'Username tidak boleh kosong'
                  )
              ),
              array(
                  'field'     => 'postPassword',
                  'label'     => 'Username',
                  'rules'     => 'trim|required',
                  'errors'    => array(
                      'required' => 'Masukan password'
                  )
              ),
          );
        
          $this->form_validation->set_rules($configValidation);
      
        /** Log in proses */
          if($this->form_validation->run() == FALSE) {
              $arrReturn = array(
                  'error' => TRUE,
                  'errorUsername' => form_error('postUsername'),
                  'errorPassword' => form_error('postPassword')
              );
          } else {
              $userData = $this->User_m->selectUserByUsername(htmlspecialchars($this->input->post('postUsername')))->result_array();
  
              if(password_verify(htmlspecialchars($this->input->post('postPassword')), $userData[0]['u_password'])){
                  $this->session->set_flashdata('logedInStatus', 'canLogin');
                  $this->session->set_flashdata('logedInUser', $userData[0]['u_name']);
                  $this->session->set_flashdata('logedInLevel', $userData[0]['u_level']);
                  $arrReturn = array(
                      'redirect' => site_url('Page_c')
                  );
              } else {
                  $arrReturn = array(
                      'error' => TRUE,
                      'errorPassword' => 'Password Salah'
                  );
              }
          }

        header('Content-Type: application/json');
        echo json_encode($arrReturn);
    }

    public function logoutProses(){
        $this->session->sess_destroy();
        redirect('Auth_c');
    }

    function _validation_username($post){
        if($post != '' ){
            if($this->User_m->selectUserByUsername(htmlspecialchars($post))->num_rows() > 0){
                return TRUE;
            } else {
                $this->form_validation->set_message('_validation_username', 'Username tidak ditemukan');
                return FALSE;
            }
        } else {
            $this->form_validation->set_message('_validation_username', 'Masukan username');
            return FALSE;
        }
    }
}