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
              <li class="breadcrumb-item active">Angsuran Penjualan</li>
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
                <h5 class="m-0 card-title">Angsuran Transaksi Penjualan</h5>
                <div class="float-right">
                	<a class="btn btn-xs btn-warning" href="<?php echo site_url('Transaksi_c/listSalesPage') ?>"><i class="fas fa-list"></i></a>
                	<?php if($detailTrans[0]['ts_status'] != 'T') { ?>
                	<a class="btn btn-xs btn-info" href="<?php echo site_url('Transaksi_c/detailSalesPage').'/'.urlencode(base64_encode($detailTrans[0]['ts_id'])) ?>"><i class="fas fa-search"></i></a>
                	<?php } ?>
                </div>
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
                  <label class="col-sm-3 col-form-label">Pembeli<a class="float-right"> : </a></label>
                  <div class="col-sm-8">
                    <p class="col-form-label"><?php echo ($detailTrans[0]['ts_member_fk'] == 0)? 'General Customer / Pelanggan Umum' : $detailTrans[0]['member_name'] ?></p>
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
                  <label class="col-sm-3 col-form-label">Total Penjualan<a class="float-right"> : </a></label>
                  <div class="col-sm-8">
                    <p class="col-form-label"><?php echo 'Rp. '.number_format($detailTrans[0]['ts_sales_price']) ?> </p>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Angsuran<a class="float-right"> : </a></label>
                  <div class="col-sm-8">
                    <p class="col-form-label"><?php echo ($detailTrans[0]['ts_status'] == 'T')? '-' : 'Rp. '.number_format($detailTrans[0]['ts_installment']) ?> </p>
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
                            <td><?php echo 'Rp '.number_format($row['is_payment']) ?></td>
                          </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <?php if ($detailTrans[0]['ts_status'] == 'K'){ ?>
                <form method="POST" enctype="multipart/form-data" action="<?php echo site_url('Transaksi_c/installmentSalesProses').'/'.urlencode(base64_encode($detailTrans[0]['ts_id'])) ?>">

                  <!-- Form-part input Nomor Nota -->
                  <div class="form-group row">
                    <label for="inputPayCode" class="col-sm-3 col-form-label">Nomor Nota Pembayaran <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postPayCode" id="inputPayCode" value="<?php echo $paymentCode ?>" placeholder="Nomor nota otomatis terisi oleh sistem" readonly required>
                    </div>
                  </div>

                  <!-- Form-part angsuran -->
                  <div class="form-group row">
                    <label for="inputAngsuran" class="col-sm-3 col-form-label">Angsuran ke -<a class="float-right"> : </a></label>
                    <div class="col-sm-9 row">
                      <div class="col-sm-4">
                        <select class="form-control" name="postAngsuranAwal" id="inputAngsuranAwal">
                          <?php 
                          for($angsuran = 1; $angsuran <= $detailTrans[0]['ts_tenor']; $angsuran++){ ?>
                            <option value="<?php echo $angsuran ?>"><?php echo $angsuran ?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="col-sm-2 text-center">
                        <font><b>Sampai</b></font>
                      </div>
                      <div class="col-sm-5">
                        <select class="form-control" name="postAngsuranAkhir" id="inputAngsuranAkhir">
                          <option> -- Pilih periode angsuran --</option>
                          <?php 
                          for($angsuran = 1; $angsuran <= $detailTrans[0]['ts_tenor']; $angsuran++){ ?>
                            <option value="<?php echo $angsuran ?>"><?php echo $angsuran ?></option>
                          <?php } ?>
                        </select>
                        <small style="color:red"><em>*kosongkan jika hanya 1x periode angsuran</em></small>
                      </div>
                    </div>
                  </div>

                  <!-- Form-part Bayar -->
                  <div class="form-group row">
                    <label for="inputTglBayar" class="col-sm-3 col-form-label">Tanggal Pembayaran<a class="float-right"> : </a></label>
                    <div class="col-sm-4">
                      <input type="date" class="form-control" name="postTglBayar">
                    </div>
                  </div>

                  <!-- Form-part Bayar -->
                  <div class="form-group row">
                    <label for="inputBayar" class="col-sm-3 col-form-label">Biaya Pembayaran<a class="float-right"> : </a></label>
                    <div class="col-sm-4">
                      <input type="number" class="form-control" name="postBayar">
                    </div>
                  </div>

                  <!-- Form Submit Button -->
                  <div class="float-right">
                    <button type="reset" class="btn btn-secondary"><b> Reset </b></button>
                    <button type="submit" class="btn btn-success"><b> Simpan </b></button>
                  </div>
                </form>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->