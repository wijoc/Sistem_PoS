<?php 

use chriskacerguis\RestServer\RestController;

defined('BASEPATH') OR exit('No direct script access allowed !');

require APPPATH."libraries/RestController.php";
require APPPATH."libraries/Format.php";

Class MY_Api extends RestController {

	public function __construct(){
		parent::__construct();
	}

    protected function auth_api($allowed_user = NULL){
        if($this->input->cookie('X-ZPOS-SESSION')){
            $jwtoken = $this->input->cookie('X-ZPOS-SESSION');
        } else {
            $head = getallheaders();
            preg_match('/Bearer\s(\S+)/', $head['Authorization'], $matches);
            $jwtoken = $matches[1];
            $head = null;
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
                        /** Set response */
                        $this->response( [
                            'status'  => false,
                            'message' => 'Not allowed !'
                        ], 403 );
					}
				} else {
                    /** Set response */
                    $this->response( [
                        'status'  => false,
                        'message' => 'Session id is invalid'
                    ], 401 );
				}
			} catch (Exception $exception){
                /** Set response */
                $this->response( [
                    'status'  => false,
                    'message' => $exception->getMessage().' !'
                ], 401 );
			}
		} else {
            /** Set response */
            $this->response( [
                'status'  => false,
                'message' => 'Provide a JSON Web Token !'
            ], 401 );
		}
    }
}