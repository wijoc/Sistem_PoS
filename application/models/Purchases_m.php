<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Purchases_m extends MY_Model{
  /* Note
      tp_delete => 1 untuk data dihapus, 0 untuk dapat ditampilkan 
  */

  /** Query Table Trans Purchase */
    /** Q-Function : Insert table purcahase */
    function insertPurchase($data){
      $resultInsert = $this->db->insert($this->tp_tb, $data);
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

    /** Q-Function : Delete purchase, digunakan kalau gagal simpan detail data */
    function deletePurchase($id){
      $this->db->where($this->tp_f[0], $id);
      return $this->db->delete($this->temp_tb);
    }

    /** Q-Function : Insert detail purchase  */
    function insertBatchDetTP($data){
      return $this->db->insert_batch($this->dtp_tb, $data);
    }

  /** Query Table Temp_purchase (Cart) */
    /** Q-Function : Insert Cart */
    function insertCart($data){
      $insertData = array(
        $this->temp_f[1] => $data['post_product_id'],
        $this->temp_f[2] => $data['post_product_jumlah'],
        $this->temp_f[3] => $data['post_harga_satuan'],
        $this->temp_f[4] => $data['post_total_bayar']
      );

      $resultInsert = $this->db->insert($this->temp_tp, $insertData);
      return $resultInsert;
    }

    /** Q-function : Update cart */
    function updateCart($data, $id){
      $this->db->set($data);
      $this->db->where($this->temp_f[0], $id);
      return $this->db->update($this->temp_tp);
    }

    /** Q-Function : Select cart purchase */
    function selectCart(){
      $this->db->select($this->temp_tp.'.*, '.$this->prd_tb.'.prd_name');
      $this->db->from($this->temp_tp);
      $this->db->join($this->prd_tb, $this->prd_tb.'.prd_id = '.$this->temp_tp.'.tp_product_fk');
      $this->db->order_by($this->prd_tb.'.prd_id', 'ASC');
      $resultSelect = $this->db->get();
      return $resultSelect->result_array();
    }

    /* Query get temp berdasar product id */
    function getTemponPrdId($prdId){
      $this->db->where($this->temp_f[1], $prdId);
      $resultSelect = $this->db->get($this->temp_tp);
      return $resultSelect->result_array();
    }

    /** Q-Function : Delete temp product berdasar product_id */
    function deleteCart($prdId, $prdPrice){
      $this->db->where($this->temp_f[1], $prdId);
      $this->db->where($this->temp_f[3], $prdPrice);
      $resultDelete = $this->db->delete($this->temp_tp);
      return $resultDelete;
    }

    /** Query Truncate / Hapus semua data di table temp */
    function truncateCart(){
      return $this->db->truncate($this->temp_tp);
    }

}