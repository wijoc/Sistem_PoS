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
          <div class="col-12">
            <div class="card card-orange card-outline">
              <div class="card-header">
                <h4 class="card-title">Detail Produk <b><?php echo $detailPrd[0]['prd_name'] ?></b> -- Barcode : <b><?php echo ($detailPrd[0]['prd_barcode'] != '')? $detailPrd[0]['prd_barcode'] : '<i class="fas fa-minus" style="color: red"></i>' ?></b></h4>
                <div class="float-right">
                  <a href="<?php echo site_url('Product_c/listProductPage') ?>" class="btn btn-xs btn-secondary"><i class="fas fa-list"></i></a>
                  <a href="<?php echo site_url('Product_c/editProductPage/').urlencode(base64_encode($detailPrd[0]['prd_id'])) ?>" class="btn btn-xs btn-warning"><i class="fas fa-edit"></i></a>
                </div>
              </div>
              <div class="card-body row">
                <div class="col-sm-6 border-right">
                  <div class="form-group row">
                    <h5 class="col-lg-4 col-sm-11 col-form-label">Nama Produk<a class="float-right"> : </a></h5>
                    <div class="col-lg-7 col-sm-11">
                      <p class="col-form-label font-weight-bold"><?php echo $detailPrd[0]['prd_name'] ?></p>
                    </div>
                  </div>
                  <div class="form-group row">
                    <h5 class="col-lg-4 col-sm-11 col-form-label">Kategori<a class="float-right"> : </a></h5>
                    <div class="col-lg-7 col-sm-11">
                      <p class="col-form-label font-weight-bold"><?php echo $detailPrd[0]['ctgr_name'] ?></p>
                    </div>
                  </div>
                  <div class="form-group row">
                    <h5 class="col-lg-4 col-sm-11 col-form-label">Isi / Satuan<a class="float-right"> : </a></h5>
                    <div class="col-lg-7 col-sm-11">
                      <p class="col-form-label font-weight-bold"><?php echo $detailPrd[0]['prd_containts']?> pcs / <?php echo $detailPrd[0]['unit_name'] ?> </p>
                    </div>
                  </div>
                  <div class="form-group row">
                    <h5 class="col-lg-4 col-sm-11 col-form-label">Harga beli<a class="float-right"> : </a></h5>
                    <div class="col-lg-7 col-sm-11">
                      <p class="col-form-label font-weight-bold"><font color="red"><?php echo 'Rp'.number_format($detailPrd[0]['prd_purchase_price'], 2) ?></font></p>
                    </div>
                  </div>
                  <div class="form-group row">
                    <h5 class="col-lg-4 col-sm-11 col-form-label">Harga jual<a class="float-right"> : </a></h5>
                    <div class="col-lg-7 col-sm-11">
                      <p class="col-form-label font-weight-bold"><font color="green"><?php echo 'Rp'.number_format($detailPrd[0]['prd_selling_price'], 2) ?></font></p>
                    </div>
                  </div>
                  <div class="form-group row">
                    <h5 class="col-lg-4 col-sm-11 col-form-label">Gambar Produk<a class="float-right"> : </a></h5>
                    <div class="col-lg-7 col-sm-11">
                      <img width="150" height="auto" class="img-fluid" src="<?php echo base_url(); echo ($detailPrd[0]['prd_image'] != '')? $detailPrd[0]['prd_image'] : 'assets/uploaded_files/product_img/no_photo.png' ?>" alt="baseurl.com/my_assets/upload/product_img/gambar_product.jpg">
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="col-12">
                    <div class="form-group">
                    <h5 class="col-md-4 col-sm-12 col-form-label">Stok<a class="float-right"> : </a></h5>
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
                              <td>Tersedia</td>
                              <td>Awal</td>
                              <td>Tersedia</td>
                              <td>Awal</td>
                              <td>Tersedia</td>
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
                  <div class="col-12">
                    <div class="form-group">
                      <h5 class="col-md-4 col-sm-12 col-form-label">Deskripsi<a class="float-right"> : </a></h5>
                      <div class="col-12 border">
                        <p class="col-form-label font-weight-bold"><?php echo $detailPrd[0]['prd_description']?> </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->