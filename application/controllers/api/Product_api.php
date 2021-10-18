<?php
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') OR exit('No direct script access allowed !');

require APPPATH."libraries/RestController.php";
require APPPATH."libraries/Format.php";

Class Product_api extends RestController {

    public function __construct(){
        parent::__construct();
        $this->load->model('Product_m', 'product');
    }

  /** Product */
    /** GET : all product and all product on category */
    public function index_get(){
        /** Check if category exist, if exist return product on selected category */
        if($this->get('category') != NULL){
            /** Decode category */
            $ctgrID = base64_decode(urldecode($this->get('category')));

            /** Check Category exist in DB */
            if($this->product->selectCategoryByID($ctgrID)->num_rows() > 0){
                /** Get data from db */
                $countData = $this->product->selectProductOnCtgr($ctgrID)->num_rows();
                $getData = $this->product->selectProductOnCtgr($ctgrID)->result_array();
            } else {
                $error_msg = 'Category didn\'t exist !';
                $error_code = 404;
            }
        } else { // return all product
            /** Get data from db */
            $countData = $this->product->selectProduct()->num_rows();
            $getData = $this->product->selectProduct()->result_array();
        }

        /** Check if there is any $error */
        if(!isset($error_msg)){
            $returnData = array();
            /** Set return data */
            foreach($getData as $row){
                $returnData[] = array(
                    'data_id'       => urlencode(base64_encode($row['prd_id'])),
                    'data_barcode'  => $row['prd_barcode'],
                    'data_name'     => $row['prd_name'],
                    'data_category' => $row['ctgr_name'],
                    'data_purchase_price'  => $row['prd_purchase_price'],
                    'data_selling_price'   => $row['prd_selling_price'],
                    'data_unit'    => $row['unit_name'],
                    'good_stock'   => 0,
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

    /** GET : detail product by id */
    public function getDetailProduct_get(){
        /** Check if prdID, if prdID exist then decode */
        $prd_id = base64_decode(urldecode($this->get('prdID')));
        if($prd_id != NULL){
            if($this->product->selectProductByID($prd_id)->num_rows() > 0){
                /** Get Data */
                $getData = $this->product->selectProductByID($prd_id)->result_array();
                foreach($getData as $row){
                    $returnData = array(
                        'data_id'       => urlencode(base64_encode($row['prd_id'])),
                        'data_barcode'  => $row['prd_barcode'],
                        'data_name'     => $row['prd_name'],
                        'data_category' => $row['ctgr_name'],
                        'data_purchase_price'  => $row['prd_purchase_price'],
                        'data_selling_price'   => $row['prd_selling_price'],
                        'data_unit'    => $row['unit_name'],
                        'good_stock'   => 0,
                    );
                }
                
                /** Set response */
                $this->response( [
                    'status' => true,
                    'data' => $returnData
                ], 200 );
            } else {
                /** Set response */
                $this->response( [
                    'status' => false,
                    'message' => 'Product not found !'
                ], 404 );
            }
        } else {
            /** Set response */
            $this->response( [
                'status' => false,
                'message' => 'Provide an ID'
            ], 400 );
        }
    }

    /** GET : detail stock by product id */
    public function getStockProduct_get(){
        /** Get Data */
        $countData = $this->product->selectProductStock()->num_rows();
        $getStock = $this->product->selectProductStock()->result_array();

        $returnData = array();
        /** Set return data */
        foreach($getStock as $row){
            $returnData[] = array(
                'data_id'      => urlencode(base64_encode($row['prd_id'])),
                'data_barcode' => $row['prd_barcode'],
                'data_name'  => $row['prd_name'],
                'initial_g'  => $row['prd_initial_g_stock'],
                'initial_ng' => $row['prd_initial_ng_stock'],
                'initial_op' => $row['prd_initial_op_stock'],
                'stk_g'      => $row['stk_good'],
                'stk_ng'     => $row['stk_not_good'],
                'stk_op'     => $row['stk_opname']
            );
        }
    
        /** Set response */
        $this->response( [
            'status'     => true,
            'count_data' => $countData,
            'data'       => $returnData
        ], 200 );
    }

  /** Category */
    /** GET : all category and category data by ctgr_id */
    public function getCategory_get(){
        /** Check if cctgrID exist, if exist get detail data by ctgr_id */
        if($this->get('ctgrID') != NULL){
            $countData = $this->product->selectCategoryByID(base64_decode(urldecode($this->get('ctgrID'))))->num_rows();
            if($countData > 0){
                $getData = $this->product->selectCategoryByID(base64_decode(urldecode($this->get('ctgrID'))))->result_array();
            } else {
                $error_msg = 'Category not found !';
                $error_code = 404;
            }
        } else {
            $countData = $this->product->selectCategory()->num_rows();
            if($countData > 0){
                $getData = $this->product->selectCategory()->result_array();
            } else {
                $error_msg = 'Category not available !';
                $error_code = 404;
            }
        }

        /** Check if there is any $error */
        if(!isset($error_msg)){
            $returnData = array();
            /** Set return data */
            foreach($getData as $row){
                $returnData[] = array(
                    'data_id'       => urlencode(base64_encode($row['ctgr_id'])),
                    'data_name'  => $row['ctgr_name']
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

  /** Unit */
    /** GET : all unit and unit data by ctgr_id */
    public function getUnit_get(){
        /** Get unit data */
        $countData = $this->product->selectUnit()->num_rows();
        if($countData > 0){
            $getData = $this->product->selectUnit()->result_array();
        } else {
            $error_msg = 'Unit not available !';
            $error_code = 404;
        }

        /** Check if there is any $error */
        if(!isset($error_msg)){
            $returnData = array();
            /** Set return data */
            foreach($getData as $row){
                $returnData[] = array(
                    'data_id'       => urlencode(base64_encode($row['unit_id'])),
                    'data_name'  => $row['unit_name']
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