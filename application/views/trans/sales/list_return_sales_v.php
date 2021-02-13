    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Halaman Transaksi Return</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('Page_c') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo site_url('Transaksi_c') ?>"><i class="fas fa-cubes"></i> Transaksi</a></li>
              <li class="breadcrumb-item active">Return</li>
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
                <h5 class="m-0 card-title">Daftar Transaksi Retrun</h5>
                <a class="btn btn-sm btn-success float-right" href="<?php echo site_url('Transaksi_c/returnSalesPage') ?>"> <i class="fas fa-plus"></i> Tambah Transaksi</a>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                    <table id="table-trans" class="table table-bordered table-striped">
                      <thead>
                        <th>No.</th>
                        <th>Kode Trans</th>
                        <th>Tanggal</th>
                        <th>Biaya</th>
                        <th>Aksi</th>
                      </thead>
                      <tbody>
                      	<?php $no = 1; foreach($dataReturn as $showRC): ?>
                      		<tr>
                      			<td><?php echo $no++ ?></td>
                      			<td><?php echo $showRC['ts_id_fk'] ?></td>
                      			<td><?php echo date('d-m-Y H:i', strtotime($showRC['rc_date'])) ?></td>
                      			<td><?php echo ($showRC['rc_paid'] != '' || $showRC['rc_paid'] > 0)? 'Rp'.number_format($showRC['rc_paid'], 2) : 'Rp0,00' ?></td>
                      			<td>
                                  <a href="<?php echo site_url('Transaksi_c/detailSalesPage/').urlencode(base64_encode($showRC['ts_id_fk'])) ?>" class="btn btn-xs btn-info"><i class="fas fa-search"></i></a>
                      			</td>
                      		</tr>
                      	<?php endforeach; ?>
                      </tbody>
                      <tfoot>
                        <th>No.</th>
                        <th>Kode Trans</th>
                        <th>Tanggal</th>
                        <th>Biaya</th>
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