    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Halaman Transaksi Penjualan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('Page_c') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo site_url('Transaksi_c') ?>"><i class="fas fa-cubes"></i> Transaksi</a></li>
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
                <a class="btn btn-sm btn-success float-right" href="<?php echo site_url('Transaksi_c/addSalesPage') ?>"> <i class="fas fa-plus"></i> Tambah Transaksi</a>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                    <table id="table-trans" class="table table-bordered table-striped">
                      <thead>
                        <th>No.</th>
                        <th>No. Transaksi</th>
                        <th>Tanggal</th>
                        <th>Customer</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                        <th>Jatuh Tempo</th>
                        <th>Aksi</th>
                      </thead>
                      <tbody>
                        <?php $no = 1; foreach($dataTrans as $showTS): ?>
                          <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $showTS['ts_trans_code'] ?></td>
                            <td><?php echo date('d-m-Y', strtotime($showTS['ts_date'])) ?></td>
                            <td><?php echo $showTS['member_name'] ?></td>
                            <td><?php echo $showTS['ts_sales_price'] ?></td>
                            <td>
                              <?php 
                                if ($showTS['ts_status'] === 'K'){
                                  echo 'Kredit - Belum Lunas';
                                } else if ($showTS['ts_status'] === 'T'){
                                  echo 'Tunai';
                                } else if ($showTS['ts_status'] === 'L'){
                                  echo 'Kredit - Lunas';
                                }
                              ?>
                            </td>
                            <td><?php echo ($showTS['ts_status'] === 'T')? '-' : date('d-m-Y', strtotime($showTS['ts_due_date']));?></td>
                            <td class="text-center">
                              <a class="btn btn-xs btn-info" href="<?php echo site_url('Transaksi_c/detailSalesPage').'/'.urlencode(base64_encode($showTS['ts_id'])) ?>"><i class="fas fa-search"></i></a>
                              <a class="btn btn-xs btn-warning" href="<?php echo site_url('Transaksi_c/paySalesInstallmentPage').'/'.urlencode(base64_encode($showTS['ts_id'])) ?>"><i class="fas fa-credit-card"></i></a>
                              <a class="btn btn-xs btn-success" href=""><i class="fas fa-exchange-alt"></i></a>
                              <a class="btn btn-xs btn-primary" href="<?php echo site_url('Transaksi_c/invoicePage') ?>"><i class="fas fa-file-invoice-dollar"></i></a>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                      <tfoot>
                        <th>No.</th>
                        <th>No. Transaksi</th>
                        <th>Tanggal</th>
                        <th>Customer</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                        <th>Jatuh Tempo</th>
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