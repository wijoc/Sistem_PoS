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
              <li class="breadcrumb-item"><a href="<?php echo site_url('Transaction_c') ?>"><i class="fas fa-cubes"></i> Transaksi</a></li>
              <li class="breadcrumb-item active">Tambah Pembelian</li>
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
          <!-- Form Cart -->
          <div class="col-lg-6">
            <div class="card card-info card-outline">
              <div class="card-header">
                <h5 class="m-0">Keranjang</h5>
              </div>
              <div class="card-body">
                <form action="<?php echo site_url('Transaction_c/addCart/Purchases/') ?>" id="form-cart">
                  <div class="row">
                    <div class="col-md-6 col-sm-6">
                      <div class="form-group">
                        <label>Product</label>
                        <input type="hidden" name="postIdPrd" readonly>
                        <input type="text" class="form-control" id="input-cart-prd" placeholder="Nama / barcode product">
                      </div>
                    </div>
                    <div class="col-md-2 col-sm-6">
                      <div class="form-group">
                        <label>Qty</label>
                        <input type="text" class="form-control" name="postCartQty" id="input-cart-qty" onkeyup="totalPrice()" placeholder="Qty">
                      </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                      <div class="form-group">
                        <label>Harga</label>
                        <input type="text" class="form-control" name="postCartPrice" id="input-cart-price" placeholder="Harga satuan">
                      </div>
                    </div>
                  </div>
                  <div class="row pb-2 border-bottom">
                    <div class="col-sm-12">
                      <button type="submit" class="col-12 btn btn-sm btn-info">Tambah</button>
                    </div>
                  </div>
                </form>
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
                  <div class="row pb-2 border-bottom">
                    <div class="col-md-12 col-sm-12">
                      <div class="form-group">
                        <label>Biaya Tambahan</label>
                        <input type="number" class="form-control" id="cart-addition-charge" min="0" step="0.01" placeholder="Additional Charge...">
                        <small id="error-p-additional" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>

          <!-- Form detail trans -->
          <div class="col-lg-6">
            <div class="card card-info card-outline">
              <div class="card-header">
                <h5 class="m-0">Form Transaksi Pembelian</h5>
              </div>
              <form action="<?php echo site_url('Transaction_c/addPurchasesProses') ?>" id="form-add-purchases" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="row">
                    <!-- Total Belanja -->
                    <div class="col-12 info-box mb-3">
                      <span class="info-box-icon bg-success"><i class="fas fa-shopping-cart"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">Total</span>
                        <span class="info-box-number float-right">
                          <h5 style="font-weight: bold" id="cart-total"></h5>
                        </span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>

                    <!-- Form-part : hidden input -->
                    <input type="hidden" name="postPurchaseAdditional" id="input-additional-charge" readonly>
                        
                    <!-- Form-part input tanggal transaksi -->
                    <div class="col-md-4 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label>Tgl Transaksi</label>
                        <input type="date" class="form-control" name="postPurchaseDate" id="input-p-date" required>
                        <small id="error-p-date" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      </div>
                    </div>

                    <!-- Form-part input Nomor nota transaksi -->
                    <div class="col-md-8 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label>No. Nota Transaksi</label>
                        <input type="text" class="form-control float-right" name="postPurchaseNote" id="input-p-note" placeholder="No. nota pembelian" required>
                        <small id="error-p-note" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      </div>
                    </div>

                    <!-- Form-part input file nota transaksi -->
                    <div class="col-md-5 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label>File Nota</label>
                        <div class="custom-file">
                          <input type="file" class="form-control float-right custom-file-input" name="postPurchaseNoteFile" id="input-p-file" required>
                          <label class="custom-file-label" for="input-file-invoice"><p>Pilih file Nota</p></label>
                          <small id="error-p-file" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                        </div>
                      </div>
                    </div>

                    <!-- Form-part input Supplier -->
                    <div class="col-md-7 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label>Supplier</label>
                        <select class="form-control float-right" name="postPurchaseSupplier" id="input-p-supplier" required>
                          <option value=""> -- Pilih Supplier -- </option>
                          <?php foreach($optSupp as $showSupp) : ?>
                            <option value="<?php echo urlencode(base64_encode($showSupp['supp_id'])) ?>"><?php echo $showSupp['supp_name'] ?></option>
                          <?php endforeach; ?>
                        </select>
                        <small id="error-p-supplier" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      </div>
                    </div>

                    <!-- Form-part input Status pembayaran -->
                    <div class="col-md-5 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label>Status</label>
                        <select class="form-control float-right" name="postPurchaseStatus" id="input-status" required>
                          <option value=""> -- Pilih Status -- </option>
                          <option value="T"> Tunai </option>
                          <option value="K"> Kredit / Angsur </option>
                        </select>
                        <small id="error-p-status" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      </div>
                    </div>

                    <!-- Form-part input Tenor -->
                    <div class="col-md-3 col-sm-6 col-xs-12 status-k" style="display: none;">
                      <div class="form-group">
                        <label>Tenor</label>
                        <div class="input-group sm-3">
                          <input type="number" class="form-control float-right input-k" name="postPurchaseTenor" id="input-p-tenor" required="" disabled> 
                          <div class="input-group-append">
                            <span class="input-group-text"><i class="fa fa-times"></i></span>
                          </div>
                          <small id="error-p-tenor" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                        </div>
                      </div>
                    </div>

                    <!-- Form-part input Periode Tenor -->
                    <div class="col-md-4 col-sm-6 col-xs-12 status-k" style="display: none;">
                      <div class="form-group">
                        <label>Periode Tenor</label>
                        <select class="form-control float-right input-k" name="postPurchaseTenorPeriode" id="input-p-tenor-periode" required="" disabled>
                          <option value="D">Harian</option>
                          <option value="W">Mingguan</option>
                          <option value="M">Bulanan</option>
                          <option value="Y">Tahunan</option>
                        </select>
                        <small id="error-p-tenor-periode" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      </div>
                    </div>

                    <!-- Form-part input Angsuran -->
                    <div class="col-md-6 col-sm-6 col-xs-12 status-k" style="display: none;">
                      <div class="form-group">
                        <label>Angsuran</label>
                        <input type="number" class="form-control float-right input-k" name="postPurchaseInstallment" id="input-p-installment" required="" disabled>
                        <small id="error-p-installment" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      </div>
                    </div>

                    <!-- Form-part input tempo -->
                    <div class="col-md-6 col-sm-6 col-xs-12 status-k" style="display: none;">
                      <div class="form-group">
                        <label>Tempo selanjutnya</label>
                        <input type="date" class="form-control float-right input-k" name="postPurchaseDue" id="input-p-due" value="" required="" disabled>
                        <small id="error-p-due" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      </div>
                    </div>

                    <!-- Form-part input Metode pembayaran -->
                    <div class="col-md-5 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label>Metode Bayar</label>
                        <select class="form-control float-right" name="postPurchaseMethod" id="input-method">
                          <option value=""> -- Pilih Metode -- </option>
                          <option value="TF"> Transfer </option>
                          <option value="TN"> Tunai </option>
                        </select>
                        <small id="error-p-method" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      </div>
                    </div>

                    <!-- Form-part input Rekening -- Jika metode transfer -->
                    <div class="col-md-7 col-sm-6 col-xs-12 method-tf" style="display: none;">
                      <div class="form-group">
                        <label>Rekening</label>
                        <select class="form-control float-right" name="postPurchaseAccount" id="input-p-account" required="" disabled>
                          <option value=""> -- Pilih Rekening -- </option>
                          <?php foreach($optAcc->result_array() as $showOpt): ?>
                            <option value="<?php echo urlencode(base64_encode($showOpt['acc_id'])) ?>"><?php echo $showOpt['bank_name'].' - '.$showOpt['acc_number'].' a/n '.$showOpt['acc_name'] ?></option>
                          <?php endforeach; ?>
                        </select>
                        <small id="error-p-account" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      </div>
                    </div>

                    <!-- Form-part input Pembayaran -->
                    <div class="col-md-12 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label>Pembayaran</label>
                        <input type="number" class="form-control float-right" step="0.01" name="postPurchasePayment" id="input-p-payment" placeholder="Pembayaran" required>
                        <small id="error-p-payment" class="error-msg" style="display:none; color:red; font-style: italic"></small>
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
                </div>
                <div class="card-footer">
                  <button type="reset" class="btn btn-sm btn-danger">Reset</button>
                  <button type="submit" class="btn btn-sm btn-info float-right">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->