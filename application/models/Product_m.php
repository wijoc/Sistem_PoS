<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

/** Note :
  *  1. prd status => 1 untuk deleted, 0 untuk allowed
  *  2. parameter status pada selectProduct, berisi nilai default 'all' untuk select semua data
  *  3. parameter keyword pada selectProduct, untuk search data, nilai default 'null' untuk select semua data
  *  4. parameter order pada selectProduct, berisi nilai default 'null' -> sort data berdaasar prd_id ascending
*/

Class Product_m extends MY_Model {
  /** CRUD Product */
    /** Q-Function : next Increment Product */
    function getNextIncrement(){
      $this->db->select('AUTO_INCREMENT');
      $this->db->from('information_schema.TABLES');
      $this->db->where('TABLE_SCHEMA', $this->db->database);
      $this->db->where('TABLE_NAME', $this->prd_tb);
      return $this->db->get();
    }
  
    /** Q-Function : insert product */
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

    /** Q-Function : Insert Stock */
    function insertProductStock($data, $prd_id){
      $insertData = array(
        $this->stk_f[1] => $prd_id,
        $this->stk_f[2] => $data['prd_initial_g_stock'],
        $this->stk_f[3] => $data['prd_initial_ng_stock'],
        $this->stk_f[4] => $data['prd_initial_op_stock']
      );
      $resultInsert = $this->db->insert($this->stk_tb, $insertData);
      return $resultInsert;
    }

    /** Query : Select product query */
    public function _querySelectProduct($status = 'all', $keyword = null, $order = null, $select = 'all', $ctgr = 'all'){        
      if($select == 'stock'){
        /** Select data stock */
        $this->db->select('prd.'.$this->prd_f[0].', prd.'.$this->prd_f[1].', prd.'.$this->prd_f[2].', prd.'.$this->prd_f[8].', prd.'.$this->prd_f[9].', prd.'.$this->prd_f[10].', stk.* ');

        $this->db->from($this->prd_tb.' as prd');

        $this->db->join($this->stk_tb.' as stk', 'prd.'.$this->prd_f[0].' = stk.'.$this->stk_f[1], 'LEFT');
      } else if ($select == 'all') {
        /** Select semua field data product */
        $this->db->select('prd.*, ctgr.'.$this->ctgr_f[1].', u.'.$this->unit_f[1].', stk.'.$this->stk_f[2]);

        $this->db->from($this->prd_tb.' as prd');

        $this->db->join($this->ctgr_tb.' as ctgr', 'ctgr.'.$this->ctgr_f[0].'=prd.'.$this->prd_f[3], 'LEFT');
        $this->db->join($this->unit_tb.' as u', 'u.'.$this->unit_f[0].'=prd.'.$this->prd_f[6], 'LEFT');

        $this->db->join($this->stk_tb.' as stk', 'prd.'.$this->prd_f[0].' = stk.'.$this->stk_f[1], 'LEFT');
      }
        
      /** Jika status = all select semua data */
      ($status != 'all')? $this->db->where('prd.'.$this->prd_f[12], $status) : '';
      if($ctgr != 'all' ?? FALSE){
        $this->db->where('prd.'.$this->prd_f[3], $ctgr);
      }

      /** Jika keyword != null, set search data berdasar keyword */
      if($keyword != null){
        $this->db->group_start();
        $this->db->like('prd.'.$this->prd_f['1'], $keyword['search']['value']);
        $this->db->or_like('prd.'.$this->prd_f['2'], $keyword['search']['value']);
        $this->db->group_end();
      }
        
      /** Jika order = null, sort data bedasar prd_id */
      ($order == null)? $this->db->order_by('prd.'.$this->prd_f[0], 'ASC') : $this->db->order_by('prd.'.$this->prd_f[$order['order']['0']['coloumn']], $order['order']['0']['dir']);
    }
    
    /** Q-Function : Select product */
    function selectProduct($amount = 0, $offset = 0, $status = 0, $search = NULL, $order = NULL){
      $this->_querySelectProduct($status, $search, $order);
      ($amount > 0)? $this->db->limit($amount, $offset) : '';
      $resultSelect = $this->db->get();
      return $resultSelect;
    }

    /** Q-function : Select product by ID */
    function selectProductByID($prd_id){
      $this->db->select('prd.*, ctgr.*, u.*, stk.'.$this->stk_f[2].', stk.'.$this->stk_f[3].', stk.'.$this->stk_f[4]);
      $this->db->from($this->prd_tb.' as prd');
      $this->db->join($this->ctgr_tb.' as ctgr', 'prd.'.$this->prd_f[3].' = ctgr.'.$this->ctgr_f[0], 'LEFT');
      $this->db->join($this->unit_tb.' as u', 'prd.'.$this->prd_f[6].' = u.'.$this->unit_f[0], 'LEFT');
      $this->db->join($this->stk_tb.' as stk', 'prd.'.$this->prd_f[0].' = stk.'.$this->stk_f[1], 'LEFT');
      $this->db->where('prd.'.$this->prd_f[0], $prd_id);
      return $this->db->get();
    }

    /** Q-Function : Select product by prd_code */
    function selectProductByCode($prd_code){
      $this->db->select('prd.*, ctgr.'.$this->ctgr_f[1].', u.'.$this->unit_f[1].', stk.'.$this->stk_f[2].', stk.'.$this->stk_f[3].', stk.'.$this->stk_f[4]);
      $this->db->from($this->prd_tb.' as prd');
      $this->db->join($this->ctgr_tb.' as ctgr', 'prd.'.$this->prd_f[0].' = ctgr.'.$this->ctgr_f[0]);
      $this->db->join($this->unit_tb.' as u', 'prd.'.$this->prd_f[0].' = u.'.$this->unit_f[0]);
      $this->db->join($this->stk_tb.' as stk', 'prd.'.$this->prd_f[0].' = stk.'.$this->stk_f[1]);
      $this->db->where($this->prd_f[1], $prd_code);
      return $this->db->get();
    }
    
    /** Q-Function : Select product berdasar category */
    function selectProductOnCtgr($cat_id, $amount = 0, $offset = 0, $status = 0, $search = NULL, $order = NULL){
      $this->_querySelectProduct($status, $search, $order, 'all', $cat_id);
      ($amount > 0)? $this->db->limit($amount, $offset) : '';
      $resultSelect = $this->db->get();
      return $resultSelect;
    }

    /** Q-Function : Select product by prd_code and id other than params */
    function selectProductByCodeExID($prd_id, $prd_code){
      $this->db->where($this->prd_f[1], $prd_code);
      $this->db->where($this->prd_f[0].' != ', $prd_id);
      return $this->db->get($this->prd_tb);
    }

    /** Q-Function : Select product by prd_name and id other than params */
    function selectProductByNameExID($prd_id, $prd_name){
      $this->db->where($this->prd_f[2], $prd_name);
      $this->db->where($this->prd_f[0].' != ', $prd_id);
      return $this->db->get($this->prd_tb);
    }

    /** Q-Function : Update product */
    function updateProduct($update_data, $prd_id){
      $this->db->set($update_data);
      $this->db->where($this->prd_f[0], $prd_id);
      return $this->db->update($this->prd_tb);
    }

    /** Q-Function : Delete product */
    function deleteProduct($prd_id, $type, $uid){
      if($type == 'soft'){
        $deleteData = array(
          'prd_status' => 1,
          'deleted_at' => date('Y-m-d H:i:s'),
          'deleted_by' => $uid
        );
        $this->db->set($deleteData);
        $this->db->where($this->prd_f[0], $prd_id);
        return $this->db->update($this->prd_tb);
      } else if ($type == 'hard'){
        $this->db->where($this->prd_f[0], $prd_id);
        return $this->db->delete($this->prd_tb);
      }
    }
    
  /** CRUD Stock & Mutation */
    /** Q-Function : Select product stock */
    function selectProductStock($amount = 0, $offset = 0, $search = null, $order = null){
      $this->_querySelectProduct('0', $search, $order, 'stock');
      ($amount > 0)? $this->db->limit($amount, $offset) : '';
      return $this->db->get();
    }

    /** Q-Function : Insert Stock Mutation */
    function insertStockMutation($sm_data){
      /** Set field asal (from) dan field tujuan (to) */
      $field_from = $sm_data['sm_stock_from'] == 'SG'? 2 : ($sm_data['sm_stock_from'] == 'SNG'? 3 : 4);
      $field_to = $sm_data['sm_stock_to'] == 'SG'? 2 : ($sm_data['sm_stock_to'] == 'SNG'? 3 : 4);

      $this->db->query('BEGIN');
      $resultInsert = $this->db->insert($this->sm_tb, $sm_data);
      if($resultInsert > 0){
        $this->db->query('LOCK TABLE '.$this->stk_tb.' as stk WRITE');
        $updateStock = $this->db->query('UPDATE '.$this->stk_tb.' as stk JOIN ( SELECT '.$sm_data['sm_prd_id_fk'].' as prd_id, '.$sm_data['sm_qty'].' as prd_qty ) update_stock ON stk.'.$this->stk_f[1].' = update_stock.prd_id SET '.$this->stk_f[$field_from].' = '.$this->stk_f[$field_from].' - prd_qty, '.$this->stk_f[$field_to].' = '.$this->stk_f[$field_to].' + prd_qty ');
        if($updateStock > 0){
          $this->db->query('COMMIT');
          $returnValue = TRUE;
        } else {
          $this->db->query('ROLLBACK');
          $returnValue = FALSE; 
        }
        $this->db->query('UNLOCK TABLE');
      } else {
        $this->db->query('ROLLBACK');
        $returnValue = FALSE;
      }
      return $returnValue;
    }

    /** Q-Function : Select Stock Mutation */
    function selectStockMutation($amount = 0, $offset = 0, $search = null, $order = null){
      $this->db->select('sm.'.$this->sm_f[2].', sm.'.$this->sm_f[3].', sm.'.$this->sm_f[4].', sm.'.$this->sm_f[5].', sm.'.$this->sm_f[8].', prd.'.$this->prd_f[2].', prd.'.$this->prd_f[1]);
      $this->db->from($this->sm_tb.' as sm');
      $this->db->join($this->prd_tb.' as prd', 'prd.'.$this->prd_f[0].' = sm.'.$this->sm_f[1]);
      ($amount > 0)? $this->db->limit($amount, $offset) : '';
      return $this->db->get();
    }

    /** Q-Function : Select Stock Mutation on prd_id */
    function selectSMByPrdID($prd_id){
      $this->db->select('sm.'.$this->sm_f[2].', sm.'.$this->sm_f[3].', sm.'.$this->sm_f[4].', sm.'.$this->sm_f[5].', sm.'.$this->sm_f[8].', prd.'.$this->prd_f[2]);
      $this->db->from($this->sm_tb.' as sm');
      $this->db->join($this->prd_tb.' as prd', 'prd.'.$this->prd_f[0].' = sm.'.$this->sm_f[1]);
      $this->db->where('prd.'.$this->prd_f[0], $prd_id);
      return $this->db->get();
    }

  /** CRUD Category */
    /** Q-Function : Select semua kategori, dan sort berdasar ctgr_name */
    function selectCategory($amount = 0, $offset = 0, $keyword = NULL){
      /** Select semua data kategori dan hitung total prd per kategori */
      $this->db->select('ctgr.*, COUNT(prd.'.$this->prd_f[0].') as ctgr_count_prd');
      $this->db->from($this->ctgr_tb.' as ctgr');

      /** Join table product */
      $this->db->join($this->prd_tb.' as prd', 'ctgr.'.$this->ctgr_f[0].' = prd.'.$this->prd_f[3].' AND prd.'.$this->prd_f['12'].' = 0', 'LEFT');

      /** Jika keyword != null, set search data berdasar keyword */
      if (!empty($keyword) && $keyword != NULL){
        $this->db->like($this->ctgr_f['1'], $keyword);
      }

      /** sort data berdasar ctgr_nama secara ASC */
      $this->db->order_by($this->ctgr_f[1], 'ASC');
        
      $this->db->group_by('ctgr.'.$this->ctgr_f[0]);
      ($amount > 0)? $this->db->limit($amount, $offset) : '';
      return $this->db->get();
    }

    /** Q-Function : Insert new kategori */
    function insertCategory($data){
      return $this->db->insert($this->ctgr_tb, $data);
    }
    
    /** Q-Function : Select kategori berdasar id */
    function selectCategoryByID($id){
      $this->db->select('ctgr.*, COUNT(prd.'.$this->prd_f[0].') as ctgr_count_prd');
      $this->db->from($this->ctgr_tb.' as ctgr');
      $this->db->join($this->prd_tb.' as prd', 'ctgr.'.$this->ctgr_f[0].' = prd.'.$this->prd_f[3].' AND prd.'.$this->prd_f['12'].' = 0', 'LEFT');
      $this->db->where($this->ctgr_f[0], $id);
      $this->db->order_by($this->ctgr_f[1], 'ASC');
      return $this->db->get();
    }

    /** Q-Function : Select category by cat_name and id other than params */
    function selectCatByNameExID($cat_id, $cat_name){
      $this->db->where($this->ctgr_f[1], $cat_name);
      $this->db->where($this->ctgr_f[0].' != ', $cat_id);
      return $this->db->get($this->ctgr_tb);
    }

    /** Q-Function : Update Kategori */
    function updateCategory($data){
      $this->db->set($this->ctgr_f[1], $data['ctgr_name']);
      $this->db->where($this->ctgr_f[0], $data['ctgr_id']);
      $resultUpdate = $this->db->update($this->ctgr_tb);
      return $resultUpdate;
    }

    /** Q-Function : Hard Delete Category berdasar ID */
    function deleteCategory($id){
      $this->db->where($this->ctgr_f[0], $id);
      return $this->db->delete($this->ctgr_tb);
    }

  /** CRUD Unit */
    /** Q-Function : Slect semua unit, sort berdasar unit_name */
    function selectUnit($amount = 0, $offset = 0, $keyword = NULL){
      $this->db->select('u.*, COUNT(prd.'.$this->prd_f[0].') as unit_count_prd');
      $this->db->from($this->unit_tb.' as u');

      $this->db->join($this->prd_tb.' as prd', 'u.'.$this->unit_f[0].' = prd.'.$this->prd_f[6].' AND prd.'.$this->prd_f['12'].' = 0', 'LEFT');

      if (!empty($keyword) && $keyword != NULL){
        $this->db->like('u.'.$this->unit_f['1'], $keyword);
      }

      $this->db->order_by('u.'.$this->unit_f[1], 'ASC');
        
      $this->db->group_by('u.'.$this->unit_f[0]);
      ($amount > 0)? $this->db->limit($amount, $offset) : '';
      return $this->db->get();
    }
    
    /** Q-Function : Select unit berdasar id */
    function selectUnitByID($id){
      $this->db->select('u.*, COUNT(prd.'.$this->prd_f[0].') as unit_count_prd');
      $this->db->from($this->unit_tb.' as u');
      $this->db->join($this->prd_tb.' as prd', 'u.'.$this->unit_f[0].' = prd.'.$this->prd_f[6].' AND prd.'.$this->prd_f['12'].' = 0', 'LEFT');
      $this->db->where($this->unit_f[0], $id);
      $this->db->order_by($this->unit_f[1], 'ASC');
      return $this->db->get();
    }

    /** Q-Function : Select unit by unit_name and id other than params */
    function selectUnitByNameExID($unit_id, $unit_name){
      $this->db->where($this->unit_f[1], $unit_name);
      $this->db->where($this->unit_f[0].' != ', $unit_id);
      return $this->db->get($this->unit_tb);
    }
    
    /** Q-Function : Insert Unit */
    function insertUnit($data){
      $resultInsert = $this->db->insert($this->unit_tb, $data);
      return $resultInsert;
    }

    /** Q-Function : Update Unit */
    function updateUnit($data){
      $this->db->set($this->unit_f[1], $data['unit_name']);
      $this->db->where($this->unit_f[0], $data['unit_id']);
      $resultUpdate = $this->db->update($this->unit_tb);
      return $resultUpdate;
    }

    /** Q-Function : Hard Delete Unit berdasar ID */
    function deleteUnit($id){
      $this->db->where($this->unit_f[0], $id);
      return $this->db->delete($this->unit_tb);
    }

}