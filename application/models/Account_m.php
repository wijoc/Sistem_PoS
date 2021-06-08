<?php 
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Account_m extends MY_Model{

  /** CRUD Account / Rekening */
    /** Query : select account */
    private function _querySelectAccount($keyword = null, $order = null, $status = 'all'){
      $this->db->select('*');
      $this->db->from($this->acc_tb.' as a');
      ($status != 'all')? $this->db->where($this->acc_f[4], $status) : '';
      $this->db->join($this->bank_tb.' as b', 'a.'.$this->acc_f[1].' = b.'.$this->bank_f[0], 'LEFT');

      /** Jika keyword != null, set search data berdasar keyword */
      if($keyword != null){
        $this->db->group_start();
        $this->db->like('a.'.$this->acc_f[1], $keyword['search']['value']);
        $this->db->or_like('a.'.$this->acc_f[2], $keyword['search']['value']);
        $this->db->or_like('a.'.$this->acc_f[3], $keyword['search']['value']);
        $this->db->or_like('b.'.$this->bank_f[1], $keyword['search']['value']);
        $this->db->or_like('b.'.$this->bank_f[2], $keyword['search']['value']);
        $this->db->group_end();
      }
          
      /** Jika order = null, sort data bedasar acc_id */
      ($order == null)? $this->db->order_by('b.'.$this->bank_f[0], 'ASC') : $this->db->order_by('a.'.$this->acc_f[$order['order']['0']['coloumn']], $order['order']['0']['dir']);
    }

    /** Q-Function : select semua account */
    function selectAccount($amount = 0, $offset = 0, $status = 0){
      $this->_querySelectAccount($this->input->post('prdSearch'), $this->input->post('order'), $status);
      ($amount > 0)? $this->db->limit($amount, $offset) : '';
      return $this->db->get();
    }

    /** Q-Function : count_filtered */
    function count_filtered($amount = 0, $offset = 0){
          $resultSelect = $this->selectAccount($amount, $offset);
          return $resultSelect->num_rows();
    }

    /** Q-Function : total semua */
    function count_all(){
          $this->_querySelectAccount(null, null);
          $resultSelect = $this->db->get();
          return $resultSelect->num_rows();
    }

    /** Q-Function : select accrount on id */
    function selectAccountOnID($acc_id){
      $this->db->select('*');
      $this->db->from($this->acc_tb.' as a');
      $this->db->join($this->bank_tb.' as b', 'a.'.$this->acc_f[1].' = b.'.$this->bank_f[0], 'LEFT');
      $this->db->where('a.'.$this->acc_f[0], $acc_id);
      return $this->db->get();
    }

  	/** Q-Function : insert account */
  	function insertAccount($data){
  		return $this->db->insert($this->acc_tb, $data);
  	}

    /** Q-Function : Update account */
    function updateAccount($data, $acc_id){
      $this->db->set($data);
      $this->db->where($this->acc_f[0], $acc_id);
      return $this->db->update($this->acc_tb);
    }

    /** Q-Function : Check accout number */
    function checkAccountNumber($acc_number, $acc_id){
      $this->db->where($this->acc_f[2], $acc_number);
      $this->db->where($this->acc_f[0].' !=', $acc_id);
      return $this->db->get($this->acc_tb);
    }

    /** Q-Function : Softdelete account */
    function softDeleteAccount($acc_id){
      $this->db->set($this->acc_f[4], '1');
      $this->db->where($this->acc_f[0], $acc_id);
      return $this->db->update($this->acc_tb);
    }
  
  /** CRUD Bank */
  	/** Q-Function : Select data bank */
  	function selectBank(){
  		return $this->db->get($this->bank_tb);
  	}

    /** Q-Function : Select bank berdasar id */
    function selectBankOnID($id){
      $this->db->where($this->bank_f[0], $id);
      return $this->db->get($this->bank_tb);
    }
}