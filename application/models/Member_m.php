<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Member_m extends CI_Model{
  /* Note 
    1. member status :
        Y = active
        N = deactive
        D = deleted
  */
	
  /* Declare table */
  	var $member_tb = 'tb_member';
  	var $member_f  = array(
  		'0' => 'member_id',
  		'1' => 'member_name',
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

    /* Query select row data member, dengan status 0 */
    function getAllowedMember(){
      $this->db->not_like($this->member_f[2], 'D');
      $this->db->order_by($this->member_f[1], 'ASC');
      $resultGet = $this->db->get($this->member_tb);
      return $resultGet->result_array();
    }

    /* Query select aktif member */
    function getAktifMember(){
      $this->db->where($this->member_f[2], 'Y');
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

    /* Query soft delete data supplier, change supp_status to 1 for deleted rowdata */
    function softdeleteMember($id){
      $this->db->set($this->member_f[2], 'D');
      $this->db->where($this->member_f[0], $id);
      $resultUpdate = $this->db->update($this->member_tb);
      return $resultUpdate;
    }
}