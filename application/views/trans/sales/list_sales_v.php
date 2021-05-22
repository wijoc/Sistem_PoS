    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark text-uppercase">Transaksi Penjualan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('Page_c') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo site_url('Transaction_c') ?>"><i class="fas fa-cubes"></i> Transaksi</a></li>
              <li class="breadcrumb-item active">Penjualan</li>
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
                <h5 class="m-0 card-title">Daftar Transaksi Penjualan</h5>
                <a class="btn btn-sm btn-success float-right" href="<?php echo site_url('Transaction_c/addSalesPage') ?>"> <i class="fas fa-plus"></i> Tambah Transaksi</a>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                    <table id="table-transaction" class="table table-bordered table-striped">
                      <thead>
                        <th>Tgl</th>
                        <th>Trans</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tempo</th>
                        <th>Aksi</th>
                      </thead>
                      <tfoot>
                        <th>Tgl</th>
                        <th>Trans</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tempo</th>
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