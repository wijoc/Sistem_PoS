    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark text-uppercase">Angsuran Transaksi Pembelian</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('Page_c') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo site_url('Transaction_c') ?>"><i class="fas fa-cubes"></i> Transaksi</a></li>
              <li class="breadcrumb-item active">Pembayaran Angsuran Pembelian</li>
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
          <div class="col-12">
            <div class="card card-info card-outline">
              <div class="card-header">
                <h5 class="m-0 card-title"><b class="text-uppercase">Detail Angsuran</b> <small><i class="fa fa-minus"></i></small> Nota : <b><?php echo $detailTrans[0]['tp_note_code'] ?></b></h5>
                <div class="float-right">
                  <a class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Detail Transaksi Pembelian" href="<?php echo site_url('Transaction_c/detailPurchasesPage/'.urlencode(base64_encode($detailTrans[0]['tp_id'])).'/') ?>"><i class="fas fa-search"></i></a>
                  <a class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Daftar Transaksi Pembelian" href="<?php echo site_url('Transaction_c/listPurchasesPage/') ?>"><i class="fas fa-list"></i></a>
                </div>
              </div>
              <div class="card-body row">
                <div class="col-lg-5 border-right border-solid">
                  <div class="form-group row">
                    <h6 class="col-sm-4">Tanggal Transaksi<a class="float-right"> : </a></h6>
                    <div class="col-sm-8">
                      <h6 class="font-weight-bold"><?php echo date('d-m-Y', strtotime($detailTrans[0]['tp_date'])) ?></h6>
                    </div>
                  </div>
                  <div class="form-group row">
                    <h6 class="col-sm-4">Supplier<a class="float-right"> : </a></h6>
                    <div class="col-sm-8">
                      <h6 class="font-weight-bold"><?php echo $detailTrans[0]['supp_name'] ?></h6>
                    </div>
                  </div>
                  <div class="form-group row">
                    <h6 class="col-sm-4">Status Pembayaran<a class="float-right"> : </a></h6>
                    <div class="col-sm-8">
                      <h6 class="font-weight-bold" style="color: green">
                        <?php 
                          if ($detailTrans[0]['tp_payment_status'] == 'K') {
                            echo '<span class="badge badge-danger">Kredit - Belum Lunas</span>';
                          } else if ($detailTrans[0]['tp_payment_status'] == 'L') {
                            echo '<span class="badge badge-success">Kredit - Lunas</span>';
                          } else if ($detailTrans[0]['tp_payment_status'] == 'T') {
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
                        echo '<b>'.$detailTrans[0]['tp_tenor'].'</b>&nbsp<small><i class="fa fa-times"></i></small>' ?>
                        , dengan periode 
                        <b>
                        <?php
                          if ($detailTrans[0]['tp_tenor_periode'] == 'D'){
                            echo '<b>Harian</b>';
                          } else if ($detailTrans[0]['tp_tenor_periode'] == 'W'){
                            echo '<b>Mingguan</b>';
                          } else if ($detailTrans[0]['tp_tenor_periode'] == 'M'){
                            echo '<b>Bulanan</b>';
                          } else if ($detailTrans[0]['tp_tenor_periode'] == 'Y'){
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
                      <h6 class="font-weight-bold"> <?php echo 'Rp '.number_format($detailTrans[0]['tp_installment'], 2) ?>
                      </h6>
                    </div>
                  </div>
                  <div class="form-group row">
                    <h6 class="col-sm-4">Jatuh Tempo<a class="float-right"> : </a></h6>
                    <div class="col-sm-8">
                      <h6 class="font-weight-bold"><font class="font-weight-bold" color="red"><?php echo date('d-m-Y', strtotime($detailTrans[0]['tp_due_date'])) ?></font>
                      </h6>
                    </div>
                  </div>
                </div>
                <div class="col-lg-7">
                  <div class="form-group">
                    <label>Riwayat Angsuran</label>
                    <div class="table-responsive">
                      <table class="table table-bordered" id="table-installment">
                        <thead class="text-center">
                          <tr>
                            <th>Periode</th>
                            <th>Tgl</th>
                            <th>Bayar</th>
                            <th>No. Nota</th>
                            <th>File Nota</th>
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
          <div class="col-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0 card-title"><b class="text-uppercase">Form Angsuran</b> <small><i class="fa fa-minus"></i></small> Nota : <b><?php echo $detailTrans[0]['tp_note_code'] ?></b></h5>
              </div>
              <form action="<?php echo site_url('Transaction_c/installmentPurchasesProses').'/'.urlencode(base64_encode($detailTrans[0]['tp_id'])) ?>" enctype="multipart/form-data" id="form-installment-purchases">
                <div class="card-body row">
                  <!-- Form-part input tanggal transaksi -->
                  <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <label>Tgl Pembayaran</label>
                      <input type="date" class="form-control" name="postIPDate" id="input-ip-date" required>
                      <small id="error-ip-date" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                    </div>
                  </div>
                        
                  <!-- Form-part input Nota Pembayaran -->
                  <div class="col-lg-3 col-md-8 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <label>No. Nota Pembayaran</label>
                      <input type="text" class="form-control float-right" name="postIPNote" id="input-ip-note" placeholder="No. nota pembayaran" required>
                      <small id="error-ip-note" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                    </div>
                  </div>

                  <!-- Form-part input file nota Pembayaran -->
                  <div class="col-lg-4 col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <label>File Nota</label>
                      <div class="custom-file">
                        <input type="file" class="form-control float-right custom-file-input" name="postIPNoteFile" id="input-ip-file" required>
                        <label class="custom-file-label" for="input-file-invoice"><p>Pilih file Nota</p></label>
                        <small id="error-ip-file" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      </div>
                    </div>
                  </div>

                  <!-- Form-part input Angsuran ke- -->
                  <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <label>Angsuran ke- </label>
                      <div class="input-group sm-3">
                        <?php $angsuranS = ($minLimitIP > 0)? intval($minLimitIP) : 1; ?>
                        <input type="number" class="form-control input-ip-periode" name="postIPPeriodeStart" value="<?php echo $angsuranS; ?>"  required="required" readonly>
                        <div class="input-group-append">
                          <span class="input-group-text"><i class="fa fa-minus"></i></span>
                        </div>
                        <select class="form-control input-ip-periode" name="postIPPeriodeEnd" id="input-ip-periode-end">
                          <?php for($angsuran = $angsuranS ; $angsuran <= $detailTrans[0]['tp_tenor']; $angsuran++){ ?>
                            <option value="<?php echo $angsuran ?>"><?php echo $angsuran ?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <small class="font-italic" style="color:red">* kosongkan kolom kanan untuk bayar 1 periode</small>
                      <small id="error-ip-periode" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      <small id="error-ip-periodeb" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                    </div>
                  </div>

                  <!-- Form-part input Pembayaran -->
                  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <label>Angsuran dibayarkan</label>
                      <input type="number" class="form-control float-right" step="0.01" name="postIPInstallment" id="input-ip-installment" placeholder="Angsuran dibayarkan...." required>
                      <small id="error-ip-installment" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                    </div>
                  </div>

                  <!-- Form-part input Metode pembayaran -->
                  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <label>Status Angsuran</label>
                      <select class="form-control float-right" name="postIPStatus" id="input-ip-status">
                        <option value="BL">Belum Lunas</option>
                        <option value="L">Lunas</option>
                      </select>
                      <small id="error-ip-status" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                    </div>
                  </div>

                  <!-- Form-part input tempo -->
                  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <label>Tempo selanjutnya</label>
                      <input type="date" class="form-control float-right" name="postIPDue" id="input-ip-due" value="" required="">
                      <small id="error-ip-due" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                    </div>
                  </div>

                  <!-- Form-part input PS -->
                  <div class="col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <label>Catatan tambahan <font class="text-lowercase font-italic" color="red"><small>(optional)</small></font></label>
                      <textarea class="form-control" cols="30" rows="5" name="postPurchasePS"></textarea>
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