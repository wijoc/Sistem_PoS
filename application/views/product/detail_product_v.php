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
          <div class="col-lg-10">
            <div class="card card-orange card-outline">
              <div class="card-header">
                <h5 class="m-0">Detail Produk</h5>
              </div>
              <div class="card-body">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Barcode Produk<a class="float-right"> : </a></label>
                  <div class="col-sm-8">
                    <p class="col-form-label"><?php echo ($detailPrd[0]['prd_barcode'] != '')? $detailPrd[0]['prd_barcode'] : '<font color="red"><b>Belum ada barcode !</b></font>' ?></p>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Nama Produk<a class="float-right"> : </a></label>
                  <div class="col-sm-8">
                    <p class="col-form-label"><?php echo $detailPrd[0]['prd_name'] ?></p>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Kategori<a class="float-right"> : </a></label>
                  <div class="col-sm-8">
                    <p class="col-form-label"><?php echo $detailPrd[0]['ctgr_name'] ?></p>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Harga beli<a class="float-right"> : </a></label>
                  <div class="col-sm-8">
                    <p class="col-form-label"><?php echo $detailPrd[0]['prd_purchase_price'] ?></p>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Harga jual<a class="float-right"> : </a></label>
                  <div class="col-sm-8">
                    <p class="col-form-label"><?php echo $detailPrd[0]['prd_selling_price'] ?></p>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Satuan<a class="float-right"> : </a></label>
                  <div class="col-sm-8">
                    <p class="col-form-label"><?php echo $detailPrd[0]['unit_name'] ?> </p>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Isi<a class="float-right"> : </a></label>
                  <div class="col-sm-8">
                    <p class="col-form-label"><?php echo $detailPrd[0]['prd_containts']?> pcs / <?php echo $detailPrd[0]['unit_name'] ?> </p>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Stok produk<a class="float-right"> : </a></label>
                  <div class="col-sm-8">
                    <table class="table table-bordered">
                      <thead>
                        <tr class="text-center">
                          <th colspan="2">Stock Bagus</th>
                          <th colspan="2">Stock Rusak</th>
                          <th colspan="2">Stock Return</th>
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
                        <tr>
                          <td class="text-center"><?php echo $detailPrd[0]['prd_initial_g_stock'] ?></td>
                          <td class="text-center"><?php echo $detailPrd[0]['stk_good'] ?></td>
                          <td class="text-center"><?php echo $detailPrd[0]['prd_initial_ng_stock'] ?></td>
                          <td class="text-center"><?php echo $detailPrd[0]['stk_not_good'] ?></td>
                          <td class="text-center"><?php echo $detailPrd[0]['prd_initial_return_stock'] ?></td>
                          <td class="text-center"><?php echo $detailPrd[0]['stk_return'] ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Deskripsi<a class="float-right"> : </a></label>
                  <div class="col-sm-8">
                    <p class="col-form-label"><?php echo $detailPrd[0]['prd_description']?> per <?php echo $detailPrd[0]['unit_name'] ?> </p>
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