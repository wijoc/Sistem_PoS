    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark text-uppercase">Stok Produk</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('Page_c') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo site_url('Product_c') ?>"><i class="fas fa-cubes"></i> Produk</a></li>
              <li class="breadcrumb-item active">Stok Produk</li>
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
            <div class="card card-primary card-outline">
              <div class="card-header">
                <div class="float-right">
                  <a class="btn btn-sm btn-info text-white" data-toggle="tooltip" data-placement="top" title="Tambah produk baru" href="<?php echo site_url('Product_c/addProductPage/') ?>">
                    <i class="fas fa-plus"></i>
                  </a>
                  <a class="btn btn-sm btn-secondary" data-toggle="tooltip" data-placement="top" title="Mutasi Stok produk" href="<?php echo site_url('Product_c/stockMutationProductPage/') ?>"> 
                    <i class="fas fa-cubes"></i>
                  </a>
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                    <table id="table-stock-product" class="table table-bordered table-striped">
                      <thead>
                      	<tr class="text-center">
	                        <th rowspan="2" class=" align-middle">Kode Product</th>
	                        <th rowspan="2" class=" align-middle">Nama Produk</th>
	                        <th colspan="2">Stock Bagus</th>
	                        <th colspan="2">Stock Rusak</th>
	                        <th colspan="2">Stock Opname</th>
	                        <th rowspan="2" class=" align-middle">Aksi</th>
                      	</tr>
                      	<tr class="text-center">
	                        <td>Awal</td>
	                        <td>Sekarang</td>
	                        <td>Awal</td>
	                        <td>Sekarang</td>
	                        <td>Awal</td>
	                        <td>Sekarang</td>
                    	</tr>
                      </thead>
                      <tbody>
                      </tbody>
                      <tfoot class="text-center">
                        <th>Barcode</th>
                        <th>Nama Produk</th>
                        <th colspan="2">Good</th>
                        <th colspan="2">Damaged</th>
                        <th colspan="2">Opname</th>
                        <th>Aksi</th>
                      </tfoot>
                    </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

      <!-- Modal Stock Mutation -->
      <div class="modal fade" id="modal-stock-mutation">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header card-warning card-outline">
              <h4 class="card-title">Detail Produk <b><span id="header-name"></span></b> -- Kode Produk : <b><span id="header-code"></span></b></h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-6 col-md-12">
                  <div class="card card-info card-outline">
                    <div class="card-header">
                      <h4 class="card-title">Stok saat ini : </h4>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-bordered" id="stock-table">
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
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="card card-success card-outline">
                    <div class="card-header">
                      <h4 class="card-title">Mutasi Stock : </h4>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-bordered" id="mutation-table">
                          <thead>
                            <tr class="text-center">
                                <td>Tgl</td>
                                <td>Asal</td>
                                <td>Tujuan</td>
                                <td>Qty</td>
                                <td>PS</td>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-12">
                  <div class="card card-warning card-outline">
                    <div class="card-header">
                      <h4 class="card-title">Form mutasi stok</h4>
                    </div>
                    <form id="form-add-stock-mutation">
                      <div class="card-body">
                        <!-- Form-part : hidden -->
                        <input type="hidden" name="postPrdID" id="input-prd-id" value="" readonly>
                        
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
            </div>
          </div>
        </div>
      </div>