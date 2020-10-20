<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Product_m extends CI_Model {

  /* Note :
      1. prd status => 1 untuk deleted, 0 untuk allowed
  */

  /* Declare Table */
   /* Table Product */
  	var $prd_tb = 'tb_product';
  	var $prd_f  = array(
  		'0' => 'prd_id',
  		'1' => 'prd_barcode',
  		'2' => 'prd_name',
  		'3' => 'prd_category_id_fk',
  		'4' => 'prd_purchase_price',
  		'5' => 'prd_selling_price',
  		'6' => 'prd_unit_id_fk',
  		'7' => 'prd_containts',
      '8' => 'prd_initial_g_stock',
      '9' => 'prd_initial_ng_stock',
      '10' => 'prd_initial_return_stock',
  		'11' => 'prd_description',
      '12' => 'prd_status'
  	);

   /* Table Stock */
    var $stk_tb = 'det_product_stock';
    var $stk_f  = array(
      '0' => 'stk_id',
      '1' => 'stk_product_id_fk',
      '2' => 'stk_good',
      '3' => 'stk_not_good',
      '4' => 'stk_return'
    );

   /* Table Kategori */
    var $cat_tb = 'tb_category';
    var $cat_f  = array(
   		'0' => 'ctgr_id',
   		'1' => 'ctgr_name'
    );

   /* Table Satuan */
    var $unit_tb = 'tb_unit';
    var $unit_f  = array(
   		'0' => 'unit_id',
   		'1' => 'unit_name'
    );

  /* Function CRUD Product */
    /* Query next Increment Product */
    function getNextIncrement(){
      $this->db->select('AUTO_INCREMENT');
      $this->db->from('information_schema.TABLES');
      $this->db->where('TABLE_SCHEMA', $this->db->database);
      $this->db->where('TABLE_NAME', $this->prd_tb);
      $returnValue = $this->db->get();
      return $returnValue->result_array();
    }

    /* Query insert product */
    function insertProduct($data){
      $resultInsert = $this->db->insert($this->prd_tb, $data);
      if($resultInsert > 0){
        $dataReturn = array(
          'resultInsert' => $resultInsert,
          'insertID'     => $this->db->insert_id() 
        );
      } else {
        $dataReturn = array(
          'resultInsert' => $resultInsert,
          'insertID'     => null 
        );
      }
      return $dataReturn;
    }

    /* Query select semua data product, Semua product, termasuk prd_status 1 */
    function getAllProduct(){
      $this->db->select('prd.*, kat.'.$this->cat_f[1].', sat.'.$this->unit_f[1]);
      $this->db->from($this->prd_tb.' as prd');
      $this->db->join($this->cat_tb.' as kat', 'kat.'.$this->cat_f[0].'=prd.'.$this->prd_f[3]);
      $this->db->join($this->unit_tb.' as sat', 'sat.'.$this->unit_f[0].'=prd.'.$this->prd_f[6]);
      $this->db->order_by($this->prd_f[0], 'ASC');
      $resultSelect = $this->db->get();
      return $resultSelect->result_array();
    }

    /* Query select semua data product, Product tanpa prd_status == 0 */
    function getAllowedProduct(){ 
      $this->db->select('prd.*, kat.'.$this->cat_f[1].', sat.'.$this->unit_f[1]);
      $this->db->from($this->prd_tb.' as prd');
      $this->db->join($this->cat_tb.' as kat', 'kat.'.$this->cat_f[0].'=prd.'.$this->prd_f[3]);
      $this->db->join($this->unit_tb.' as sat', 'sat.'.$this->unit_f[0].'=prd.'.$this->prd_f[6]);
      $this->db->where($this->prd_f[12], '0');
      $this->db->order_by($this->prd_f[0], 'ASC');
      $resultSelect = $this->db->get();
      return $resultSelect->result_array();
    }

    /* Query select stock product */
    function getStockProduct(){
      $this->db->select('prd.'.$this->prd_f[1].', prd.'.$this->prd_f[2].', prd.'.$this->prd_f[8].', prd.'.$this->prd_f[9].', prd.'.$this->prd_f[10].', stk.*');
      $this->db->from($this->stk_tb.' as stk');
      $this->db->join($this->prd_tb.' as prd', 'prd.'.$this->prd_f[0].'=stk.'.$this->stk_f[1]);
      $this->db->where('prd.'.$this->prd_f[12], '0');
      $this->db->order_by('prd.'.$this->prd_f[0], 'ASC');
      $resultSelect = $this->db->get();
      return $resultSelect->result_array();
    }

    /* Query select 1 data product berdasar product id */
    function getProductOnID($id){
      $this->db->select('prd.*, stk.*, kat.'.$this->cat_f[1].', sat.'.$this->unit_f[1]);
      $this->db->from($this->prd_tb.' as prd');
      $this->db->where($this->prd_f[0], $id);
      $this->db->join($this->cat_tb.' as kat', 'kat.'.$this->cat_f[0].'=prd.'.$this->prd_f[3]);
      $this->db->join($this->unit_tb.' as sat', 'sat.'.$this->unit_f[0].'=prd.'.$this->prd_f[6]);
      $this->db->join($this->stk_tb.' as stk', 'stk.'.$this->stk_f[1].'=prd.'.$this->prd_f[6]);
      $resultSelect = $this->db->get();
      return $resultSelect->result_array();
    }

    /* Query update data product */
    function updateProduct($id, $data){
      $this->db->set($data);
      $this->db->where($this->prd_f[0], $id);
      $resultUpdate = $this->db->update($this->prd_tb);
      return $resultUpdate;
    }

    /* Query delete Product */
    function deleteProduct($id){
      $this->db->where($this->prd_f[0], $id);
      $resultDelete = $this->db->delete($this->prd_tb);
      return $resultDelete;
    }

    /* Query soft delete Product */
    function softdeleteProduct($id){
      $this->db->set($this->prd_f[12], '1');
      $this->db->where($this->prd_f[0], $id);
      $resultUpdate = $this->db->update($this->prd_tb);
      return $resultUpdate;
    }

    /* Query insert stock */
    function insertProductStock($data, $id){
      $insertData = array(
        $this->stk_f[1] => $id,
        $this->stk_f[2] => $data['prd_initial_g_stock'],
        $this->stk_f[3] => $data['prd_initial_ng_stock'],
        $this->stk_f[4] => $data['prd_initial_return_stock']
      );
      $resultInsert = $this->db->insert($this->stk_tb, $insertData);
      return $resultInsert;
    }

    /* Query search product */
    function searchProduct($term){
      $this->db->like($this->prd_f[1], $term);
      $this->db->or_like($this->prd_f[2], $term);
      $resultSelect = $this->db->get($this->prd_tb);
      return $resultSelect->result_array();
    }

  /* Function CRUD Kategori */
   /* Function : Insert Kategori */
  	function insertCategory($data){
  		$resultInsert = $this->db->insert($this->cat_tb, $data);
  		return $resultInsert;
  	}

   /* Function : Select semua kategori, dan sort berdasar ctgr_name */
    function getCategory(){
      $this->db->order_by($this->cat_f[1], 'ASC');
      $resultInsert = $this->db->get($this->cat_tb);
      return $resultInsert->result_array();
    }

   /* Function : Update Kategori */
    function updateCategory($data){
      $this->db->set($this->cat_f[1], $data['ctgr_name']);
      $this->db->where($this->cat_f[0], $data['ctgr_id']);
      $resultUpdate = $this->db->update($this->cat_tb);
      return $resultUpdate;
    }

   /* Function : Delete Kategori */
    function deleteCategory($id){
      $this->db->where($this->cat_f[0], $id);
      $resultDelete = $this->db->delete($this->cat_tb);
      return $resultDelete;
    }

  /* Function CRUD Satuan */
   /* Function : Insert Satuan */
  	function insertUnit($data){
  		$resultInsert = $this->db->insert($this->unit_tb, $data);
  		return $resultInsert;
  	}

   /* Function : Select semua Satuan, dan sort berdasar sat_nama */
  	function getUnit(){
  		$this->db->order_by($this->unit_f[1], 'ASC');
  		$resultInsert = $this->db->get($this->unit_tb);
  		return $resultInsert->result_array();
  	}

   /* Function : Update Satuan */
    function updateUnit($data){
      $this->db->set($this->unit_f[1], $data['unit_nama']);
      $this->db->where($this->unit_f[0], $data['unit_id']);
      $resultUpdate = $this->db->update($this->unit_tb);
      return $resultUpdate;
    }

   /* Function : Delete Satuan */
    function deleteUnit($id){
      $this->db->where($this->unit_f[0], $id);
      $resultDelete = $this->db->delete($this->unit_tb);
      return $resultDelete;
    }
}