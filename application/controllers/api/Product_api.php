<?php
defined('BASEPATH') OR exit('No direct script access allowed !');

require APPPATH."core/MY_Api.php";

Class Product_api extends MY_Api {

    public function __construct(){
        parent::__construct();
        $this->load->model('Product_m', 'product');
    }

  /** Product */
    /** GET : all product and all product on category */
    public function index_get($prd_id = NULL){
        if($this->auth_api(['uAll', 'uO', 'uG', 'uK', 'uP']) == TRUE){
            if($prd_id == NULL){
                /** Check if category exist, if exist return product on selected category */
                if($this->get('categoryID') == NULL){
                    $dataLen    = $this->get('length') ?? 0;
                    $dataOffset = $this->get('start') ?? 0;
                    $dataKeyword = $this->get('search')['value'] ?? $this->get('searchProduct');
                    $draw       = $this->get('draw') ?? '';
                    
                    /** Get data from db */
                    $totalData = $this->product->selectProduct(0, 0, 0)->num_rows();
                    $countData = $this->product->selectProduct($dataLen, $dataOffset, 0, $dataKeyword)->num_rows();
                    $getData = $this->product->selectProduct($dataLen, $dataOffset, 0, $dataKeyword)->result_array();
                    $returnData = array();

                    /** Set return data */
                    foreach($getData as $row){
                        $returnData[] = array(
                            'data_id'       => urlencode(base64_encode($row['prd_id'])),
                            'data_code'  => $row['prd_code'],
                            'data_name'     => $row['prd_name'],
                            'data_category' => ($row['ctgr_name'] != NULL)? $row['ctgr_name'] : '[kategori deleted]',
                            'data_purchase_price'  => $row['prd_purchase_price'],
                            'data_selling_price'   => $row['prd_selling_price'],
                            'data_unit'    => ($row['unit_name'] != NULL)? $row['unit_name'] : '[unit deleted]',
                            'good_stock'   => ($row['stk_good'] != NULL)? $row['stk_good'] : 0
                        );
                    }
                
                    /** Set response */
                    $this->response( [
                        'status'     => true,
                        'message'    => ($countData <= 0)? 'Data produk tidak tersedia' : 'Data produk ditemukan',
                        'count_data' => $countData,
                        'data'       => $returnData,
        
                        /** Value untuk datatable */
                        'draw'            => $draw,
                        'recordsTotal'    => $totalData,
                        'recordsFiltered' => $countData
                    ], 200 );
                } else {
                    if(ctype_digit(base64_decode(urldecode($this->get('categoryID')))) == TRUE){
                        /** Decode category */
                        $ctgrID = base64_decode(urldecode($this->get('categoryID')));

                        $dataLen    = $this->get('length') ?? 0;
                        $dataOffset = $this->get('start') ?? 0;
                        $dataKeyword = $this->get('search')['value'] ?? $this->get('searchProduct');
                        $draw       = $this->get('draw') ?? '';
                        
                        /** Get data from db */
                        $ctgrData = $this->product->selectCategoryByID( $ctgrID )->result_array();

                        $totalData = $this->product->selectProductOnCtgr($ctgrID, 0, 0, 0)->num_rows();
                        $countData = $this->product->selectProductOnCtgr($ctgrID, $dataLen, $dataOffset, 0, $dataKeyword,)->num_rows();
                        $getData = $this->product->selectProductOnCtgr($ctgrID, $dataLen, $dataOffset, 0, $dataKeyword,)->result_array();
                        $returnData = array();
    
                        /** Set return data */
                        foreach($getData as $row){
                            $returnData[] = array(
                                'data_id'       => urlencode(base64_encode($row['prd_id'])),
                                'data_code'  => $row['prd_code'],
                                'data_name'     => $row['prd_name'],
                                'data_category' => $row['ctgr_name'],
                                'data_purchase_price'  => $row['prd_purchase_price'],
                                'data_selling_price'   => $row['prd_selling_price'],
                                'data_unit'    => $row['unit_name'],
                                'good_stock'   => $row['stk_good']
                            );
                        }

                        /** Set response */
                        $this->response( [
                            'status'     => true,
                            'message'    => ($countData <= 0)? 'Data produk tidak tersedia' : 'Data produk ditemukan',
                            'category'   => $ctgrData[0]['ctgr_name'],
                            'count_data' => $countData,
                            'data'       => $returnData,
            
                            /** Value untuk datatable */
                            'draw'            => $draw,
                            'recordsTotal'    => $totalData,
                            'recordsFiltered' => $countData
                        ], 200 );
                    } else {
                        /** Set response */
                        $this->response( [
                            'status'     => false,
                            'message'    => 'Invalid categoryID !'
                        ], 401 );
                    }
                }
            } else {
                if(ctype_digit(base64_decode(urldecode($prd_id))) == TRUE){
                    $prdID = base64_decode(urldecode($prd_id));
    
                    if($this->product->selectProductByID($prdID)->num_rows() > 0){
                        /** Get Data */
                        $getData = $this->product->selectProductByID($prdID)->result_array();
        
                        if($getData[0]['prd_status'] == '0'){
                            if($this->get('necessity') == 'detail'){
                                foreach($getData as $row){
                                    $returnData = array(
                                        'data_id'       => urlencode(base64_encode($row['prd_id'])),
                                        'data_code'     => $row['prd_code'],
                                        'data_name'     => $row['prd_name'],
                                        'data_category' => $row['ctgr_name'],
                                        'data_p_price'  => $row['prd_purchase_price'],
                                        'data_s_price'  => $row['prd_selling_price'],
                                        'data_unit'     => $row['unit_name'],
                                        'data_contains' => $row['prd_contains'],
                                        'data_desc'     => $row['prd_description'],
                                        'data_image'    => ($row['prd_image'] != NULL)? base_url().$row['prd_image'] : base_url('/assets/uploaded_files/product_img/no_photo.png'),
                                        'ini_g_stock'   => ($row['prd_initial_g_stock'])? $row['prd_initial_g_stock'] : 0,
                                        'ini_ng_stock'  => ($row['prd_initial_ng_stock'])? $row['prd_initial_ng_stock'] : 0,
                                        'ini_op_stock'  => ($row['prd_initial_op_stock'])? $row['prd_initial_op_stock'] : 0,
                                        'data_g_stock'  => ($row['stk_good'])? $row['stk_good'] : 0,
                                        'data_ng_stock' => ($row['stk_not_good'])? $row['stk_not_good'] : 0,
                                        'data_op_stock' => ($row['stk_opname'])? $row['stk_opname'] : 0,
                                    );
                                }
                            } else if ($this->get('necessity') == 'edit'){
                                foreach($getData as $row){
                                    $returnData = array(
                                        'data_id'       => urlencode(base64_encode($row['prd_id'])),
                                        'data_code'     => $row['prd_code'],
                                        'data_name'     => $row['prd_name'],
                                        'data_category' => urlencode(base64_encode($row['ctgr_id'])),
                                        'data_p_price'  => $row['prd_purchase_price'],
                                        'data_s_price'  => $row['prd_selling_price'],
                                        'data_unit'     => urlencode(base64_encode($row['unit_id'])),
                                        'data_contains' => $row['prd_contains'],
                                        'data_desc'     => $row['prd_description'],
                                        'data_image'    => ($row['prd_image'] != NULL)? base_url().$row['prd_image'] : base_url('/assets/uploaded_files/product_img/no_photo.png')
                                    );
                                }
                            }
        
                            if($this->get('mutation') ?? FALSE){
                                if($this->product->selectSMByPrdID($prdID)->num_rows() > 0){
                                    foreach($this->product->selectSMByPrdID($prdID)->result_array() as $sm_row):
                                        $returnData['mutation'][] = array(
                                        'data_name' => $sm_row['prd_name'],
                                        'dsm_from'  => $sm_row['sm_stock_from'] == 'SG'? 'Stk Good' : ($sm_row['sm_stock_from'] == 'SNG'? 'Stk Rusak' : 'Stk Opname'),
                                        'dsm_to'    => $sm_row['sm_stock_to'] == 'SG'? 'Stk Good' : ($sm_row['sm_stock_to'] == 'SNG'? 'Stk Rusak' : 'Stk Opname'),
                                        'dsm_qty'   => $sm_row['sm_qty'],
                                        'dsm_ps'    => $sm_row['sm_post_script'],
                                        'dsm_date'  => $sm_row['sm_date'],
                                    );
                                    endforeach;
                                } else {
                                    $returnData['mutation'] = null;
                                }
                            }
                            
                            $this->response( [
                                'status' => true,
                                'data' => $returnData,
                            ], 200 );
                        } else {
                            $this->response( [
                                'status' => false,
                                'message' => 'Product no longer exist !'
                            ], 404 );
                        }
                    } else {
                        $this->response( [
                            'status' => false,
                            'message' => 'Product not found !'
                        ], 404 );
                    }
                } else {
                    /** Set response */
                    $this->response( [
                        'status'     => false,
                        'message'    => 'Invalid Product ID !'
                    ], 401 );
                }
            }
        }
    }

    /** POST : insert & Update product, 
     * PHP can't handle HTTP PUT and PATCH using multipart/form-data, so using POST as update as well
     * p-set-method to determine whether input or update */
    public function index_post(){
        if($this->auth_api(['uAll', 'uO', 'uG']) == TRUE){
            if($this->post('p-set-method') == '_POST'){
                /** Load library & Helper */
                $this->load->library('form_validation');
                  
                /** Set rules form validation */
                $configValidation = array(
                        array(
                            'field'	=> 'postCode',
                            'label'	=> 'Kode Produk',
                            'rules'	=> 'trim|is_unique[tb_product.prd_code]',
                            'errors'	=> array(
                                'is_unique' => 'Produk dengan code berikut sudah tersedia'
                            )
                        ),
                        array(
                            'field'	=> 'postName',
                            'label'	=> 'Nama Produk',
                            'rules'	=> 'trim|required|is_unique[tb_product.prd_name]',
                            'errors'	=> array(
                                'required' => 'Nama produk tidak boleh kosong',
                                'is_unique' => 'Produk sudah tersedia'
                            )
                        ),
                        array(
                            'field'	=> 'postCategory',
                            'label'	=> 'Kategori Produk',
                            'rules'	=> 'trim|required|callback__validation_category',
                            'errors'	=> array(
                                'required'	=> 'Kategori produk tidak boleh kosong',
                                '_validation_category' => 'Kategori tidak ditemukan'
                            )
                        ),
                        array(
                            'field'	=> 'postPPrice',
                            'label'	=> 'Harga Beli',
                            'rules'	=> 'trim|required|greater_than_equal_to[0]|numeric',
                            'errors'	=> array(
                                'required' 	=> 'Harga beli tidak boleh kosong',
                                'numeric'	=> 'Harga tidak sesuai format',
                                'greater_than_equal_to' => 'Harga harus lebih dari 0' 
                            )
                        ),
                        array(
                            'field'	=> 'postSPrice',
                            'label'	=> 'Harga Jual',
                            'rules'	=> 'trim|required|greater_than_equal_to[0]|numeric',
                            'errors'	=> array(
                                'required' 	=> 'Harga Jual tidak boleh kosong',
                                'numeric'	=> 'Harga tidak sesuai format',
                                'greater_than_equal_to' => 'Harga harus lebih dari 0' 
                            )
                        ),
                        array(
                            'field'	=> 'postUnit',
                            'label'	=> 'Satuan',
                            'rules'	=> 'trim|required|callback__validation_unit',
                            'errors'	=> array(
                                'required'	=> 'Satuan produk tidak boleh kosong',
                                '_validation_unit' => 'Satuan tidak ditemukan'
                            )
                        ),
                        array(
                            'field'	=> 'postContains',
                            'label'	=> 'Isi per satuan',
                            'rules'	=> 'trim|required|numeric|greater_than[0]',
                            'errors'	=> array(
                                'required'	=> 'Isi tidak boleh kosong',
                                'numeric'	=> 'Isi tidak sesuai format',
                                'greater_than' => 'Isi harus lebih dari 0' 
                            )
                        ),
                        array(
                            'field'	=> 'postStockG',
                            'label'	=> 'Stok awal',
                            'rules'	=> 'trim|required|numeric|greater_than_equal_to[0]',
                            'errors'	=> array(
                                'numeric'	=> 'tidak sesuai format',
                                'required'	=> 'Stok awal tidak boleh kosong',
                                'greater_than_equal_to' => 'Stok awal harus >= 0' 
                            )
                        ),
                        array(
                            'field'	=> 'postStockNG',
                            'label'	=> 'Stok awal rusak',
                            'rules'	=> 'trim|required|numeric|greater_than_equal_to[0]',
                            'errors'	=> array(
                                'numeric'	=> 'tidak sesuai format',
                                'required'	=> 'Stok awal tidak boleh kosong',
                                'greater_than_equal_to' => 'Stok awal harus >= 0' 
                            )
                        ),
                        array(
                            'field'	=> 'postStockOP',
                            'label'	=> 'Stok awal opname',
                            'rules'	=> 'trim|required|numeric|greater_than_equal_to[0]',
                            'errors'	=> array(
                                'numeric'	=> 'tidak sesuai format',
                                'required'	=> 'Stok awal tidak boleh kosong',
                                'greater_than_equal_to' => 'Stok awal harus >= 0' 
                            )
                        ),
                        array(
                            'field'	=> 'postDesc',
                            'label'	=> 'Deskripsi Produk',
                            'rules'	=> 'trim'
                        )
                );
                $this->form_validation->set_rules($configValidation);
        
                /** Run form validation */
                if($this->form_validation->run() == FALSE) {
                    $error_message = array(
                        'error_msg'     => 'Invalid input !',
                        'errorCode' 	=> form_error('postCode'),
                        'errorName' 	=> form_error('postName'),
                        'errorCategory'	=> form_error('postCategory'),
                        'errorPPrice'	=> form_error('postPPrice'),
                        'errorSPrice'	=> form_error('postSPrice'),
                        'errorUnit'     => form_error('postUnit'),
                        'errorContains' => form_error('postContains'),
                        'errorStockG'	=> form_error('postStockG'),
                        'errorStockNG'  => form_error('postStockNG'),
                        'errorStockOP'  => form_error('postStockOP')			
                    );

                    /** Set response */
                    $this->response( [
                        'status' => false,
                        'message' => $error_message
                    ], 422 );
                } else {
                    /** Set product code */                        
                    if($this->post('postCode') ?? false){
                        $nextAI  = $this->product->getNextIncrement()->result_array();
                        if($nextAI > 0){
                            $nextAI = $this->product->getNextIncrement()->result_array(); // Get next auto increment table
                            $nol = '';
                            for($n = 4; $n >= strlen($nextAI['0']['AUTO_INCREMENT']); $n--){
                                $nol .= '0';
                            }
                            $nextCode = date('ymds').$nol.$nextAI['0']['AUTO_INCREMENT'];
                        } else {
                            $nextCode = date('ymds').'0001';
                        }
                    }
        
                    $postData = array(
                        'prd_code'		     => ($this->post('postCode'))? $this->post('postCode') : $nextCode,
                        'prd_name'			 => $this->post('postName'),
                        'prd_category_id_fk' => base64_decode(urldecode($this->post('postCategory'))),
                        'prd_purchase_price' => $this->post('postPPrice'),
                        'prd_selling_price'	 => $this->post('postSPrice'),
                        'prd_unit_id_fk' 	 	=> base64_decode(urldecode($this->post('postUnit'))),
                        'prd_contains' 	 	    => $this->post('postContains'),
                        'prd_initial_g_stock'	=> $this->post('postStockG'),
                        'prd_initial_ng_stock'	=> $this->post('postStockNG'),
                        'prd_initial_op_stock'	=> $this->post('postStockOP'),
                        'prd_description'		=> $this->post('postDesc'),
                        'prd_image'			    => NULL
                    );
        
                    if($_FILES['postImg']['name']){
                        /** Load lib dan helper */
                        $this->load->helper('file');
                        $this->load->library('upload');
        
                        /** Prepare config tambahan */
                        $config['upload_path']   = 'assets/uploaded_files/product_img/'; // Path folder untuk upload file
                        $config['allowed_types'] = 'jpeg|jpg|png|bmp|svg'; // Allowed types
                        $config['max_size']    	 = '2048'; // Max size in KiloBytes
                        $config['encrypt_name']  = TRUE; // Encrypt nama file ketika diupload
                        $this->upload->initialize($config); // Initialize config
        
                        /** Upload proses dan Simpan file ke database */
                        $upload = $this->upload->do_upload('postImg');
                        
                        /** Set nilai untuk simpan ke database */
                        if($upload){
                            /** Get data upload file */
                            $uploadData = $this->upload->data();
                
                            /** Set value */
                            $postData['prd_image'] = $config['upload_path'].$uploadData['file_name'];
                        } else {
                            $errorUpload = $this->upload->display_errors();
                        }
                    }
    
                    if(isset($errorUpload)){
                        $error_message = array(
                            'error_msg' => 'Invalid file !',
                            'errorImg'  => $errorUpload
                        );

                        /** Set response */
                        $this->response( [
                            'status' => false,
                            'message' => $error_message
                        ], 422 );
                    } else {
                        $inputPrd = $this->product->insertProduct($postData);
        
                        /** Return dan redirect */
                        if($inputPrd && $inputPrd['resultInsert'] > 0){
                            /** Insert stock product */
                            $inputStock = $this->product->insertProductStock($postData, $inputPrd['insertID']);

                            if($inputStock > 0){
                                $this->response( [
                                    'icon'   => 'success',
                                    'message'    => 'Berhasil menambah data produk !'
                                ], 201 );
                            } else {
                                $this->product->deleteProduct($inputPrd['insertID'], 'hard');

                                /** Set response */
                                $this->response( [
                                    'icon'   => 'success',
                                    'message'    => 'Kesalahan sistem ! Gagal menambah data produk !'
                                ], 500 );
                            }
                        } else {
                            unlink($postData['prd_image']);

                            /** Set response */
                            $this->response( [
                                'icon'   => 'success',
                                'message'    => 'Kesalahan sistem ! Gagal menambah data produk !'
                            ], 500 );
                        }
                    }
                }
            } else if($this->post('p-set-method') == '_PUT'){
                $updateResult = $this->_updateProses();
    
                /** Set response */
                $this->response( [
                    'status'  => $updateResult['res_status'],
                    'icon'    => $updateResult['res_icon'],
                    'message' => $updateResult['res_message']
                ], $updateResult['res_code'] );
            }
        }
    }

    /** Update product proses */
    private function _updateProses(){
        /** Load library & Helper */
        $this->load->library('form_validation');
          
        /** Set rules form validation */
        $configValidation = array(
                array(
                    'field'	=> 'postCode',
                    'label'	=> 'Kode Produk',
                    'rules'	=> 'trim|callback__validation_update_code',
                    'errors'	=> array(
                    )
                ),
                array(
                    'field'	=> 'postName',
                    'label'	=> 'Nama Produk',
                    'rules'	=> 'trim|required|callback__validation_update_name',
                    'errors'	=> array(
                        'required' => 'Nama produk tidak boleh kosong',
                    )
                ),
                array(
                    'field'	=> 'postCategory',
                    'label'	=> 'Kategori Produk',
                    'rules'	=> 'trim|required|callback__validation_category',
                    'errors'	=> array(
                        'required'	=> 'Kategori produk tidak boleh kosong'
                    )
                ),
                array(
                    'field'	=> 'postPPrice',
                    'label'	=> 'Harga Beli',
                    'rules'	=> 'trim|required|greater_than_equal_to[0]|numeric',
                    'errors'	=> array(
                        'required' 	=> 'Harga beli tidak boleh kosong',
                        'numeric'	=> 'Harga tidak sesuai format',
                        'greater_than_equal_to' => 'Harga harus lebih dari 0' 
                    )
                ),
                array(
                    'field'	=> 'postSPrice',
                    'label'	=> 'Harga Jual',
                    'rules'	=> 'trim|required|greater_than_equal_to[0]|numeric',
                    'errors'	=> array(
                        'required' 	=> 'Harga Jual tidak boleh kosong',
                        'numeric'	=> 'Harga tidak sesuai format',
                        'greater_than_equal_to' => 'Harga harus lebih dari 0' 
                    )
                ),
                array(
                    'field'	=> 'postUnit',
                    'label'	=> 'Satuan',
                    'rules'	=> 'trim|required|callback__validation_unit',
                    'errors'	=> array(
                        'required'	=> 'Satuan produk tidak boleh kosong'
                    )
                ),
                array(
                    'field'	=> 'postContains',
                    'label'	=> 'Isi per satuan',
                    'rules'	=> 'trim|required|numeric|greater_than[0]',
                    'errors'	=> array(
                        'required'	=> 'Isi tidak boleh kosong',
                        'numeric'	=> 'Isi tidak sesuai format',
                        'greater_than' => 'Isi harus lebih dari 0' 
                    )
                ),
                array(
                    'field'	=> 'postDesc',
                    'label'	=> 'Deskripsi Produk',
                    'rules'	=> 'trim'
                )
        );
        $this->form_validation->set_rules($configValidation);
        // $this->form_validation->set_data($post_data);
        
        if($this->form_validation->run() == FALSE) {
            $update_result = array(
                'res_status' => false,
                'res_code'   => 422,
                'res_icon'   => 'error',
                'res_message' => array(
                    'error_msg'     => 'Invalid input !',
                    'errorID'       => form_error('postID'),
                    'errorCode' 	=> form_error('postCode'),
                    'errorName' 	=> form_error('postName'),
                    'errorCategory'	=> form_error('postCategory'),
                    'errorPPrice'	=> form_error('postPPrice'),
                    'errorSPrice'	=> form_error('postSPrice'),
                    'errorUnit'     => form_error('postUnit'),
                    'errorContains' => form_error('postContains')			
                )
                // 'res_message' => $post_data
            );
        } else {
            $prdID = base64_decode(urldecode($this->post('postID')));
            $postData = array(
                'prd_code'		     => $this->post('postCode'),
                'prd_name'			 => $this->post('postName'),
                'prd_category_id_fk' => base64_decode(urldecode($this->post('postCategory'))),
                'prd_purchase_price' => $this->post('postPPrice'),
                'prd_selling_price'	 => $this->post('postSPrice'),
                'prd_unit_id_fk' 	 	=> base64_decode(urldecode($this->post('postUnit'))),
                'prd_contains' 	 	    => $this->post('postContains'),
                'prd_description'		=> $this->post('postDesc'),
                'prd_image'			    => NULL
            );

            if($_FILES['postImg']['name']){
                /** Load lib dan helper */
                $this->load->helper('file');
                $this->load->library('upload');

                /** Prepare config tambahan */
                $config['upload_path']   = 'assets/uploaded_files/product_img/'; // Path folder untuk upload file
                $config['allowed_types'] = 'jpeg|jpg|png|bmp|svg'; // Allowed types
                $config['max_size']    	 = '2048'; // Max size in KiloBytes
                $config['encrypt_name']  = TRUE; // Encrypt nama file ketika diupload
                $this->upload->initialize($config); // Initialize config

                /** Upload proses dan Simpan file ke database */
                $upload = $this->upload->do_upload('postImg');
                
                /** Set nilai untuk simpan ke database */
                if($upload){
                    /** Get data upload file */
                    $uploadData = $this->upload->data();
        
                    /** Set value */
                    $postData['prd_image'] = $config['upload_path'].$uploadData['file_name'];
                } else {
                    $errorUpload = $this->upload->display_errors();
                }
            }
    
            if(isset($errorUpload)){
                $update_result = array(
                    'res_status' => false,
                    'res_code'   => 422,
                    'res_icon'   => 'error',
                    'res_message' => array(
                        'error_msg' => 'invalid file !',
                        'errorImg'  => $errorUpload
                    )
                );
            } else {
                /** get current prd data */
                $oldProduct = $this->product->selectProductByID($prdID)->result_array();
                
                /** */
                $updatePrd = $this->product->updateProduct($postData, $prdID);

                /** Return dan redirect */
                if($updatePrd > 0){
                    ($oldProduct[0]['prd_image'] ?? false)? unlink($oldProduct[0]['prd_image']) : '';
                    $update_result = array(
                        'res_status' => true,
                        'res_code'   => 200,
                        'res_icon'   => 'success',
                        'res_message' => 'Berhasil mengubah data produk !'
                    );
                } else {
                    unlink($postData['prd_image']);
                    $update_result = array(
                        'res_status' => false,
                        'res_code'   => 500,
                        'res_icon'   => 'error',
                        'res_message' => 'Kesalahan sistem, gagal mengubah data produk !'
                    );
                }
            }
        }

        return $update_result;
    }

    /** DELETE : Delete product */
    public function index_delete($prd_id){
        if($this->auth_api(['uAll', 'uO', 'uG']) == TRUE){
            if($prd_id){
                /** Get user data */
                $userData = $this->auth_api(['uAll', 'uO', 'uG']);

                $id = base64_decode(urldecode($prd_id));
                $delPrd = $this->product->deleteProduct($id, $this->delete('type'), base64_decode(urldecode($userData->user_id)));
        
                if($delPrd > 0){
                    if($this->delete('type') == 'soft'){
                        $res_msg = 'Produk telah dihapus ! Penghapusan TIDAK PERMANEN, data transaksi tidak berubah';
                    } else {
                        $res_msg = 'Produk telah dihapus ! Penghapusan bersifat PERMANEN, data transaksi terkait akan berubah';
                    }
        
                    $this->response( [
                        'status' => true,
                        'icon'  => 'success',
                        'message' => $res_msg,
                        'table' => '#table-product',
                    ], 200 );
                } else {
                    $this->response( [
                        'status' => true,
                        'icon'  => 'error',
                        'message' => 'Kesalahan sistem, data tidak terhapus !',
                        'table' => '#table-product'
                    ], 500 );
                }
            } else {
                /** Set response */
                $this->response( [
                    'status' => false,
                    'message' => 'Provide an ID !'
                ], 400 );
            }
        }
    }

  /** Stocck & mutation */
    public function stocks_get($prd_id = NULL){
        if($this->auth_api(['uAll', 'uO', 'uG', 'uK', 'uP']) == TRUE){
            if($prd_id == NULL){
                $dataLen    = $this->get('length') ?? 0;
                $dataOffset = $this->get('start') ?? 0;
                $dataKeyword = $this->get('search')['value'] ?? $this->get('searchProduct');
                $draw       = $this->get('draw') ?? '';
                
                /** Get data from db */
                $totalData = $this->product->selectProductStock(0, 0, 0)->num_rows();
                $countData = $this->product->selectProductStock($dataLen, $dataOffset, 0, $dataKeyword)->num_rows();
                $getData = $this->product->selectProductStock($dataLen, $dataOffset, 0, $dataKeyword)->result_array();
                $returnData = array();
                
                foreach($getData as $row){
                    $returnData[] = array(
                        'data_id'    => urlencode(base64_encode($row['prd_id'])),
                        'data_code'  => $row['prd_code'],
                        'data_name'  => $row['prd_name'],
                        'ini_g_stock'  => ($row['prd_initial_g_stock'])? $row['prd_initial_g_stock'] : 0,
                        'ini_ng_stock' => ($row['prd_initial_ng_stock'])? $row['prd_initial_ng_stock'] : 0,
                        'ini_op_stock' => ($row['prd_initial_op_stock'])? $row['prd_initial_op_stock'] : 0,
                        'data_g_stock'     => ($row['stk_good'])? $row['stk_good'] : 0,
                        'data_ng_stock'    => ($row['stk_not_good'])? $row['stk_not_good'] : 0,
                        'data_op_stock'    => ($row['stk_opname'])? $row['stk_opname'] : 0
                    );
                }
            
                /** Set response */
                $this->response( [
                    'status'     => true,
                    'message'    => ($countData <= 0)? 'Data produk tidak tersedia' : 'Data produk ditemukan',
                    'count_data' => $countData,
                    'data'       => $returnData,
    
                    /** Value untuk datatable */
                    'draw'            => $draw,
                    'recordsTotal'    => $totalData,
                    'recordsFiltered' => $countData
                ], 200 );
            } else {
                if(ctype_digit(base64_decode(urldecode($prd_id))) == TRUE){
                    $prdID = base64_decode(urldecode($prd_id));
    
                    if($this->product->selectProductByID($prdID)->num_rows() > 0){
                        /** Get Data */
                        $getData = $this->product->selectProductByID($prdID)->result_array();
        
                        if($getData[0]['prd_status'] == '0'){
                            foreach($getData as $row){
                                $returnData['stk'] = array(
                                    'data_id'    => urlencode(base64_encode($row['prd_id'])),
                                    'data_code'  => $row['prd_code'],
                                    'data_name'  => $row['prd_name'],
                                    'ini_g_stock'  => ($row['prd_initial_g_stock'])? $row['prd_initial_g_stock'] : 0,
                                    'ini_ng_stock' => ($row['prd_initial_ng_stock'])? $row['prd_initial_ng_stock'] : 0,
                                    'ini_op_stock' => ($row['prd_initial_op_stock'])? $row['prd_initial_op_stock'] : 0,
                                    'data_g_stock'     => ($row['stk_good'])? $row['stk_good'] : 0,
                                    'data_ng_stock'    => ($row['stk_not_good'])? $row['stk_not_good'] : 0,
                                    'data_op_stock'    => ($row['stk_opname'])? $row['stk_opname'] : 0
                                );
                            }
        
                            if($this->get('mutation') ?? FALSE){
                                if($this->product->selectSMByPrdID($prdID)->num_rows() > 0){
                                    foreach($this->product->selectSMByPrdID($prdID)->result_array() as $sm_row):
                                        $returnData['mutation'][] = array(
                                        'data_name' => $sm_row['prd_name'],
                                        'dsm_from'  => $sm_row['sm_stock_from'] == 'SG'? 'Stk Good' : ($sm_row['sm_stock_from'] == 'SNG'? 'Stk Rusak' : 'Stk Opname'),
                                        'dsm_to'    => $sm_row['sm_stock_to'] == 'SG'? 'Stk Good' : ($sm_row['sm_stock_to'] == 'SNG'? 'Stk Rusak' : 'Stk Opname'),
                                        'dsm_qty'   => $sm_row['sm_qty'],
                                        'dsm_ps'    => $sm_row['sm_post_script'],
                                        'dsm_date'  => $sm_row['sm_date'],
                                    );
                                    endforeach;
                                } else {
                                    $returnData['mutation'] = null;
                                }
                            }
                            
                            $this->response( [
                                'status' => true,
                                'data' => $returnData
                            ], 200 );
                        } else {
                            $this->response( [
                                'status' => false,
                                'message' => 'Product no longer exist !'
                            ], 404 );
                        }
                    } else {
                        $this->response( [
                            'status' => false,
                            'message' => 'Product not found !'
                        ], 404 );
                    }
                } else {
                    /** Set response */
                    $this->response( [
                        'status'     => false,
                        'message'    => 'Invalid Product ID !'
                    ], 401 );
                }
            }
        }
    }

    /** GET : get stock mutation */
    public function mutation_get(){
        if($this->auth_api(['uAll', 'uO', 'uG', 'uK', 'uP']) == TRUE){
            /** Check Lenght and start for pagination */
            $dataLen    = $this->get('length') ?? 0;
            $dataOffset = $this->get('start') ?? 0;
            $draw       = $this->get('draw') ?? '';
            $dataKeyword = $this->get('search')['value'] ?? NULL;
            
            if($this->get('necessity') == 'dt'){
                /** Get data from db */
                $totalData = $this->product->selectStockMutation(0, 0, 0)->num_rows();
                $countData = $this->product->selectStockMutation($dataLen, $dataOffset, 0, $dataKeyword,)->num_rows();
                $getData = $this->product->selectStockMutation($dataLen, $dataOffset, 0, $dataKeyword,)->result_array();
    
                $returnData = array();
                /** Set return data */
                foreach($getData as $row){
                    $sm_product = ($row['prd_code'] != null)? $row['prd_code'].' - '.$row['prd_name'] : $row['prd_name'];
                    $returnData[] = array(
                        'data_date' => $row['sm_date'],
                        'data_product'  => $sm_product,
                        'data_from' => $row['sm_stock_from'] == 'SG'? 'Stk Good' : ($row['sm_stock_from'] == 'SNG'? 'Stk Rusak' : 'Stk Opname'),
                        'data_to'   => $row['sm_stock_to'] == 'SG'? 'Stk Good' : ($row['sm_stock_to'] == 'SNG'? 'Stk Rusak' : 'Stk Opname'),
                        'data_qty'  => $row['sm_qty'],
                        'data_ps'   => $row['sm_post_script'],
                    );
                }
            
                /** Set response */
                $this->response( [
                    'status'     => true,
                    'count_data' => $countData,
                    'data'       => $returnData,
    
                    /** Value untuk datatable */
                    'draw'            => $draw,
                    'recordsTotal'    => $totalData,
                    'recordsFiltered' => $countData
                ], 200 );
            }
        }
    }

    /** POST : input stock Mutation */
    public function mutation_post(){
        if($this->auth_api(['uAll', 'uO', 'uG']) == TRUE){
            /** Load library & Helper */
            $this->load->library('form_validation'); 
                
            /** Set rules form validation */
            $configValidation = array(
                array(
                    'field' => 'postPrdID',
                    'label' => '',
                    'rules' => 'trim|required|callback__validation_product_id',
                    'errors'	=> array(
                        'required'	=> 'Pilih produk yang akan dimutasi !'
                    )
                ),
                array(
                    'field'	=> 'postStockDate',
                    'label'	=> 'Tanggal Mutasi',
                    'rules'	=> 'trim|required|callback__validation_date',
                    'errors'	=> array(
                        'required'	=> 'Tgl mutasi tidak boleh kosong !'
                    )
                ),
                array(
                    'field'	=> 'postStockA',
                    'label'	=> 'Dari',
                    'rules'	=> 'trim|required|in_list[SG,SNG,SO]',
                    'errors'	=> array(
                        'required'	=> 'Pilih asal mutasi !',
                        'in_list'   => 'Pilih opsi yang tersedia !'
                    )
                ),
                array(
                    'field'	=> 'postStockB',
                    'label'	=> 'Tujuan',
                    'rules'	=> 'trim|required|in_list[SG,SNG,SO]|callback__validation_stock_b',
                    'errors'	=> array(
                        'required'	=> 'Pilih tujuan mutasi !',
                        'in_list'   => 'Pilih opsi yang tersedia !'
                    )
                ),
                array(
                    'field'	=> 'postStockQty',
                    'label'	=> 'Tujuan',
                    'rules'	=> 'trim|required|numeric',
                    'errors'	=> array(
                        'required' => 'Pilih tujuan mutasi !',
                        'numeric'  => 'Harus berupa angka'
                    )
                ),
                array(
                    'field'	=> 'postStockPS',
                    'label'	=> 'Tujuan',
                    'rules'	=> 'trim'
                )
            );
            $this->form_validation->set_rules($configValidation);
        
            if($this->form_validation->run() == FALSE) {
                $error_msg = array(
                    'errorPrdID'   => strip_tags(form_error('postPrdID')),
                    'errorStockDate' => strip_tags(form_error('postStockDate')),
                    'errorStockA'    => strip_tags(form_error('postStockA')),
                    'errorStockB'    => strip_tags(form_error('postStockB')),
                    'errorStockQty'  => strip_tags(form_error('postStockQty')),
                    'errorStockPS'   => strip_tags(form_error('postStockPS')),
                );
    
                if(form_error('postPrdID') ?? false){
                    /** Set response */
                    $this->response( [
                        'status'  => false,
                        'icon'    => 'error',
                        'message' => $error_msg
                    ], 404 );
                } else {
                    /** Set response */
                    $this->response( [
                        'status'  => false,
                        'icon'    => 'error',
                        'message' => $error_msg
                    ], 422 );
                }
            } else {
                $postData = array(
                    'sm_prd_id_fk'  => base64_decode(urldecode($this->post('postPrdID'))),
                    'sm_date'       => $this->post('postStockDate'),
                    'sm_stock_from' => $this->post('postStockA'),
                    'sm_stock_to'   => $this->post('postStockB'),
                    'sm_qty'        => $this->post('postStockQty'),
                    'sm_post_script' => $this->post('postStockPS'),
                );
    
                $inputSM = $this->product->insertStockMutation($postData);
                // $inputSM = 1;
    
                if($inputSM > 0){
                    /** Get new stock data */
                    $getData = $this->product->selectProductByID(base64_decode(urldecode($this->post('postPrdID'))))->result_array();
    
                    foreach($getData as $row){
                        $returnData['stk'] = array(
                            'data_id'    => urlencode(base64_encode($row['prd_id'])),
                            'data_code'  => $row['prd_code'],
                            'data_name'  => $row['prd_name'],
                            'ini_g_stock'  => $row['prd_initial_g_stock'],
                            'ini_ng_stock' => $row['prd_initial_ng_stock'],
                            'ini_op_stock' => $row['prd_initial_op_stock'],
                            'data_g_stock'     => $row['stk_good'],
                            'data_ng_stock'    => $row['stk_not_good'],
                            'data_op_stock'    => $row['stk_opname']
                        );
                    }
    
                    /** Get new mutation data */
                    if($this->product->selectSMByPrdID(base64_decode(urldecode($this->post('postPrdID'))))->num_rows() > 0){
                        foreach($this->product->selectSMByPrdID(base64_decode(urldecode($this->post('postPrdID'))))->result_array() as $sm_row):
                            $returnData['mutation'][] = array(
                                'data_name' => $sm_row['prd_name'],
                                'dsm_from'  => $sm_row['sm_stock_from'] == 'SG'? 'Stk Good' : ($sm_row['sm_stock_from'] == 'SNG'? 'Stk Rusak' : 'Stk Opname'),
                                'dsm_to'    => $sm_row['sm_stock_to'] == 'SG'? 'Stk Good' : ($sm_row['sm_stock_to'] == 'SNG'? 'Stk Rusak' : 'Stk Opname'),
                                'dsm_qty'   => $sm_row['sm_qty'],
                                'dsm_ps'    => $sm_row['sm_post_script'],
                                'dsm_date'  => $sm_row['sm_date'],
                            );
                        endforeach;
                    } else {
                        $returnData['mutation'] = null;
                    }
                    
                    /** Set response */
                    $this->response( [
                        'status'  => true,
                        'icon'    => 'success',
                        'message' => 'Berhasil melakukan mutasi stock !',
                        'prd_id'  => $this->post('postPrdID'),
                        'data'    => $returnData
                    ], 201 );
                } else {
                    $this->response( [
                        'status' => false,
                        'icon'   => 'error',
                        'message' => 'Kesalahan sistem, Gagal melakukan mutasi stock !'
                    ], 500 );
                }
            }
        }
    }

  /** Category */
    /** GET : all category and category data by ctgr_id */
    public function categories_get($ctgr_id = NULL){
        if($this->auth_api(['uAll', 'uO', 'uG', 'uK', 'uP']) == TRUE){
            if($ctgr_id == NULL){
                $dataLen    = $this->get('length') ?? 0;
                $dataOffset = $this->get('start') ?? 0;
                $dataKeyword = $this->get('search')['value'] ?? $this->get('searchCategory');
                $draw       = $this->get('draw') ?? '';
                
                $getData = $this->product->selectCategory($dataLen, $dataOffset, $dataKeyword)->result_array();
        
                $totalData = $this->product->selectCategory(0, 0, $dataKeyword)->num_rows();
                $countData = $this->product->selectCategory($dataLen, $dataOffset, $dataKeyword)->num_rows();

                $returnData = array();
                $no = $dataOffset+1;
                /** Set return data */
                foreach($getData as $row){
                    $returnData[] = array(
                        'data_no'   => $no++,
                        'data_id'   => urlencode(base64_encode($row['ctgr_id'])),
                        'data_name' => $row['ctgr_name'],
                        'data_product' => $row['ctgr_count_prd']
                    );
                }

                /** Set response */
                $this->response( [
                    'status'  => true,
                    'message' => ($countData <= 0)? 'Data kategori tidak tersedia' : 'Data kategori ditemukan',
                    'count_data' => $countData,
                    'data'       => $returnData,

                    /** Value untuk datatable */
                    'draw'            => $draw,
                    'recordsTotal'    => $totalData,
                    'recordsFiltered' => $totalData
                ], 200 );
            } else {
                if(ctype_digit(base64_decode(urldecode($ctgr_id))) == TRUE){
                    $countData = $this->product->selectCategoryByID( base64_decode(urldecode($ctgr_id)) )->num_rows();
                    $getData = $this->product->selectCategoryByID( base64_decode(urldecode($ctgr_id)) )->result_array();
    
                    if($countData > 0){
                        $returnData = array();
                        /** Set return data */
                        foreach($getData as $row){
                            $returnData[] = array(
                                'data_id'   => urlencode(base64_encode($row['ctgr_id'])),
                                'data_name' => $row['ctgr_name'],
                                'data_product' => $row['ctgr_count_prd']
                            );
                        }
    
                        $this->response( [
                            'status'     => true,
                            'count_data' => $countData,
                            'data'       => $returnData,
                        ], 200 );
                    } else {
                        /** Set response */
                        $this->response( [
                            'status'     => false,
                            'message'    => 'Category tidak ditemukan !'
                        ], 404 );
                    }
                } else {
                    /** Set response */
                    $this->response( [
                        'status'     => false,
                        'message'    => 'Invalid Category ID !'
                    ], 401 );
                }
            }
        }
    }

    /** POST : input new category */
    public function categories_post(){
        if($this->auth_api(['uAll', 'uO', 'uG']) ?? FALSE){
            /** Load library & Helper */
            $this->load->library('form_validation'); 
                
            /** Set rules form validation */
            $configValidation = array(
                array(
                    'field'	=> 'postCatName',
                    'label'	=> 'Nama Kategori',
                    'rules'	=> 'trim|required|is_unique[tb_category.ctgr_name]',
                    'errors'	=> array(
                        'is_unique'	=> 'Kategori sudah tersedia',
                        'required'	=> 'Kategori tidak boleh kosong'
                    )
                )
            );
            $this->form_validation->set_rules($configValidation);
        
            /** Run form validation */
            if($this->form_validation->run() == FALSE) {
                $error_msg = array(
                    'errorName' => form_error('postCatName')
                );

                /** Set response */
                $this->response( [
                    'status' => false,
                    'icon'   => 'error',
                    'message'   => $error_msg
                ], 422 );
            } else {
                /** Get user data */
                $userData = $this->auth_api(['uAll', 'uO', 'uG']);

                /** Get data post dari form */
                $postData = array(
                    'ctgr_name' => $this->post('postCatName'),
                    'created_at' => date('y-m-d H:i:s'),
                    'created_by' => base64_decode(urldecode($userData->user_id))
                );
                    
                $inputCat = $this->product->insertCategory($postData);

                if($inputCat > 0){
                    /** Set response */
                    $this->response( [
                        'status' => true,
                        'icon'   => 'success',
                        'message'   => 'Berhasil menyimpan data kategori !'
                    ], 201 );
                } else {
                    /** Set response */
                    $this->response( [
                        'status' => false,
                        'icon'   => 'error',
                        'message'   => 'Kesalahan sistem. Gagal menyimpan data kategori !'
                    ], 500 );
                }
            }
        }
    }

    /** Put : Update category */
    public function categories_put($ctgr_id){
        if($this->auth_api(['uAll', 'uO', 'uG']) ?? FALSE){
            if($ctgr_id ?? FALSE){
                if($this->_validation_category($ctgr_id) == TRUE){
                    $ctgrID = base64_decode(urldecode($ctgr_id));
                    
                    $this->load->library('form_validation'); 
                    
                    $configValidation = array(
                        array(
                            'field'	=> 'postCatName',
                            'label'	=> 'Nama Kategori',
                            'rules'	=> 'trim|required|callback__validation_cat_name['.$ctgrID.']',
                            'errors'	=> array(
                                'is_unique'	=> 'Kategori sudah tersedia',
                                'required'	=> 'Kategori tidak boleh kosong'
                            )
                        )
                    );
        
                    /** Var untuk data yang akan di validasi, karena form_validation tidak membaca method PUT */
                    $dataToValidate = array(
                        'postCatName' => $this->put('postCatName')
                    );
                    $this->form_validation->set_data($dataToValidate); // Set data yang akan divalidasi
                    $this->form_validation->set_rules($configValidation);
                
                    if($this->form_validation->run() == FALSE) {
                        $this->response( [
                            'icon'   => 'error',
                            'message'   => array('errorName' => strip_tags(form_error('postCatName')))
                        ], 422 );
                    } else {
                        $updateData = array(
                            'ctgr_id' => $ctgrID,
                            'ctgr_name' => $this->put('postCatName')
                        );
        
                        $updateCtgr = $this->product->updateCategory($updateData);
        
                        if($updateCtgr > 0){
                            /** Set response */
                            $this->response( [
                                'icon'    => 'success',
                                'message' => 'Kategori berhasil diperbarui !',
                                'table'   => '#table-category'
                            ], 201 );
                        } else {
                            /** Set response */
                            $this->response( [
                                'icon'   => 'error',
                                'message'   => 'Kesalahan sistem. Gagal mengubah data kategori'
                            ], 500 );
                        }

                    }
                } else {
                    $this->response( [
                        'icon'   => 'error',
                        'message'   => 'Data tidak ditemukan !'
                    ], 404 );
                }
            } else {
                /** Set response */
                $this->response( [
                    'status' => false,
                    'message' => 'Provide an ID !'
                ], 400 );
            }
        }
    }

    /** Delete : Delete category (Permanent) */
    public function categories_delete($ctgr_id){
        if($this->auth_api(['uAll', 'uO', 'uG']) ?? FALSE){
            if($ctgr_id ?? FALSE){
                if($this->_validation_category($ctgr_id) == TRUE){
                    $ctgrID = base64_decode(urldecode($ctgr_id));
                    $delCat = $this->product->deleteCategory($ctgrID);
    
                    if($delCat > 0){
                        /** Set response */
                        $this->response( [
                            'status' => true,
                            'icon'    => 'success',
                            'message' => 'Kategori berhasil dihapus !',
                            'table'   => '#table-category'
                        ], 200 );
                    } else {
                        /** Set response */
                        $this->response( [
                            'status' => false,
                            'icon'   => 'error',
                            'message'   => 'Kesalahan sistem. Gagal menghapus data kategori'
                        ], 500 );
                    }
                } else {
                    $this->response( [
                        'status' => false,
                        'icon'   => 'error',
                        'message'   => 'Data tidak ditemukan !'
                    ], 404 );
                }
            } else {
                /** Set response */
                $this->response( [
                    'status' => false,
                    'message' => 'Provide an ID !'
                ], 400 );
            }
        }
    }

  /** Unit */
    /** GET : all unit and unit data by unit_id */
    public function units_get($unit_id = NULL){
        if($this->auth_api(['uAll', 'uO', 'uG', 'uK', 'uP']) == TRUE){
            if($unit_id == NULL){
                $dataLen    = $this->get('length') ?? 0;
                $dataOffset = $this->get('start') ?? 0;
                $dataKeyword = $this->get('search')['value'] ?? $this->get('searchUnit');
                $draw       = $this->get('draw') ?? '';
                
                $getData = $this->product->selectUnit($dataLen, $dataOffset, $dataKeyword)->result_array();
        
                $totalData = $this->product->selectUnit(0, 0, $dataKeyword)->num_rows();
                $countData = $this->product->selectUnit($dataLen, $dataOffset, $dataKeyword)->num_rows();

                $returnData = array();
                $no = $dataOffset+1;
                /** Set return data */
                foreach($getData as $row){
                    $returnData[] = array(
                        'data_no'   => $no++,
                        'data_id'   => urlencode(base64_encode($row['unit_id'])),
                        'data_name' => $row['unit_name'],
                        'data_product' => $row['unit_count_prd']
                    );
                }

                /** Set response */
                $this->response( [
                    'status'  => true,
                    'message' => ($countData <= 0)? 'Data satuan tidak tersedia' : 'Data satuan ditemukan',
                    'count_data' => $countData,
                    'data'       => $returnData,

                    /** Value untuk datatable */
                    'draw'            => $draw,
                    'recordsTotal'    => $totalData,
                    'recordsFiltered' => $totalData
                ], 200 );
            } else {
                if(ctype_digit(base64_decode(urldecode($unit_id))) == TRUE){
                    $countData = $this->product->selectUnitByID( base64_decode(urldecode($unit_id)) )->num_rows();
                    $getData = $this->product->selectUnitByID( base64_decode(urldecode($unit_id)) )->result_array();
    
                    if($countData > 0){
                        $returnData = array();
                        /** Set return data */
                        foreach($getData as $row){
                            $returnData[] = array(
                                'data_id'   => urlencode(base64_encode($row['unit_id'])),
                                'data_name' => $row['unit_name'],
                                'data_product' => $row['unit_count_prd']
                            );
                        }
    
                        $this->response( [
                            'status'     => true,
                            'count_data' => $countData,
                            'data'       => $returnData,
                        ], 200 );
                    } else {
                        /** Set response */
                        $this->response( [
                            'status'     => false,
                            'message'    => 'Satuan tidak ditemukan !'
                        ], 404 );
                    }
                } else {
                    /** Set response */
                    $this->response( [
                        'status'     => false,
                        'message'    => 'Invalid Unit ID !'
                    ], 401 );
                }
            }
        }
    }

    /** POST : input new unit / satuan */
    public function units_post(){
        if($this->auth_api(['uAll', 'uO', 'uG']) ?? FALSE){
            /** Load library & Helper */
            $this->load->library('form_validation'); 
                
            /** Set rules form validation */
            $configValidation = array(
                array(
                    'field'	=> 'postUnitName',
                    'label'	=> 'Nama Satuan',
                    'rules'	=> 'trim|required|is_unique[tb_unit.unit_name]',
                    'errors'	=> array(
                        'is_unique'	=> 'Satuan sudah tersedia',
                        'required'	=> 'Satuan tidak boleh kosong'
                    )
                )
            );
            $this->form_validation->set_rules($configValidation);
        
            /** Run form validation */
            if($this->form_validation->run() == FALSE) {
                $error_msg = array(
                    'errorName' => form_error('postUnitName')
                );

                /** Set response */
                $this->response( [
                    'status' => false,
                    'icon'   => 'error',
                    'message'   => $error_msg
                ], 422 );
            } else {
                /** Get data post dari form */
                $postData = array(
                    'unit_name' => $this->post('postUnitName')
                );
                    
                $inputUnit = $this->product->insertUnit($postData);

                if($inputUnit > 0){
                    /** Set response */
                    $this->response( [
                        'status' => true,
                        'icon'   => 'success',
                        'message'   => 'Berhasil menyimpan data satuan !'
                    ], 201 );
                } else {
                    /** Set response */
                    $this->response( [
                        'status' => false,
                        'icon'   => 'error',
                        'message'   => 'Kesalahan sistem. Gagal menyimpan data satuan !'
                    ], 500 );
                }
            }
        }
    }

    /** PUT : Update unit / satuan */
    public function units_put($unit_id){
        if($this->auth_api(['uAll', 'uO', 'uG']) ?? FALSE){
            if($unit_id ?? FALSE){
                if($this->_validation_unit($unit_id) == TRUE){
                    $unitID = base64_decode(urldecode($this->put('editUnitID')));
                    
                    $this->load->library('form_validation'); 
                    
                    $configValidation = array(
                        array(
                            'field'	=> 'postUnitName',
                            'label'	=> 'Nama Satuan',
                            'rules'	=> 'trim|required|callback__validation_unit_name['.$unitID.']',
                            'errors'	=> array(
                                'is_unique'	=> 'Satuan sudah tersedia',
                                'required'	=> 'Satuan tidak boleh kosong'
                            )
                        )
                    );
        
                    /** Var untuk data yang akan di validasi, karena form_validation tidak membaca method PUT */
                    $dataToValidate = array(
                        'postUnitName' => $this->put('postUnitName')
                    );
                    $this->form_validation->set_data($dataToValidate); // Set data yang akan divalidasi
                    $this->form_validation->set_rules($configValidation);
        
                    if($this->form_validation->run() == FALSE) {
                        $this->response( [
                            'icon'   => 'error',
                            'message'   => array('errorName' => form_error('postUnitName'))
                        ], 422 );
                    } else {
                        $updateData = array(
                            'unit_id' => $unitID,
                            'unit_name' => $this->put('postUnitName')
                        );
        
                        $updateUnit = $this->product->updateUnit($updateData);
        
                        if($updateUnit > 0){
                            /** Set response */
                            $this->response( [
                                'icon'    => 'success',
                                'message' => 'Satuan berhasil diperbarui !',
                                'table'   => '#table-unit'
                            ], 201 );
                        } else {
                            /** Set response */
                            $this->response( [
                                'icon'   => 'error',
                                'message'   => 'Kesalahan sistem. Gagal mengubah data satuan'
                            ], 500 );
                        }
                    }
                } else {
                    $this->response( [
                        'icon'   => 'error',
                        'message'   => 'Data tidak ditemukan !'
                    ], 404 );
                }
            } else {
                /** Set response */
                $this->response( [
                    'status' => false,
                    'message' => 'Provide an ID !'
                ], 400 );
            }
        }
    }

    /** Delete : Delete unit/satuan (Permanent) */
    public function units_delete($unit_id){
        if($this->auth_api(['uAll', 'uO', 'uG']) ?? FALSE){
            if($unit_id ?? FALSE){
                if($this->_validation_unit($unit_id) == TRUE){
                    $unitID = base64_decode(urldecode($unit_id));
                    $delUnit = $this->product->deleteUnit($unitID);
                    
                    if($delUnit > 0){
                        /** Set response */
                        $this->response( [
                            'icon'    => 'success',
                            'message' => 'Satuan berhasil dihapus !',
                            'table'   => '#table-unit'
                        ], 200 );
                    } else {
                        /** Set response */
                        $this->response( [
                            'icon'   => 'error',
                            'message'   => 'Kesalahan sistem. Gagal menghapus data satuan'
                        ], 500 );
                    }
                } else {
                    $this->response( [
                        'status' => false,
                        'icon'   => 'error',
                        'message'   => 'Data tidak ditemukan !'
                    ], 404 );
                }
            } else {
                /** Set response */
                $this->response( [
                    'status' => false,
                    'message' => 'Provide an ID !'
                ], 400 );
            }
        }
    }

  /** Validation */
    /** Validate Category ID */
    public function _validation_category($id){
        $decoded_id = base64_decode(urldecode($id));
        if(ctype_digit($decoded_id) == TRUE){
            if($this->product->selectCategoryByID($decoded_id)->num_rows() > 0){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /** Validate : Category name on update */
    public function _validation_cat_name($cat_name, $cat_id){
        if($cat_name ?? FALSE){
            if($this->product->selectCatByNameExID( $cat_id, $cat_name )->num_rows() > 0){
                $this->form_validation->set_message('_validation_cat_name', 'Nama Kategori sudah terpakai !');
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            $this->form_validation->set_message('_validation_cat_name', 'Nama Kategori tidak boleh kosong !');
            return FALSE;
        }
    }

    /** Validate Unit ID */
    public function _validation_unit($id){
        $decoded_id = base64_decode(urldecode($id));
        if(ctype_digit($decoded_id) == TRUE){
            if($this->product->selectUnitByID($decoded_id)->num_rows() > 0){
                return TRUE;
            } else {
                return FALSE;
            }   
        } else {
            return FALSE;
        }
    }

    /** Validate : Unit name on update */
    public function _validation_unit_name($unit_name, $unit_id){
        if($unit_name ?? FALSE){
            if($this->product->selectUnitByNameExID( $unit_id, $unit_name )->num_rows() > 0){
                $this->form_validation->set_message('_validation_unit_name', 'Nama Unit sudah terpakai !');
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            $this->form_validation->set_message('_validation_unit_name', 'Nama Unit tidak boleh kosong !');
            return FALSE;
        }
    }

    /** Validate : Product ID */
    public function _validation_product_id($prd_id){
        if($prd_id ?? FALSE){
            $decoded_id = base64_decode(urldecode($prd_id));
            if(ctype_digit($decoded_id) == TRUE){
                if($this->product->selectProductByID($decoded_id)->num_rows() > 0){
                    return TRUE;
                } else {
                    $this->form_validation->set_message('_validation_product_id', 'Produk tidak ditemukan !');
                    return FALSE;
                }
            } else {
                $this->form_validation->set_message('_validation_product_id', 'ID Produk tidak valid !');
                return FALSE;
            }
        } else {
            $this->form_validation->set_message('_validation_product_id', 'Mohon pilih produk yang akan diproses');
            return FALSE;
        }
    }

    /** Validate : Product Code when Update */
    public function _validation_update_code($prd_code){
        if($prd_code ?? FALSE){
            if($this->product->selectProductByCodeExID(base64_decode(urldecode($this->post('postID'))), $prd_code)->num_rows() > 0){
                $this->form_validation->set_message('_validation_update_code', 'Kode produk sudah terpakai !');
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return TRUE;
        }
    }

    /** Validate : Product name when update */
    public function _validation_update_name($prd_name){
        if($prd_name ?? FALSE){
            if($this->product->selectProductByNameExID( base64_decode(urldecode($this->post('postID'))), $prd_name )->num_rows() > 0){
                $this->form_validation->set_message('_validation_update_name', 'Nama Produk sudah terpakai !');
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            $this->form_validation->set_message('_validation_update_name', 'Nama Produk tidak boleh kosong !');
            return FALSE;
        }
    }

    /** Validate : Tujuan mutasi / Stock mutation destination */
    public function _validation_stock_b($stock_b){
        if($stock_b == $this->post('postStockA')){
            $this->form_validation->set_message('_validation_stock_b', 'Tujuan tidak boleh sama dengan asal stok !');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /** Validate : Date */
	function _validation_date($post){
		/** preg_match pattern for input format YYYY-mm-dd */
		if(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $post)){
			/** checkdate(month, day, year) for input format YYYY-mm-dd */
			if(checkdate(substr($post, 5, 2), substr($post, 8, 2), substr($post, 0, 4))){
				return TRUE;
			} else {
                $this->form_validation->set_message('_validation_date', 'Tanggal tidak valid !');
				return FALSE;
			}
		} else {
            $this->form_validation->set_message('_validation_date', 'Tanggal harus berformat YYYY-mm-dd !');
			return FALSE;
		}
    }

}