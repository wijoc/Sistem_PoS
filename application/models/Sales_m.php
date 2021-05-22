<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Sales_m extends MY_Model{
  /** Query tb_sales */
  	/** Q-Function : Get next autoincrement tb_sales */
  	function getNextIncrement(){
  		$this->db->select('AUTO_INCREMENT');
  		$this->db->from('information_schema.TABLES');
  		$this->db->where('TABLE_NAME', $this->ts_tb);
  		$this->db->where('TABLE_SCHEMA', $this->db->database);
  		return $this->db->get();
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

	/** Query : Select trans sales return (query string) */
	function _querySelectSales($payment_status = 'all', $delete = 'all', $keyword = NULL, $order = NULL){
		$this->db->select('ts.'.$this->ts_f[0].', ts.'.$this->ts_f[1].', ts.'.$this->ts_f[2].', ts.'.$this->ts_f[3].', ts.'.$this->ts_f[5].', ts.'.$this->ts_f[8].', ts.'.$this->ts_f[12].', ctm.'.$this->ctm_f[1]);
		$this->db->from($this->ts_tb.' as ts');
		$this->db->join($this->ctm_tb.' as ctm', 'ctm.'.$this->ctm_f[0].' = ts.'.$this->ts_f[3], 'LEFT');

		if($payment_status == 'L'){
			$this->db->where('ts.'.$this->ts_f[8], 'L');
			$this->db->or_where('ts.'.$this->ts_f[8], 'T');
		} else {
			$this->db->where('ts.'.$this->ts_f[8], $payment_status);
		}
      
		/** Delete status */
		($delete != 'all')? $this->db->where('ts.'.$this->ts_f[13], $delete) : '';
  
		/** Search */
		if($keyword != NULL){
			$this->db->group_start();
			$this->db->like('ts.'.$this->ts_f[1], $keyword);
			$this->db->or_like('ctm.'.$this->ctm_f[1], $keyword);
			$this->db->group_end();
		}
  
		/** Order, default sortby tp_date DESC */
		($order == null)? $this->db->order_by('ts.'.$this->ts_f[2], 'DESC') : $this->db->order_by('ts.'.$this->tp_f[$order['order']['0']['coloumn']], $order['order']['0']['dir']);
	}

	/** Q-Function : Select rowdata trans sales */
	function selectSales($amount = 0, $offset = 0, $payment_s = 'all', $delete = 0){
		$this->_querySelectSales($payment_s, $delete, $this->input->post('search'), $this->input->post('order'));
		($amount > 0)? $this->db->limit($amount, $offset) : '';
		return $this->db->get();
	}

    /** Q-Function : Select data berdasar id */
    function selectSalesOnID($trans_id){
      $this->db->select('ts.*, ctm.'.$this->ctm_f[1].', SUM(dts.'.$this->dts_f[6].') as total_cart, acc.'.$this->acc_f[3].', bank.'.$this->bank_f[2]);
      $this->db->from($this->ts_tb.' as ts');
      $this->db->join($this->ctm_tb.' as ctm', 'ctm.'.$this->ctm_f[0].' = ts.'.$this->ts_f[3], 'LEFT');
      $this->db->join($this->dts_tb.' as dts', 'dts.'.$this->dts_f[1].' = ts.'.$this->ts_f[0]);
      $this->db->join($this->acc_tb.' as acc', 'acc.'.$this->acc_f[0].' = ts.'.$this->ts_f[6], 'LEFT');
      $this->db->join($this->bank_tb.' as bank', 'bank.'.$this->bank_f[0].' = acc.'.$this->acc_f[1], 'LEFT');
      $this->db->where('ts.'.$this->ts_f[0], $trans_id);
      return $this->db->get();
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

    /** Q-function : Select detail trans sale berdasar id */
    function selectDetTS($trans_id){
      $this->db->select('dts.'.$this->dts_f[3].', dts.'.$this->dts_f[4].', dts.'.$this->dts_f[5].', dts.'.$this->dts_f[6].', prd.'.$this->prd_f[2]);
      $this->db->from($this->dts_tb.' as dts');
      $this->db->join($this->prd_tb.' as prd', 'prd.'.$this->prd_f[0].' = dts.'.$this->dts_f[2], 'LEFT');
      $this->db->where('dts.'.$this->dts_f[1], $trans_id);
      $this->db->group_by('dts.'.$this->dts_f[0]);
      return $this->db->get();
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