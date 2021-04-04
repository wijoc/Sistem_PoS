    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark text-uppercase">Transaksi Pembelian</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('Page_c') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo site_url('Transaksi_c') ?>"><i class="fas fa-cashier"></i> Pembelian</a></li>
              <li class="breadcrumb-item active">Detail Pembelian</li>
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
                <h4 class="m-0 card-title">Detail Transaksi <i class="fas fa-minus"></i> Nota : <b><?php echo $detailTrans[0]['tp_note_code'] ?></b></h4>
                <div class="float-right">
                  <a class="btn btn-xs btn-success" href="<?php echo site_url('Transaction_c/listPurchasesPage') ?>"><i class="fas fa-list"></i></a>
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
                    <h6 class="col-sm-4">Total belanja<a class="float-right"> : </a></h6>
                    <div class="col-sm-8">
                      <h6 class="font-weight-bold" style="color: green"><?php echo 'Rp'.$detailTrans[0]['tp_purchase_price'] ?></h6>
                    </div>
                  </div>
                  <div class="form-group row">
                    <h6 class="col-sm-4">Metode pembayaran<a class="float-right"> : </a></h6>
                    <div class="col-sm-8">
                      <h6 class="font-weight-bold"><?php echo ($detailTrans[0]['tp_payment_method'] == 'TF')? 'Transfer' : 'Cash / Tunai' ?></h6>
                    </div>
                  </div>
                  <?php if ($detailTrans[0]['tp_payment_method'] == 'TF'){ ?>
                  <div class="form-group row">
                    <h6 class="col-sm-4">Rekening pembayaran<a class="float-right"> : </a></h6>
                    <div class="col-sm-8">
                      <h6 class="font-weight-bold"><?php echo $detailTrans[0]['bank_name'].' - '.$detailTrans[0]['acc_number'].' A/N '.$detailTrans[0]['acc_name'] ?></h6>
                    </div>
                  </div>
                  <?PHP } ?>
                  <div class="form-group row">
                    <h6 class="col-sm-4">Status Pembayaran<a class="float-right"> : </a></h6>
                    <div class="col-sm-8">
                      <h6 class="font-weight-bold" style="color: green">
                        <?php 
                          if ($detailTrans[0]['tp_status'] == 'K') {
                            echo '<font color="red">Kredit - Belum Lunas</font>';
                          } else if ($detailTrans[0]['tp_status'] == 'L') {
                            echo '<font color="green">Kredit - Lunas</font>';
                          } else if ($detailTrans[0]['tp_status'] == 'T') {
                            echo '<font color="green">Tunai - Lunas</font>';
                          } 
                        ?>
                      </h6>
                    </div>
                  </div>
                  <?php if ($detailTrans[0]['tp_status'] != 'T'){ ?>
                  <div class="form-group row">
                    <h6 class="col-sm-4">Tenor<a class="float-right"> : </a></h6>
                    <div class="col-sm-8">
                      <h6>
                        <?php 
                        echo '<b>'.$detailTrans[0]['tp_tenor'].'<i class="fas fa-cross"></i></b>' ?>
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
                      <h6 class="font-weight-bold"> <?php echo $detailTrans[0]['tp_installment'] ?>
                      </h6>
                    </div>
                  </div>
                  <?PHP } ?>
                </div>
                <div class="col-lg-7 border-right border-solid">
                  <div class="col-12">
                    <div class="form-group">
                      <label>Detail Belanja</label>
                      <div class="table-responsive">
                        <table class="table table-bordered" id="cart-shop">
                          <thead class="text-center">
                            <tr>
                              <th>Product</th>
                              <th>Qty</th>
                              <th>Harga</th>
                              <th>Total</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                            <th colspan="3" class="text-right">Total</th>
                            <th id="total-payment" class="text-right">0</th>
                            <th></th>
                          </tfoot>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <label>Riwayat Angsuran</label>
                      <div class="table-responsive">
                        <table class="table table-bordered" id="cart-shop">
                          <thead class="text-center">
                            <tr>
                              <th>Angsuran</th>
                              <th>Tgl Bayar</th>
                              <th>Biaya</th>
                              <th>No Nota</th>
                              <th>File Nota</th>
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
          </div>
          <div class="col-12">
            <div class="card card-danger card-outline">
              <div class="card-header">
                <h4 class="m-0 card-title">Detail Retur Transaksi <i class="fas fa-minus"></i> Nota : <b><?php echo $detailTrans[0]['tp_note_code'] ?></b></h4>
                <div class="float-right">
                  <a class="btn btn-xs btn-success" href="<?php echo site_url('Transaction_c/listPurchasesPage') ?>"><i class="fas fa-list"></i></a>
                </div>
              </div>
              <div class="card-body row">
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <th>Nota Retur</th>
                      <th>Produk</th>
                      <th>Qty</th>
                      <th>Status</th>
                    </thead>
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
    <?php print("<pre>".print_r($detailTrans, true)."</pre>") ?>