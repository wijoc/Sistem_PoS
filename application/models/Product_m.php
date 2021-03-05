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
    /** Query next Increment Product */
      function getNextIncrement(){
        $this->db->select('AUTO_INCREMENT');
        $this->db->from('information_schema.TABLES');
        $this->db->where('TABLE_SCHEMA', $this->db->database);
        $this->db->where('TABLE_NAME', $this->prd_tb);
        $returnValue = $this->db->get();
        return $returnValue->result_array();
      }
    
    /** Query insert product */
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

    /** Query : Select product query */
      private function _querySelectProduct($status = 'all', $keyword = null, $order = null){
        /** Select semua field data product, nama kategori, dan nama satuan */
        $this->db->select('prd.*, ctgr.'.$this->ctgr_f[1].', u.'.$this->unit_f[1]);
        $this->db->from($this->prd_tb.' as prd');

        /** Join table kategori alias ctgr, dan satuan alias u */
        $this->db->join($this->ctgr_tb.' as ctgr', 'ctgr.'.$this->ctgr_f[0].'=prd.'.$this->prd_f[3]);
        $this->db->join($this->unit_tb.' as u', 'u.'.$this->unit_f[0].'=prd.'.$this->prd_f[6]);
        
        /** Jika status = all select semua data */
        ($status != 'all')? $this->db->where($this->prd_f[12], $status) : '';

        /** Jika keyword != null, set search data berdasar keyword */
        if($keyword != null){
          $this->db->group_start();
          $this->db->like('prd.'.$this->prd_f['1'], $keyword);
          $this->db->or_like('prd.'.$this->prd_f['2'], $keyword);
          $this->db->group_end();
        }
        
        /** Jika order = null, sort data bedasar prd_id */
        ($order == null)? $this->db->order_by($this->prd_f[0], 'ASC') : $this->db->order_by($this->prd_f[$order['coloumn']], $order['dir']);
      }
    
    /** Query : Select product */
      function selectProduct($amount = 0, $offset = 0){
        $this->_querySelectProduct('0', $this->input->post('prdSearch'), $this->input->post('order'));
        ($amount > 0)? $this->db->limit($amount, $offset) : '';
        $resultSelect = $this->db->get();
        return $resultSelect;
      }

    /** Q-Function : Select 1 data product berdasar product id */
      function selectProductOnID($id){
        $this->db->select('prd.*, stk.*, kat.'.$this->ctgr_f[1].', sat.'.$this->unit_f[1]);
        $this->db->from($this->prd_tb.' as prd');
        $this->db->where($this->prd_f[0], $id);
        $this->db->join($this->ctgr_tb.' as kat', 'kat.'.$this->ctgr_f[0].'=prd.'.$this->prd_f[3]);
        $this->db->join($this->unit_tb.' as sat', 'sat.'.$this->unit_f[0].'=prd.'.$this->prd_f[6]);
        $this->db->join($this->stk_tb.' as stk', 'stk.'.$this->stk_f[1].'=prd.'.$this->prd_f[6]);
        $resultSelect = $this->db->get();
        return $resultSelect->result_array();
      }

    /** Q-Function : Select data product berdasar ctgr_id
      function selectProductOnCtgr($ctgr_id){
        $this->_querySelectProduct;
        $this->db->where('a', 'a');
        $this->db
      } */

    /** Query : count_filtered */
      function count_filtered($amount = 0, $offset = 0){
        $resultSelect = $this->selectProduct($amount, $offset);
        return $resultSelect->num_rows();
      }

    /** Query : total semua */
      function count_all(){
        $this->_querySelectProduct('0');
        $resultSelect = $this->db->get();
        return $resultSelect->num_rows();
      }
    
    /** Query : Delete Product */
      function deleteProduct($id){
        $this->db->where($this->prd_f[0], $id);
        $resultDelete = $this->db->delete($this->prd_tb);
        return $resultDelete;
      }
    
    /** Query : Soft-delete Product */
      function softdeleteProduct($id){
        $this->db->set($this->prd_f[12], '1');
        $this->db->where($this->prd_f[0], $id);
        $resultUpdate = $this->db->update($this->prd_tb);
        return $resultUpdate;
      }

    /** Query : insert stock */
      function insertProductStock($data, $id){
        $insertData = array(
          $this->stk_f[1] => $id,
          $this->stk_f[2] => $data['prd_initial_g_stock'],
          $this->stk_f[3] => $data['prd_initial_ng_stock'],
          $this->stk_f[4] => $data['prd_initial_op_stock']
        );
        $resultInsert = $this->db->insert($this->stk_tb, $insertData);
        return $resultInsert;
      }

    /** Query : search product */
      function searchProduct($term){
        $this->db->group_start();
        $this->db->like($this->prd_f[1], $term);
        $this->db->or_like($this->prd_f[2], $term);
        $this->db->group_end();
        $resultSelect = $this->db->get($this->prd_tb);
        return $resultSelect->result_array();
      }

  /** CRUD Kategori */
    /** Q-Function : Insert Kategori */
      function insertCategory($data){
        $resultInsert = $this->db->insert($this->ctgr_tb, $data);
        return $resultInsert;
      }
      
    /** Q-Function : Select semua kategori, dan sort berdasar ctgr_name */
      function selectCategory($amount = 0, $offset = 0){
        /** Select semua data kategori dan hitung total prd per kategori */
        $this->db->select('ctgr.*, COUNT(prd.'.$this->prd_f[0].') as ctgr_count_prd');
        $this->db->from($this->ctgr_tb.' as ctgr');

        /** Join table produck */
        $this->db->join($this->prd_tb.' as prd', 'ctgr.'.$this->ctgr_f[0].' = prd.'.$this->prd_f[3].' AND prd.'.$this->prd_f['12'].' = 0', 'LEFT');

        /** Jika keyword != null, set search data berdasar keyword */
        if (!empty($this->input->post('cgtrSearch')) && $this->input->post('cgtrSearch') != NULL){
          $this->db->like($this->ctgr_f['1'], $this->input->post('cgtrSearch'));
        }

        /** Jika order = null, sort data berdasar ctgr_nama secara ASC */
        if (!empty($this->input->post('cgtrSearch')) && $this->input->post('cgtrSearch') != NULL){
          $this->db->order_by($this->ctgr_f[$this->input->post('cgtrSearch')['coloumn']], $this->input->post('cgtrSearch')['dir']);
        } else {
          $this->db->order_by($this->ctgr_f[1], 'ASC');
        }
        
        $this->db->group_by('ctgr.'.$this->ctgr_f[0]);
        ($amount > 0)? $this->db->limit($amount, $offset) : '';
        $resultInsert = $this->db->get();
        return $resultInsert;
      }
    
    /** Query : Select kategori berdasar id */
      function selectCategoryOnID($id){
        $this->db->where($this->ctgr_f[0], $id);
        $this->db->order_by($this->ctgr_f[1], 'ASC');
        $resultInsert = $this->db->get($this->ctgr_tb);
        return $resultInsert->result_array();
      }

    /** Query : Update Kategori */
      function updateCategory($data){
        $this->db->set($this->ctgr_f[1], $data['ctgr_name']);
        $this->db->where($this->ctgr_f[0], $data['ctgr_id']);
        $resultUpdate = $this->db->update($this->ctgr_tb);
        return $resultUpdate;
      }

    /** Query : Delete Kategori */
      function deleteCategory($id){
        $this->db->where($this->ctgr_f[0], $id);
        $resultDelete = $this->db->delete($this->ctgr_tb);
        return $resultDelete;
      }

  /** CRUD Satuan */
    /** Query : Insert Satuan */
      function insertUnit($data){
        $resultInsert = $this->db->insert($this->unit_tb, $data);
        return $resultInsert;
      }
    
    /** Query : Select semua Satuan, dan sort berdasar sat_nama 
      function selectUnit(){
        $this->db->order_by($this->unit_f[1], 'ASC');
        $resultInsert = $this->db->get($this->unit_tb);
        return $resultInsert->result_array();
      }
      */
      
    /** Q-Function : Select semua unit, dan sort berdasar ctgr_name */
      function selectUnit($amount = 0, $offset = 0){
        /** Select semua data unit dan hitung total prd per unit */
        $this->db->select('u.*, COUNT(prd.'.$this->prd_f[0].') as unit_count_prd');
        $this->db->from($this->unit_tb.' as u');
        $this->db->join($this->prd_tb.' as prd', 'u.'.$this->unit_f[0].' = prd.'.$this->prd_f[6].' AND prd.'.$this->prd_f['12'].' = 0', 'LEFT');

        /** Jika keyword != null, set search data berdasar keyword */
        if (!empty($this->input->post('unitSearch')) && $this->input->post('unitSearch') != NULL){
          $this->db->like($this->unit_f['1'], $this->input->post('unitSearch'));
        }

        /** Jika order = null, sort data berdasar ctgr_nama secara ASC */
        if (!empty($this->input->post('unitSearch')) && $this->input->post('unitSearch') != NULL){
          $this->db->order_by($this->unit_f[$this->input->post('unitSearch')['coloumn']], $this->input->post('unitSearch')['dir']);
        } else {
          $this->db->order_by($this->unit_f[1], 'ASC');
        }
        
        $this->db->group_by('u.'.$this->unit_f[0]);
        ($amount > 0)? $this->db->limit($amount, $offset) : '';
        $resultInsert = $this->db->get();
        return $resultInsert;
      }

    /** Query : Update Satuan */
      function updateUnit($data){
        $this->db->set($this->unit_f[1], $data['unit_nama']);
        $this->db->where($this->unit_f[0], $data['unit_id']);
        $resultUpdate = $this->db->update($this->unit_tb);
        return $resultUpdate;
      }

    /** Query : Delete Satuan */
      function deleteUnit($id){
        $this->db->where($this->unit_f[0], $id);
        $resultDelete = $this->db->delete($this->unit_tb);
        return $resultDelete;
      }


}