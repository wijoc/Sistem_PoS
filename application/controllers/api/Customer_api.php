<?php
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') OR exit('No direct script access allowed !');

require APPPATH."libraries/RestController.php";
require APPPATH."libraries/Format.php";

Class Customer_api extends RestController {

    public function __construct(){
        parent::__construct();
        $this->load->model('Customer_m', 'ctm');
    }

    /** Rest GET : All customer and customer by id */
    public function index_get(){
        /** Check ctmID */
        if($this->get('ctmID') != NULL){
            $countData = $this->ctm->selectCustomerOnID(base64_decode(urldecode($this->get('ctmID'))))->num_rows();
            if($countData > 0){
                $getData = $this->ctm->selectCustomerOnID(base64_decode(urldecode($this->get('ctmID'))))->result_array();
                if($getData[0]['ctm_status'] == 1){
                    $error_msg = 'Customer no longer exist !';
                    $error_code = 403;
                } else if ($getData[0]['ctm_status'] == 2){
                    $error_msg = 'Customer is Deactived !';
                    $error_code = 403;
                }
            } else {
                $error_msg = 'Customer not found !';
                $error_code = 404;
            }
        } else {
            $countData = $this->ctm->selectCustomer(0, 0, 0, null, 'asc')->num_rows();
            if($countData > 0){
                $getData = $this->ctm->selectCustomer(0, 0, 0, null, 'asc')->result_array();
            } else {
                $error_msg = 'Customer not Available !';
                $error_code = 404;
            }
        }

        /** Check if there is any $error */
        if(!isset($error_msg)){
            $returnData = array();
            /** Set return data */
            foreach($getData as $row){
                $returnData[] = array(
                    'data_id'       => urlencode(base64_encode($row['ctm_id'])),
                    'data_name'     => $row['ctm_name'],
                    'data_email'    => $row['ctm_email'],
                    'data_phone'    => $row['ctm_phone'],
                    'data_address'  => $row['ctm_address'],
                    'data_status'   => ($row['ctm_status'] == 0)? 'active' : 'deactived',
                );
            }
        
            /** Set response */
            $this->response( [
                'status'     => true,
                'count_data' => $countData,
                'data'       => $returnData
            ], 200 );
        } else {
            /** Set response */
            $this->response( [
                'status' => false,
                'message'   => $error_msg
            ], $error_code );
        }
    }
}