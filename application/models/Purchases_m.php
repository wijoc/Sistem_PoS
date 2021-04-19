<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Purchases_m extends MY_Model{
  /* Note
      tp_delete => 1 untuk data dihapus, 0 untuk dapat ditampilkan 
      tp_status => K untuk data dgn status pembayaran kredit, T untuk Tunai Lunas, L untuk Kredit Lunas 
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

    /** Query : Select data purchase */
    function _querySelectPurchase($payment_status = 'all', $delete = 'all', $keyword = NULL, $order = NULL){
      $this->db->select('tp.*, supp.'.$this->supp_f[1]);
      $this->db->from($this->tp_tb.' as tp');
      $this->db->join($this->supp_tb.' as supp', 'supp.'.$this->supp_f[0].' = tp.'.$this->tp_f[2]);

      /** Payment Status */
      if($payment_status == 'L'){
        $this->db->where('tp.'.$this->tp_f[7], 'L');
        $this->db->or_where('tp.'.$this->tp_f[7], 'T');
      } else if ($payment_status == 'K' || $payment_status == 'T'){
        $this->db->where('tp.'.$this->tp_f[7], $payment_status);
      }
      
      /** Delete status */
      ($delete != 'all')? $this->db->where('tp.'.$this->tp_f[11], $delete) : '';

      /** Search */
      if($keyword != NULL){
        $this->db->group_start();
        $this->db->like('tp.'.$this->tp_f[12], $keyword);
        $this->db->or_like('supp.'.$this->supp_f[1], $keyword);
        $this->db->group_end();
      }

      /** Order, default sortby tp_date DESC */
      ($order == null)? $this->db->order_by('tp.'.$this->tp_f[1], 'DESC') : $this->db->order_by('tp.'.$this->tp_f[$order['order']['0']['coloumn']], $order['order']['0']['dir']);
    }

    /** Q-Function : Select trans purchase */
    function selectPurchase($payment = 'all', $delete = 0, $amount = 0, $offset = 0){
      $this->_querySelectPurchase($payment, $delete, $this->input->post('tpSearch'), $this->input->post('order'));
      ($amount > 0)? $this->db->limit($amount, $offset) : '';
      return $this->db->get();
    }

    /** Q-Function : total semua */
    function count_all($payment = 'all', $delete = 0){
      $this->_querySelectPurchase($payment, $delete, null, null);
      $resultSelect = $this->db->get();
      return $resultSelect->num_rows();
    }

    /** Q-Function : Select Trans Purchase berdasar id */
    function selectPurchaseOnID($trans_id){
      $this->db->select('tp.*, SUM(dtp.'.$this->dtp_f[5].') as total_cart, supp.'.$this->supp_f[1].', acc.'.$this->acc_f[2].', acc.'.$this->acc_f[3].', bank.'.$this->bank_f[2]);
      $this->db->from($this->tp_tb.' as tp');
      $this->db->join($this->dtp_tb.' as dtp', 'dtp.'.$this->dtp_f[1].' = tp.'.$this->tp_f[0], 'LEFT');
      $this->db->join($this->supp_tb.' as supp', 'supp.'.$this->supp_f[0].' = tp.'.$this->tp_f[2], 'LEFT');
      $this->db->join($this->acc_tb.' as acc', 'acc.'.$this->acc_f[0].' = tp.'.$this->tp_f[5], 'LEFT');
      $this->db->join($this->bank_tb.' as bank', 'bank.'.$this->bank_f[0].' = acc.'.$this->acc_f[1], 'LEFT');
      $this->db->where('tp.'.$this->tp_f[0], $trans_id);
      return $this->db->get();
    }

    /** Q-Function : Update Trans Purchase berdasar ID */
    function updatePurchaseOnID($data, $id){
      $this->db->where($this->tp_f[0], $id);
      return $this->db->update($this->tp_tb, $data);
    }

    /** Q-Function : Insert detail purchase  */
    function insertBatchDetTP($data){
      return $this->db->insert_batch($this->dtp_tb, $data);
    }

    /** Q-function : Select detail trans purchase berdasar id */
    function selectDetTP($trans_id){
      $this->db->select('dtp.'.$this->dtp_f[3].', dtp.'.$this->dtp_f[4].', dtp.'.$this->dtp_f[5].', prd.'.$this->prd_f[2]);
      $this->db->from($this->dtp_tb.' as dtp');
      $this->db->join($this->prd_tb.' as prd', 'prd.'.$this->prd_f[0].' = dtp.'.$this->dtp_f[2], 'LEFT');
      $this->db->where('dtp.'.$this->dtp_f[1], $trans_id);
      $this->db->group_by('dtp.'.$this->dtp_f[0]);
      return $this->db->get();
    }

  /** Query Table Temp_purchase (Cart) */
    /** Q-Function : Insert Cart */
    function insertCart($data){
      $insertData = array(
        $this->cp_f[1] => $data['post_product_id'],
        $this->cp_f[2] => $data['post_qty'],
        $this->cp_f[3] => $data['post_price'],
        $this->cp_f[4] => $data['post_total']
      );

      $resultInsert = $this->db->insert($this->cp_tb, $insertData);
      return $resultInsert;
    }

    /** Q-function : Update cart */
    function updateCart($data, $id){
      $this->db->set($data);
      $this->db->where($this->cp_f[0], $id);
      return $this->db->update($this->cp_tb);
    }

    /** Q-Function : Select cart purchase */
    function selectCart(){
      $this->db->select($this->cp_tb.'.*, '.$this->prd_tb.'.prd_name');
      $this->db->from($this->cp_tb);
      $this->db->join($this->prd_tb, $this->prd_tb.'.prd_id = '.$this->cp_tb.'.tp_product_fk');
      $this->db->order_by($this->prd_tb.'.prd_id', 'ASC');
      return $this->db->get();
    }

    /** Q-Function : Cart total proce */
    function sumCartPrice(){
      $this->db->select_sum($this->cp_f[4]);
      return $this->db->get($this->cp_tb);
    }

    /* Query get temp berdasar product id */
    function getCartonPrdId($prdId){
      $this->db->where($this->cp_f[1], $prdId);
      $resultSelect = $this->db->get($this->cp_tb);
      return $resultSelect->result_array();
    }

    /** Q-Function : Delete temp product berdasar product_id */
    function deleteCart($prdId, $prdPrice){
      $this->db->where($this->cp_f[1], $prdId);
      $this->db->where($this->cp_f[3], $prdPrice);
      $resultDelete = $this->db->delete($this->cp_tb);
      return $resultDelete;
    }

    /** Query Truncate / Hapus semua data di table temp */
    function truncateCart(){
      return $this->db->truncate($this->cp_tb);
    }

}