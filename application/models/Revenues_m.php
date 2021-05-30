<?php 
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Revenues_m extends MY_Model {

	/** Q-Function : Select next auto increment */
  	function getNextIncrement(){
  		$this->db->select('AUTO_INCREMENT');
  		$this->db->from('information_schema.TABLES');
  		$this->db->where('TABLE_NAME', $this->tr_tb);
  		$this->db->where('TABLE_SCHEMA', $this->db->database);
  		return $this->db->get();
  	}

	/** Q-Function : insert data pengeluaran */
	function insertRevenues($data){
		return $this->db->insert($this->tr_tb, $data);
	}

	/** Query : Select data Revenue */
	function _querySelectRevenues($keyword = NULL, $order = NULL){
		$this->db->select('*');
		$this->db->from($this->tr_tb);

		/** Search */
		if($keyword != NULL){
			$this->db->group_start();
			$this->db->where($this->tr_f[1]);
			$this->db->or_where($this->tr_f[2]);
			$this->db->group_end();
		}

		/** Order by */
		($order != NULL)? $this->db->order_by($this->tr_f[$order['order']['0']['coloumn']], $order['order']['0']['dir']) : $this->db->order_by($this->tr_f[2], 'DESC');
	}

	/** Q-Function select data revenues */
	function selectRevenues($amount = 0, $offset = 0){
		$this->_querySelectRevenues($this->input->post('search'), $this->input->post('order'));
		($amount > 0)? $this->db->limit($amount, $offset) : '';
		return $this->db->get();
	}

	/** Q-Function : Count All Data */
	function countAllRevenues(){
		$this->_querySelectRevenues($this->input->post('search'), $this->input->post('order'));
		return $this->db->get()->num_rows();
	}

	/** Q-Function : Select row-data berdasar tr_id */
	function selectRevenuesOnID($trans_id){
		$this->db->select('tr.'.$this->tr_f[1].', tr.'.$this->tr_f[2].', tr.'.$this->tr_f[3].', tr.'.$this->tr_f[4].', tr.'.$this->tr_f[5].', tr.'.$this->tr_f[7].', acc.'.$this->acc_f[2].', acc.'.$this->acc_f[3].', bank.'.$this->bank_f[2]);
		$this->db->from($this->tr_tb.' as tr');
		$this->db->join($this->acc_tb.' as acc', 'acc.'.$this->acc_f[0].' = tr.'.$this->tr_f[6], 'LEFT');
		$this->db->join($this->bank_tb.' as bank', 'bank.'.$this->bank_f[0].' = acc.'.$this->acc_f[1], 'LEFT');
		$this->db->where($this->tr_f[0], $trans_id);
		return $this->db->get();
	}
}