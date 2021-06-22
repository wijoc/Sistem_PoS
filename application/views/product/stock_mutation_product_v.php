    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark text-uppercase">Halaman Produk</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('Page_c') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo site_url('Product_c') ?>"><i class="fas fa-cubes"></i> Produk</a></li>
              <li class="breadcrumb-item active">Detail Produk</li>
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
          <div class="col-lg-6 col-md-12">
            <div class="card card-info card-outline">
              <div class="card-header">
                <h4 class="card-title">Stok Produk <b><?php echo $detailPrd[0]['prd_name'] ?></b> -- Barcode : <b><?php echo ($detailPrd[0]['prd_barcode'] != '')? $detailPrd[0]['prd_barcode'] : '<i class="fas fa-minus" style="color: red"></i>' ?></b></h4>
                <div class="float-right">
                  <a href="<?php echo site_url('Product_c/listProductPage') ?>" class="btn btn-xs btn-secondary"><i class="fas fa-list"></i></a>
                  <a href="<?php echo site_url('Product_c/editProductPage/').urlencode(base64_encode($detailPrd[0]['prd_id'])) ?>" class="btn btn-xs btn-warning"><i class="fas fa-edit"></i></a>
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr class="text-center">
                          <th colspan="2">Bagus</th>
                          <th colspan="2">Rusak</th>
                          <th colspan="2">Opname</th>
                      </tr>
                      <tr class="text-center">
                          <td>Awal</td>
                          <td>Saat Ini</td>
                          <td>Awal</td>
                          <td>Saat Ini</td>
                          <td>Awal</td>
                          <td>Saat Ini</td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                          <td class="text-center"><?php echo $detailPrd[0]['prd_initial_g_stock'] ?></td>
                          <td class="text-center"><?php echo $detailPrd[0]['stk_good'] ?></td>
                          <td class="text-center"><?php echo $detailPrd[0]['prd_initial_ng_stock'] ?></td>
                          <td class="text-center"><?php echo $detailPrd[0]['stk_not_good'] ?></td>
                          <td class="text-center"><?php echo $detailPrd[0]['prd_initial_op_stock'] ?></td>
                          <td class="text-center"><?php echo $detailPrd[0]['stk_opname'] ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-12">
            <div class="card card-danger card-outline">
              <div class="card-header">
                <h4 class="card-title">Form mutasi stok</h4>
              </div>
              <form id="form-stock-mutation" action="<?php echo site_url('Product_c/stockMutationProses/') ?>">
                <div class="card-body">
                  <!-- Form-part : hidden -->
                  <input type="hidden" name="postPrdID" value="<?php echo urlencode(base64_encode($detailPrd[0]['prd_id'])) ?>" readonly>
                  
                  <!-- Form-part : Tgl Mutasi -->
                  <div class="form-group row">
                    <label for="input-stock-date" class="col-sm-3 col-form-label">Tgl Mutasi <font class="text-red">*</font></label>
                    <div class="col-sm-9">
                      <input type="date" class="form-control" name="postStockDate" id="input-stock-date" required>
                      <small id="error-stock-date" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                    </div>
                  </div>

                  <!-- Form-part : Asal stok -->
                  <div class="form-group row">
                    <label for="input-stock-from" class="col-sm-3 col-form-label">Dari <font class="text-red">*</font></label>
                    <div class="col-sm-9">
                      <select class="form-control input-is-periode" name="postStockA" id="input-stock-from" required>
                        <option value="">Pilih Asal Mutasi Stok</option>
                        <option value="SG">Stok Bagus</option>
                        <option value="SNG">Stok Rusak</option>
                        <option value="SO">Stok Opname</option>
                      </select>
                      <small id="error-stock-from" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                    </div>
                  </div>

                  <!-- Form-part : Tujuan mutasi stok -->
                  <div class="form-group row">
                    <label for="input-stock-to" class="col-sm-3 col-form-label">Tujuan <font class="text-red">*</font></label>
                    <div class="col-sm-9">
                      <select class="form-control input-is-periode" name="postStockB" id="input-stock-to" required>
                        <option value="">Pilih Tujuan Mutasi Stok</option>
                        <option value="SG">Stok Bagus</option>
                        <option value="SNG">Stok Rusak</option>
                        <option value="SO">Stok Opname</option>
                      </select>
                      <small id="error-stock-to" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                    </div>
                  </div>

                  <!-- Form-part : Jumlah -->
                  <div class="form-group row">
                    <label for="input-stock-qty" class="col-sm-3 col-form-label">Jumlah <font class="text-red">*</font></label>
                    <div class="col-sm-9">
                      <input type="number" min="0" class="form-control" name="postStockQty" id="input-stock-qty" placeholder="Jumlah mutasi"/>
                      <small id="error-stock-qty" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                    </div>
                  </div>

                  <!-- Form-part : Catatan -->
                  <div class="form-group row">
                    <label for="input-stock-ps" class="col-sm-3 col-form-label">Catatan mutasi</label>
                    <div class="col-sm-9">
                      <textarea class="form-control" name="postStockPS" id="input-stock-ps" cols="30" rows="5"></textarea>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="float-right">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-info">Simpan</button>
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