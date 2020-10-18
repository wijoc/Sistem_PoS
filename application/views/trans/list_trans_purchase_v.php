    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Halaman Transaksi Pembelian</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('Page_c') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo site_url('Transaksi_c') ?>"><i class="fas fa-cubes"></i> Transaksi</a></li>
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
            <div class="card card-orange card-outline">
              <div class="card-header">
                <h5 class="m-0 card-title">Daftar Transaksi Pembelian</h5>
                <a class="btn btn-sm btn-success float-right" href="<?php echo site_url('Transaksi_c/addPurchasePage') ?>"> <i class="fas fa-plus"></i> Tambah Transaksi</a>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                    <table id="table-barang" class="table table-bordered table-striped">
                      <thead>
                        <th>No.</th>
                        <th>No. Transaksi</th>
                        <th>Tanggal</th>
                        <th>Supplier</th>
                        <th>Total Bayar</th>
                        <th>Kurangan</th>
                        <th>Status</th>
                        <th>Jatuh Tempo</th>
                        <th>Aksi</th>
                      </thead>
                      <tbody>
                        <?php $no = 1; foreach($dataTrans as $showTP): ?>
                          <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $showTP['tp_no_trans'] ?></td>
                            <td><?php echo date('d-m-Y', strtotime($showTP['tp_date'])) ?></td>
                            <td><?php echo $showTP['supp_name'] ?></td>
                            <td><?php echo $showTP['tp_purchase_price'] ?></td>
                            <td><?php echo $showTP['tp_insufficient'] ?></td>
                            <td><?php echo ($showTP['tp_status'] === 'L')? 'Lunas' : 'Belum Lunas' ?></td>
                            <td><?php echo ($showTP['tp_status'] === 'L')? '-' : date('d-m-Y', strtotime($showTP['tp_due_date']));?></td>
                            <td class="text-center">
                              <a href="" class="btn btn-xs btn-info"><i class="fas fa-search"></i></a>
                              <a href="" class="btn btn-xs btn-warning"><i class="fas fa-edit"></i></a>
                              <a href="" class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></a>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                      <tfoot>
                        <th>No.</th>
                        <th>No. Transaksi</th>
                        <th>Tanggal</th>
                        <th>Supplier</th>
                        <th>Total Bayar</th>
                        <th>Kurangan</th>
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