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
            <div class="card card-info card-outline">
              <?php if( in_array($this->session->userdata('logedInLevel'), ['uAll', 'uO', 'uK']) == TRUE ){ ?>
              <div class="card-header">
                <div class="btn-group float-right" role="group" aria-label="Basic example">
                  <a class="btn btn-sm btn-info text-white" data-toggle="tooltip" data-placement="top" title="Tambah Transaksi" href="<?php echo site_url('Transaction_c/addSalesPage') ?>"> 
                    <i class="fas fa-plus"></i>
                  </a>
                </div>
              </div>
              <?php } ?>
              <div class="card-body">
                <div class="table-responsive">
                    <table id="table-transaction" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th rowspan="2" class="align-center text-center">Tgl</th>
                          <th rowspan="2" class="align-center text-center">Trans</th>
                          <th rowspan="2" class="align-center text-center">Pelanggan</th>
                          <th rowspan="2" class="align-center text-center">Total</th>
                          <th colspan="2" class="align-center text-center">Status</th>
                          <th rowspan="2" class="align-center text-center">Tempo</th>
                          <th rowspan="2" class="align-center text-center">Aksi</th>
                        </tr>
                        <tr>
                          <th>Pembayaran</th>
                          <th>Retur</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <th>Tgl</th>
                        <th>Trans</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Pembayaran</th>
                        <th>Retur</th>
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