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
          <div class="col-lg-10">
            <div class="card card-orange card-outline">
              <div class="card-header">
                <h5 class="m-0">Ubah Produk</h5>
              </div>
              <form class="form-horizontal" method="POST" action="<?php echo site_url('Product_c/editProductProses') ?>">
                <div class="card-body">

                  <!-- Form-part hidden input ID Product -->
                  	<input type="hidden" name="postId" value="<?php echo urlencode(base64_encode($detailPrd[0]['prd_id'])) ?>">

                  <!-- Form-part input Nama Produk -->
                    <div class="form-group row">
                      <label for="editNamaBrg" class="col-sm-3 col-form-label">Nama Produk<a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control float-right" name="postNamaBrg" id="editNamaBrg" value="<?php echo $detailPrd[0]['prd_nama'] ?>" placeholder="Nama Produk" required>
                      </div>
                    </div>

                  <!-- Form-part input Kategori -->
                    <div class="form-group row">
                      <label for="editKategoriBrg" class="col-sm-3 col-form-label">Kategori <a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <select class="form-control float-right" name="postKategoriBrg" id="editKategoriBrg">
                          <option> -- Pilih Kategori -- </option>
                          <?php foreach ($optKtgr as $showKtgr): ?>
                            <option value="<?php echo $showKtgr['ktgr_id'] ?>" <?php echo ($detailPrd[0]['prd_kategori_id_fk'] === $showKtgr['ktgr_id'])? 'selected="selected"' : '' ?>> 
                            	<?php echo $showKtgr['ktgr_nama'] ?> 
                            </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                  <!-- Form-part input Harga Beli -->
                    <div class="form-group row">
                      <label for="editHargaBeli" class="col-sm-3 col-form-label">Harga Beli <a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <input type="number" class="form-control float-right" step="0.01" name="postHargaBeli" id="editHargaBeli" value="<?php echo $detailPrd[0]['prd_harga_beli'] ?>" placeholder="Harga Beli Produk" required>
                      </div>
                    </div>

                  <!-- Form-part input Harga Jual -->
                    <div class="form-group row">
                      <label for="editHargaJual" class="col-sm-3 col-form-label">Harga Jual <a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <input type="number" class="form-control float-right" step="0.01" name="postHargaJual" id="editHargaJual" value="<?php echo $detailPrd[0]['prd_harga_jual'] ?>" placeholder="Harga Jual Produk" required>
                      </div>
                    </div>

                  <!-- Form-part input Satuan Produk -->
                    <div class="form-group row">
                      <label for="editSatuan" class="col-sm-3 col-form-label">Satuan <a class="float-right"> : </a></label>
                      <div class="col-sm-5">
                        <select class="form-control float-right" name="postSatuan" id="editSatuan">
                          <option> -- Pilih Satuan -- </option>
                          <?php foreach ($optSatuan as $showSatuan): ?>
                            <option value="<?php echo $showSatuan['satuan_id'] ?>" <?php echo ($detailPrd[0]['prd_satuan_id_fk'] === $showSatuan['satuan_id'])? 'selected="selected"' : '' ?>> 
                            	<?php echo $showSatuan['satuan_nama'] ?> 
                            </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                  <!-- Form-part input Isi -->
                    <div class="form-group row">
                      <label for="editIsi" class="col-sm-3 col-form-label">Isi tiap satuan <a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <input type="number" class="form-control float-right" name="postIsi" id="editIsi" value="<?php echo $detailPrd[0]['prd_isi_per_satuan'] ?>" placeholder="Isi Produk tiap satuan" required>
                      </div>
                    </div>

                  <!-- Form-part input Deskripsi Produk -->
                    <div class="form-group row">
                      <label for="editDeskripsiBrg" class="col-sm-3 col-form-label">Deskripsi <a class="float-right"> : </a></label>
                      <div class="col-sm-3">
                        <textarea class="form-control" name="postDeskripsiBrg" id="editDeskripsiBrg" placeholder="Deskripsi Produk (optional)"><?php echo $detailPrd[0]['prd_nama'] ?></textarea>
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