    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark text-uppercase">Tambah Produk</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('Page_c') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo site_url('Product_c') ?>"><i class="fas fa-cubes"></i> Produk</a></li>
              <li class="breadcrumb-item active">Tambah Produk</li>
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
          <div class="col-lg-12">
            <div class="card card-info card-outline">
              <form class="form-horizontal" id="formAddPrd" enctype="multipart/form-data">
                <div class="card-body">
                  <!-- Div ALert -->
                  <div id="alert-proses"></div>
                  
                  <h4>Informasi Produk</h4>
                  <hr>
                  <div class="col-12 ml-1 mb-3 row">
                    <!-- Form-part input Nama Produk -->
                      <div class="col-md-5">
                        <div class="form-group">
                          <label>Nama Product <font color="red"><small>*</small></font></label>
                          <input type="text" class="form-control" name="postNama" id="inputNama" placeholder="Nama Produk" required>
                          <small id="errorNama" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                        </div>
                      </div>

                    <!-- Form-part input Kode Produk -->
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Code Product</label>
                          <input type="text" class="form-control" name="postCode" id="inputCode" placeholder="Barcode akan terisi otomatis jika kosong">
                          <small style="color:red; font-style: italic">Akan terisi otomatis jika product tidak memiliki kode</small>
                        </div>
                      </div>

                    <!-- Form-part input Kategori Produk -->
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Kategori <font color="red"><small>*</small></font></label>
                          <select class="form-control" name="postKategori" id="inputKategori" required>
                            <option value=""> -- Pilih Kategori -- </option>
                            <?php foreach ($optCtgr as $showCtgr): ?>
                              <option value="<?php echo $showCtgr['ctgr_id'] ?>"> <?php echo $showCtgr['ctgr_name'] ?> </option>
                            <?php endforeach; ?>
                          </select>
                          <small id="errorKategori" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                        </div>
                      </div>

                    <!-- Form-part input Harga Beli -->
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Harga Beli <font color="red"><small>*</small></font></label>
                          <input type="number" class="form-control" step="0.01" name="postHargaBeli" id="inputHargaBeli" placeholder="Harga Beli Produk" required>
                          <small id="errorHargaBeli" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                        </div>
                      </div>

                    <!-- Form-part input Harga Jual -->
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Harga Jual <font color="red"><small>*</small></font></label>
                          <div class="row">
                              <div class="col-11">
                                <input type="number" class="form-control" step="0.01" name="postHargaJual" id="inputHargaJual" placeholder="Harga Jual Produk" required>
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
                              <option value="<?php echo $showUnit['unit_id'] ?>"> <?php echo $showUnit['unit_name'] ?> </option>
                            <?php endforeach; ?>
                          </select>
                          <small id="errorSatuan" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                        </div>
                      </div>

                    <!-- Form-part input Isi per statuan -->
                      <div class="col-lg-2 col-md-4">
                        <div class="form-group">
                          <label>Isi per satuan <font color="red"><small>*</small></font></label>
                          <input type="number" class="form-control" name="postIsi" id="inputIsi" placeholder="Isi tiap satuan" required>
                          <small id="errorIsi" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                        </div>
                      </div>

                    <!-- Form-part input gambar product -->
                      <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                          <label>Gambar <small class="help" style="color: red; font-style: italic;">( potrait / square, maksimal 2MB )</small></label>
                          <input type="file" class="dropify" name="postImg" id="inputImg" data-allowed-formats="portrait square" data-max-file-size="2M" data-max-height="2000" />
                          <small id="errorImg" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                        </div>
                      </div>
                    
                    <!-- Form-part input deskripsi -->
                      <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                          <label>Deskripsi</label>
                          <textarea class="form-control" name="postDeskripsi" id="inputDeskripsi" rows="8"></textarea>
                        </div>
                      </div>
                  </div>
                  
                  <h4>Stok Awal Produk</h4>
                  <hr>
                  <div class="col-12 ml-1 row">
                    <!-- Form-part input Stok Awal -->
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Stok awal <font color="red"><small>*</small></font></label>
                          <input type="number" class="form-control" name="postStockG" id="inputStockG" placeholder="Stok awal produk" required>
                          <small id="errorStockG" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                        </div>
                      </div>

                    <!-- Form-part input Stok Awal -->
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Stok damaged / rusak <font color="red"><small>*</small></font></label>
                          <input type="number" class="form-control" name="postStockNG" id="inputStockNG" placeholder="Stok awal produk rusak / damaged " required>
                          <small id="errorStockNG" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                        </div>
                      </div>

                    <!-- Form-part input Stok Awal -->
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Stok Opname <font color="red"><small>*</small></font></label>
                          <input type="number" class="form-control" name="postStockOP" id="inputStockOP" placeholder="Stok awal opname" required>
                          <small id="errorStockOP" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                        </div>
                      </div>
                  </div>

                </div>
                <div class="card-footer">
                  <div class="float-right">
                    <button type="reset" class="btn btn-secondary"><b> Reset </b></button>
                    <button type="submit" class="btn btn-success" id="submitForm"><b> Simpan </b></button>
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