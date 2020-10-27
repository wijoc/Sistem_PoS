    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Page Produk</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('Page_c') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo site_url('Product_c') ?>"><i class="fas fa-cubes"></i> Produk</a></li>
              <li class="breadcrumb-item active">Detail Produk</li>
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
                <h5 class="m-0">Detail Produk</h5>
              </div>
              <div class="card-body">
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
                  <label class="col-sm-3 col-form-label">File Pembelian<a class="float-right"> : </a></label>
                  <div class="col-sm-8">
                    <a class="btn btn-sm btn-success" target="_blank" href="<?php echo base_url().$detailTrans[0]['tp_invoice_file'] ?>">
                      <i class="fas fa-download"></i>&nbsp; Download
                    </a>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Tanggal Transaksi<a class="float-right"> : </a></label>
                  <div class="col-sm-8">
                    <p class="col-form-label"><?php echo date('d-m-Y', strtotime($detailTrans[0]['tp_date'])) ?></p>
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
                            $totalBayar += $row['dtp_total_price'];
                          ?>
                          <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $row['prd_name']; ?></td>
                            <td><?php echo $row['dtp_product_amount'] ?></td>
                            <td class="text-right"><?php echo number_format($row['dtp_purchase_price']) ?></td>
                            <td class="text-right"><?php echo number_format($row['dtp_total_price']) ?></td>
                          </tr>
                        <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                          <th colspan="4" class="text-right">Total : </th>
                          <th><?php echo number_format($totalBayar) ?></th>
                        </tfoot>
                      </table>
                    </div>    
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Supplier<a class="float-right"> : </a></label>
                  <div class="col-sm-8">
                    <p class="col-form-label"><?php echo $detailTrans[0]['supp_name'] ?></p>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Metode Pembayaran<a class="float-right"> : </a></label>
                  <div class="col-sm-8">
                    <p class="col-form-label"><?php echo $detailTrans[0]['tp_payment_metode'] ?> </p>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Status<a class="float-right"> : </a></label>
                  <div class="col-sm-8">
                    <p class="col-form-label">
                      <?php 
                        if($detailTrans[0]['tp_status'] == 'T'){
                          echo '<font color="green"> Pembayaran Tunai - Lunas </font>';
                        } else if ($detailTrans[0]['tp_status'] == 'K') {
                          echo '<font color="red"> Pembayaran Kredit - Belum Lunas </font>';
                        } else if ($detailTrans[0]['tp_status'] == 'L'){
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
                  <label class="col-sm-3 col-form-label">Total dibayar<a class="float-right"> : </a></label>
                  <div class="col-sm-8">
                    <p class="col-form-label"><?php echo $detailTrans[0]['tp_paid'] ?> </p>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Total Kurangan<a class="float-right"> : </a></label>
                  <div class="col-sm-8">
                    <p class="col-form-label"><?php echo $detailTrans[0]['tp_insufficient'] ?> </p>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Riwayat angsuran<a class="float-right"> : </a></label>
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
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->