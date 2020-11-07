    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Halaman Transaksi Pengeluaran</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('Page_c') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo site_url('Transaksi_c') ?>"><i class="fas fa-cubes"></i> Transaksi</a></li>
              <li class="breadcrumb-item active">Pengeluaran</li>
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
                <h5 class="m-0 card-title">Daftar Transaksi Pengeluaran</h5>
                <a class="btn btn-sm btn-success float-right" href="<?php echo site_url('Transaksi_c/addExpensePage') ?>"> <i class="fas fa-plus"></i> Tambah Transaksi</a>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                    <table id="table-trans" class="table table-bordered table-striped">
                      <thead>
                        <th>No.</th>
                        <th>Keperluan</th>
                        <th>Tanggal</th>
                        <th>Metode</th>
                        <th>Total Bayar</th>
                        <th>Nota</th>
                        <th>Aksi</th>
                      </thead>
                      <tbody>
                      	<?php $no = 1; foreach($dataTrans as $showTE): ?>
                      		<tr>
                      			<td><?php echo $no++ ?></td>
                      			<td><?php echo $showTE['te_necessity'] ?></td>
                      			<td><?php echo date('Y-m-d', strtotime($showTE['te_date'])) ?></td>
                      			<td><?php echo ($showTE['te_payment_method'] == 'TN')? 'Cash / Tunai' : 'Transfer' ?></td>
                      			<td><?php echo $showTE['te_payment'] ?></td>
                      			<td><?php echo ($showTE['te_invoice'] == NULL)? '<i class="fas fa-times" style="color: red"></i>' : '<i class="fas fa-check" style="color: green"</i>' ?></td>
                      			<td>
                      				<a class="btn btn-xs btn-info" href="<?php echo site_url('Transaksi_c/detailExpensePage/').urlencode(base64_encode($showTE['te_id'])) ?>"><i class="fas fa-search"></i></a>
                      				<?php if($showTE['te_invoice'] != NULL){ ?><a class="btn btn-xs btn-success" target="_blank" href="<?php echo base_url().$showTE['te_invoice'] ?>"><i class="fas fa-download"></i></a><?php } ?>
                      			</td>
                      		</tr>
                      	<?php endforeach; ?>
                      </tbody>
                      <tfoot>
                        <th>No.</th>
                        <th>Keperluan</th>
                        <th>Tanggal</th>
                        <th>Metode</th>
                        <th>Total Bayar</th>
                        <th>Nota</th>
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