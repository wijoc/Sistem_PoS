<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Customer_m extends CI_Model{
  /* Note 
    1. member status :
        Y = active
        N = deactive
        D = deleted
  */
	
  /* Declare table */
  	var $ctm_tb = 'tb_customer';
  	var $ctm_f  = array(
  		'0' => 'ctm_id',
  		'1' => 'ctm_name',
      '2' => 'ctm_phone',
      '3' => 'ctm_email',
      '4' => 'ctm_address',
  		'5' => 'ctm_status',
  		'6' => 'ctm_discount_type',
      '7' => 'ctm_discount_percent',
      '8' => 'ctm_discount_price'
  	);

  /* Query */
  	/* Query select semua row data customer */
  	function getAllCustomer(){
  		$this->db->order_by($this->ctm_f[1], 'ASC');
  		$resultGet = $this->db->get($this->ctm_tb);
  		return $resultGet->result_array();
  	}

    /* Query select row data customer, dengan status <> D (D untuk data customer deleted) */
    function getAllowedCustomer($amount, $offset){
      $this->db->where($this->ctm_f[5], 'Y');
      $this->db->order_by($this->ctm_f[1], 'ASC');
      $resultGet = $this->db->get($this->ctm_tb, $amount, $offset);
      return $resultGet;
    }

    /* Query select row data customer berdasar ctm_id */
    function getCustomerOnID($id){
      $this->db->where($this->ctm_f[0], $id);
      $resultSelect = $this->db->get($this->ctm_tb);
      return $resultSelect->result_array();
    }

  	/* Query insert data customer */
  	function insertCustomer($data){
  		$resultInsert = $this->db->insert($this->ctm_tb, $data);
  		return $resultInsert;
  	}

    /* Query update data customer */
    function updateCustomer($data, $id){
      $this->db->set($data);
      $this->db->where($this->ctm_f[0], $id);
      $resultUpdate = $this->db->update($this->ctm_tb);
      return $resultUpdate;
    }

  	/* Query delete data customer */
  	function deleteCustomer($id){
  		$resultDelete = $this->db->delete($this->ctm_tb, array($this->ctm_f[0] => $id));
  		return $resultDelete;
  	}

    /* Query soft delete data customer, change ctm_status to D for deleted rowdata */
    function softdeleteCustomer($id){
      $this->db->set($this->ctm_f[5], 'D');
      $this->db->where($this->ctm_f[0], $id);
      $resultUpdate = $this->db->update($this->ctm_tb);
      return $resultUpdate;
    }
}