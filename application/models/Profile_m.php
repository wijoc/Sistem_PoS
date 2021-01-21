<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Profile_m extends CI_Model {

  /* Declare table profile */
	var $pfl_tb = "tb_profile";
	var $pfl_f  = array(
		'0' => 'pfl_id',
		'1' => 'pfl_name',
		'2' => 'pfl_logo',
		'3' => 'pfl_address',
		'4' => 'pfl_email',
		'5' => 'pfl_telp',
		'6' => 'pfl_fax'
	);

  /* Function untuk management profile */
  	/* Query get profile */
  	function getProfile($profile_id){
		$this->db->where($this->pfl_f[0], $profile_id);
		$resultSelect = $this->db->get($this->pfl_tb);
		return $resultSelect->result_array();
  	}

  	/* Query ipdate profile */
  	function updateProfile($data, $id){
  		$this->db->set($data);
  		$this->db->where($this->pfl_f[0], $id);
  		$resultUpdate = $this->db->update($this->pfl_tb);
  		return $resultUpdate;
  	}

  /* Function untuk management user */  

}