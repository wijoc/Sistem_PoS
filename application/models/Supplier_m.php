<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Supplier_m extends CI_Model{

  /* Note
    supp_status : 1 for deleted data, 0 for allowed data 
  */
	
  /* Declare table */
  	var $supp_tb = 'tb_supplier';
  	var $supp_f  = array(
  		'0' => 'supp_id',
  		'1' => 'supp_name',
  		'2' => 'supp_contact_name',
  		'3' => 'supp_email',
  		'4' => 'supp_telp',
  		'5' => 'supp_address',
      '6' => 'supp_status'
  	);

  /* Query */
  	/* Query select semua row data supplier */
  	function getAllSupplier(){
  		$this->db->order_by($this->supp_f[1], 'ASC');
  		$resultGet = $this->db->get($this->supp_tb);
  		return $resultGet->result_array();
  	}

    /* Query select row data supplier berdasar supp_id */
    function getSupplierOnID($id){
      $this->db->where($this->supp_f[0], $id);
      $resultGet = $this->db->get($this->supp_tb);
      return $resultGet->result_array();
    }

    /* Query select row data supplier dengan supp_status 0 */
    function getAllowedSupplier($amount, $offset){
      $this->db->where($this->supp_f[6], '0');
      $this->db->order_by($this->supp_f[1], 'ASC');
      $resultGet = $this->db->get($this->supp_tb, $amount, $offset);
      return $resultGet;
    }

  	/* Query insert data supplier */
  	function insertSupplier($data){
  		$resultInsert = $this->db->insert($this->supp_tb, $data);
  		return $resultInsert;
  	}

    /* Query update data supplier */
    function updateSupplier($data, $id){
      $this->db->set($data);
      $this->db->where($this->supp_f[0], $id);
      $resultUpdate = $this->db->update($this->supp_tb);
      return $resultUpdate;
    }

  	/* Query delete data supplier */
  	function deleteSupplier($id){
  		$resultDelete = $this->db->delete($this->supp_tb, array($this->supp_f[0] => $id));
  		return $resultDelete;
  	}

    /* Query soft delete data supplier, change supp_status to 1 for deleted rowdata */
    function softdeleteSupplier($id){
      $this->db->set($this->supp_f[6], '1');
      $this->db->where($this->supp_f[0], $id);
      $resultUpdate = $this->db->update($this->supp_tb);
      return $resultUpdate;
    }
}