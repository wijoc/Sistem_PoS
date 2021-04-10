<?php 
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Installment_m extends MY_Model {
  /** Purchase Installment */
    /** Q-Function : Insert installment */
  	function insertIP($insert_data){
  		return $this->db->insert($this->ip_tb, $insert_data);
    }

    /** Q-Function : Select on tp_id */
    function selectIPonID($tp_id){
      $this->db->where($this->ip_f[1], $tp_id);
      $this->db->order_by($this->ip_f[2], 'ASC');
      return $this->db->get($this->ip_tb);
    }

    /** Q-Function : Select last installment */
    function selectLastPeriodeIP($tp_id){
      $this->db->select($this->ip_f[3]);
      $this->db->where($this->ip_f[1], $tp_id);
      $this->db->order_by($this->ip_f[3], 'DESC');
      $this->db->limit(1);
      return $this->db->get($this->ip_tb);
    }

  /** Sales Installment */
}