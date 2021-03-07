    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Halaman Produk</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('Page_c') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo site_url('Product_c') ?>"><i class="fas fa-cubes"></i> Produk</a></li>
              <li class="breadcrumb-item active">Ubah Produk</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card card-orange card-outline">
              <div class="card-header">
                <h5 class="card-title">Ubah detail produk</h5>
                <div class="float-right">
                  <a href="<?php echo site_url('Product_c/listProductPage') ?>" class="btn btn-xs btn-secondary"><i class="fas fa-list"></i></a>
                  <a href="<?php echo site_url('Product_c/detailProductPage/').urlencode(base64_encode($detailPrd[0]['prd_id'])) ?>" class="btn btn-xs btn-info"><i class="fas fa-search"></i></a>
                </div>
              </div>
              <form class="form-horizontal" action="<?php echo site_url('Product_c/editProductProses') ?>" id="form-edit-prd">
              <div class="card-body">
                  <!-- Div ALert -->
                  <div id="alert-proses"></div>
                  
                  <div class="col-12 ml-1 mb-3 row">

                    <!-- Form-part hidden input ID Product -->
                      <input type="hidden" name="postId" value="<?php echo urlencode(base64_encode($detailPrd[0]['prd_id'])) ?>">

                    <!-- Form-part input Nama Produk -->
                      <div class="col-md-5">
                        <div class="form-group">
                          <label>Nama Product <font color="red"><small>*</small></font></label>
                          <input type="text" class="form-control" name="postNama" id="inputNama" value="<?php echo $detailPrd[0]['prd_name'] ?>" placeholder="Nama Produk" required>
                          <small id="errorNama" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                        </div>
                      </div>

                    <!-- Form-part input Kode Produk -->
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Barcode Product</label>
                          <input type="text" class="form-control" name="postBarcode" id="inputBarcode" value="<?php echo $detailPrd[0]['prd_barcode'] ?>" placeholder="Kosongkan jika tidak memiliki barcode">
                        </div>
                      </div>

                    <!-- Form-part input Kategori Produk -->
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Kategori <font color="red"><small>*</small></font></label>
                          <select class="form-control" name="postKategori" id="inputKategori" required>
                            <option value=""> -- Pilih Kategori -- </option>
                            <?php foreach ($optCtgr as $showCtgr): ?>
                              <option value="<?php echo $showCtgr['ctgr_id'] ?>" <?php echo ($detailPrd[0]['prd_category_id_fk'] === $showCtgr['ctgr_id'])? 'selected="selected"' : '' ?>> 
                                <?php echo $showCtgr['ctgr_name'] ?> 
                              </option>
                            <?php endforeach; ?>
                          </select>
                          <small id="errorKategori" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                        </div>
                      </div>

                    <!-- Form-part input Harga Beli -->
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Harga Beli <font color="red"><small>*</small></font></label>
                          <input type="number" class="form-control" step="0.01" name="postHargaBeli" id="inputHargaBeli" value="<?php echo $detailPrd[0]['prd_purchase_price'] ?>" placeholder="Harga Beli Produk" required>
                          <small id="errorHargaBeli" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                        </div>
                      </div>

                    <!-- Form-part input Harga Jual -->
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Harga Jual <font color="red"><small>*</small></font></label>
                          <div class="row">
                              <div class="col-11">
                                <input type="number" class="form-control" step="0.01" name="postHargaJual" id="inputHargaJual" value="<?php echo $detailPrd[0]['prd_selling_price'] ?>" placeholder="Harga Jual Produk" required>
                              </div>
                              <div class="col-1"><h3><b>/</b></h3></div>
                          </div>
                          <small id="errorHargaJual" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                        </div>
                      </div>

                    <!-- Form-part input Satuan -->
                      <div class="col-lg-2 col-md-4">
                        <div class="form-group">
                          <label>Satuan <font color="red"><small>*</small></font></label>
                          <select class="form-control" name="postSatuan" id="inputSatuan" required>
                            <option value=""> -- Pilih Satuan -- </option>
                            <?php foreach ($optUnit as $showUnit): ?>
                              <option value="<?php echo $showUnit['unit_id'] ?>" <?php echo ($detailPrd[0]['prd_unit_id_fk'] === $showUnit['unit_id'])? 'selected="selected"' : '' ?>> 
                                <?php echo $showUnit['unit_name'] ?> 
                            <?php endforeach; ?>
                          </select>
                          <small id="errorSatuan" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                        </div>
                      </div>

                    <!-- Form-part input Isi per statuan -->
                      <div class="col-lg-2 col-md-3 col-sm-4">
                        <div class="form-group">
                          <label>Isi per satuan <font color="red"><small>*</small></font></label>
                          <input type="number" class="form-control" name="postIsi" id="inputIsi" value="<?php echo $detailPrd[0]['prd_containts'] ?>" placeholder="Isi tiap satuan" required>
                          <small id="errorIsi" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                        </div>
                      </div>

                    <!-- Form-part input gambar product -->
                      <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="form-group">
                          <label>Gambar</label>
                          <div>
                            <img width="160" height="auto" class="img-fluid" src="<?php echo base_url(); echo ($detailPrd[0]['prd_image'] != '')? $detailPrd[0]['prd_image'] : 'assets/uploaded_files/product_img/no_photo.png' ?>" alt="baseurl.com/my_assets/upload/product_img/gambar_product.jpg">
                          </div>
                          <input type="hidden" name="postOldImg" value="<?php echo $detailPrd[0]['prd_image'] ?>">
                        </div>
                      </div>

                    <!-- Form-part input gambar product -->
                      <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="form-group">
                          <label>Gambar Baru <small class="help" style="color: red; font-style: italic;">( potrait / square, maksimal 2MB )</small></label>
                          <input type="file" class="dropify" name="postImg" id="inputImg" data-allowed-formats="portrait square" data-max-file-size="2M" data-max-height="2000" />
                          <small id="errorImg" class="error-msg" style="color:red; font-style: italic"></small>
                        </div>
                      </div>
                    
                    <!-- Form-part input deskripsi -->
                      <div class="col-lg-5 col-sm-12">
                        <div class="form-group">
                          <label>Deskripsi</label>
                          <textarea class="form-control" name="postDeskripsi" id="inputDeskripsi" rows="8"><?php echo $detailPrd[0]['prd_description'] ?></textarea>
                        </div>
                      </div>
                  </div>
                  <div class="col-12 ml-1 row">
                    <!-- Form-part input Stok Awal -->
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Stok awal <font color="red"><small>*</small></font></label>
                          <input type="number" class="form-control" name="postStockG" id="inputStockG" value="<?php echo $detailPrd[0]['prd_initial_g_stock'] ?>" placeholder="Stok awal produk" required>
                          <small id="errorStockG" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                        </div>
                      </div>

                    <!-- Form-part input Stok Awal -->
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Stok damaged / rusak <font color="red"><small>*</small></font></label>
                          <input type="number" class="form-control" name="postStockNG" id="inputStockNG" value="<?php echo $detailPrd[0]['prd_initial_ng_stock'] ?>" placeholder="Stok awal produk rusak / damaged " required>
                          <small id="errorStockNG" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                        </div>
                      </div>

                    <!-- Form-part input Stok Awal -->
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Stok Opname <font color="red"><small>*</small></font></label>
                          <input type="number" class="form-control" name="postStockOP" id="inputStockOP" value="<?php echo $detailPrd[0]['prd_initial_op_stock'] ?>" placeholder="Stok awal opname" required>
                          <small id="errorStockOP" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                        </div>
                      </div>

                    <!-- Stock edit msg -->
                      <div class="col-12"><small style="color: red"><em>** mengubah stok awal akan mengubah stok saat ini ! </em></small></div>

                  </div>

                </div>
                <div class="card-footer">
                  <div class="float-right">
                    <button type="reset" class="btn btn-secondary"><b> Reset </b></button>
                    <button type="submit" id="submit-form" class="btn btn-success"><b> Simpan </b></button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->