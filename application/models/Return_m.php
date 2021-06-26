<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Return_m extends MY_Model {
  /** Additional CRUD Product Stock */
    /** Q-Function : Update stock after return supplier */
      function updateStockAfterReturn($prd_update, $status_update){
        $this->db->query('LOCK TABLE '.$this->stk_tb.' as dps WRITE');

        $first_key = array_key_first($prd_update); 
        $first_value = array_values($prd_update)[0];
        $query_join = 'UPDATE '.$this->stk_tb.' as dps JOIN ( SELECT '.$first_key.' as prd_id, '.$first_value.' as minus_stock ';
        
        unset($prd_update[$first_key]);

        foreach($prd_update as $prd_id => $prd_value){
          $query_join .= ' UNION ALL 
                          SELECT '.$prd_id.', '.$prd_value;
        }

        if($status_update == 'R'){
          $query_join .= ') update_stock ON dps.'.$this->stk_f[1].' = update_stock.prd_id
                          SET '.$this->stk_f[3].' = '.$this->stk_f[3].' - minus_stock, '.$this->stk_f[2].' = '.$this->stk_f[2].' + minus_stock';
        } else if ($status_update == 'U'){
          $query_join .= ') update_stock ON dps.'.$this->stk_f[1].' = update_stock.prd_id
                          SET '.$this->stk_f[3].' = '.$this->stk_f[3].' - minus_stock';
        }

        $this->db->query($query_join);

        $this->db->query('UNLOCK TABLE');
      }

    /** Q-Function : Update stock after return supplier */
      function updateStockAfterRC($prd_update, $status_update){
        $this->db->query('LOCK TABLE '.$this->stk_tb.' as dps WRITE');

        $first_key = array_key_first($prd_update); 
        $first_value = array_values($prd_update)[0];
        $query_join = 'UPDATE '.$this->stk_tb.' as dps JOIN ( SELECT '.$first_key.' as prd_id, '.$first_value.' as minus_stock ';
        
        unset($prd_update[$first_key]);

        foreach($prd_update as $prd_id => $prd_value){
          $query_join .= ' UNION ALL 
                          SELECT '.$prd_id.', '.$prd_value;
        }

        if($status_update == 'R'){
          $query_join .= ') update_stock ON dps.'.$this->stk_f[1].' = update_stock.prd_id
                          SET '.$this->stk_f[3].' = '.$this->stk_f[3].' + minus_stock, '.$this->stk_f[2].' = '.$this->stk_f[2].' - minus_stock';
        } else if ($status_update == 'U'){
          $query_join .= ') update_stock ON dps.'.$this->stk_f[1].' = update_stock.prd_id
                          SET '.$this->stk_f[3].' = '.$this->stk_f[3].' + minus_stock';
        }

        $this->db->query($query_join);

        $this->db->query('UNLOCK TABLE');
      }

  /** CRUD Return Supplier */
  	/** Q-Function : Get next autoincrement return_customer */
  	function getNextIncrement(){
  		$this->db->select('AUTO_INCREMENT');
  		$this->db->from('information_schema.TABLES');
  		$this->db->where('TABLE_NAME', $this->rc_tb);
  		$this->db->where('TABLE_SCHEMA', $this->db->database);
  		return $this->db->get();
  	}

    /** Q-Function : Insert Trans Return Supplier */
    function insertReturnSupplier($data, $detData, $prdData){
        $this->db->query('BEGIN');
        $this->db->insert($this->rs_tb, $data);
        foreach($detData as $key => $value){
          $detData[$key]['drs_rs_id_fk'] = $this->db->insert_id();
        }

        $insertDetail = $this->insertDetRS($detData);
        $updateStock  = $this->updateStockAfterReturn($prdData, $data['rs_status']);
        if($insertDetail > 0){
            $this->db->query('COMMIT');
            return TRUE;
        } else {
            $this->db->query('ROLLBACK');
            return FALSE;
        }
    }

    /** Q-Function : Select Trans Return berdasar tp_id */
    function selectRSByTPID($tp_id){
      $this->db->select('rs.*, drs.*, prd.'.$this->prd_f[2]);
      $this->db->from($this->rs_tb.' as rs');
      $this->db->join($this->drs_tb.' as drs', 'drs.'.$this->drs_f[1].' = rs.'.$this->rs_f[0], 'LEFT');
      $this->db->join($this->prd_tb.' as prd', 'prd.'.$this->prd_f[0].' = drs.'.$this->drs_f[2], 'LEFT');
      $this->db->where('rs.'.$this->rs_f[1], $tp_id);
      return $this->db->get();
    }

    /** Q-Function : Insert detail return supplier */
    function insertDetRS($data){
        return $this->db->insert_batch($this->drs_tb, $data);
    }

  /** CRUD Return Customer */
    /** Q-Function : Select Trans Return Customer berdasar trans sales id */
    function selectRCByTSID($trans_id){
      $this->db->where($this->rc_f[1], $trans_id);
      return $this->db->get($this->rc_tb);
    }

    /** Q-Function : Insert Trans Return Customer */
    function insertReturnCustomer($data, $detData, $prdData){
      $this->db->query('BEGIN');
      $this->db->insert($this->rc_tb, $data);
      foreach($detData as $key => $value){
        $detData[$key]['drc_rc_id_fk'] = $this->db->insert_id();
      }

      $insertDetail = $this->insertDetRC($detData);
      $updateStock  = $this->updateStockAfterRC($prdData, $data['rc_status']);
      if($insertDetail > 0){
          $this->db->query('COMMIT');
          return TRUE;
      } else {
          $this->db->query('ROLLBACK');
          return FALSE;
      }
    }

    /** Q-Function : Insert detail return supplier */
    function insertDetRC($data){
        return $this->db->insert_batch($this->drc_tb, $data);
    }
}