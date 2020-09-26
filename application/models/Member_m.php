<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Member_m extends CI_Model{
	
  /* Declare table */
  	var $member_tb = 'tb_member';
  	var $member_f  = array(
  		'0' => 'member_id',
  		'1' => 'member_nama',
  		'2' => 'member_status',
  		'3' => 'member_discount'
  	);

  /* Query */
  	/* Query select semua row data member */
  	function getAllMember(){
  		$this->db->order_by($this->member_f[1], 'ASC');
  		$resultGet = $this->db->get($this->member_tb);
  		return $resultGet->result_array();
  	}

  	/* Query insert data member */
  	function insertMember($data){
  		$resultInsert = $this->db->insert($this->member_tb, $data);
  		return $resultInsert;
  	}

  	/* Query delete data member */
  	function deleteMember($id){
  		$resultDelete = $this->db->delete($this->member_tb, array($this->member_f[0] => $id));
  		return $resultDelete;
  	}
}