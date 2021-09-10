    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark text-uppercase">Retur Supplier</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('Page_c') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo site_url('Transaction_c') ?>"><i class="fas fa-cash-register"></i> Transaksi</a></li>
              <li class="breadcrumb-item active">Tambah Retur</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <form class="form-horizontal" id="form-add-rs" method="POST" action="<?php echo site_url('Transaction_c/addRSProses') ?>" enctype="multipart/form-data">
          <div class="row">
            <div class="col-lg-6 col-md-12">
              <div class="card card-info card-outline">
                <div class="card-header">
                  <h5>Keranjang Retur</h5>
                </div>
                <div class="card-body">
                    <div class="col-12">
                      <div class="form-group">
                        <div class="table-responsive">
                          <table class="table table-bordered" id="cart-shop">
                            <thead class="text-center">
                              <tr>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Harga (Rp)</th>
                                <th>Qty Retur</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach($detailCart as $showCart): ?>
                              <tr>
                                <td><small><?php echo $showCart['prd_name'] ?></small></td>
                                <td class="text-center"><?php echo $showCart['dtp_product_amount'] ?></td>
                                <td class="text-right"><?php echo number_format($showCart['dtp_purchase_price']) ?></td>
                                <td style="width: 25%;"><input type="number" class="form-control" min="0" max="<?php echo $showCart['dtp_product_amount'] ?>" name="postRSItem[<?php echo $showCart['dtp_product_fk'] ?>]"></td>
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
            <div class="col-lg-6 col-md-12">
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h5>Form Retur</h5>
                </div>
                <div class="card-body">
                  <div class="col-12 row">
                    <input type="hidden" name="postTPID" value="<?php echo $transID ?>" readonly>
                            
                    <div class="col-lg-6 col-md-6">
                      <div class="form-group">
                        <label>Tanggal Retur <font color="red"><small>*</small></font></label>
                        <input type="date" class="form-control" name="postRSDate" id="input-rs-date" required>
                        <small id="error-rs-date" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                      <div class="form-group">
                        <label>Status Retur <font color="red"><small>*</small></font></label>
                        <select class="form-control" name="postRSStatus" id="input-rs-status" required>
                          <option value="">-- Pilih Status Retur --</option>
                          <option value="R">Tukar - Barang rusak</option>
                          <option value="U">Pengembalian Dana / Cash</option>
                        </select>
                        <small id="error-rs-status" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                      <div class="form-group">
                        <label>Biaya Retur (Dana keluar)</label>
                        <input type="number" min="0" step="0.01" class="form-control" name="postRSCashOut" id="input-rs-cash-out">
                        <small id="error-rs-cash-out" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                      <div class="form-group">
                        <label>Pengembalian Dana (Dana masuk)</label>
                        <input type="number" min="0" step="0.01" class="form-control" name="postRSCashIn" id="input-rs-cash-in" disabled required="">
                        <small id="error-rs-cash-in" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Catatan </label>
                        <textarea class="form-control" name="postRSPS" id="input-rs-ps" cols="3" rows="5"></textarea>
                        <small id="error-rs-ps" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="float-right">
                    <button type="reset" class="btn btn-secondary"><b> Reset </b></button>
                    <button type="submit" class="btn btn-success" id="submitForm"><b> Simpan </b></button>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="card card-info card-outline">
                <div class="card-header">
                  Histori Retur
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
                            <?php
                                if($showDRS['count_prd'] > 1){
                                  ?>
                                    <td><?php echo $showDRS['detail_rs'][array_key_first($showDRS['detail_rs'])]['retur_product'] ?></td>
                                    <td class="text-center"><?php echo $showDRS['detail_rs'][array_key_first($showDRS['detail_rs'])]['retur_qty'] ?></td>
                                  </tr>
                                  <?php unset($showDRS['detail_rs'][array_key_first($showDRS['detail_rs'])]); foreach($showDRS['detail_rs'] as $showPrd): ?>
                                  <tr>
                                    <td><?php echo $showPrd['retur_product'] ?></td>
                                    <td class="text-center"><?php echo $showPrd['retur_qty'] ?></td>
                                  </tr>
                                  <?php
                                  endforeach;
                                } else {
                                  ?>
                                  <td><?php echo $showDRS['detail_rs'][array_key_first($showDRS['detail_rs'])]['retur_product'] ?></td>
                                  <td class="text-center"><?php echo $showDRS['detail_rs'][array_key_first($showDRS['detail_rs'])]['retur_qty'] ?></td>
                                </tr>
                                  <?php
                                }
                            ?>
                        <?php endforeach ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->