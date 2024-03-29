    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark text-uppercase">Transaksi Pembelian</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('Page_c') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo site_url('Transaction_c') ?>"><i class="fas fa-cubes"></i> Transaksi</a></li>
              <li class="breadcrumb-item active">Pembelian</li>
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
                <h5 class="m-0 card-title">Daftar Transaksi Pembelian</h5>
                <a class="btn btn-sm btn-info float-right text-white" data-toggle="tooltip" data-placement="top" title="Tambah Transaksi" href="<?php echo site_url('Transaction_c/addPurchasesPage') ?>"> <i class="fas fa-plus"></i></a>
              </div>
              <div class="card-body">
                <table id="table-transaction" class="table table-bordered table-striped">
                  <thead>
                    <th></th>
                    <th>Tanggal</th>
                    <th>Nota</th>
                    <th>Supplier</th>
                    <th>Total Bayar</th>
                    <th>Status Pembayaran</th>
                    <th>Jatuh Tempo</th>
                    <th>Aksi</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th></th>
                    <th>Tanggal</th>
                    <th>Nota</th>
                    <th>Supplier</th>
                    <th>Total Bayar</th>
                    <th>Status Pembayaran</th>
                    <th>Jatuh Tempo</th>
                    <th>Aksi</th>
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