<?php
use chriskacerguis\RestServer\RestController;

defined('BASEPATH') OR exit('No direct script access allowed !');

require APPPATH."libraries/RestController.php";
require APPPATH."libraries/Format.php";

Class Product_api extends RestController {

    public function __construct(){
        parent::__construct();
        $this->load->model('Product_m', 'product');
    }

  /** Product */
    /** GET : all product and all product on category */
    public function index_get(){
        /** Check if category exist, if exist return product on selected category */
        if($this->get('category') != NULL){
            /** Decode category */
            $ctgrID = base64_decode(urldecode($this->get('category')));

            /** Check Category exist in DB */
            if($this->product->selectCategoryByID($ctgrID)->num_rows() > 0){
                /** Get data from db */
                $countData = $this->product->selectProductOnCtgr($ctgrID)->num_rows();
                $getData = $this->product->selectProductOnCtgr($ctgrID)->result_array();
            } else {
                $error_msg = 'Category didn\'t exist !';
                $error_code = 404;
            }
        } else { // return all product
            /** Check Lenght and start for pagination */
            $dataLen    = $this->get('length') ?? 0;
            $dataOffset = $this->get('start') ?? 0;
            $draw       = $this->get('draw') ?? '';

            /** Get data from db */
            $totalData = $this->product->selectProduct(0, 0, 0)->num_rows();
            $countData = $this->product->selectProduct($dataLen, $dataOffset, 0)->num_rows();
            $getData = $this->product->selectProduct($dataLen, $dataOffset, 0)->result_array();
        }

        /** Check if there is any $error */
        if(!isset($error_msg)){
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
                'status' => false,
                'message'   => $error_msg
            ], $error_code );
        }
    }

    /** POST : insert product */
    public function index_post(){
        /** Load library & Helper */
            $this->load->library('form_validation'); 
            $this->load->helper('file');
            $this->load->library('upload');
		  
        /** Set rules form validation */
            $configValidation = array(
                array(
                    'field'	=> 'postCode',
                    'label'	=> 'Kode Produk',
                    'rules'	=> 'trim'
                ),
                array(
                    'field'	=> 'postNama',
                    'label'	=> 'Nama Produk',
                    'rules'	=> 'trim|required',
                    'errors'	=> array(
                        'required' => 'Nama produk tidak boleh kosong'
                    )
                ),
                array(
                    'field'	=> 'postKategori',
                    'label'	=> 'Kategori Produk',
                    'rules'	=> 'trim|required|numeric',
                    'errors'	=> array(
                        'required'	=> 'Kategori produk tidak boleh kosong',
                        'numeric'	=> 'Pilih option tersedia'
                    )
                ),
                array(
                    'field'	=> 'postHargaBeli',
                    'label'	=> 'Harga Beli',
                    'rules'	=> 'trim|required|greater_than_equal_to[0]|numeric',
                    'errors'	=> array(
                        'required' 	=> 'Harga beli tidak boleh kosong',
                        'numeric'	=> 'Harga tidak sesuai format',
                        'greater_than_equal_to' => 'Harga harus lebih dari 0' 
                    )
                ),
                array(
                    'field'	=> 'postHargaJual',
                    'label'	=> 'Harga Jual',
                    'rules'	=> 'trim|required|greater_than_equal_to[0]|numeric',
                    'errors'	=> array(
                        'required' 	=> 'Harga Jual tidak boleh kosong',
                        'numeric'	=> 'Harga tidak sesuai format',
                        'greater_than_equal_to' => 'Harga harus lebih dari 0' 
                    )
                ),
                array(
                    'field'	=> 'postSatuan',
                    'label'	=> 'Satuan',
                    'rules'	=> 'trim|required|numeric',
                    'errors'	=> array(
                        'required'	=> 'Satuan produk tidak boleh kosong',
                        'numeric'	=> 'Satuan tidak sesuai format'
                    )
                ),
                array(
                    'field'	=> 'postIsi',
                    'label'	=> 'Isi per satuan',
                    'rules'	=> 'trim|required|numeric',
                    'errors'	=> array(
                        'required'	=> 'Isi tidak boleh kosong',
                        'numeric'	=> 'Isi tidak sesuai format'
                    )
                ),
                array(
                    'field'	=> 'postStockG',
                    'label'	=> 'Stok awal',
                    'rules'	=> 'trim|required|numeric',
                    'errors'	=> array(
                        'numeric'	=> 'tidak sesuai format',
                        'required'	=> 'Stok awal tidak boleh kosong'
                    )
                ),
                array(
                    'field'	=> 'postStockNG',
                    'label'	=> 'Stok awal rusak',
                    'rules'	=> 'trim|required|numeric',
                    'errors'	=> array(
                        'numeric'	=> 'tidak sesuai format',
                        'required'	=> 'Stok awal tidak boleh kosong'
                    )
                ),
                array(
                    'field'	=> 'postStockOP',
                    'label'	=> 'Stok awal opname',
                    'rules'	=> 'trim|required|numeric',
                    'errors'	=> array(
                        'numeric'	=> 'tidak sesuai format',
                        'required'	=> 'Stok awal tidak boleh kosong'
                    )
                ),
                array(
                    'field'	=> 'postDeskripsi',
                    'label'	=> 'Deskripsi Produk',
                    'rules'	=> 'trim'
                )
            );
            $this->form_validation->set_rules($configValidation);

        /** Run form validation */
            if($this->form_validation->run() == FALSE) {
                $error_code = 422;
                $error_msg = array(
                    'error_msg'     => 'Invalid input !',
                    'errorNama' 	=> form_error('postNama'),
                    'errorKategori'	=> form_error('postKategori'),
                    'errorHrgBeli'	=> form_error('postHargaBeli'),
                    'errorHrgJual'	=> form_error('postHargaJual'),
                    'errorSatuan'	=> form_error('postSatuan'),
                    'errorIsi'		=> form_error('postIsi'),
                    'errorStockG'	=> form_error('postStockG'),
                    'errorStockNG' => form_error('postStockNG'),
                    'errorStockOP' => form_error('postStockOP')			
                );
            } else {
                /** Set product code */
                    if($this->post('postCode') ?? false){
                        $nextAI  = $this->product->getNextIncrement();
                        if($nextAI > 0){
                            $nextAI = $this->Sales_m->getNextIncrement()->result_array(); // Get next auto increment table
                            $nol = '';
                            for($n = 4; $n >= strlen($nextAI['0']['AUTO_INCREMENT']); $n--){
                                $nol .= '0';
                            }
                            $nextCode = 'p'.date('ymd').$nol.$nextAI['0']['AUTO_INCREMENT'];
                        } else {
                            $nextCode = 'p'.date('ymd').'0001';
                        }
                    }

                /** Get Form Data */
                    $postData = array(
                        'prd_code'		     => $this->post('postCode'),
                        'prd_name'			 => $this->post('postNama'),
                        'prd_category_id_fk' => $this->post('postKategori'),
                        'prd_purchase_price' => $this->post('postHargaBeli'),
                        'prd_selling_price'	 => $this->post('postHargaJual'),
                        'prd_unit_id_fk' 	 	=> $this->post('postSatuan'),
                        'prd_containts' 	 	=> $this->post('postIsi'),
                        'prd_initial_g_stock'	=> $this->post('postStockG'),
                        'prd_initial_ng_stock'	=> $this->post('postStockNG'),
                        'prd_initial_op_stock'	=> $this->post('postStockOP'),
                        'prd_description'		=> $this->post('postDeskripsi'),
                        'prd_image'			    => NULL
                    );

                /** Upload Proses */
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

                /** Proses simpan data */
                    if(isset($errorUpload)){
                        $error_code = 422;
                        $error_msg = array(
                            'error_msg' => 'Invalid file format !',
                            'errorImg'  => $errorUpload
                        );
                    } else {
                        $inputPrd = $this->product->insertProduct($postData);

                        /** Return dan redirect */
                        if($inputPrd && $inputPrd['resultInsert'] > 0){
                            /** Insert stock product */
                            $inputStock = $this->product->insertProductStock($postData, $inputPrd['insertID']); // Insert ke table stok
                        
                            /** Result to return */
                            $arrReturn = array(
                                'success'	=> TRUE,
                                'status'	=> 'successInsert',
                                'statusMsg' => 'Berhasil Menambahkan produk !',
                                'statusIcon' => 'success',
                                'redirect'	=> site_url('Product_c/listProductPage')
                            );
                        } else {
                            /** Result to return */
                            $arrReturn = array(
                                'success'	=> TRUE,
                                'status'	=> 'failedInsert',
                                'statusMsg' => 'Gagal Menambahkan produk !',
                                'statusIcon' => 'error',
                                'redirect'	=> site_url('Product_c/listProductPage')
                            );
                        }
                    }
            }

        /** Set response */
        $this->response( [
            'status' => true,
            'message'   => $postData
        ], 200 );
    }

    /** GET : detail product by id */
    public function getDetailProduct_get(){
        /** Check if prdID, if prdID exist then decode */
        $prd_id = base64_decode(urldecode($this->get('prdID')));
        if($prd_id != NULL){
            if($this->product->selectProductByID($prd_id)->num_rows() > 0){
                /** Get Data */
                $getData = $this->product->selectProductByID($prd_id)->result_array();
                foreach($getData as $row){
                    $returnData = array(
                        'data_id'       => urlencode(base64_encode($row['prd_id'])),
                        'data_barcode'  => $row['prd_code'],
                        'data_name'     => $row['prd_name'],
                        'data_category' => $row['ctgr_name'],
                        'data_purchase_price'  => $row['prd_purchase_price'],
                        'data_selling_price'   => $row['prd_selling_price'],
                        'data_unit'    => $row['unit_name'],
                        'good_stock'   => 0,
                    );
                }
                
                /** Set response */
                $this->response( [
                    'status' => true,
                    'data' => $returnData
                ], 200 );
            } else {
                /** Set response */
                $this->response( [
                    'status' => false,
                    'message' => 'Product not found !'
                ], 404 );
            }
        } else {
            /** Set response */
            $this->response( [
                'status' => false,
                'message' => 'Provide an ID'
            ], 400 );
        }
    }

    /** GET : detail stock by product id */
    public function getStockProduct_get(){
        /** Get Data */
        $countData = $this->product->selectProductStock()->num_rows();
        $getStock = $this->product->selectProductStock()->result_array();

        $returnData = array();
        /** Set return data */
        foreach($getStock as $row){
            $returnData[] = array(
                'data_id'      => urlencode(base64_encode($row['prd_id'])),
                'data_barcode' => $row['prd_code'],
                'data_name'  => $row['prd_name'],
                'initial_g'  => $row['prd_initial_g_stock'],
                'initial_ng' => $row['prd_initial_ng_stock'],
                'initial_op' => $row['prd_initial_op_stock'],
                'stk_g'      => $row['stk_good'],
                'stk_ng'     => $row['stk_not_good'],
                'stk_op'     => $row['stk_opname']
            );
        }
    
        /** Set response */
        $this->response( [
            'status'     => true,
            'count_data' => $countData,
            'data'       => $returnData
        ], 200 );
    }

  /** Category */
    /** GET : all category and category data by ctgr_id */
    public function getCategory_get(){
        /** Check if ctgrID exist, if exist get detail data by ctgr_id */
        if($this->get('ctgrID') != NULL){
            $countData = $this->product->selectCategoryByID(base64_decode(urldecode($this->get('ctgrID'))))->num_rows();
            
            if($countData > 0){
                $getData = $this->product->selectCategoryByID(base64_decode(urldecode($this->get('ctgrID'))))->result_array();
            } else {
                $error_msg = 'Category not found !';
                $error_code = 404;
            }
        } else {
            $dataLen    = $this->get('length') ?? 0;
            $dataOffset = $this->get('start') ?? 0;

            if($this->get('necessity') == 'dt'){
                $dataKeyword = $this->get('search')['value'] ?? NULL;
                $draw       = $this->get('draw') ?? '';
                $getData = $this->product->selectCategory($dataLen, $dataOffset, $dataKeyword)->result_array();

                $totalData = $this->product->selectCategory(0, 0, $dataKeyword)->num_rows();
                $countData = $this->product->selectCategory($dataLen, $dataOffset, $dataKeyword)->num_rows();
            } else {
                $dataKeyword = $this->get('search') ?? NULL;
                $getData = $this->product->selectCategory($dataLen, $dataOffset, $dataKeyword)->result_array();

                $totalData = $this->product->selectCategory(0, 0, $dataKeyword)->num_rows();
                $countData = $this->product->selectCategory($dataLen, $dataOffset, $dataKeyword)->num_rows();
                
                if($countData > 0){
                    $getData = $this->product->selectCategory($dataLen, $dataOffset, $dataKeyword)->result_array();
                } else {
                    $error_msg = 'Category not available !';
                    $error_code = 404;
                }
            }

        }

        /** Check if there is any $error */
        if(!isset($error_msg)){
            $returnData = array();
            $no = 1;
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
                'status'     => true,
                'count_data' => $countData,
                'data'       => $returnData,

                /** Value untuk datatable */
                'draw'            => ($this->get('necessity') == 'dt')? $draw : null,
                'recordsTotal'    => ($this->get('necessity') == 'dt')? $totalData : null,
                'recordsFiltered' => ($this->get('necessity') == 'dt')? $totalData : null,
            ], 200 );
        } else {
            /** Set response */
            $this->response( [
                'status' => false,
                'message'   => $error_msg
            ], $error_code );
        }
    }

    /** Post : input new category */
    public function getCategory_post(){
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
                $error_code = 422;
                $error_msg = array(
                    'errorName' => form_error('postCatName')
                );
                $error_icon = 'error';
            } else {
                /** Get data post dari form */
                $postData = array(
                    'ctgr_name' => $this->post('postCatName')
                );
                
                $inputCat = $this->product->insertCategory($postData);
            }

        /** Check if there is an error */
        if(!isset($error_msg) && !isset($error_code)){
            if($inputCat > 0){
                /** Set response */
                $this->response( [
                    'icon'   => 'success',
                    'message'    => 'Berhasil menambah data kategori !'
                ], 201 );
            } else {
                /** Set response */
                $this->response( [
                    'icon'   => 'error',
                    'message'   => 'Kesalahan sistem. Gagal menyimpan data kategori'
                ], 500 );
            }
        } else {
            /** Set response */
            $this->response( [
                'icon'   => $error_icon,
                'message'   => $error_msg
            ], $error_code );
        }
    }

    /** Put : Update category */
    public function getCategory_put(){
        if($this->put('editID')){
            $ctgrID = base64_decode(urldecode($this->put('editID')));
            
            $this->load->library('form_validation'); 
            
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

            /** Var untuk data yang akan di validasi, karena form_validation tidak membaca method PUT */
            $dataToValidate = array(
                'postCatName' => $this->put('postCatName')
            );
            $this->form_validation->set_data($dataToValidate); // Set data yang akan divalidasi
            $this->form_validation->set_rules($configValidation);
        
            if($this->form_validation->run() == FALSE) {
                $this->response( [
                    'icon'   => 'error',
                    'message'   => array('errorName' => form_error('postCatName'))
                ], 422 );
            } else {
                if($this->checkCatID($ctgrID) == TRUE){
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
                } else {
                    $this->response( [
                        'icon'   => 'error',
                        'message'   => 'Kategori tidak ditemukan !'
                    ], 404 );
                }
            }
        } else {
            /** Set response */
            $this->response( [
                'icon'   => 'error',
                'message'   => 'Pilih kategori yang akan diubah !'
            ], 400 );
        }
    }

    /** Delete : Delete category (Permanent) */
    public function getCategory_delete(){
        if($this->delete('dataID') != NULL){
            if($this->checkCatID(base64_decode(urldecode($this->delete('dataID')))) == TRUE){
                $delCat = $this->product->deleteCategory(base64_decode(urldecode($this->delete('dataID'))));

                if($delCat > 0){
                    /** Set response */
                    $this->response( [
                        'icon'    => 'success',
                        'message' => 'Kategori berhasil dihapus !',
                        'table'   => '#table-category'
                    ], 200 );
                } else {
                    /** Set response */
                    $this->response( [
                        'icon'   => 'error',
                        'message'   => 'Kesalahan sistem. Gagal menghapus data kategori'
                    ], 500 );
                }
            } else {
                /** Set response */
                $this->response( [
                    'icon'   => 'error',
                    'message'   => 'Kategori tidak ditemukan !',
                ], 400 );
            }
        } else {
            /** Set response */
            $this->response( [
                'icon'   => 'error',
                'message'   => 'Pilih kategori yang akan dihapus !'
            ], 400 );
        }
    }

  /** Unit */
    /** GET : all unit and unit data by unit_id */
    public function getUnit_get(){
        /** Check if unitID exist, if exist get detail data by unit_id */
        if($this->get('unitID') != NULL){
            $countData = $this->product->selectUnitByID(base64_decode(urldecode($this->get('unitID'))))->num_rows();
            
            if($countData > 0){
                $getData = $this->product->selectUnitByID(base64_decode(urldecode($this->get('unitID'))))->result_array();
            } else {
                $error_msg = 'Unit not found !';
                $error_code = 404;
            }
        } else {
            $dataLen    = $this->get('length') ?? 0;
            $dataOffset = $this->get('start') ?? 0;

            if($this->get('necessity') == 'dt'){
                $dataKeyword = $this->get('search')['value'] ?? NULL;
                $draw       = $this->get('draw') ?? '';
                $getData = $this->product->selectUnit($dataLen, $dataOffset, $dataKeyword)->result_array();

                $totalData = $this->product->selectUnit(0, 0, $dataKeyword)->num_rows();
                $countData = $this->product->selectUnit($dataLen, $dataOffset, $dataKeyword)->num_rows();
            } else {
                $dataKeyword = $this->get('search') ?? NULL;
                $getData = $this->product->selectUnit($dataLen, $dataOffset, $dataKeyword)->result_array();

                $totalData = $this->product->selectUnit(0, 0, $dataKeyword)->num_rows();
                $countData = $this->product->selectUnit($dataLen, $dataOffset, $dataKeyword)->num_rows();
                
                if($countData > 0){
                    $getData = $this->product->selectUnit($dataLen, $dataOffset, $dataKeyword)->result_array();
                } else {
                    $error_msg = 'Unit not available !';
                    $error_code = 404;
                }
            }
        }

        /** Check if there is any $error */
        if(!isset($error_msg)){
            $returnData = array();
            $no = 1;
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
                'status'     => true,
                'count_data' => $countData,
                'data'       => $returnData,

                /** Value untuk datatable */
                'draw'            => ($this->get('necessity') == 'dt')? $draw : null,
                'recordsTotal'    => ($this->get('necessity') == 'dt')? $totalData : null,
                'recordsFiltered' => ($this->get('necessity') == 'dt')? $totalData : null,
            ], 200 );
        } else {
            /** Set response */
            $this->response( [
                'status' => false,
                'message'   => $error_msg
            ], $error_code );
        }
    }

    /** POST : input new unit / satuan */
    public function getUnit_post(){
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
                $error_code = 422;
                $error_msg = array(
                    'errorName' => form_error('postUnitName')
                );
                $error_icon = 'error';
            } else {
                /** Get data post dari form */
                $postData = array(
                    'unit_name' => $this->post('postUnitName')
                );
                
                $inputUnit = $this->product->insertUnit($postData);
            }

        /** Check if there is an error */
            if(!isset($error_msg) && !isset($error_code)){
                if($inputUnit > 0){
                    /** Set response */
                    $this->response( [
                        'icon'   => 'success',
                        'message'    => 'Berhasil menambah data unit !'
                    ], 201 );
                } else {
                    /** Set response */
                    $this->response( [
                        'icon'   => 'error',
                        'message'   => 'Kesalahan sistem. Gagal menyimpan data unit'
                    ], 500 );
                }
            } else {
                /** Set response */
                $this->response( [
                    'icon'   => $error_icon,
                    'message'   => $error_msg
                ], $error_code );
            }
    }

    /** PUT : Update unit / satuan */
    public function getUnit_put(){
        if($this->put('editUnitID')){
            $unitID = base64_decode(urldecode($this->put('editUnitID')));
            
            $this->load->library('form_validation'); 
            
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
                if($this->checkUnitID($unitID) == TRUE){
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
                } else {
                    $this->response( [
                        'icon'   => 'error',
                        'message'   => 'Satuan tidak ditemukan !'
                    ], 404 );
                }
            }
        } else {
            /** Set response */
            $this->response( [
                'icon'   => 'error',
                'message'   => 'Pilih satuan yang akan diubah !'
            ], 400 );
        }
    }

    /** Delete : Delete unit/satuan (Permanent) */
    public function getUnit_delete(){
        if($this->delete('dataID') != NULL){
            if($this->checkUnitID(base64_decode(urldecode($this->delete('dataID')))) == TRUE){
                $delUnit = $this->product->deleteUnit(base64_decode(urldecode($this->delete('dataID'))));

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
                /** Set response */
                $this->response( [
                    'icon'   => 'error',
                    'message'   => 'Satuan tidak ditemukan !',
                ], 400 );
            }
        } else {
            /** Set response */
            $this->response( [
                'icon'   => 'error',
                'message'   => 'Pilih Satuan yang akan dihapus !'
            ], 400 );
        }
    }

  /** Validation & Other */
    /** Check Category ID */
    private function checkCatID($id){
        if(ctype_digit($id) == TRUE){
            if($this->product->selectCategoryByID($id)->num_rows() > 0){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /** Check Unit ID */
    private function checkUnitID($id){
        if(ctype_digit($id) == TRUE){
            if($this->product->selectUnitByID($id)->num_rows() > 0){
                return TRUE;
            } else {
                return FALSE;
            }   
        } else {
            return FALSE;
        }
    }
}