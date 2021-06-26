    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark text-uppercase">Angsuran Transaksi Penjualan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('Page_c') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo site_url('Transaction_c') ?>"><i class="fas fa-cubes"></i> Transaksi</a></li>
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
          <div class="col-lg-6">
            <div class="card card-info card-outline">
              <div class="card-header">
                <h5 class="m-0 card-title"><b class="text-uppercase">Detail Angsuran</b> <small><i class="fa fa-minus"></i></small> Nota : <b><?php echo $detailTrans[0]['ts_trans_code'] ?></b></h5>
                <div class="float-right">
                  <a class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Detail Transaksi Pembelian" href="<?php echo site_url('Transaction_c/detailSalesPage/'.urlencode(base64_encode($detailTrans[0]['ts_id'])).'/') ?>"><i class="fas fa-search"></i></a>
                  <a class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Daftar Transaksi Pembelian" href="<?php echo site_url('Transaction_c/listSalesPage/') ?>"><i class="fas fa-list"></i></a>
                </div>
              </div>
              <div class="card-body row">
                <div class="col-12 border-bottom border-solid">
                  <div class="form-group row">
                    <h6 class="col-sm-4">Tanggal Transaksi<a class="float-right"> : </a></h6>
                    <div class="col-sm-8">
                      <h6 class="font-weight-bold"><?php echo date('d-m-Y', strtotime($detailTrans[0]['ts_date'])) ?></h6>
                    </div>
                  </div>
                  <div class="form-group row">
                    <h6 class="col-sm-4">Pelanggan<a class="float-right"> : </a></h6>
                    <div class="col-sm-8">
                      <h6 class="font-weight-bold"><?php echo $detailTrans[0]['ctm_name'] ?></h6>
                    </div>
                  </div>
                  <div class="form-group row">
                    <h6 class="col-sm-4">Total Transaksi<a class="float-right"> : </a></h6>
                    <div class="col-sm-8">
                      <h6 class="font-weight-bold"><?php echo 'Rp '.number_format($detailTrans[0]['ts_total_sales'], 2) ?></h6>
                    </div>
                  </div>
                  <div class="form-group row">
                    <h6 class="col-sm-4">Status Pembayaran<a class="float-right"> : </a></h6>
                    <div class="col-sm-8">
                      <h6 class="font-weight-bold" style="color: green">
                        <?php 
                          if ($detailTrans[0]['ts_payment_status'] == 'K') {
                            echo '<span class="badge badge-danger">Kredit - Belum Lunas</span>';
                          } else if ($detailTrans[0]['ts_payment_status'] == 'L') {
                            echo '<span class="badge badge-success">Kredit - Lunas</span>';
                          } else if ($detailTrans[0]['ts_payment_status'] == 'T') {
                            echo '<span class="badge badge-success">Tunai - Lunas</span>';
                          } 
                          ?>
                      </h6>
                    </div>
                  </div>
                  <div class="form-group row">
                    <h6 class="col-sm-4">Tenor<a class="float-right"> : </a></h6>
                    <div class="col-sm-8">
                      <h6>
                      <?php 
                        echo '<b>'.$detailTrans[0]['ts_tenor'].'</b>&nbsp<small><i class="fa fa-times"></i></small>' ?>
                        , dengan periode 
                        <b>
                        <?php
                          if ($detailTrans[0]['ts_tenor_periode'] == 'D'){
                            echo '<b>Harian</b>';
                          } else if ($detailTrans[0]['ts_tenor_periode'] == 'W'){
                            echo '<b>Mingguan</b>';
                          } else if ($detailTrans[0]['ts_tenor_periode'] == 'M'){
                            echo '<b>Bulanan</b>';
                          } else if ($detailTrans[0]['ts_tenor_periode'] == 'Y'){
                            echo '<b>Tahunan</b>';
                          } 
                        ?>
                        </b>
                      </h6>
                    </div>
                  </div>
                  <div class="form-group row">
                    <h6 class="col-sm-4">Angsuran<a class="float-right"> : </a></h6>
                    <div class="col-sm-8">
                      <h6 class="font-weight-bold"> <?php echo 'Rp '.number_format($detailTrans[0]['ts_installment'], 2) ?>
                      </h6>
                    </div>
                  </div>
                  <div class="form-group row">
                    <h6 class="col-sm-4">Jatuh Tempo<a class="float-right"> : </a></h6>
                    <div class="col-sm-8">
                      <h6 class="font-weight-bold"><font class="font-weight-bold" color="red"><?php echo date('d-m-Y', strtotime($detailTrans[0]['ts_due_date'])) ?></font>
                      </h6>
                    </div>
                  </div>
                </div>
                <div class="col-12 mt-2">
                  <div class="form-group">
                    <label>Riwayat Angsuran</label>
                    <div class="table-responsive">
                      <table class="table table-bordered" id="table-installment">
                        <thead class="text-center">
                          <tr>
                            <th>Periode</th>
                            <th>Tempo</th>
                            <th>No. Bayar</th>
                            <th>Bayar</th>
                            <th>Tgl bayar</th>
                            <th>PS</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0 card-title"><b class="text-uppercase">Form Angsuran</b> <small><i class="fa fa-minus"></i></small> Nota : <b><?php echo $detailTrans[0]['ts_trans_code'] ?></b></h5>
              </div>
              <form action="<?php echo site_url('Transaction_c/installmentSalesProses').'/'.urlencode(base64_encode($detailTrans[0]['ts_id'])) ?>" method="POST" enctype="multipart/form-data" id="form-installment-sales">
                <div class="card-body row">
                  <!-- Form-part input tanggal transaksi -->
                  <div class="col-sm-6 col-xs-12">
                    <div class="form-group">
                      <label>Tgl Pembayaran</label>
                      <input type="date" class="form-control" name="postISDate" id="input-is-date" required>
                      <small id="error-is-date" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                    </div>
                  </div>

                  <!-- Form-part input Angsuran ke- -->
                  <div class="col-sm-6 col-xs-12">
                    <div class="form-group">
                      <label>Angsuran ke- </label>
                      <div class="input-group sm-3">
                        <input type="number" class="form-control input-is-periode" name="postISPeriodeStart" value="<?php echo $minLimitI; ?>"  required="required" readonly>
                        <div class="input-group-append">
                          <span class="input-group-text"><i class="fa fa-minus"></i></span>
                        </div>
                        <select class="form-control input-is-periode" name="postISPeriodeEnd" id="input-is-periode-end">
                          <?php for($angsuran = $minLimitI ; $angsuran <= $detailTrans[0]['ts_tenor']; $angsuran++){ ?>
                            <option value="<?php echo $angsuran ?>"><?php echo $angsuran ?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <small class="font-italic" style="color:red">* kosongkan kolom kanan untuk bayar 1 periode</small>
                      <small id="error-is-periode" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      <small id="error-is-periodeb" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                    </div>
                  </div>

                  <!-- Form-part input Pembayaran -->
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label>Angsuran dibayarkan</label>
                      <input type="number" class="form-control float-right" step="0.01" name="postISInstallment" id="input-is-installment" placeholder="Angsuran dibayarkan...." required>
                      <small id="error-is-installment" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                    </div>
                  </div>

                  <!-- Form-part input PS -->
                  <div class="col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <label>Catatan tambahan <font class="text-lowercase font-italic" color="red"><small>(optional)</small></font></label>
                      <textarea class="form-control" cols="30" rows="5" name="postISPS"></textarea>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <button type="reset" class="btn btn-danger">Reset</button>
                  <button type="submit" class="btn btn-primary float-right">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    <?php print("<pre>".print_r($minLimitI, true)."</pre>") ?>