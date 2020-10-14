<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Supplier_m extends CI_Model{
	
  /* Declare table */
  	var $supp_tb = 'tb_supplier';
  	var $supp_f  = array(
  		'0' => 'supp_id',
  		'1' => 'supp_name',
  		'2' => 'supp_contact_name',
  		'3' => 'supp_email',
  		'4' => 'supp_telp',
  		'5' => 'supp_address'
  	);

  /* Query */
  	/* Query select semua row data supplier */
  	function getAllSupplier(){
  		$this->db->order_by($this->supp_f[1], 'ASC');
  		$resultGet = $this->db->get($this->supp_tb);
  		return $resultGet->result_array();
  	}

  	/* Query insert data supplier */
  	function insertSupplier($data){
  		$resultInsert = $this->db->insert($this->supp_tb, $data);
  		return $resultInsert;
  	}

  	/* Query delete data supplier */
  	function deleteSupplier($id){
  		$resultDelete = $this->db->delete($this->supp_tb, array($this->supp_f[0] => $id));
  		return $resultDelete;
  	}
}