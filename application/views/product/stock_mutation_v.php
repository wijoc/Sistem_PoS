    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark text-uppercase">Daftar Mutasi</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('Page_c') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo site_url('Product_c') ?>"><i class="fas fa-cubes"></i> Produk</a></li>
              <li class="breadcrumb-item active">Daftar Mutasi</li>
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
              <div class="card-body">
                <table id="table-stock-mutation" class="table table-bordered table-striped">
                  <thead>
                    <tr class="text-center">
                        <th>Tgl</th>
                        <th>Product</th>
                        <th>Asal</th>
                        <th>Tujuan</th>
                        <th>Qty</th>
                        <th>Catatan</th>
                    </tr>
                  </thead>
                  <tbody class="text-center">
                  </tbody>
                  <tfoot>
                    <tr class="text-center">
                        <th>Tgl</th>
                        <th>Product</th>
                        <th>Asal</th>
                        <th>Tujuan</th>
                        <th>Qty</th>
                        <th>Catatan</th>
                    </tr>
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