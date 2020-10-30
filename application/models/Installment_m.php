<?php 
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Installment_m extends CI_Model {

	/* Declare Table installment Purcahse */
	var $ip_tb = 'installment_purchases';
	var $ip_f  = array(
		'0' => 'ip_id',
		'1' => 'ip_trans_id_fk',
		'2' => 'ip_periode',
		'3' => 'ip_periode_end',
		'4' => 'ip_date',
		'5' => 'ip_payment',
		'6' => 'ip_invoice_code',
		'7' => 'ip_invoice_file'
	);

  /* Declare table installment Sales */
  var $is_tb = 'installment_sales';
  var $is_f  = array(
    '0' => 'is_id',
    '1' => 'is_trans_id_fk',
    '2' => 'is_code',
    '3' => 'is_periode',
    '4' => 'is_due_date',
    '5' => 'is_payment',
    '6' => 'is_payment_date',
    '7' => 'is_status',
  );

  /* Installment Purchase */
  	/* Query insert installment_purchase */
  	function insertInstallmentPurchase($insert_data){
  		$resultInsert = $this->db->insert($this->ip_tb, $insert_data);
  		return $resultInsert;
  	}

    /* Query insert installment_purchase */
    function insertInstallmentSales($insert_data){
      $resultInsert = $this->db->insert_batch($this->is_tb, $insert_data);
      return $resultInsert;
    }

  	/* Query select data installment berdasar trans_id */
  	function getInstallmentPurchase($trans_id){
  		$this->db->where($this->ip_f[1], $trans_id);
  		$resultSelect = $this->db->get($this->ip_tb);
  		return $resultSelect->result_array();
  	}

  /* Installment Sales */
    /* Query select data installment berdasar trans_sale_id */
    function getInstallmentSales($trans_id){
      $this->db->order_by($this->is_f[3], 'ASC');
      $this->db->where($this->is_f[1], $trans_id);
      $resultSelect = $this->db->get($this->is_tb);
      return $resultSelect->result_array();
    }

    /* Query update data installment */
    function updateInstallmentSales($data, $periode, $trans_id){
      $this->db->set($data);
      $this->db->where($this->is_f[1], $trans_id);
      $this->db->where($this->is_f[3], $periode);
      $resultUpdate = $this->db->update($this->is_tb);
      return $resultUpdate;
    }

}