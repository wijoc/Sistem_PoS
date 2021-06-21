<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_c extends MY_Controller {

	public function index(){
		//$this->auth_user('kasir');
		print("<pre>".print_r($this->session->userdata('logedInLevel'), true)."</pre>");
		$this->auth_user(['uAll', 'uO', 'uG']);
	}
}
