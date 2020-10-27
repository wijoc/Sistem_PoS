<?php 
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Installment_m extends CI_Model {

	/* Declare Table installment Purcahse */
	var $ip_tb = 'intallment_purchase';
	var $ip_f  = array(
		'0' => 'ip_id',
		'1' => 'ip_trans_code_fk',
		'2' => 'ip_periode',
		'3' => 'ip_periode_end',
		'4' => 'ip_date',
		'5' => 'ip_payment',
		'6' => 'ip_invoice_code',
		'7' => 'ip_invoice_file'
	);

  /* Installment Purchase */
  	/* Query insert installment_purchase */
  	function insertInstallmentPurchase($insert_data){
  		$resultInsert = $this->db->insert($this->ip_tb, $insert_data);
  		return $resultInsert;
  	}

  	/* Query select data installment berdasar trans_code */
  	function getInstallmentPurchase($trans_code){
  		$this->db->where($this->ip_f[1], $trans_code);
  		$resultSelect = $this->db->get($this->ip_tb);
  		return $resultSelect->result_array();
  	}

  /* Installment Sales */

}