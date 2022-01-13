<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

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
            $userData = $this->User_m->selectUserByUsername($this->input->post('postUsername'))->result_array();
              
            if(password_verify($this->input->post('postPassword'), $userData[0]['u_password'])){
                /** Set session_id dan input ke JWT dan DB, untuk validasi saat user melakukan request */
                $session_id = hash('sha1', date('Ymdhis').'sessi1DPOS');
                $sessData = array(
                    'user_id' => $userData[0]['u_id'],
                    'user_ip' => $this->input->ip_address(),
                    'sess_id' => $session_id
                );
                $this->User_m->insertUserSess($sessData);

                $tokenData = array(
                    'user_id'    => urlencode(base64_encode($userData[0]['u_id'])),
                    'logedUser'  => $userData[0]['u_name'],
                    'logedLevel' => $userData[0]['u_level'],
                    'session_id' => $session_id
                );
                    
                $response['token'] = Authorization::generateToken($tokenData);

                /** Note : for CI set Cookie / Untuk set cookie CI, 
                 * key 'domain' must be the same if null or different it won't work /
                 * key 'domain' harus sama dengan url saat ini kalau null / beda cookie tidak tersimpan
                 * or you can use setcookie() from php 
                 * atau bisa pakai setcookie() */
                
                $url_parts = parse_url(current_url()); // Get current url
                $domain = str_replace('www.', '', $url_parts['host']); // Remove subdomain

                $cookie = array(
                    'name'  => 'X-ZPOS-SESSION',
                    'value' => $response['token'],
                    'expire' => 3600 * 8,
                    'domain' => $domain, // When deploy, you can also set with your domain, now i $domain to get domain from current url
                    'path'   => '/',
                    'secure' => TRUE
                );
                $this->input->set_cookie($cookie);
                
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
            if($this->User_m->selectUserByUsername($post)->num_rows() > 0){
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