    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark text-uppercase">Retur Pelanggan</h1>
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
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-primary card-outline">
              <form class="form-horizontal" id="form-add-rc" method="POST" action="<?php echo site_url('Transaction_c/addRCProses') ?>" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 border-right">
                            <div class="form-group">
                                <label>Keranjang retur</label>
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
                                            <td class="text-center"><?php echo $showCart['dts_product_amount'] ?></td>
                                            <td class="text-right"><?php echo number_format($showCart['dts_sale_price']) ?></td>
                                            <td style="width: 25%;"><input type="number" class="form-control" min="0" max="<?php echo $showCart['dts_product_amount'] ?>" name="postRCItem[<?php echo $showCart['dts_product_fk'] ?>]"></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 row">
                            <input type="text" name="postTSID" value="<?php echo $transID ?>" readonly>
                            
                            <div class="col-lg-4 col-md-4">
                                <div class="form-group">
                                    <label>Tanggal Retur <font color="red"><small>*</small></font></label>
                                    <input type="date" class="form-control" name="postRCDate" id="input-rs-date" required>
                                    <small id="error-rs-date" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="form-group">
                                    <label>Status Retur <font color="red"><small>*</small></font></label>
                                    <select class="form-control" name="postRCStatus" id="input-rs-status" required>
                                        <option value="">-- Pilih Status Retur --</option>
                                        <option value="R">Tukar - Barang rusak</option>
                                        <option value="U">Cash</option>
                                    </select>
                                    <small id="error-rs-status" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4" id="div-cash">
                                <div class="form-group">
                                    <label>Biaya Retur</label>
                                    <input type="number" min="0" step="0.01" class="form-control" name="postRCCash" id="input-rs-cash" disabled>
                                    <small id="error-rs-cash" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Catatan </label>
                                    <textarea class="form-control" name="postRCPS" id="input-rs-ps" cols="3" rows="5"></textarea>
                                    <small id="error-rs-ps" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                                </div>
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
              </form>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

    <?php print("<pre>".print_r($detailCart, true)."</pre>"); ?>