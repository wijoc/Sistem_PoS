    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark text-uppercase">Daftar Produk</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('Page_c') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo site_url('Product_c') ?>"><i class="fas fa-cubes"></i> Produk</a></li>
              <li class="breadcrumb-item active">Daftar Produk</li>
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
              <?php if( in_array($info_user->logedLevel, ['uAll', 'uO', 'uG']) == TRUE ){ ?>
              <div class="card-header">
                <h5 class="m-0 card-title"><?php echo (!empty($dataCtgr))? 'Produk dalam kategori <b class="text-uppercase">"'.$dataCtgr[0]['ctgr_name'].'"</b>' : '' ?></h5>
                <div class="float-right" role="group" aria-label="Basic example">
                  <a class="btn btn-sm btn-info" id="btn-add-prd" data-toggle="tooltip" data-placement="top" title="Tambah produk">
                    <i class="text-white fas fa-plus"></i>
                  </a>
                  <a class="btn btn-sm btn-secondary" data-toggle="tooltip" data-placement="top" title="Stok produk" href="<?php echo site_url('Product_c/productStock') ?>"> 
                    <i class="fas fa-cubes"></i>
                  </a>
                </div>
              </div>
              <?php } ?>

              <div class="card-body">
                <table id="table-product" class="table table-bordered table-striped">
                  <thead>
                    <th>Barcode</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <?php if( in_array($info_user->logedLevel, ['uAll', 'uO', 'uP']) == TRUE ){ ?> <th>Harga Beli</th> <?php } ?>
                    <?php if( in_array($info_user->logedLevel, ['uAll', 'uO', 'uK']) == TRUE ){ ?> <th>Harga Jual</th> <?php } ?>
                    <th>Satuan</th>
                    <th>Stok</th>
                    <?php if( in_array($info_user->logedLevel, ['uAll', 'uO', 'uG']) == TRUE ){ ?> <th>Aksi</th> <?php } ?>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Barcode</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <?php if( in_array($info_user->logedLevel, ['uAll', 'uO', 'uP']) == TRUE ){ ?> <th>Harga Beli</th> <?php } ?>
                    <?php if( in_array($info_user->logedLevel, ['uAll', 'uO', 'uK']) == TRUE ){ ?> <th>Harga Jual</th> <?php } ?>
                    <th>Satuan</th>
                    <th>Stok</th>
                    <?php if( in_array($info_user->logedLevel, ['uAll', 'uO', 'uG']) == TRUE ){ ?> <th>Aksi</th> <?php } ?>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->


    <?php if( in_array($info_user->logedLevel, ['uAll', 'uO', 'uG']) == TRUE ){ ?>
      <!-- Modal Product -->
      <div class="modal fade" id="modal-product">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header card-primary card-outline">
              <h4 class="modal-title"><span id="form-title">Tambah</span> Produk</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
              <form class="form-horizontal" method="POST" id="form-prd" enctype="multipart/form-data">
                <div class="modal-body">
                  <!-- Form-hidden -->
                  <input type="hidden" name="p-set-method" id="set-method" value="_POST" required readonly>
                  <input type="hidden" name="postID" id="edit-prd-id" required="" disabled="disabled" readonly>
                    
                  <h4>Informasi Produk</h4>
                  <hr>
                  <div class="col-12 ml-1 mb-3 row">
                    <!-- Form-part input Nama Produk -->
                      <div class="col-md-5">
                        <div class="form-group">
                          <label>Nama Product <font color="red"><small>*</small></font></label>
                          <input type="text" class="form-control" name="postName" id="input-prd-name" placeholder="Nama Produk" required>
                          <small id="error-prd-name" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                        </div>
                      </div>

                    <!-- Form-part input Kode Produk -->
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Code Product</label>
                          <input type="text" class="form-control" name="postCode" id="input-prd-code" placeholder="Barcode akan terisi otomatis jika kosong">
                          <small id="error-prd-code" class="error-msg" style="display:none; color:red; font-style: italic; text-decoration:underline;"></small>
                          <small id="warning-code" style="color:red; font-style: italic">Akan terisi otomatis jika product tidak memiliki kode</small>
                        </div>
                      </div>

                    <!-- Form-part input Kategori Produk -->
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Kategori <font color="red"><small>*</small></font></label>
                          <select class="form-control" name="postCategory" id="input-prd-category" required>
                            <option value=""> -- Pilih Kategori -- </option>
                            <?php foreach ($optCtgr as $showCtgr): ?>
                              <option value="<?php echo urlencode(base64_encode($showCtgr['ctgr_id'])) ?>"> <?php echo $showCtgr['ctgr_name'] ?> </option>
                            <?php endforeach; ?>
                          </select>
                          <small id="error-prd-category" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                        </div>
                      </div>

                    <!-- Form-part input Harga Beli -->
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Harga Beli <font color="red"><small>*</small></font></label>
                          <input type="number" class="form-control" step="0.01" name="postPPrice" id="input-prd-p-price" placeholder="Harga Beli Produk" required>
                          <small id="error-prd-p-price" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                        </div>
                      </div>

                    <!-- Form-part input Harga Jual -->
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Harga Jual <font color="red"><small>*</small></font></label>
                          <div class="row">
                              <div class="col-11">
                                <input type="number" class="form-control" step="0.01" name="postSPrice" id="input-prd-s-price" placeholder="Harga Jual Produk" required>
                              </div>
                              <div class="col-1"><h3><b>/</b></h3></div>
                          </div>
                          <small id="error-prd-s-price" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                        </div>
                      </div>

                    <!-- Form-part input Satuan -->
                      <div class="col-lg-2 col-md-4">
                        <div class="form-group">
                          <label>Satuan <font color="red"><small>*</small></font></label>
                          <select class="form-control" name="postUnit" id="input-prd-unit" required>
                            <option value=""> -- Pilih Satuan -- </option>
                            <?php foreach ($optUnit as $showUnit): ?>
                              <option value="<?php echo urlencode(base64_encode($showUnit['unit_id'])) ?>"> <?php echo $showUnit['unit_name'] ?> </option>
                            <?php endforeach; ?>
                          </select>
                          <small id="error-prd-unit" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                        </div>
                      </div>

                    <!-- Form-part input Isi per statuan -->
                      <div class="col-lg-2 col-md-4">
                        <div class="form-group">
                          <label>Isi per satuan <font color="red"><small>*</small></font></label>
                          <input type="number" class="form-control" name="postContains" id="input-prd-contains" placeholder="Isi tiap satuan" required>
                          <small id="error-prd-contains" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                        </div>
                      </div>

                    <!-- Form-part gambar product old -->
                      <div class="col-lg-6 col-sm-12" id="div-old-img" style="display: none;">
                        <div class="row">
                          <label class="col-12">Gambar saat ini</label>
                          <span class="col-12 text-center">
                            <img class="img-fluid" style="max-height: 250px;" id="old-prd-img" src="" alt="">
                          </span>
                        </div>
                      </div>

                    <!-- Form-part input gambar product -->
                      <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                          <label>Gambar <small class="help" style="color: red; font-style: italic;">( potrait / square, maksimal 2MB )</small></label>
                          <input type="file" class="dropify" name="postImg" id="input-prd-img" data-allowed-formats="portrait square" data-max-file-size="2M" data-max-height="2000" />
                          <small id="error-prd-img" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                        </div>
                      </div>
                      
                    <!-- Form-part input deskripsi -->
                      <div class="col-lg-6 col-sm-12" id="div-prd-desc">
                        <div class="form-group">
                          <label>Deskripsi</label>
                          <textarea class="form-control" name="postDesc" id="input-prd-desc" rows="8"></textarea>
                        </div>
                      </div>
                  </div>
                    
                  <h4 id="stock-title">Stok Awal Produk</h4>
                  <hr>
                  <div class="col-12 ml-1 row" id="stock-form">
                    <!-- Form-part input Stok Awal -->
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Stok awal <font color="red"><small>*</small></font></label>
                          <input type="number" class="form-control stock-form-input" name="postStockG" id="input-stock-g" placeholder="Stok awal produk" required>
                          <small id="error-stock-g" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                        </div>
                      </div>

                    <!-- Form-part input Stok Awal -->
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Stok rusak <font color="red"><small>*</small></font></label>
                          <input type="number" class="form-control stock-form-input" name="postStockNG" id="input-stock-ng" placeholder="Stok awal produk rusak / damaged " required>
                          <small id="error-stock-ng" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                        </div>
                      </div>

                    <!-- Form-part input Stok Awal -->
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Stok Opname <font color="red"><small>*</small></font></label>
                          <input type="number" class="form-control stock-form-input" name="postStockOP" id="input-stock-op" placeholder="Stok awal opname" required>
                          <small id="error-stock-op" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                        </div>
                      </div>
                  </div>

                </div>
                <div class="modal-footer justify-content-between">
                  <button type="reset" class="btn btn-secondary"><b> Reset </b></button>
                  <button type="submit" class="btn btn-success" id="add-submit-button"><b> Simpan </b></button>
                </div>
              </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      <!-- Modal Detail Product -->
      <div class="modal fade" id="modal-detail-product">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header card-info card-outline">
              <h4 class="card-title">Detail Produk <b><span id="header-name"></span></b> -- Kode Produk : <b><span id="header-code"></span></b></h4>
            </div>
            <div class="modal-body row">
              <div class="col-lg-4 col-sm-12 border-right">
                <div class="form-group row">
                  <h5 class="col-lg-4 col-sm-11 col-form-label">Nama Produk<a class="float-right"> : </a></h5>
                  <div class="col-lg-7 col-sm-11">
                    <p class="col-form-label font-weight-bold" id="det-prd-name"></p>
                  </div>
                </div>
                <div class="form-group row">
                  <h5 class="col-lg-4 col-sm-11 col-form-label">Kategori<a class="float-right"> : </a></h5>
                  <div class="col-lg-7 col-sm-11">
                    <p class="col-form-label font-weight-bold" id="det-prd-category"></p>
                  </div>
                </div>
                <div class="form-group row">
                  <h5 class="col-lg-4 col-sm-11 col-form-label">Isi / Satuan<a class="float-right"> : </a></h5>
                  <div class="col-lg-7 col-sm-11">
                    <p class="col-form-label font-weight-bold" id="det-prd-upc"> pcs / </p>
                  </div>
                </div>
                <div class="form-group row">
                  <h5 class="col-lg-4 col-sm-11 col-form-label">Harga beli<a class="float-right"> : </a></h5>
                  <div class="col-lg-7 col-sm-11">
                    <p class="col-form-label font-weight-bold"><font color="red" id="det-prd-p-price"></font></p>
                  </div>
                </div>
                <div class="form-group row">
                  <h5 class="col-lg-4 col-sm-11 col-form-label">Harga jual<a class="float-right"> : </a></h5>
                  <div class="col-lg-7 col-sm-11">
                    <p class="col-form-label font-weight-bold"><font color="green" id="det-prd-s-price"></font></p>
                  </div>
                </div>
                <div class="form-group row">
                  <h5 class="col-lg-4 col-sm-11 col-form-label">Gambar Produk<a class="float-right"> : </a></h5>
                  <div class="col-lg-7 col-sm-11">
                    <img width="150" height="auto" class="img-fluid" id="det-prd-img" src="" alt="">
                  </div>
                </div>
              </div>
              <div class="col-lg-8 col-sm-12">
                <div class="col-12">
                  <div class="form-group row">
                    <h5 class="col-lg-4 col-md-4 col-sm-12 col-form-label">Deskripsi<a class="float-right"> : </a></h5>
                    <div class="col-lg-8 col-md-12 border">
                      <p class="col-form-label font-weight-bold" id="det-prd-desc"></p>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                  <h5 class="col-md-4 col-sm-12 col-form-label font-weight-bold">Stok<a class="float-right"> : </a></h5>
                    <div class="table-responsive">
                      <table class="table table-bordered" id="det-stock-table">
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
                <div class="col-12">
                  <div class="form-group">
                  <h5 class="col-md-4 col-sm-12 col-form-label font-weight-bold">Mutasi<a class="float-right"> : </a></h5>
                    <div class="table-responsive">
                      <table class="table table-bordered" id="det-mutation-table">
                        <thead>
                          <tr>
                            <th>Tgl</th>
                            <th class="text-center">Asal</th>
                            <th class="text-center">Tujuan</th>
                            <th class="text-center">Qty Mutasi</th>
                            <th>PS</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>