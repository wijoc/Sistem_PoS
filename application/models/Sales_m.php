<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Sales_m extends CI_Model{

  /* Declare Table Trans Penjualan */
	var $ts_tb = 'trans_sales';
	var $ts_f  = array(
		'0' => 'ts_id',
		'1' => 'ts_trans_code',
		'2' => 'ts_date',
		'3' => 'ts_customer_fk',
		'4' => 'ts_payment_metode',
		'5' => 'ts_sales_price',
		'6' => 'ts_account_fk',
		'7' => 'ts_paid',
		'8' => 'ts_status',
		'9' => 'ts_tenor',
		'10' => 'ts_tenor_periode',
    '11' => 'ts_installment',
		'12' => 'ts_due_date',
    '13' => 'ts_delete',
    '14' => 'ts_delivery_metode',
    '15' => 'ts_delivery_payment',
    '16' => 'ts_return'
	);

  /* Declare table Detail Trans Penjualan */
	var $dts_tb = 'det_trans_sales';
	var $dts_f  = array(
		'0' => 'dts_id',
		'1' => 'dts_ts_id_fk',
		'2' => 'dts_product_fk',
		'3' => 'dts_product_amount',
		'4' => 'dts_sale_price',
		'5' => 'dts_discount',
		'6' => 'dts_total_price'
	);

  /* Declare table temp / keranjang trans penjualan */
	var $temp_ts = 'temp_sales';
	var $temp_f  = array(
		'0' => 'temps_id',
		'1' => 'temps_product_fk',
		'2' => 'temps_product_amount',
		'3' => 'temps_sale_price',
		'4' => 'temps_discount',
		'5' => 'temps_total_paid'
	);

  /* Start Query table trans sales */
  	/* Query get next autoincrement table transaksi */
  	function getNextIncrement(){
  		$this->db->select('AUTO_INCREMENT');
  		$this->db->from('information_schema.TABLES');
  		$this->db->where('TABLE_SCHEMA', $this->db->database);
  		$this->db->where('TABLE_NAME', $this->ts_tb);
  		$resultAI = $this->db->get();
  		return $resultAI->result_array();
  	}

    /* Query insert table transaksi penjualan */
    function insertTransSales($data){
      $resultInsert = $this->db->insert($this->ts_tb, $data);
      if($resultInsert > 0){
        $dataReturn = array(
          'resultInsert' => $resultInsert,
          'insertID'     => $this->db->insert_id() 
        );
      } else {
        $dataReturn = array(
          'resultInsert' => $resultInsert,
          'insertID'     => null 
        );
      }
      return $dataReturn;
    }

    /* Query select semua data trans penjualan */
    function getAllTransSales(){
      $this->db->select('ts.*, ctm.ctm_name');
      $this->db->from($this->ts_tb.' as ts');
      $this->db->join('tb_customer as ctm', 'ctm.ctm_id = ts.'.$this->ts_f['3']);
      $this->db->order_by($this->ts_f['2'], 'DESC');
      $resultSelect = $this->db->get();
      return $resultSelect->result_array();
    }

    /* Query select data trans penjualan dengan ts_delete = 0 */
    function getAvailableTransSales(){
      $this->db->select('ts.*, ctm.ctm_name');
      $this->db->from($this->ts_tb.' as ts');
      $this->db->where($this->ts_f[13], '0');
      $this->db->join('tb_customer as ctm', 'ctm.ctm_id = ts.'.$this->ts_f['3'], 'LEFT');
      $this->db->order_by($this->ts_f[2], 'DESC');
      $resultSelect = $this->db->get();
      return $resultSelect->result_array();
    }

    /* Query select data trans penjualan berdasar trans id */
    function getTransSalesonID($trans_id){
      $this->db->select('ts.*, dts.*, ctm.ctm_name, tb_product.prd_name');
      $this->db->from($this->ts_tb.' as ts ');
      $this->db->join($this->dts_tb.' as dts', 'ts.'.$this->ts_f[0].'=dts.'.$this->dts_f[1]);
      $this->db->join('tb_customer as ctm', 'ts.'.$this->ts_f[3].'=ctm.ctm_id', 'LEFT');
      $this->db->join('tb_product', 'dts.'.$this->dts_f[2].'=tb_product.prd_id');
      $this->db->where('ts.'.$this->ts_f[0], $trans_id);
      $resultSelect = $this->db->get();
      return $resultSelect->result_array();
    }

    /** Query update sales */
    function updateTransSales($id, $data){
      $this->db->set($data);
      $this->db->where($this->ts_f[0], $id);
      $resultUpdate = $this->db->update($this->ts_tb);
      return $resultUpdate;
    }

    /** Delete trans sales (permanent) */
    function deleteTransSales($trans_id){
  		$resultDelete = $this->db->delete($this->ts_tb, array($this->ts_f[0] => $trans_id));
  		return $resultDelete;
    }

  /* Start Query Table Detail Trans Purchase */
    function insertBatchDetTS($data){
      $resultInsert = $this->db->insert_batch($this->dts_tb, $data);
      return $resultInsert;
    }

  /* Start Query Table Temp Trans Purchase */
    /* Query insert table temp product penjualan */
    function insertTemp($data){
      $insertData = array(
        $this->temp_f[1] => $data['post_product_id'],
        $this->temp_f[2] => $data['post_product_jumlah'],
        $this->temp_f[3] => $data['post_harga_satuan'],
        $this->temp_f[4] => $data['post_potongan'],
        $this->temp_f[5] => $data['post_total_bayar']
      );

      $resultInsert = $this->db->insert($this->temp_ts, $insertData);
      return $resultInsert;
    }

    /* Query get temp product penjualan */
    function getTemp(){
      $this->db->select($this->temp_ts.'.*, tb_product.prd_name');
      $this->db->from($this->temp_ts);
      $this->db->join('tb_product', 'tb_product.prd_id = '.$this->temp_ts.'.'.$this->temp_f[1]);
      $resultSelect = $this->db->get();
      return $resultSelect->result_array();
    }

    /* Query get temp berdasar product id */
    function getTemponPrdId($prdId){
      $this->db->where($this->temp_f[1], $prdId);
      $resultSelect = $this->db->get($this->temp_ts);
      return $resultSelect->result_array();
    }

    /* Query insert on update */
    function updateTemp($data, $id){
      $this->db->set($data);
      $this->db->where($this->temp_f[0], $id);
      $resultInsert = $this->db->update($this->temp_ts);
      return $resultInsert;
    }

    /* Query delete temp product berdasar product_id */
    function deleteTemp($prdId){
      $this->db->where($this->temp_f[1], $prdId);
      $resultDelete = $this->db->delete($this->temp_ts);
      return $resultDelete;
    }

    /* Query Truncate / Hapus semua data di table temp */
    function truncateTemp(){
      $resultTruncate = $this->db->truncate($this->temp_ts);
      return $resultTruncate;
    }
}