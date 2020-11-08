<?php 
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Expense_m extends CI_Model {
	
	/* Declare Var table expense */
	var $te_tb = 'trans_expense';
	var $te_f  = array(
		'0' => 'te_id',
		'1' => 'te_necessity',
		'2' => 'te_date',
		'3' => 'te_payment_method',
		'4' => 'te_payment',
		'5' => 'te_note',
		'6' => 'te_account_id_fk',
		'7' => 'te_invoice'
	);

	/* Query insert data pengeluaran */
	function insertExpense($data){
		$resultInsert = $this->db->insert($this->te_tb, $data);
		return $resultInsert;
	}

	/* Query get data expense */
	function getExpense(){
		$this->db->order_by($this->te_f[2], 'DESC');
		$resultSelect = $this->db->get($this->te_tb);
		return $resultSelect->result_array();
	}
}