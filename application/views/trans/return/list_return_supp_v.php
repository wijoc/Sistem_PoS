    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark text-uppercase">Transaksi Retur Pembelian</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('Page_c') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo site_url('Transaction_c') ?>"><i class="fas fa-cubes"></i> Transaksi</a></li>
              <li class="breadcrumb-item active">Retur Pembelian</li>
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
              <div class="card-header">
                <div class="btn-group float-right" role="group" aria-label="Basic example">
                  <a class="btn btn-sm btn-info text-white" data-toggle="tooltip" data-placement="top" title="Daftar Transaksi Penjualan" href="<?php echo site_url('Transaction_c/listSalesPage/') ?>"> 
                    <i class="fas fa-list"></i>
                  </a>
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                    <table id="table-transaction" class="table table-bordered table-striped">
                      <thead>
                        <tr class="text-center">
                          <th rowspan="2" class="align-center">Tgl</th>
                          <th rowspan="2" class="align-center">Trans.</th>
                          <th rowspan="2" class="align-center">Status</th>
                          <th rowspan="2" class="align-center">Supplier</th>
                          <th colspan="2" class="align-center">Biaya</th>
                          <th rowspan="2" class="align-center">Catatan</th>
                          <th rowspan="2" class="align-center">Aksi</th>
                        </tr>
                        <tr>
                          <th class="text-center">Keluar</th>
                          <th class="text-center">Dana Masuk</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                      <tfoot class="text-center">
                          <th>Tgl</th>
                          <th>Trans.</th>
                          <th>Status</th>
                          <th>Supplier</th>
                          <th>Keluar</th>
                          <th>Dana Masuk</th>
                          <th>Catatan</th>
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