<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Return_m extends MY_Model {
  /** Additional CRUD Product Stock */
    /** Q-Function : Update stock after return supplier */
      function updateStockAfterReturn($prd_update){
        $this->db->query('LOCK TABLE '.$this->stk_tb.' as dps WRITE');

        $first_key = array_key_first($prd_update); 
        $first_value = array_values($prd_update)[0];
        $query_join = 'UPDATE '.$this->stk_tb.' as dps JOIN ( SELECT '.$first_key.' as prd_id, '.$first_value.' as minus_stock ';
        
        unset($prd_update[$first_key]);

        foreach($prd_update as $prd_id => $prd_value){
          $query_join .= ' UNION ALL 
                          SELECT '.$prd_id.', '.$prd_value;
        }
        $query_join .= ') update_stock ON dps.'.$this->stk_f[1].' = update_stock.prd_id
                        SET '.$this->stk_f[3].' = '.$this->stk_f[3].' - minus_stock';

        $this->db->query($query_join);

        $this->db->query('UNLOCK TABLE');
      }

  /** CRUD Return Supplier */
    /** Q-Function : Insert Trans Return Supplier */
    function insertReturnSupplier($data, $detData, $prdData){
        $this->db->query('BEGIN');
        $this->db->insert($this->rs_tb, $data);
        foreach($detData as $key => $value){
          $detData[$key]['drs_rs_id_fk'] = $this->db->insert_id();
        }

        $insertDetail = $this->insertDetRS($detData);
        if($data['rs_status'] == 'R'){
            $updateStock  = $this->updateStockAfterReturn($prdData);
        } else {
            $updateStock  = 1;
        }
        if($insertDetail > 0){
            $this->db->query('COMMIT');
            return TRUE;
        } else {
            $this->db->query('ROLLBACK');
            return FALSE;
        }
    }

    /** Q-Function : Select Trans Return berdasar tp_id */
    function selectRSOnTPID($tp_id){
      $this->db->where($this->rs_f[1], $tp_id);
      return $this->db->get($this->rs_tb);
    }

    /** Q-Function : Insert detail return supplier */
    function insertDetRS($data){
        return $this->db->insert_batch($this->drs_tb, $data);
    }

  /** CRUD Return Customer */
}