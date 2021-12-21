<?php
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') OR exit('No direct script access allowed !');

require APPPATH."libraries/RestController.php";
require APPPATH."libraries/Format.php";

Class Transaction_api extends RestController {

    public function __construct(){
        parent::__construct();
		$this->load->model('Sales_m', 'sales');
		$this->load->model('Purchases_m', 'purchases');
		$this->load->model('Expenses_m', 'expenses');
		$this->load->model('Revenues_m', 'revenues');
		$this->load->model('Return_m', 'return');
    }

    /** Rest GEt : All transaction */
    public function index_get(){
        $trans_type = $this->get('type');
        // $trans_id = $this->get('transID');

        switch ($trans_type) {
            case 'purchase' :
                $countData = $this->purchases->selectPurchase('all', 0, 0, 0)->num_rows();
                $getData = $this->purchases->selectPurchase('all', 0, 0, 0)->result_array();

                if($countData > 0){
                    $returnData = array();
                    /** Set return data */
                    foreach($getData as $row){
                        if ($row['tp_payment_status'] == 'T'){
                            $paymentStatus = 'Tunai Lunas';
                        } else if($row['tp_payment_status'] == 'K'){
                            $paymentStatus = 'Kredit - Belum Lunas';
                        } else {
                            $paymentStatus = 'Kredit Lunas';
                        }

                        $returnData[] = array(
                            'data_id'        => urlencode(base64_encode($row['tp_id'])),
                            'data_note_code' => $row['tp_note_code'],
                            'data_note_file' => $row['tp_note_file'],
                            'data_date'      => $row['tp_date'],
                            'data_supplier'  => $row['supp_name'],
                            'data_payment_method'   => ($row['tp_payment_method'] == 'TN')? 'Tunai / Cash' : 'Transfer',
                            'data_additional_cost'  => $row['tp_additional_cost'],
                            'data_total_cost'    => $row['tp_total_cost'],
                            'data_account_fk'    => $row['tp_account_fk'],
                            'data_paid'          => $row['tp_paid'],
                            'data_payment_status' => $paymentStatus,
                            // 'data_payment_status' => ($row['tp_payment_status'] == 'T')? 'Tunai Lunas' : ($row['tp_payment_status'] == 'K')? 'Kredit - Belum Lunas' : 'Kredit Lunas', // PHP 7 Only,  depecreted in php 8
                            'data_tenor'         => $row['tp_tenor'],
                            'data_tenor_periode' => $row['tp_tenor_periode'],
                            'data_installment'   => $row['tp_installment'],
                            'data_due_date'      => ($row['tp_payment_status'] == 'K')? $row['tp_due_date'] : '',
                            'data_post_script'   => $row['tp_post_script'],
                            'data_return_status' => ($row['tp_return_status'] == 0)? 'Pernah Return' : 'Belum Return',
                        );
                    }
                } else {
                    $error_msg = 'No purchase transaction available';
                    $error_code = 404;
                }
                break;
            case 'sales' :
                $countData = $this->sales->selectSales(0, 0, 'all', 0)->num_rows();
                $getData = $this->sales->selectSales(0, 0, 'all', 0)->result_array();

                if($countData > 0){
                    $returnData = array();
                    /** Set return data */
                    foreach($getData as $row){
                        if ($row['ts_payment_status'] == 'T'){
                            $paymentStatus = 'Tunai Lunas';
                        } else if($row['ts_payment_status'] == 'K'){
                            $paymentStatus = 'Kredit - Belum Lunas';
                        } else {
                            $paymentStatus = 'Kredit Lunas';
                        }

                        $returnData[] = array(
                            'data_id'         => urlencode(base64_encode($row['ts_id'])),
                            'data_trans_code' => $row['ts_trans_code'],
                            'data_date'       => $row['ts_date'],
                            'data_customer'   => $row['ctm_name'],
                            'data_total_sales'    => $row['ts_total_sales'],
                            'data_payment_status' => $paymentStatus,
                            'data_due_date' => ($row['ts_payment_status'] == 'K')? $row['ts_due_date'] : '',
                            'data_return'   => ($row['ts_return'] == 'N')? 'Belum Retur' : 'Sudah Retur',
                        );
                    }
                } else {
                    $error_msg = 'No sale transaction available';
                    $error_code = 404;
                }
                break;
            case 'revenues' :
                $countData = $this->revenues->selectRevenues(0, 0)->num_rows();
                $getData = $this->revenues->selectRevenues(0, 0)->result_array();

                if($countData > 0){
                    $returnData = array();
                    /** Set return data */
                    foreach($getData as $row){
                        $returnData[] = array(
                            'data_id'     => urlencode(base64_encode($row['tr_id'])),
                            'data_source' => $row['tr_source'],
                            'data_date'   => $row['tr_date'],
                            'data_trans_code' => $row['tr_trans_code'],
                            'data_payment'    => $row['tr_payment'],
                            'data_payment_method' => ($row['tr_payment_method'] == 'TN')? 'Tunai / Cash' : 'Transfer',
                        );
                    }
                } else {
                    $error_msg = 'No expense transaction available';
                    $error_code = 404;
                }
                break;
            case 'expenses' :
                $countData = $this->expenses->selectExpenses(0, 0)->num_rows();
                $getData = $this->expenses->selectExpenses(0, 0)->result_array();

                if($countData > 0){
                    $returnData = array();
                    /** Set return data */
                    foreach($getData as $row){
                        $returnData[] = array(
                            'data_id'        => urlencode(base64_encode($row['te_id'])),
                            'data_necessity' => $row['te_necessity'],
                            'data_date'      => $row['te_date'],
                            'data_payment_method' => ($row['te_payment_method'] == 'TN')? 'Tunai / Cash' : 'Transfer',
                            'data_payment'       => $row['te_payment'],
                            'data_note_code'     => $row['te_note_code'],
                            'data_account_id_fk' => $row['te_account_id_fk'],
                            'data_note_file'     => $row['te_note_file'],
                        );
                    }
                } else {
                    $error_msg = 'No expense transaction available';
                    $error_code = 404;
                }
                break;
            case 'returnc' :
                $countData = $this->return->selectRS(0, 0)->num_rows();
                $getData = $this->return->selectRS(0, 0)->result_array();

                if($countData > 0){
                    $returnData = array();
                    /** Set return data */
                    foreach($getData as $row){
                        $returnData[] = array(
                            'trans_id'        => urlencode(base64_encode($row['rc_ts_id_fk'])),
                            'trans_trans_code' => $row['ts_trans_code'],
                            'data_ctm'    => $row['ctm_name'],
                            'data_date'   => $row['rc_date'],
                            'data_status' => ($row['rc_status'] == 'R')? 'Tukar Barang' : 'Pengembalian Dana',
                            'data_cash'   => $row['rc_cash']
                        );
                    }
                } else {
                    $error_msg = 'No return customer transaction available';
                    $error_code = 404;
                }
                break;
            case 'returns' :
                $countData = $this->return->selectRS(0, 0)->num_rows();
                $getData = $this->return->selectRS(0, 0)->result_array();

                if($countData > 0){
                    $returnData = array();
                    /** Set return data */
                    foreach($getData as $row){
                        $returnData[] = array(
                            'trans_id'        => urlencode(base64_encode($row['rs_tp_id_fk'])),
                            'trans_note_code' => $row['tp_note_code'],
                            'data_supp'       => $row['supp_name'],
                            'data_date'       => $row['rs_date'],
                            'data_status'     => ($row['rs_status'] == 'R')? 'Tukar Barang' : 'Pengembalian Dana',
                            'data_cash_in'    => $row['rs_cash_in'],
                            'data_cash_out'   => $row['rs_cash_out'],
                            'data_post_sctipt' => $row['rs_post_script']
                        );
                    }
                } else {
                    $error_msg = 'No return supplier transaction available';
                    $error_code = 404;
                }
                break;
            default :
                $error_msg = "Provide a transaction type !";
                $error_code = 400;
        }

        /** Check if there is any $error */
        if(!isset($error_msg)){
        
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