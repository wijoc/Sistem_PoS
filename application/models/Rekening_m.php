<?php 
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Rekening_m extends CI_Model{

	/* Declare table rekening */
	var $rek_tb = 'tb_rekening_bank';
	var $rek_f = array(
		'0' => 'rek_id',
		'1' => 'rek_bank_code',
		'2' => 'rek_nomor',
		'3' => 'rek_atas_nama'
	);

	/* Declare table bank */
	var $bank_tb = 'ref_bank';
	var $bank_f = array(
		'0' => 'bank_id',
		'1' => 'bank_code',
		'2' => 'bank_name'
	);

  /* Query */
  	/* Query select SEMUA rekening join bank */
  	function getAllRekening(){
  		$this->db->select('*');
  		$this->db->from($this->rek_tb);
  		$this->db->join($this->bank_tb, $this->bank_tb.'.'.$this->bank_f[1].'='.$this->rek_tb.'.'.$this->rek_f[1]);
  		$resultSelect = $this->db->get();
  		return $resultSelect->result_array();
  	}

  	/* Query insert rekening */
  	function insertRekening($data){
  		$resultInsert = $this->db->insert($this->rek_tb, $data);
  		return $resultInsert;
  	}

  	/* Query select Semua kode bank */
  	function getAllBank(){
  		$resultSelect = $this->db->get($this->bank_tb);
  		return $resultSelect->result_array();
  	}
}