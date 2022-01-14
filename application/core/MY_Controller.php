<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	
	protected $pageData = array();

	public function __construct(){
		parent::__construct();
	}

	public function layout(){
		$this->layout = array(
			'head_load' => $this->load->view('layout/head_load', $this->pageData, TRUE),
			'foot_load' => $this->load->view('layout/foot_load', $this->pageData, TRUE),
			'header' 	=> $this->load->view('layout/header', $this->pageData, TRUE),
			'sidebar' 	=> $this->load->view('layout/sidebar', $this->pageData, TRUE),
			'footer' 	=> $this->load->view('layout/footer', $this->pageData, TRUE),
			'content' 	=> $this->load->view($this->page, $this->pageData, TRUE),
		);
		$this->load->view('layout/base_layout', $this->layout);
	}

	public function auth_user($allowed_user = NULL){
		// $jwtoken = $this->input->cookie('X-ZPOS-SESSION');

        if($this->input->cookie('X-ZPOS-SESSION')){
            $jwtoken = $this->input->cookie('X-ZPOS-SESSION');
        } else {
            $head = getallheaders();
            if($head['Authorization']){
                preg_match('/Bearer\s(\S+)/', $head['Authorization'], $matches);
                $jwtoken = $matches[1];
                $head = null;
            } else {
                $jwtoken = NULL;
            }
        }

		if($jwtoken ?? FALSE){
			/** Validate JWT */
			try{
				$response = Authorization::validateToken($jwtoken);

				/** Validate session_id */
				$this->load->model('User_m', 'user');
				if($this->user->checkUSess($response->session_id)->num_rows() > 0){
					if(in_array($response->logedLevel, $allowed_user) == TRUE){
						return $response;
					} else {
						redirect('Page_c/notAllowedPage/');
					}
				} else {
					redirect('Auth_c');
				}
			} catch (Exception $exception){
				redirect('Auth_c');
			}
		} else {
			redirect('Auth_c');
		}
	}
}