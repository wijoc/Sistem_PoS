<?php 
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Revenues_m extends CI_Model {
	
	/* Declare Var table revenues */
	var $tr_tb = 'trans_revenues';
	var $tr_f  = array(
		'0' => 'tr_id',
		'1' => 'tr_trans_code',
		'2' => 'tr_source',
		'3'	=> 'tr_date',
		'4' => 'tr_payment_method',
		'5' => 'tr_payment',
		'6' => 'tr_note',
		'7' => 'tr_account_id_fk'
	);

	/* Query get next auto increment */
  	function getNextIncrement(){
  		$this->db->select('AUTO_INCREMENT');
  		$this->db->from('information_schema.TABLES');
  		$this->db->where('TABLE_SCHEMA', $this->db->database);
  		$this->db->where('TABLE_NAME', $this->tr_tb);
  		$resultAI = $this->db->get();
  		return $resultAI->result_array();
  	}

	/* Query insert data pengeluaran */
	function insertRevenues($data){
		$resultInsert = $this->db->insert($this->tr_tb, $data);
		return $resultInsert;
	}

	/* Query get data Revenue */
	function getRevenues(){
		$this->db->order_by($this->tr_f[3], 'DESC');
		$resultSelect = $this->db->get($this->tr_tb);
		return $resultSelect->result_array();
	}
}