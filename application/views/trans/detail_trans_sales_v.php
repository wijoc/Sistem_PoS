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
              <li class="breadcrumb-item active">Detail Penjualan</li>
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
          <div class="col-lg-10">
            <div class="card card-orange card-outline">
              <div class="card-header">
                <h5 class="m-0">Detail Transaksi Penjualan</h5>
              </div>
              <div class="card-body">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Nomor Transaksi<a class="float-right"> : </a></label>
                  <div class="col-sm-8">
                    <p class="col-form-label"><?php echo $detailTrans[0]['ts_trans_code'] ?></p>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Tanggal Transaksi<a class="float-right"> : </a></label>
                  <div class="col-sm-8">
                    <p class="col-form-label"><?php echo date('d F Y', strtotime($detailTrans[0]['ts_date'])) ?></p>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Produk<a class="float-right"> : </a></label>
                  <div class="col-sm-8">
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <thead>
                          <th>No.</th>
                          <th>Product</th>
                          <th>Jumlah</th>
                          <th>Harga satuan</th>
                          <th>Total</th>
                        </thead>
                        <tbody>
                          <?php 
                          $no = 1;
                          $totalBayar = 0; 
                          foreach ($detailTrans as $row): 
                            $totalBayar += $row['dts_total_price'];
                          ?>
                          <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $row['prd_name']; ?></td>
                            <td><?php echo $row['dts_product_amount'] ?></td>
                            <td class="text-right"><?php echo number_format($row['dts_sale_price']) ?></td>
                            <td class="text-right"><?php echo number_format($row['dts_total_price']) ?></td>
                          </tr>
                        <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                          <th colspan="4" class="text-right">Total : </th>
                          <th class="text-right"><?php echo number_format($totalBayar) ?></th>
                        </tfoot>
                      </table>
                    </div>    
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Pembeli<a class="float-right"> : </a></label>
                  <div class="col-sm-8">
                    <p class="col-form-label"><?php echo ($detailTrans[0]['ts_member_fk'] == 0)? 'General Customer / Pelanggan Umum' : $detailTrans[0]['member_name'] ?></p>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Metode Pembayaran<a class="float-right"> : </a></label>
                  <div class="col-sm-8">
                    <p class="col-form-label"><?php echo ($detailTrans[0]['ts_payment_metode'] == 'TN')? 'Tunai' : 'Bank Transfer' ?> </p>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Status<a class="float-right"> : </a></label>
                  <div class="col-sm-8">
                    <p class="col-form-label">
                      <?php 
                        if($detailTrans[0]['ts_status'] == 'T'){
                          echo '<font color="green"> Pembayaran Tunai - Lunas </font>';
                        } else if ($detailTrans[0]['ts_status'] == 'K') {
                          echo '<font color="red"> Pembayaran Kredit - Belum Lunas </font>';
                        } else if ($detailTrans[0]['ts_status'] == 'L'){
                          echo '<font color="red"> Pembayaran Kredit - Lunas </font>';
                        }
                      ?> 
                    </p>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Tenor<a class="float-right"> : </a></label>
                  <div class="col-sm-8">
                    <p class="col-form-label">
                      <?php if ($detailTrans[0]['ts_status'] == 'T'){
                        echo '-';
                      } else {
                        echo '<b>'.$detailTrans[0]['ts_tenor'].'x </b> dengan periode ';
                        if ($detailTrans[0]['ts_tenor_periode'] == 'D'){
                          echo '<b>Harian</b>';
                        } else if ($detailTrans[0]['ts_tenor_periode'] == 'W'){
                          echo '<b>Mingguan</b>';
                        } else if ($detailTrans[0]['ts_tenor_periode'] == 'M'){
                          echo '<b>Bulanan</b>';
                        } else if ($detailTrans[0]['ts_tenor_periode'] == 'Y'){
                          echo '<b>Tahunan</b>';
                        }
                      }
                      ?> 
                    </p>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Angsuran<a class="float-right"> : </a></label>
                  <div class="col-sm-8">
                    <p class="col-form-label"><?php echo ($detailTrans[0]['ts_status'] == 'T')? '-' : $detailTrans[0]['ts_installment'] ?> </p>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Total Penjualan<a class="float-right"> : </a></label>
                  <div class="col-sm-8">
                    <p class="col-form-label"><?php echo 'Rp. '.number_format($detailTrans[0]['ts_sales_price']) ?> </p>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Total dibayar<a class="float-right"> : </a></label>
                  <div class="col-sm-8">
                    <p class="col-form-label"><?php echo 'Rp. '.number_format($detailTrans[0]['ts_paid']) ?> </p>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Total Kurangan<a class="float-right"> : </a></label>
                  <div class="col-sm-8">
                    <p class="col-form-label"><?php echo 'Rp. '.number_format($detailTrans[0]['ts_insufficient']) ?> </p>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Riwayat angsuran<a class="float-right"> : </a></label>
                  <div class="col-sm-8">
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <thead>
                          <tr class="text-center">
                          	<th>#</th>
                            <th>Angsuran ke -</th>
                            <th>Tempo</th>
                            <th>Tgl Bayar</th>
                            <th>Biaya</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach($detailPayment as $row): ?>
                          <tr>
                          	<td>
                          		<?php echo ($row['is_status'] == 0)? '<i class="fas fa-times" style="color:red;"></i>' : '<i class="fas fa-check" style="color:green;"></i>' ?>
                          	</td>
                            <td class="text-center">
                              <?php 
                                echo $row['is_periode'];  
                              ?>    
                            </td>
                            <td><?php echo date('d-m-Y', strtotime($row['is_due_date'])) ?></td>
                            <td><?php echo ($row['is_payment_date'])? $row['is_payment_date'] : '-' ?></td>
                            <td><?php echo 'Rp '.number_format($row['is_payment_date']) ?></td>
                          </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->