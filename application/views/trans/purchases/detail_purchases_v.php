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
                <h4 class="m-0 card-title text-uppercase"><b>Detail Transaksi</b></h4> <small><i class="fa fa-minus"></i></small> Nota : <b><?php echo $detailTrans[0]['tp_note_code'] ?></b>
                <div class="float-right">
                  <a class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Daftar Transaksi Pembelian" href="<?php echo site_url('Transaction_c/listPurchasesPage') ?>"><i class="fas fa-list"></i></a>
                  <?php         
                  if(in_array($this->session->userdata('logedInLevel'), ['uAll', 'uO'])){
                    if($detailTrans[0]['tp_payment_status'] == 'K'){ ?>
                      <a class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Bayar Angsuran Pembelian" href="<?php echo site_url('Transaction_c/installmentPurchasesPage/'.urlencode(base64_encode($detailTrans[0]['tp_id']))) ?>">
                        <i class="fas fa-cash-register"></i>
                      </a>
                    <?php } ?>
                    <a class="btn btn-sm btn-secondary" data-toggle="tooltip" data-placement="top" title="Retur" href="<?php echo site_url('Transaction_c/addRSPage/'.urlencode(base64_encode($detailTrans[0]['tp_id']))) ?>">
                      <i class="fas fa-exchange-alt"></i>
                    </a>
                  <?php } ?>
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
                    <h6 class="col-sm-4">Total Keranjang<a class="float-right"> : </a></h6>
                    <div class="col-sm-8">
                      <h6 class="font-weight-bold" style="color: green"><?php echo 'Rp'.number_format($detailTrans[0]['total_cart']) ?></h6>
                    </div>
                  </div>
                  <div class="form-group row">
                    <h6 class="col-sm-4">Biaya Tambahan<a class="float-right"> : </a></h6>
                    <div class="col-sm-8">
                      <h6 class="font-weight-bold" style="color: green"><?php echo 'Rp'.number_format($detailTrans[0]['tp_additional_cost']) ?></h6>
                    </div>
                  </div>
                  <div class="form-group row">
                    <h6 class="col-sm-4">Total Belanja<a class="float-right"> : </a></h6>
                    <div class="col-sm-8">
                      <h6 class="font-weight-bold" style="color: green"><?php echo 'Rp'.number_format($detailTrans[0]['tp_total_cost']) ?></h6>
                    </div>
                  </div>
                  <div class="form-group row">
                    <h6 class="col-sm-4">Metode pembayaran<a class="float-right"> : </a></h6>
                    <div class="col-sm-8">
                      <h6 class="font-weight-bold">
                        <?php echo ($detailTrans[0]['tp_payment_method'] == 'TF')? '<span class="badge badge-warning">Transfer</span>' : '<span class="badge badge-info">Cash / Tunai</span>' ?>
                      </h6>
                    </div>
                  </div>
                  <?php if ($detailTrans[0]['tp_payment_method'] == 'TF'){ ?>
                  <div class="form-group row">
                    <h6 class="col-sm-4">Rekening<a class="float-right"> : </a></h6>
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
                  <?php if ($detailTrans[0]['tp_payment_status'] != 'T'){ ?>
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
                    <h6 class="col-sm-4">Tempo selanjutnya<a class="float-right"> : </a></h6>
                    <div class="col-sm-8">
                      <h6 class="font-weight-bold"><font class="font-weight-bold" color="red"><?php echo date('d-m-Y', strtotime($detailTrans[0]['tp_due_date'])) ?></font>
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
                              <th>Harga (Rp)</th>
                              <th>Total (Rp)</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach($detailCart as $showCart): ?>
                              <tr>
                                <td><?php echo $showCart['prd_name'] ?></td>
                                <td class="text-center"><?php echo $showCart['dtp_product_amount'] ?></td>
                                <td class="text-right"><?php echo number_format($showCart['dtp_purchase_price']) ?></td>
                                <td class="text-right"><?php echo number_format($showCart['dtp_total_price']) ?></td>
                              </tr>
                            <?php endforeach; ?>
                          </tbody>
                          <tfoot>
                            <th colspan="3" class="text-right">Total (Rp)</th>
                            <th id="total-payment" class="text-right"><?php echo number_format($detailTrans[0]['total_cart']) ?></th>
                          </tfoot>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="card card-info card-outline">
              <div class="card-header">
                <h4 class="m-0 card-title">Detail Pembayaran Angsuran <i class="fas fa-minus"></i> Nota : <b><?php echo $detailTrans[0]['tp_note_code'] ?></b></h4>
              </div>
              <div class="card-body row">
                <div class="table-responsive">
                  <table class="table table-bordered" id="cart-shop">
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
                      <?php foreach($detailIP as $showIP): ?>
                        <tr>
                          <td class="text-center"><?php echo ($showIP['ip_periode_end'] == $showIP['ip_periode_begin'])? $showIP['ip_periode_begin'] : $showIP['ip_periode_begin'].' - '.$showIP['ip_periode_end'] ?></td>
                          <td class="text-center"><?php echo date('d-m-Y', strtotime($showIP['ip_date'])) ?></td>
                          <td class="text-center"><?php echo 'Rp'.number_format($showIP['ip_payment'], 2) ?></td>
                          <td class="text-center"><?php echo $showIP['ip_note_code'] ?></td>
                          <td><a class="btn btn-xs btn-success" target="_blank" href="'.base_url().$showIP['ip_note_file'].'"><i class="fas fa-file-download"></i></a></td>
                          <td class="text-justify"><p><?php echo $showIP['ip_post_script'] ?></p></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="card card-danger card-outline">
              <div class="card-header">
                <h4 class="m-0 card-title">Detail Retur Transaksi <i class="fas fa-minus"></i> Nota : <b><?php echo $detailTrans[0]['tp_note_code'] ?></b></h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th rowspan="2" class="text-center align-middle">Tgl</th>
                        <th rowspan="2" class="text-center align-middle">Status</th>
                        <th colspan="2" class="text-center align-middle">Biaya</th>
                        <th rowspan="2" class="text-center align-middle">PS</th>
                        <th colspan="2" class="text-center align-middle">Detail Retur</th>
                      </tr>
                      <tr>
                        <th class="text-center">Keluar</th>
                        <th class="text-center">Dana Masuk</th>
                        <th class="text-center">Produk</th>
                        <th class="text-center">Qty Retur</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($detailRetur as $showDRS): ?>
                          <tr>
                            <td class="text-center" rowspan="<?php echo $showDRS['count_prd'] ?>"><?php echo $showDRS['show_date'] ?></td>
                            <td class="text-center" rowspan="<?php echo $showDRS['count_prd'] ?>"><?php echo $showDRS['show_status'] ?></td>
                            <td class="text-right" rowspan="<?php echo $showDRS['count_prd'] ?>"><?php echo $showDRS['show_cash_out'] ?></td>
                            <td class="text-right" rowspan="<?php echo $showDRS['count_prd'] ?>"><?php echo $showDRS['show_cash_in'] ?></td>
                            <td class="text-center" rowspan="<?php echo $showDRS['count_prd'] ?>"><small><?php echo $showDRS['show_ps'] ?></small></td>
                        
                        <?php if($showDRS['count_prd'] > 1){ ?>
                            <td><?php echo $showDRS['detail_rs'][array_key_first($showDRS['detail_rs'])]['retur_product'] ?></td>
                            <td class="text-center"><?php echo $showDRS['detail_rs'][array_key_first($showDRS['detail_rs'])]['retur_qty'] ?></td>
                          </tr>
                          <?php unset($showDRS['detail_rs'][array_key_first($showDRS['detail_rs'])]); foreach($showDRS['detail_rs'] as $showPrd): ?>
                          <tr>
                            <td><?php echo $showPrd['retur_product'] ?></td>
                            <td class="text-center"><?php echo $showPrd['retur_qty'] ?></td>
                          </tr>
                        
                        <?php endforeach; } else { ?>
                            <td><?php echo $showDRS['detail_rs'][array_key_first($showDRS['detail_rs'])]['retur_product'] ?></td>
                            <td class="text-center"><?php echo $showDRS['detail_rs'][array_key_first($showDRS['detail_rs'])]['retur_qty'] ?></td>
                          </tr>
                         <?php } ?>
                      <?php endforeach ?>
                    </tbody>
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