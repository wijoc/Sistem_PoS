<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class User_m extends MY_Model{
    
    /** Select user berdasar username */
    function selectUserByUsername($username){
        $this->db->where($this->u_f[1], $username);
        return $this->db->get($this->u_tb);
    }
}