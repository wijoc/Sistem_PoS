<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Supplier_m extends MY_Model{

  /* Note
    supp_status : 1 for deleted data, 0 for allowed data 
  */

  /** Q-Function : select data supplier */
  function selectSupplier($amount = 0, $offset = 0, $status = 'all', $keyword = NULL, $order = 'asc'){
    $this->db->select('supp.*');
    $this->db->from($this->supp_tb.' as supp');

    if($status != 'all'){ $this->db->where($this->supp_f[6], 0); }

    if($keyword != NULL){
      $this->db->group_start();
      $this->db->like($this->supp_f[1], $keyword);
      $this->db->or_like($this->supp_f[2], $keyword);
      $this->db->group_end();
    }

    $this->db->order_by($this->supp_f[1], $order);

    if($amount > 0){ $this->db->limit($amount, $offset); }

    return $this->db->get();
  }

  /** Q-Function : select row data supplier berdasar supp_id */
  function selectSupplierByID($id){
    $this->db->where($this->supp_f[0], $id);
    $resultSelect = $this->db->get($this->supp_tb);
    return $resultSelect;
  }

  /** Query : insert data supplier */
  function insertSupplier($data){
  	$resultInsert = $this->db->insert($this->supp_tb, $data);
  	return $resultInsert;
  }

  /** Query : update data supplier */
  function updateSupplier($update_data, $id){
    $this->db->set($update_data);
    $this->db->where($this->supp_f[0], $id);
    $resultUpdate = $this->db->update($this->supp_tb);
    return $resultUpdate;
  }

  /** Query : delete data supplier */
  function deleteSupplier($id){
  	$resultDelete = $this->db->delete($this->supp_tb, array($this->supp_f[0] => $id));
  	return $resultDelete;
	}

  /** Query : soft delete data supplier, change supp_status to 1 for deleted rowdata */
  function softdeleteSupplier($id){
    $this->db->set($this->supp_f[6], '1');
    $this->db->where($this->supp_f[0], $id);
    $resultUpdate = $this->db->update($this->supp_tb);
    return $resultUpdate;
  }
}