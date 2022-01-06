<?php
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') OR exit('No direct script access allowed !');

require APPPATH."libraries/RestController.php";
require APPPATH."libraries/Format.php";

Class Supplier_api extends RestController {

    public function __construct(){
        parent::__construct();
        $this->load->model('Supplier_m', 'supp');
    }

    /** Rest GET : All supplier and supplier by id */
    public function index_get(){
        /** Check suppID */
        if($this->get('suppID') != NULL){
            $countData = $this->supp->selectSupplierByID(base64_decode(urldecode($this->get('suppID'))))->num_rows();
            if($countData > 0){
                $getData = $this->supp->selectSupplierByID(base64_decode(urldecode($this->get('suppID'))))->result_array();
                if($getData[0]['supp_status'] != 0){
                    $error_msg = 'Supplier no longer exist !';
                    $error_code = 403;
                }
            } else {
                $error_msg = 'Supplier not found !';
                $error_code = 404;
            }
        } else {
            $countData = $this->supp->selectSupplier(0, 0, 0, null, 'asc')->num_rows();
            if($countData > 0){
                $getData = $this->supp->selectSupplier(0, 0, 0, null, 'asc')->result_array();
            } else {
                $error_msg = 'Supplier not Available !';
                $error_code = 404;
            }
        }

        /** Check if there is any $error */
        if(!isset($error_msg)){
            $returnData = array();
            /** Set return data */
            foreach($getData as $row){
                $returnData[] = array(
                    'data_id'       => urlencode(base64_encode($row['supp_id'])),
                    'data_name'     => $row['supp_name'],
                    'data_email'    => $row['supp_email'],
                    'data_telp'     => $row['supp_telp'],
                    'data_address'  => $row['supp_address'],
                    'data_status'   => ($row['supp_status'] == 0)? 'active' : 'deactived',
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