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
    /** Q-Function : Insert Installment */
    function insertIS($insert_data){
      return $this->db->insert_batch($this->is_tb, $insert_data);
    }

    /** Q-Function : Select last installment */
    function selectLastPeriodeIS($ts_id){
      $this->db->select($this->is_f[3]);
      $this->db->where($this->is_f[1], $ts_id);
      $this->db->where($this->is_f[7], 0);
      $this->db->order_by($this->is_f[3], 'ASC');
      $this->db->limit(1);
      return $this->db->get($this->is_tb);
    }

    /** Q-Function : Select last paid installment */
    function selectLastISCode($ts_id){
      $this->db->select('*');
      $this->db->where($this->is_f[1], $ts_id);
      $this->db->where($this->is_f[7], 1);
      $this->db->order_by($this->is_f[3], 'DESC');
      $this->db->limit(1);
      return $this->db->get($this->is_tb);
    }

    /** Q-Function : Select Installment berdasar trans_id */
    function selectISOnID($ts_id){
      $this->db->where($this->is_f[1], $ts_id);
      $this->db->order_by($this->is_f[3], 'ASC');
      return $this->db->get($this->is_tb);
    }

    /** Q-Function : Update pembayaran installment */
    function updatePaymentIS($update_data, $trans_id, $is_periode){
      $this->db->where($this->is_f[1], $trans_id);
      $this->db->where($this->is_f[3], $is_periode);
      $this->db->set($update_data);
      return $this->db->update($this->is_tb);
    }
}