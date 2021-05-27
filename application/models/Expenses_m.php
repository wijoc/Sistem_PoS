<?php 
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Expenses_m extends MY_Model {

	/** Q-Function : insert data expense */
	function insertExpenses($data){
		return $this->db->insert($this->te_tb, $data);
	}

	/** Query select data expense */
	private function __querySelectExpense($keyword = NULL, $order = NULL){
		$this->db->select('*');
		$this->db->from($this->te_tb);

		/** Search */
		if($keyword != NULL){
			$this->db->group_start();
			$this->db->where($this->te_f[1]);
			$this->db->or_where($this->te_f[5]);
			$this->db->group_end();
		}

		/** Order by */
		($order != NULL)? $this->db->order_by($this->te_f[$order['order']['0']['coloumn']], $order['order']['0']['dir']) : $this->db->order_by($this->te_f[2], 'DESC');
	}

	/** Q-Function select data expense */
	function selectExpenses($amount = 0, $offset = 0){
		$this->__querySelectExpense($this->input->post('search'), $this->input->post('order'));
		($amount > 0)? $this->db->limit($amount, $offset) : '';
		return $this->db->get();
	}

	/** Q-Function : Count All Data */
	function countAllExpenses(){
		$this->__querySelectExpense($this->input->post('search'), $this->input->post('order'));
		return $this->db->get()->num_rows();
	}
}