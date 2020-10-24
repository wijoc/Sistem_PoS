<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

	public function index()
	{
		$this->pageData['title'] = 'Page Title';
		$this->page = "sample_content";
		$this->layout();
	}
}
