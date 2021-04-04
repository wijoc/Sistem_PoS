<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

Class Return_m extends CI_Model {

    /** Table Trans Retur Customer */
        protected $rc_tb    = 'return_customer';
        protected $rc_f     = array(
            '0' => 'rc_id',
            '1' => 'ts_id_fk',
            '2' => 'rc_date',
            '3' => 'rc_paid'
        );
    
    /** Table detail retur customer */
        protected $drc_tb   = 'det_return_customer';
        protected $drc_f    = array(
            '0' => 'drc_id',
            '1' => 'rc_id_fk',
            '2' => 'prd_id_fk',
            '3' => 'drc_qty'
        );


    /** Query return customer */
      /** Query insert data return customer */
        function insertRC($data){
            $resultInsert = $this->db->insert($this->rc_tb, $data);
            if($resultInsert > 0){ 
                $resultData = array(
                    'resultInsert'  => $resultInsert,
                    'insertID'      => $this->db->insert_id()
                );
            } else {
                $resultData = array(
                    'resultInsert'  => $resultInsert,
                    'insertID'      => null
                );
            }

            return $resultData;
        }

      /** Query insert detail product return */
        function insertDetailRC($data){
            $resultInsert = $this->db->insert_batch($this->drc_tb, $data);
            return $resultInsert;
        }

      /** Query get all return_customer data */
        function getAllRC(){
            $this->db->order_by($this->rc_f[2], 'DESC');
            $resultSelect = $this->db->get($this->rc_tb);
            return $resultSelect->result_array();
        }
    
      /** Query get data return berdasar ts_id */
        function getReturnOnID($sales_id){
            $this->db->select('rc.*, drc.*, prd.prd_name');
            $this->db->from($this->rc_tb.' as rc');
            $this->db->join($this->drc_tb.' as drc', 'rc.'.$this->rc_f[0].'=drc.'.$this->drc_f[1], 'LEFT');
            $this->db->join('tb_product as prd', 'drc.'.$this->drc_f[2].'=prd.prd_id', 'LEFT');
            $this->db->where('rc.'.$this->rc_f[1], $sales_id);
            $resultSelect = $this->db->get();
            return $resultSelect->result_array();
        }
}