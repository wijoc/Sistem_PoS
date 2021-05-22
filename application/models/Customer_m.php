<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Customer_m extends MY_Model{
  /** Note 
   * 1. member status :
   *    0 = active
   *    1 = deleted
   *    2 = deactive
  */

  /** Q-Function select data customer */
  function selectCustomer($amount = 0, $offset = 0, $status = 'all', $keyword = NULL, $order = 'asc'){
    $this->db->select('ctm.*');
    $this->db->from($this->ctm_tb.' as ctm');

    if($status != 'all'){ $this->db->where($this->ctm_f[5], 0); }

    if($keyword != NULL){
      $this->db->group_start();
      $this->db->like($this->ctm_f[1], $keyword);
      $this->db->group_end();
    }

    $this->db->order_by($this->ctm_f[1], $order);

    if($amount > 0){ $this->db->limit($amount, $offset); }

    return $this->db->get();
  }

  /** Q-Function : Select row data customer berdasar ctm_id */
  function selectCustomerOnID($id){
    $this->db->where($this->ctm_f[0], $id);
    return $this->db->get($this->ctm_tb);
  }

  /** Q-Function : Select row data customer berdasar term nama */
  function searchCustomer($field, $term){
    $this->db->like($this->ctm_f[$field], $term);
    $this->db->where($this->ctm_f[5], 0);
    $returnResult = $this->db->get($this->ctm_tb);
    return $returnResult->result_array();
  }

  /** Q-Function : Insert data customer */
  function insertCustomer($data, $return_value = null){
  	$resultInsert = $this->db->insert($this->ctm_tb, $data);
    $returnResult = ($return_value == 'id') ? $this->db->insert_id() : $resultInsert;
  	return $returnResult;
  }

  /** Q-Function : Update data customer */
  function updateCustomer($data, $id){
    $this->db->set($data);
    $this->db->where($this->ctm_f[0], $id);
    $resultUpdate = $this->db->update($this->ctm_tb);
    return $resultUpdate;
  }

  /** Q-Function : Delete data customer */
  function deleteCustomer($id){
  	$resultDelete = $this->db->delete($this->ctm_tb, array($this->ctm_f[0] => $id));
  	return $resultDelete;
	}

  /** Q-Function : Soft delete data customer, change ctm_status to 1 for deleted rowdata */
  function softdeleteCustomer($id){
    $this->db->set($this->ctm_f[5], '1');
    $this->db->where($this->ctm_f[0], $id);
    $resultUpdate = $this->db->update($this->ctm_tb);
    return $resultUpdate;
  }
}