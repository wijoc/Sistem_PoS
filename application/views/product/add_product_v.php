    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Page Produk</h1>
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
          <div class="col-lg-10">
            <div class="card card-orange card-outline">
              <div class="card-header">
                <h5 class="m-0">Tambah Produk Baru</h5>
              </div>
              <form class="form-horizontal" method="POST" action="<?php echo site_url('Product_c/addProductProses') ?>">
                <div class="card-body">
                  <!-- Div ALert -->
                  <div id="alert-product"></div>

                  <!-- Form-part input Kode Produk : Otomatis -->
                    <div class="form-group row">
                      <label for="inputBarcodePrd" class="col-sm-3 col-form-label">Barcode Produk <a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control float-right" name="postBarcodePrd" id="inputBarcodePrd" placeholder="Kosongkan jika produk tidak memiliki barcode">
                      </div>
                    </div>

                  <!-- Form-part input Nama Produk -->
                    <div class="form-group row">
                      <label for="inputNamaPrd" class="col-sm-3 col-form-label">Nama Produk<a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control float-right" name="postNamaPrd" id="inputNamaPrd" placeholder="Nama Produk" required>
                      </div>
                    </div>

                  <!-- Form-part input Kategori -->
                    <div class="form-group row">
                      <label for="inputKategoriPrd" class="col-sm-3 col-form-label">Kategori <a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <select class="form-control float-right" name="postKategoriPrd" id="inputKategoriPrd">
                          <option> -- Pilih Kategori -- </option>
                          <?php foreach ($optKtgr as $showKtgr): ?>
                            <option value="<?php echo $showKtgr['ktgr_id'] ?>"> <?php echo $showKtgr['ktgr_nama'] ?> </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                  <!-- Form-part input Harga Beli -->
                    <div class="form-group row">
                      <label for="inputHargaBeli" class="col-sm-3 col-form-label">Harga Beli <a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <input type="number" class="form-control float-right" step="0.01" name="postHargaBeli" id="inputHargaBeli" placeholder="Harga Beli Produk" required>
                      </div>
                    </div>

                  <!-- Form-part input Harga Jual -->
                    <div class="form-group row">
                      <label for="inputHargaJual" class="col-sm-3 col-form-label">Harga Jual <a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <input type="number" class="form-control float-right" step="0.01" name="postHargaJual" id="inputHargaJual" placeholder="Harga Jual Produk" required>
                      </div>
                    </div>

                  <!-- Form-part input Satuan Produk -->
                    <div class="form-group row">
                      <label for="inputSatuan" class="col-sm-3 col-form-label">Satuan <a class="float-right"> : </a></label>
                      <div class="col-sm-5">
                        <select class="form-control float-right" name="postSatuan" id="inputSatuan">
                          <option> -- Pilih Satuan -- </option>
                          <?php foreach ($optSatuan as $showSatuan): ?>
                            <option value="<?php echo $showSatuan['satuan_id'] ?>"> <?php echo $showSatuan['satuan_nama'] ?> </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                  <!-- Form-part input Isi -->
                    <div class="form-group row">
                      <label for="inputIsi" class="col-sm-3 col-form-label">Isi tiap satuan <a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <input type="number" class="form-control float-right" name="postIsi" id="inputIsi" placeholder="Isi Produk tiap satuan" required>
                      </div>
                    </div>

                  <!-- Form-part input Deskripsi Produk -->
                    <div class="form-group row">
                      <label for="inputDeskripsiPrd" class="col-sm-3 col-form-label">Deskripsi <a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <textarea class="form-control" rows="3" name="postDeskripsiPrd" id="inputDeskripsiPrd" placeholder="Deskripsi Produk (optional)"></textarea>
                      </div>
                    </div>
                </div>
                <div class="card-footer">
                  <div class="float-right">
                    <button type="reset" class="btn btn-secondary"><b> Reset </b></button>
                    <button type="submit" class="btn btn-success"><b> Simpan </b></button>
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