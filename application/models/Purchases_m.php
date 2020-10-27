<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Purchases_m extends CI_Model{
  /* Note
      tp_delete => 1 untuk data dihapus, 0 untuk dapat ditampilkan 
  */

  /* Declare var table transaksi barang masuk */
  	var $tp_tb = 'trans_purchase';
  	var $tp_f  = array(
  		'0' => 'tp_id',
  		'1' => 'tp_trans_code',
  		'2' => 'tp_date',
  		'3' => 'tp_supplier_fk',
  		'4' => 'tp_payment_metode',
  		'5' => 'tp_purchase_price',
  		'6' => 'tp_account_fk', // Allow Null
  		'7' => 'tp_paid',
  		'8' => 'tp_insufficient',
  		'9' => 'tp_status',
  		'10' => 'tp_tenor', // Allow Null
  		'11' => 'tp_tenor_periode', // Allow Null
      '12' => 'tp_due_date', // Allow Null
      '13' => 'tp_delete', // as defined 0
      '14' => 'tp_invoice_code',
      '15' => 'tp_installment',
      '16' => 'tp_invoice_file'
  	);

  /* Declare var table detail trans masuk */
  	var $dtp_tb = 'det_trans_purchase';
  	var $dtp_f  = array(
  		'0' => 'dtp_id',
  		'1' => 'dtp_tp_fk',
  		'2' => 'dtp_product_fk',
  		'3' => 'dtp_product_amount',
  		'4' => 'dtp_purchase_price',
      '5' => 'dtp_total_price'
  	);

  /* Declare var table temp */
    var $temp_tp = 'temp_purchase';
    var $temp_f  = array(
      '0' => 'tp_id', 
      '1' => 'tp_product_fk', 
      '2' => 'tp_product_amount', 
      '3' => 'tp_purchase_price',
      '4' => 'tp_total_paid'
    );

  /* Start Query Table Trans Purchase */
  	/* Query get next auto increment table transaksi */
    function getNextIncrement(){
      $this->db->select('AUTO_INCREMENT');
      $this->db->from('information_schema.TABLES');
      $this->db->where('TABLE_SCHEMA', $this->db->database);
      $this->db->where('TABLE_NAME', $this->tp_tb);
    	$resultAI = $this->db->get();
    	return $resultAI->result_array();
    }

    /* Query insert table transaksi pembelian */
    function insertTransPurchase($data){
      $resultInsert = $this->db->insert($this->tp_tb, $data);
      return $resultInsert;
    }

    /* Query select semua data trans pembelian */
    function getAllTransPurchase(){
      $this->db->select('tp.*, supp.supp_name');
      $this->db->from($this->tp_tb.' as tp');
      $this->db->join('tb_supplier as supp', 'supp.supp_id = tp.'.$this->tp_f['3']);
      $this->db->order_by($this->tp_f['2'], 'DESC');
      $resultSelect = $this->db->get();
      return $resultSelect->result_array();
    }

    /* Query select data trans pembelian berdasar id */
    function getTransPurchaseonID($trans_id){
      $this->db->select('tp.*, det_tp.*, supp.supp_name, tb_product.prd_name');
      $this->db->from($this->tp_tb.' as tp');
      $this->db->join($this->dtp_tb.' as det_tp', 'tp.'.$this->tp_f[1].' = det_tp.'.$this->dtp_f[1]);
      $this->db->join('tb_supplier as supp', 'supp.supp_id = tp.'.$this->tp_f[3]);
      $this->db->join('tb_product', 'tb_product.prd_id = det_tp.'.$this->dtp_f[2]);
      $this->db->where('tp.'.$this->tp_f[0], $trans_id);

      $resultSelect = $this->db->get();
      return $resultSelect->result_array();
    }

    /* Query update trans purchase */
    function updateTransPurchase($data, $trans_id){
      $this->db->set($data);
      $this->db->where($this->tp_f[0], $trans_id);
      $resultUpdate = $this->db->update($this->tp_tb);
      return $resultUpdate;
    }

  /* Start Query Table Detail Trans Purchase */
    function insertBatchDetTP($data){
      $resultInsert = $this->db->insert_batch($this->dtp_tb, $data);
      return $resultInsert;
    }

  /* Start Query Table Temp Trans Purchase */
    /* Query insert table temp product pembelian */
    function insertTemp($data){
      $insertData = array(
        $this->temp_f[1] => $data['post_product_id'],
        $this->temp_f[2] => $data['post_product_jumlah'],
        $this->temp_f[3] => $data['post_harga_satuan'],
        $this->temp_f[4] => $data['post_total_bayar']
      );

      $resultInsert = $this->db->insert($this->temp_tp, $insertData);
      return $resultInsert;
    }

    /* Query insert on update */
    function updateTemp($data, $id){
      $this->db->set($data);
      $this->db->where($this->temp_f[0], $id);
      $resultInsert = $this->db->update($this->temp_tp);
      return $resultInsert;
    }

    /* Query get temp product pembelian */
    function getTemp(){
      $this->db->select($this->temp_tp.'.*, tb_product.prd_name');
      $this->db->from($this->temp_tp);
      $this->db->join('tb_product', 'tb_product.prd_id = '.$this->temp_tp.'.tp_product_fk');
      $resultSelect = $this->db->get();
      return $resultSelect->result_array();
    }

    /* Query get temp berdasar product id */
    function getTemponPrdId($prdId){
      $this->db->where($this->temp_f[1], $prdId);
      $resultSelect = $this->db->get($this->temp_tp);
      return $resultSelect->result_array();
    }

    /* Query delete temp product berdasar product_id */
    function deleteTemp($prdId){
      $this->db->where($this->temp_f[1], $prdId);
      $resultDelete = $this->db->delete($this->temp_tp);
      return $resultDelete;
    }

    /* Query Truncate / Hapus semua data di table temp */
    function truncateTemp(){
      $resultTruncate = $this->db->truncate($this->temp_tp);
      return $resultTruncate;
    }

}