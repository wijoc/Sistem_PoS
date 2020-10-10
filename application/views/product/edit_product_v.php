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
                  <!-- Div ALert -->
                  <div id="alert-product"></div>

                  <!-- Form-part hidden input ID Product -->
                  	<input type="hidden" name="postId" value="<?php echo urlencode(base64_encode($detailPrd[0]['prd_id'])) ?>">

                  <!-- Form-part input Nama Produk -->
                    <div class="form-group row">
                      <label for="editNamaPrd" class="col-sm-3 col-form-label">Nama Produk<a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control float-right" name="postNamaPrd" id="editNamaPrd" value="<?php echo $detailPrd[0]['prd_name'] ?>" placeholder="Nama Produk" required>
                      </div>
                    </div>

                  <!-- Form-part input Kategori -->
                    <div class="form-group row">
                      <label for="editKategoriPrd" class="col-sm-3 col-form-label">Kategori <a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <select class="form-control float-right" name="postKategoriPrd" id="editKategoriPrd">
                          <option> -- Pilih Kategori -- </option>
                          <?php foreach ($optCtgr as $showCtgr): ?>
                            <option value="<?php echo $showCtgr['ctgr_id'] ?>" <?php echo ($detailPrd[0]['prd_category_id_fk'] === $showCtgr['ctgr_id'])? 'selected="selected"' : '' ?>> 
                            	<?php echo $showCtgr['ctgr_name'] ?> 
                            </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                  <!-- Form-part input Harga Beli -->
                    <div class="form-group row">
                      <label for="editHargaBeli" class="col-sm-3 col-form-label">Harga Beli <a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <input type="number" class="form-control float-right" step="0.01" name="postHargaBeli" id="editHargaBeli" value="<?php echo $detailPrd[0]['prd_purchase_price'] ?>" placeholder="Harga Beli Produk" required>
                      </div>
                    </div>

                  <!-- Form-part input Harga Jual -->
                    <div class="form-group row">
                      <label for="editHargaJual" class="col-sm-3 col-form-label">Harga Jual <a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <input type="number" class="form-control float-right" step="0.01" name="postHargaJual" id="editHargaJual" value="<?php echo $detailPrd[0]['prd_selling_price'] ?>" placeholder="Harga Jual Produk" required>
                      </div>
                    </div>

                  <!-- Form-part input Satuan Produk -->
                    <div class="form-group row">
                      <label for="editSatuan" class="col-sm-3 col-form-label">Satuan <a class="float-right"> : </a></label>
                      <div class="col-sm-5">
                        <select class="form-control float-right" name="postSatuan" id="editSatuan">
                          <option> -- Pilih Satuan -- </option>
                          <?php foreach ($optUnit as $showUnit): ?>
                            <option value="<?php echo $showUnit['unit_id'] ?>" <?php echo ($detailPrd[0]['prd_unit_id_fk'] === $showUnit['unit_id'])? 'selected="selected"' : '' ?>> 
                            	<?php echo $showUnit['unit_name'] ?> 
                            </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                  <!-- Form-part input Isi -->
                    <div class="form-group row">
                      <label for="editIsi" class="col-sm-3 col-form-label">Isi tiap satuan <a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <input type="number" class="form-control float-right" name="postIsi" id="editIsi" value="<?php echo $detailPrd[0]['prd_containts'] ?>" placeholder="Isi Produk tiap satuan" required>
                      </div>
                    </div>

                  <!-- Form-part input stok awal -->
                    <div class="form-group row">
                      <label for="editStokAwal" class="col-sm-3 col-form-label">Stok awal <a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <input type="number" class="form-control float-right" name="postStokAwal" id="editStokAwal" value="<?php echo $detailPrd[0]['prd_initial_stock'] ?>" placeholder="Stok awal produk, stok akan berisi 0 jika tidak terisi">
                        <small style="color: red">* <em>mengubah stok awal tidak akan mengubah stok saat ini</em></small>
                      </div>
                    </div>

                  <!-- Form-part input Deskripsi Produk -->
                    <div class="form-group row">
                      <label for="editDeskripsiPrd" class="col-sm-3 col-form-label">Deskripsi <a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <textarea class="form-control" rows="3" name="postDeskripsiPrd" id="editDeskripsiPrd" placeholder="Deskripsi Produk (optional)"><?php echo $detailPrd[0]['prd_description'] ?></textarea>
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