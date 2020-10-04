<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Pembelian_m extends CI_Model{

  /* Declare var table transaksi barang masuk */
  	var $tb_tb = 'trans_purchase';
  	var $tb_f  = array(
  		'0' => 'tb_id',
  		'1' => 'tb_no_trans',
  		'2' => 'tb_date',
  		'3' => 'tb_supplier_fk',
  		'4' => 'tb_payment_metode',
  		'5' => 'tb_cash_or_credit',
  		'6' => 'tb_account_fk',
  		'7' => 'tb_paid',
  		'8' => 'tb_insufficient',
  		'9' => 'tb_status',
  		'10' => 'tb_tenor',
  		'11' => 'tb_tempo'
  	);

  /* Declare var table detail trans masuk */
  	var $dtb_tb = 'det_trans_purchase';
  	var $dtb_f  = array(
  		'' => 'dtb_id',
  		'' => 'dtb_tb_fk',
  		'' => 'dtb_product_fk',
  		'' => 'dtb_product_amount',
  		'' => 'dtb_purchase_price'
  	);

  /* Declare var table temp */
    var $temp_tb = 'temp_purchase';
    var $temp_f  = array(
      '0' => 'tp_id', 
      '1' => 'tp_product_fk', 
      '2' => 'tp_product_amount', 
      '3' => 'tp_purchase_price',
      '4' => 'tp_total_paid'
    );

  /* Start Query */
  	/* Query get next auto increment table transaksi */
    function getNextIncrement(){
      $this->db->select('AUTO_INCREMENT');
      $this->db->from('information_schema.TABLES');
      $this->db->where('TABLE_SCHEMA', $this->db->database);
      $this->db->where('TABLE_NAME', $this->tb_tb);
    	$returnValue = $this->db->get();
    	return $returnValue->result_array();
    }

    /* Query insert table temp product pembelian */
    function insertTemp($data){
      $insertData = array(
        $this->temp_f[1] => $data['post_product_id'],
        $this->temp_f[2] => $data['post_product_jumlah'],
        $this->temp_f[3] => $data['post_harga_satuan'],
        $this->temp_f[4] => $data['post_total_bayar']
      );

      $resultInsert = $this->db->insert($this->temp_tb, $insertData);
      return $resultInsert;
    }

    /* Query get temp product pembelian */
    function getTemp(){
      $this->db->select($this->temp_tb.'.*, tb_product.prd_nama');
      $this->db->from($this->temp_tb);
      $this->db->join('tb_product', 'tb_product.prd_id = '.$this->temp_tb.'.tp_product_fk');
      $resultSelect = $this->db->get();
      return $resultSelect->result_array();
    }

}