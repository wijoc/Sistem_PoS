    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark text-uppercase">Transaksi Penjualan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('Page_c') ?>"><i class="fas fa-home"></i></a></li><li class="breadcrumb-item"><a href="<?php echo site_url('Transaction_c/listSalesPage') ?>"><i class="fas fa-cash-register"></i> Penjualan</a></li>
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
          <!-- Detail Transaction -->
          <div class="col-12">
            <div class="card card-info card-outline">
              <div class="card-header">
                <h4 class="m-0 card-title text-uppercase">Detail Transaksi <i class="fas fa-minus"></i> Nota : <b><?php echo $detailTrans[0]['ts_trans_code'] ?></b></h4>
                <div class="float-right">
                  <a class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Daftar Transaksi Sales" href="<?php echo site_url('Transaction_c/listSalesPage') ?>"><i class="fas fa-list"></i></a>
                  <?php if($detailTrans[0]['ts_payment_status'] == 'K'){ ?>
                  <a class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Bayar Angsuran Sales" href="<?php echo site_url('Transaction_c/installmentSalesPage/'.urlencode(base64_encode($detailTrans[0]['ts_id']))) ?>"><i class="fas fa-cash-register"></i></a>
                  <?php } ?>
                </div>
              </div>
              <div class="card-body row">
                <div class="col-lg-5 border-right border-solid">
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
                    <h6 class="col-sm-4">Total Keranjang<a class="float-right"> : </a></h6>
                    <div class="col-sm-8">
                      <h6 class="font-weight-bold" style="color: green"><?php echo 'Rp'.number_format($detailTrans[0]['total_cart']) ?></h6>
                    </div>
                  </div>
                  <div class="form-group row">
                    <h6 class="col-sm-4">Biaya Pengiriman<a class="float-right"> : </a></h6>
                    <div class="col-sm-8">
                      <h6 class="font-weight-bold" style="color: green"><?php echo 'Rp'.number_format($detailTrans[0]['ts_delivery_fee']) ?></h6>
                    </div>
                  </div>
                  <div class="form-group row">
                    <h6 class="col-sm-4">Total Belanja<a class="float-right"> : </a></h6>
                    <div class="col-sm-8">
                      <h6 class="font-weight-bold" style="color: green"><?php echo 'Rp'.number_format($detailTrans[0]['ts_total_sales']) ?></h6>
                    </div>
                  </div>
                  <div class="form-group row">
                    <h6 class="col-sm-4">Metode pembayaran<a class="float-right"> : </a></h6>
                    <div class="col-sm-8">
                      <h6 class="font-weight-bold">
                        <?php echo ($detailTrans[0]['ts_payment_method'] == 'TF')? '<span class="badge badge-warning">Transfer</span>' : '<span class="badge badge-info">Cash / Tunai</span>' ?>
                      </h6>
                    </div>
                  </div>
                  <?php if ($detailTrans[0]['ts_payment_method'] == 'TF'){ ?>
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
                  <?php if ($detailTrans[0]['ts_payment_status'] != 'T'){ ?>
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
                    <h6 class="col-sm-4">Tempo selanjutnya<a class="float-right"> : </a></h6>
                    <div class="col-sm-8">
                      <h6 class="font-weight-bold"><font class="font-weight-bold" color="red"><?php echo date('d-m-Y', strtotime($detailTrans[0]['ts_due_date'])) ?></font>
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
                              <th>Potongan (Rp)</th>
                              <th>Total (Rp)</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach($detailCart as $showCart): ?>
                              <tr>
                                <td><?php echo $showCart['prd_name'] ?></td>
                                <td class="text-center"><?php echo $showCart['dts_product_amount'] ?></td>
                                <td class="text-right"><?php echo number_format($showCart['dts_sale_price']) ?></td>
                                <td class="text-right"><?php echo number_format($showCart['dts_discount']) ?></td>
                                <td class="text-right"><?php echo number_format($showCart['dts_total_price']) ?></td>
                              </tr>
                            <?php endforeach; ?>
                          </tbody>
                          <tfoot>
                            <th colspan="4" class="text-right">Total (Rp)</th>
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

          <!-- Detail Installment History -->
          <?php if($detailTrans[0]['ts_payment_status'] != 'T'){ ?>
            <div class="col-12">
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h4 class="m-0 card-title text-uppercase">Detail Pembayaran Angsuran <i class="fas fa-minus"></i> Nota : <b><?php echo $detailTrans[0]['ts_trans_code'] ?></b></h4>
                </div>
                <div class="card-body row">
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead class="text-center">
                        <tr>
                          <th>Periode</th>
                          <th>Tempo</th>
                          <th>No. Pembayaran</th>
                          <th>Biaya Pembayaran</th>
                          <th>Tgl Bayar</th>
                          <th>PS</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($detailIS as $showIS): ?>
                        <tr>
                          <td class="text-center"><?php echo $showIS['is_periode'] ?></td>
                          <td class="text-center"><?php echo date('Y-m-d', strtotime($showIS['is_due_date'])) ?></td>
                          <td class="text-center"><?php echo ($showIS['is_code'] != '')? '<font color="green">'.$showIS['is_code'].'</font>' : '-' ?></td>
                          <td class="text-right"><?php echo ($showIS['is_payment'] != '')? '<font color="green">'.number_format($showIS['is_payment'], 2).'</font>' : '-' ?></td>
                          <td class="text-center"><?php echo ($showIS['is_payment_date'] != '')? '<font color="green">'.date('d/m/y',strtotime($showIS['is_payment_date'])).'</font>' : '-' ?></td>
                          <td class="text-justify"><?php echo ($showIS['is_post_script'] != '')? '<small>'.$showIS['is_post_script'].'</small>' : '' ?></td>
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>

          <!-- Detail Return -->
          <?php if ($detailTrans[0]['ts_return'] == 'Y') { ?>
            <div class="col-12">
              <div class="card card-danger card-outline">
                <div class="card-header">
                  <h4 class="m-0 card-title text-uppercase">History Retur <i class="fas fa-minus"></i> Nota : <b><?php echo $detailTrans[0]['ts_trans_code'] ?></b></h4>
                </div>
                <div class="card-body row">
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead class="text-center">
                        <tr>
                          <th rowspan="2" class="align-middle">Tgl</th>
                          <th rowspan="2" class="align-middle">No. Retur</th>
                          <th rowspan="2" class="align-middle">Status</th>
                          <th rowspan="2" class="align-middle">Biaya</th>
                          <th rowspan="2" class="align-middle">Catatan</th>
                          <th colspan="2" class="align-middle">Detail Retur</th>
                        </tr>
                        <tr>
                          <th class="text-center">Produk</th>
                          <th class="text-center">Qty Retur</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($detailRS as $showDRC): ?>
                          <tr>
                            <td class="text-center align-middle" rowspan="<?php echo $showDRC['count_prd'] ?>"><?php echo $showDRC['show_date'] ?></td>
                            <td class="text-right align-middle" rowspan="<?php echo $showDRC['count_prd'] ?>"><?php echo $showDRC['show_code'] ?></td>
                            <td class="text-center align-middle" rowspan="<?php echo $showDRC['count_prd'] ?>"><?php echo $showDRC['show_status'] ?></td>
                            <td class="text-right align-middle" rowspan="<?php echo $showDRC['count_prd'] ?>"><?php echo $showDRC['show_cash'] ?></td>
                            <td rowspan="<?php echo $showDRC['count_prd'] ?>"><small><?php echo $showDRC['show_ps'] ?></small></td>
                        
                        <?php if($showDRC['count_prd'] > 1){ ?>
                            <td><?php echo $showDRC['detail_rc'][array_key_first($showDRC['detail_rc'])]['retur_product'] ?></td>
                            <td class="text-center"><?php echo $showDRC['detail_rc'][array_key_first($showDRC['detail_rc'])]['retur_qty'] ?></td>
                          </tr>
                          <?php unset($showDRC['detail_rc'][array_key_first($showDRC['detail_rc'])]); foreach($showDRC['detail_rc'] as $showPrd): ?>
                          <tr>
                            <td><?php echo $showPrd['retur_product'] ?></td>
                            <td class="text-center"><?php echo $showPrd['retur_qty'] ?></td>
                          </tr>
                        
                        <?php endforeach; } else { ?>
                            <td><?php echo $showDRC['detail_rc'][array_key_first($showDRC['detail_rc'])]['retur_product'] ?></td>
                            <td class="text-center"><?php echo $showDRC['detail_rc'][array_key_first($showDRC['detail_rc'])]['retur_qty'] ?></td>
                          </tr>
                         <?php } ?>
                        <?php endforeach ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->