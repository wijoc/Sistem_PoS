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
          <!-- Detail transaksi -->
          <div class="col-lg-12">
            <div class="card card-orange card-outline">
              <div class="card-header">
                <h5 class="m-0 card-title">Detail Transaksi Penjualan - <b><?php echo $detailTrans[0]['ts_trans_code'] ?></b></h5>
                <div class="float-right">
                	<a class="btn btn-xs btn-warning" href="<?php echo site_url('Transaksi_c/listSalesPage') ?>"><i class="fas fa-list"></i></a>
                	<?php if($detailTrans[0]['ts_status'] != 'T') { ?>
                	<a class="btn btn-xs btn-info" href="<?php echo site_url('Transaksi_c/paySalesInstallmentPage').'/'.urlencode(base64_encode($detailTrans[0]['ts_id'])) ?>"><i class="fas fa-credit-card"></i></a>
                	<?php } ?>
                </div>
              </div>
              <div class="card-body">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Tgl Transaksi<a class="float-right"> : </a></label>
                  <div class="col-sm-2">
                    <p class="col-form-label"><?php echo date('d/m/Y', strtotime($detailTrans[0]['ts_date'])) ?></p>
                  </div>
                  <label class="col-sm-1 col-form-label">Pembeli<a class="float-right"> : </a></label>
                  <div class="col-sm-2">
                    <p class="col-form-label"><?php echo ($detailTrans[0]['ts_customer_fk'] == 0)? 'General Customer / Pelanggan Umum' : $detailTrans[0]['ctm_name'] ?></p>
                  </div>
                  <label class="col-sm-1 col-form-label">Status<a class="float-right"> : </a></label>
                  <div class="col-sm-3">
                    <p class="col-form-label">
                      <b>
                      <?php 
                        if($detailTrans[0]['ts_status'] == 'T'){
                          echo '<font color="green"> Pembayaran Tunai - Lunas </font>';
                        } else if ($detailTrans[0]['ts_status'] == 'K') {
                          echo '<font color="red"> Pembayaran Kredit - Belum Lunas </font>';
                        } else if ($detailTrans[0]['ts_status'] == 'L'){
                          echo '<font color="red"> Pembayaran Kredit - Lunas </font>';
                        }
                      ?> 
                      </b>
                    </p>
                  </div>
                </div>
                <?php if($detailTrans[0]['ts_status'] != 'T'){ ?>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tenor<a class="float-right"> : </a></label>
                    <div class="col-sm-10">
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
                        ( Angsuran <b><font color="red"><?php echo ($detailTrans[0]['ts_status'] == 'T')? '-' : 'Rp'.number_format($detailTrans[0]['ts_installment'], 2) ?> </font></b> )
                      </p>
                    </div>
                  </div>
                <?php } ?>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Total Penjualan<a class="float-right"> : </a></label>
                  <div class="col-sm-2"> 
                    <p class="col-form-label"><?php echo number_format($detailTrans[0]['ts_sales_price'], 2); ?></p>    
                  </div>
                  <label class="col-sm-2 col-form-label"><?php echo ($detailTrans[0]['ts_status'] != 'T')? 'Uang Muka / DP' : 'Bayar'; ?><a class="float-right"> : </a></label>
                  <div class="col-sm-4"> 
                    <p class="col-form-label"><?php echo number_format($detailTrans[0]['ts_paid'], 2); ?></p>    
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Form return -->
          <div class="col-lg-12">
            <div class="card card-orange card-outline">
              <div class="card-header">
                <h5 class="m-0 card-title">Form return transaksi penjualan - <b><?php echo $detailTrans[0]['ts_trans_code'] ?></b></h5>
              </div>
              <form method="POST" action="<?php echo site_url('Transaksi_c/returnSalesProses') ?>">
                <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <thead>
                          <th>Product</th>
                          <th>Harga</th>
                          <th>Jumlah</th>
                          <th>Total</th>
                          <th>Qty Retur</th>
                          <th>Status Retur</th>
                        </thead> 
                        <tbody>
                          <?php 
                          foreach ($detailTrans as $row): 
                          ?>
                          <tr>
                            <input type="hidden" name="post_prd[]" value="<?php echo urlencode(base64_encode($row['dts_product_fk'])); ?>">
                            <td><?php echo $row['prd_name']; ?></td>
                            <td class="text-right"><?php echo number_format($row['dts_sale_price']) ?></td>
                            <td><?php echo $row['dts_product_amount'] ?></td>
                            <td class="text-right"><?php echo number_format($row['dts_total_price']) ?></td>
                            <td><input class="form-control" type="number" name="returnQty-<?php echo urlencode(base64_encode($row['dts_product_fk'])); ?>" id="" min="0" max="<?php echo $row['dts_product_amount'] ?>"></td>
                            <td>
                                <select class="form-control" name="returnStatus-<?php echo urlencode(base64_encode($row['dts_product_fk'])); ?>" id="">
                                    <option value="">-- Status Retur --</option>
                                    <option value="T">Tukar (barang rusak)</option>
                                    <option value="RU">Retur Uang</option>
                                </select>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>

                    <!-- Form-part transaksi sales id -->
                    <input type="hidden" class="form-control" name="returnSalesID" value="<?php echo urlencode(base64_encode($detailTrans[0]['ts_id'])) ?>">
                    
                    <!-- Form-part input Tanggal transaksi -->
                    <div class="form-group row">
                        <label for="inputReturnDate" class="col-sm-3 col-form-label">Tgl retur <a class="float-right"> : </a></label>
                        <div class="col-sm-5">
                          <input type="datetime-local" class="form-control float-right" name="returnDate" id="inputReturnDate" required>
                        </div>
                    </div>
                    
                    <!-- Form-part input Biaya Return -->
                    <div class="form-group row">
                        <label for="inputReturnPayment" class="col-sm-3 col-form-label">Total biaya retur <a class="float-right"> : </a></label>
                        <div class="col-sm-5">
                            <input type="number" class="form-control float-right" name="returnPayment" id="inputReturnPayment" min="0" step="0.01" required="">
                        </div>
                    </div>
                    
                    <?php if($detailTrans[0]['ts_status'] == 'K') { ?>
                    <!-- Form-part input Biaya Return -->
                    <div class="form-group row">
                        <label for="inputReturnInstallment" class="col-sm-3 col-form-label">Angsuran baru <a class="float-right"> : </a></label>
                        <div class="col-sm-5">
                            <input type="number" class="form-control float-right" name="returnInstallment" id="inputReturnInstallment" min="0" step="0.01">
                            <font style="font-style: italic; color: red;"><small>* Kosongkan jika tidak merubah angsuran </small></font>
                        </div>
                    </div>
                    <?php } ?>
                    
                    <!-- Form-part input Keterangan Return -->
                    <div class="form-group row">
                        <label for="inputReturnNote" class="col-sm-3 col-form-label">Keterangan retur <a class="float-right"> : </a></label>
                        <div class="col-sm-9">
                            <textarea name="returnNote" id="inputReturnNote" cols="10" class="form-control" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="float-right">
                        <a href="<?php echo site_url('Transaksi_c/listSalesPage') ?>" class="btn btn-danger ">Batal</a>
                        <input type="submit" class="btn btn-success" value="Simpan">
                    </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->