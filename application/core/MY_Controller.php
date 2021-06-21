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

	public function auth_user($allowed_user){
		if($this->session->userdata('logedInStatus') == 'canLogin'){
			if(in_array($this->session->userdata('logedInLevel'), $allowed_user) == FALSE){
				redirect('Page_c/notAllowedPage/');
			}
		} else {
			redirect('Auth_c');
		}
	}
}