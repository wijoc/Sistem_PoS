<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Product_m extends CI_Model {

  /* Declare Table */
   /* Table Product */
	var $prd_tb = 'tb_product';
	var $prd_f  = array(
		'0' => 'prd_id',
		'1' => 'prd_kode',
		'2' => 'prd_nama',
		'3' => 'prd_kategori_id_fk',
		'4' => 'prd_harga_beli',
		'5' => 'prd_harga_jual',
		'6' => 'prd_satuan_id_fk',
		'7' => 'prd_isi_per_satuan',
		'8' => 'prd_deskripsi'
	);

   /* Table Kategori */
    var $kat_tb = 'tb_kategori';
    var $kat_f  = array(
   		'0' => 'ktgr_id',
   		'1' => 'ktgr_nama'
    );

   /* Table Satuan */
    var $sat_tb = 'tb_satuan';
    var $sat_f  = array(
   		'0' => 'satuan_id',
   		'1' => 'satuan_nama'
    );

  /* Function CRUD Kategori */
   /* Function : Insert Kategori */
  	function insertKategori($data){
  		$resultInsert = $this->db->insert($this->kat_tb, $data);
  		return $resultInsert;
  	}

   /* Function : Select semua kategori, dan sort berdasar ktgr_nama */
  	function getKategori(){
  		$this->db->order_by($this->kat_f[1], 'ASC');
  		$resultInsert = $this->db->get($this->kat_tb);
  		return $resultInsert->result_array();
  	}

  /* Function CRUD Satuan */
   /* Function : Insert Satuan */
  	function insertSatuan($data){
  		$resultInsert = $this->db->insert($this->sat_tb, $data);
  		return $resultInsert;
  	}

   /* Function : Select semua Satuan, dan sort berdasar sat_nama */
  	function getSatuan(){
  		$this->db->order_by($this->sat_f[1], 'ASC');
  		$resultInsert = $this->db->get($this->sat_tb);
  		return $resultInsert->result_array();
  	}
}