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
          <div class="col-lg-10">
            <div class="card card-orange card-outline">
              <div class="card-header">
                <h5 class="m-0">Form bayar angsuran pembelian</h5>
              </div>
              <div class="card-body">
                <!-- Section Alert -->
                <div id="alert-trans"></div>

                <!-- Section Detail Transaksi -->
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Nomor Transaksi<a class="float-right"> : </a></label>
                  <div class="col-sm-8">
                    <p class="col-form-label"><?php echo $detailTrans[0]['tp_trans_code'] ?></p>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Nomor Nota Pembelian<a class="float-right"> : </a></label>
                  <div class="col-sm-8">
                    <p class="col-form-label"><?php echo $detailTrans[0]['tp_invoice_code'] ?></p>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Tenor<a class="float-right"> : </a></label>
                  <div class="col-sm-8">
                    <p class="col-form-label">
                      <?php if ($detailTrans[0]['tp_status'] == 'T'){
                        echo '-';
                      } else {
                        echo '<b>'.$detailTrans[0]['tp_tenor'].'x </b> dengan periode ';
                        if ($detailTrans[0]['tp_tenor_periode'] == 'D'){
                          echo '<b>Harian</b>';
                        } else if ($detailTrans[0]['tp_tenor_periode'] == 'W'){
                          echo '<b>Mingguan</b>';
                        } else if ($detailTrans[0]['tp_tenor_periode'] == 'M'){
                          echo '<b>Bulanan</b>';
                        } else if ($detailTrans[0]['tp_tenor_periode'] == 'Y'){
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
                    <p class="col-form-label"><?php echo ($detailTrans[0]['tp_status'] == 'T')? '-' : $detailTrans[0]['tp_installment'] ?> </p>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Total Pembelian<a class="float-right"> : </a></label>
                  <div class="col-sm-8">
                    <p class="col-form-label"><?php echo $detailTrans[0]['tp_purchase_price'] ?> </p>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Pembayaran pertama<a class="float-right"> : </a></label>
                  <div class="col-sm-8">
                    <p class="col-form-label"><?php echo $detailTrans[0]['tp_paid'] ?> </p>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Angsuran Terbayar<a class="float-right"> : </a></label>
                  <div class="col-sm-8">
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <thead>
                          <tr class="text-center">
                            <th>Angsuran ke -</th>
                            <th>Tgl Bayar</th>
                            <th>Biaya</th>
                            <th>No Nota</th>
                            <th>File Nota</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach($detailPayment as $row): ?>
                          <tr>
                            <td class="text-center">
                              <?php 
                                echo ($row['ip_periode_end'] != 0)? $row['ip_periode'].' sampai '.$row['ip_periode_end'] : $row['ip_periode'];  
                              ?>    
                            </td>
                            <td><?php echo date('d-m-Y', strtotime($row['ip_date'])) ?></td>
                            <td><?php echo 'Rp '.number_format($row['ip_payment']) ?></td>
                            <td><?php echo $row['ip_invoice_code'] ?></td>
                            <td class="text-center"><a class="btn btn-xs btn-success" target="_blank" href="<?php echo $row['ip_invoice_code'] ?>"><i class="fas fa-download"></i> </a></td>
                          </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <?php if ($detailTrans[0]['tp_status'] == 'K'){ ?>
                <form method="POST" enctype="multipart/form-data" action="<?php echo site_url('Transaksi_c/installmentPurchaseProses').'/'.urlencode(base64_encode($detailTrans[0]['tp_id'])) ?>">
                  <!-- Form-part kode transaksi :hidden -->
                  <input type="hidden" name="postTransCode" value="<?php echo $detailTrans[0]['tp_trans_code'] ?>">

                  <!-- Form-part angsuran -->
                  <div class="form-group row">
                    <label for="inputAngsuran" class="col-sm-3 col-form-label">Angsuran ke -<a class="float-right"> : </a></label>
                    <div class="col-sm-9 row">
                      <div class="col-sm-4">
                        <select class="form-control" name="postAngsuranAwal" id="inputAngsuranAwal">
                          <?php 
                          for($angsuran = 1; $angsuran <= $detailTrans[0]['tp_tenor']; $angsuran++){ ?>
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
                          for($angsuran = 1; $angsuran <= $detailTrans[0]['tp_tenor']; $angsuran++){ ?>
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

                  <!-- Form-part input Nomor Nota -->
                  <div class="form-group row">
                    <label for="inputTransNota" class="col-sm-3 col-form-label">Nomor Nota Pembayaran <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postTransNota" id="inputTransNota" placeholder="Masukkan nomor nota pembelian" required>
                    </div>
                  </div>

                  <!-- Form-part input File Nota -->
                  <div class="form-group row">
                    <label for="inputTransFileNota" class="col-sm-3 col-form-label">File Nota <a class="float-right"> : </a></label>
                    <div class="col-sm-6">
                      <div class="custom-file">
                        <input type="file" class="form-control float-right custom-file-input" name="postTransFileNota" id="inputTransFileNota" required>
                        <label class="custom-file-label" for="inputTransFileNota"><p>Pilih File Nota Pembayaran</p></label>
                      </div>
                    </div>
                  </div>

                  <!-- Form-part Bayar -->
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Tempo selanjutnya<a class="float-right"> : </a></label>
                    <div class="col-sm-4">
                      <input type="date" class="form-control" name="postNextTempo">
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