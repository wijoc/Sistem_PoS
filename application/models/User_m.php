<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class User_m extends MY_Model{
    /** Q-Function : Insert user */
    function insertUser($insert_data){
        return $this->db->insert($this->u_tb, $insert_data);
    }

    /** Q-Function : Select user berdasar username */
    function selectUserByUsername($username){
        $this->db->where($this->u_f[1], $username);
        return $this->db->get($this->u_tb);
    }

    /** Q-Function : Select all user data */
    function selectUser($amount = 0, $offset = 0, $keyword = NULL, $order = NULL){
        ($amount > 0)? $this->db->limit($amount, $offset) : '';

        /** Jika keyword != null, set search data berdasar keyword */
        if($keyword != null){
          $this->db->group_start();
          $this->db->like($this->u_tb.'.'.$this->u_f['1'], $keyword['search']['value']);
          $this->db->or_like($this->u_tb.'.'.$this->u_f['3'], $keyword['search']['value']);
          $this->db->group_end();
        }
        
        /** Jika order = null, sort data bedasar prd_id */
        ($order == null)? $this->db->order_by($this->u_tb.'.'.$this->u_f[4], 'ASC') : $this->db->order_by($this->u_tb.'.'.$this->prd_f[$order['order']['0']['coloumn']], $order['order']['0']['dir']);
        return $this->db->get($this->u_tb);
    }

    /** Q-Function : Select user berdasar id */
    function selectUserByID($uid){
        $this->db->select($this->u_f[0].', '.$this->u_f[1].', '.$this->u_f[3].', '.$this->u_f[4]);
        $this->db->from($this->u_tb);
        $this->db->where($this->u_f[0], $uid);
        return $this->db->get();
    }

    /** Q-Function : Count user per role */
    function countUserPerRole(){
        $this->db->select($this->u_f[4].', COUNT('.$this->u_f[0].') as count_user');
        $this->db->from($this->u_tb);
        $this->db->group_by($this->u_f[4]);
        return $this->db->get();
    }

    /** Q-Function : Count all row-date */
    function count_all(){
        return $this->db->get($this->u_tb)->num_rows();
    }

    /** Q-Function : Validate username */
    function validationUsername($username, $uid){
        $this->db->where($this->u_f[1], $username);
        $this->db->where($this->u_f[0].' != ', $uid);
        return $this->db->get($this->u_tb);
    }

    /** Q-Function : Update data */
    function updatetUser($set_data, $uid){
        $this->db->set($set_data);
        $this->db->where($this->u_f[0], $uid);
        return $this->db->update($this->u_tb);
    }
}