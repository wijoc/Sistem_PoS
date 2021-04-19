<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Sales_m extends MY_Model{
  /** Query tb_sales */
  	/** Q-Function : Get next autoincrement tb_sales */
  	function getNextIncrement(){
  		$this->db->select('AUTO_INCREMENT');
  		$this->db->from('information_schema.TABLES');
  		$this->db->where('TABLE_SCHEMA', $this->db->database);
  		$this->db->where('TABLE_NAME', $this->ts_tb);
  		$resultAI = $this->db->get();
  		return $resultAI->result_array();
  	}
	
	/** Q-Function: insert transaction sales */
	function insertSale($data){
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

    /** Q-Function : Delete transaction sales (permanent) */
    function deleteSale($trans_id){
  		return $this->db->delete($this->ts_tb, array($this->ts_f[0] => $trans_id));
    }

  /** Query det_sales */
	/** Q-Function : Insert detail trans sale */
    function insertBatchDetTS($data){
		$resultInsert = $this->db->insert_batch($this->dts_tb, $data);
		return $resultInsert;
	}

	/** Q-Function : Delete detail trans sale */
	function deleteDetTS($trans_id){
		$this->db->where($this->dts_f[1], $trans_id);
		return $this->db->delete($this->dts_tb);
	}

  /** Query temp_sales */
    /** Q-Function : Insert cart */
    function insertCart($data){
		$insertData = array(
		  $this->cs_f[1] => $data['post_product_id'],
		  $this->cs_f[2] => $data['post_qty'],
		  $this->cs_f[3] => $data['post_price'],
		  $this->cs_f[4] => $data['post_discount'],
		  $this->cs_f[5] => $data['post_total']
		);
  
		return $this->db->insert($this->cs_tb, $insertData);
	}

    /** Q-Function : Select cart */
    function selectCart(){
    	$this->db->select($this->cs_tb.'.*, '.$this->prd_tb.'.'.$this->prd_f[2]);
    	$this->db->from($this->cs_tb);
    	$this->db->join($this->prd_tb, $this->prd_tb.'.'.$this->prd_f[0].' = '.$this->cs_tb.'.'.$this->cs_f[1]);
    	return $this->db->get();
    }

    /** Q-Function : Get cart berdasar product_id */
    function getCartonPrdID($prd_id){
		$this->db->where($this->cs_f[1], $prd_id);
		return $this->db->get($this->cs_tb);
	}

    /** Q-Function : Update cart */
    function updateCart($data, $id){
      $this->db->set($data);
      $this->db->where($this->cs_f[0], $id);
      return $this->db->update($this->cs_tb);
    }

    /** Q-Function : Delete cart berdasar product_id */
    function deleteCart($prdId, $prdPrice){
      $this->db->where($this->cs_f[1], $prdId);
      $this->db->where($this->cs_f[3], $prdPrice);
      return $this->db->delete($this->cs_tb);
    }

    /** Q-Function : Truncate / Hapus semua data di table temp */
    function truncateCart(){
      return $this->db->truncate($this->cs_tb);
    }
}