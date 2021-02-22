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
            <div class="card card-orange card-outline">
              <div class="card-header">
                <h5 class="m-0 card-title">Daftar Produk <?php echo (!empty($dataKtgr))? 'dalam kategori <b>'.$dataKtgr[0]['ctgr_name'].'</b>' : '' ?></h5>
                <a class="btn btn-sm btn-success float-right" href="<?php echo site_url('Product_c/addProductPage') ?>"> <i class="fas fa-plus"></i> Tambah Produk</a>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                    <table id="table-product" class="table-server table table-bordered table-striped">
                      <thead>
                        <th>No.</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Satuan</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                      </thead>
                      <tbody>
                      </tbody>
                      <tfoot>
                        <th>No.</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Satuan</th>
                        <th>Stok</th>
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