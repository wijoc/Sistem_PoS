<?php
defined'BASEPATH') OR exit('No direct script access allowed !');

Class Trans_masuk_m extends CI_Model{

  /* Declare var table transaksi barang masuk */
  	var $tm_tb = 'trans_masuk';
  	var $tm_f  = array(
  		'0' => 'tm_id',
  		'1' => 'tm_no_trans',
  		'2' => 'tm_date',
  		'3' => 'tm_supplier_fk',
  		'4' => 'tm_metode_bayar',
  		'5' => 'tm_tunai_kredit',
  		'6' => 'tm_rekening_fk',
  		'7' => 'tm_dibayar',
  		'8' => 'tm_kurangan',
  		'9' => 'tm_status',
  		'10' => 'tm_tenor',
  		'11' => 'tm_tempo'
  	);

  /* Declare var table detail trans masuk */
  	var $dtm_tb = 'det_trans_masuk';
  	var $dtm_f  = array(
  		'' => 'dtm_id',
  		'' => 'dtm_tm_fk',
  		'' => 'dtm_dtm_product_fk',
  		'' => 'dtm_product_amount',
  		'' => 'dtm_purchase_price'
  	);

  /* Start Query */
  	/* Query get next auto increment table transaksi */
    function getNextIncrement(){
        $this->db->select('AUTO_INCREMENT');
        $this->db->from('information_schema.TABLES');
        $this->db->where('TABLE_SCHEMA', $this->db->database);
        $this->db->where('TABLE_NAME', $this->tm_tb);
    	$returnValue = $this->db->get();
    	return $returnValue->result_array();
    }

}