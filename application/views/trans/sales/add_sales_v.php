    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark text-uppercase">Tambah Transaksi Penjualan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('Page_c') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo site_url('Transaksi_c') ?>"><i class="fas fa-cubes"></i> Transaksi</a></li>
              <li class="breadcrumb-item active">Tambah Penjualan</li>
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
                <h5 class="m-0 text-uppercase">Keranjang</h5>
              </div>
              <div class="card-body">
                <form action="<?php echo site_url('Transaction_c/addCart/Sales/') ?>" id="form-cart">
                  <div class="row">
                    <div class="col-md-4 col-sm-6">
                      <div class="form-group">
                        <label>Product</label>
                        <input type="hidden" name="postIdPrd" readonly>
                        <input type="text" class="form-control" id="input-cart-prd" placeholder="Nama / barcode product">
                      </div>
                    </div>
                    <div class="col-md-2 col-sm-6">
                      <div class="form-group">
                        <label>Qty</label>
                        <input type="number" class="form-control" name="postCartQty" id="input-cart-qty" onkeyup="totalPrice()" placeholder="Qty">
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                      <div class="form-group">
                        <label>Harga</label>
                        <input type="number" min="0" step="0.01" class="form-control" name="postCartPrice" id="input-cart-price" placeholder="Harga satuan">
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                      <div class="form-group">
                        <label>Potongan</label>
                        <input type="number" min="0" step="0.01" class="form-control" name="postCartDiscount" id="input-cart-discount" placeholder="Potongan">
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
                        <th>Disc</th>
                        <th>Total</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                      <th colspan="4" class="text-right">Total</th>
                      <th id="total-payment" class="text-right">0</th>
                      <th></th>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <!-- Form detail trans -->
          <div class="col-lg-6">
            <div class="card card-info card-outline">
              <div class="card-header">
                <h5 class="m-0 text-uppercase">Form Penjualan</h5>
              </div>
              <form method="POST" action="<?php echo site_url('Transaction_c/addSalesProses/') ?>" id="form-add-sales" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="row">
                    <!-- Hidden Form -->
                      <!-- Form-part input tag id customer -->
                      <input type="hidden" class="form-control" name="postSCtm" id="input-s-ctm-id" value="" readonly>
                      <!-- Form-part input Total Sales -->
                      <input type="hidden" class="form-control" name="postSTotalSale" id="input-s-total-sales" readonly>
                      <!-- Form-part total keranjang -->
                      <input type="hidden" class="form-control" name="postSTotalCart" id="total-cart" value="" disabled>

                    <!-- Form-part input tanggal transaksi -->
                    <div class="col-md-4 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label>Tgl Transaksi</label>
                        <input type="date" class="form-control" name="postSDate" id="input-s-date" required>
                        <small id="error-s-date" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      </div>
                    </div>

                    <!-- Form-part input customer -->
                    <div class="col-md-8 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label>Pelanggan</label>
                        <div class="input-group">
                          <input type="text" class="form-control" id="input-s-ctm-name" readonly>
                          <span class="input-group-append">
                            <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-pilih-pelanggan">Pilih Customer</button>
                          </span>
                        </div>
                        <small id="error-s-ctm" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      </div>
                    </div>

                    <!-- Form-part input Status Pembayaran -->
                    <div class="col-md-4 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label>Status Pembayaran</label>
                        <select class="form-control" name="postStatus" id="input-s-status" required>
                          <option value="T" selected="selected"> Lunas / Cash / Tunai </option>
                          <option value="K"> Kredit </option>
                        </select>
                        <small id="error-s-status" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      </div>
                    </div>

                    <!-- Form-part input Tenor -->
                    <div class="col-md-4 col-sm-6 col-xs-12 div-credit" style="display: none;">
                      <div class="form-group">
                        <label>Tenor</label>
                        <div class="input-group">
                          <div class="input-group sm-3">
                              <input type="number" class="form-control class-credit" name="postSTenor" id="input-s-tenor" onkeyup="countPayment()" min="0" required="" disabled>
                              <div class="input-group-append">
                                  <span class="input-group-text"><i class="fa fa-times"></i></span>
                              </div>
                          </div>
                        </div>
                        <small id="error-s-tenor" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12 div-credit" style="display: none;">
                      <div class="form-group">
                        <label> Periode Tenor </label>
                        <select class="form-control float-right class-credit" name="postSTenorPeriode" id="input-s-tenor-periode" onchange="countPayment()" required="" disabled>
                          <option value="D">Harian</option>
                          <option value="W">Mingguan</option>
                          <option value="M">Bulanan</option>
                          <option value="Y">Tahunan</option>
                        </select>
                        <small id="error-s-tenor-periode" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      </div>
                    </div>

                    <!-- Form-part input Tempo -->
                    <div class="col-md-6 col-sm-6 col-xs-12 div-credit" style="display: none;">
                      <div class="form-group">
                        <label>Tempo</label>
                        <input type="date" class="form-control float-right class-credit" name="postSDue" id="input-s-due" required="" disabled>
                        <small id="error-s-due" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      </div>
                    </div> 

                    <!-- Form-part input Angsuran -->
                    <div class="col-md-6 col-sm-6 col-xs-12 div-credit" style="display: none;">
                      <div class="form-group">
                        <label>Angsuran</label>
                        <input type="number" class="form-control float-right class-credit" onkeyup="countPayment()" name="postSInstallment" id="input-s-installment" required="" disabled>
                        <small id="error-s-installment" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      </div>
                    </div>

                    <!-- Form-part input customer -->
                    <div class="col-md-4 col-sm-6 col-xs-12" id="div-delivery">
                      <div class="form-group">
                        <label>Pengiriman</label>
                        <select class="form-control" name="postSDelivery" id="input-s-delivery">
                          <option value="N"> Tanpa jasa pengiriman </option>
                          <option value="T"> Pengiriman Toko </option>
                          <option value="E"> Ekspedisi </option>
                        </select>
                        <small id="error-s-delivery" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      </div>
                    </div>

                    <!-- Form-part input Ogkir -->
                    <div class="col-md-6 col-sm-6 col-xs-12" id="div-postal-fee" style="display: none;">
                      <div class="form-group">
                        <label>Ongkir</label>
                        <input type="number" class="form-control" min="0" step="0.01" name="postSPostalFee" id="input-s-fee" onkeyup="countTotalSale()" required="" disabled="">
                        <small id="error-s-fee" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      </div>
                    </div>

                    <!-- Form-part input Pembayaran -->
                    <div class="col-12">
                      <div class="form-group">
                        <label id="label-payment">Pembayaran</label>
                        <input type="number" class="form-control float-right" min="0" step="0.01" name="postSPayment" id="input-s-payment" onkeyup="countPayment()" placeholder="Pembayaran pertama" required>
                        <small id="error-s-payment" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      </div>
                    </div>

                    <!-- Form-part input Metode Pembayaran -->
                    <div class="col-md-5 col-sm-6 col-xs-12" id="div-method">
                      <div class="form-group">
                        <label>Metode Pembayaran</label>
                        <select class="form-control float-right" name="postMethod" id="input-method" required>
                          <option value=""> -- Pilih Metode -- </option>
                          <option value="TF"> Transfer </option>
                          <option value="TN"> Tunai </option>
                        </select>
                        <small id="error-s-method" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      </div>
                    </div>

                    <!-- Form-part input Rekening -->
                    <div class="col-md-7 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label>Rekening</label>
                        <select class="form-control float-right" name="postAccount" id="input-account" required disabled>
                          <option value=""> -- Pilih Rekening -- </option>
                          <?php foreach($optAcc->result_array() as $showOpt): ?>
                            <option value="<?php echo urlencode(base64_encode($showOpt['acc_id'])) ?>"><?php echo $showOpt['bank_name'].' - '.$showOpt['acc_number'].' a/n '.$showOpt['acc_name'] ?></option>
                          <?php endforeach; ?>
                        </select>
                        <small id="error-s-account" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      </div>
                    </div>

                  </div>
                  <div id="div-new-ctm" style="display: none">
                    <hr>
                    <!-- Form-part input Pelanggan nama -->
                    <div class="form-group row">
                      <label for="inputCtmNama" class="col-sm-4 col-form-label">Nama Pelanggan <font color="red">*</font> <a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <input type="text" class="class-new-ctm form-control float-right" name="postCtmName" placeholder="Nama Pelanggan" required disabled>
                      </div>
                    </div>

                    <!-- Form-part input Pelanggan Telp -->
                    <div class="form-group row">
                      <label for="inputCtmTelp" class="col-sm-4 col-form-label">No. Telphone <a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <input type="text" class="class-new-ctm form-control float-right" name="postCtmPhone" placeholder="Nomor telepone pelanggan" disabled>
                      </div>
                    </div>

                    <!-- Form-part input Pelanggan Email -->
                    <div class="form-group row">
                      <label for="inputCtmEmail" class="col-sm-4 col-form-label">E - mail <a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <input type="email" class="class-new-ctm form-control float-right" name="postCtmEmail" placeholder="Alamat E - mail" disabled>
                      </div>
                    </div>

                    <!-- Form-part input Pelanggan Alamat -->
                    <div class="form-group row">
                      <label for="inputCtmEmail" class="col-sm-4 col-form-label">Alamat <a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <textarea class="class-new-ctm form-control" name="postCtmAddress" rows="3" disabled></textarea>
                      </div>
                    </div>
                  </div>
                  <div id="divInfoBox">
                    <hr>
                    <div class="info-box mb-3">
                      <span class="info-box-icon bg-success"><i class="fas fa-shopping-basket"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">Total</span>
                        <span class="info-box-number float-right"><h2 style="font-weight: bold">Rp. <span id="note-total"></span></h2></span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                    <div class="info-box mb-3">
                      <span class="info-box-icon bg-warning"><i class="fas fa-cash-register"></i></span>

                      <div class="info-box-content" id="info-cash">
                        <span class="info-box-text" id="label-change">Kembalian</span>
                        <span class="info-box-number float-right"><h2 style="font-weight: bold">Rp. <span id="note-change">0,00</span></h2></span>
                      </div>
                      <div class="info-box-content row div-credit" id="info-credit" style="display: none">
                        <div class="info-box-content col-12">
                          <span class="info-box-text">Uang muka</span>
                          <span class="info-box-number float-right">
                            <h2 style="font-weight: bold">
                                Rp. <span id="note-dp">0,00</span>
                            </h2>
                          </span>
                        </div>
                        <div class="col-12 ">
                          <span class="float-right">
                            <font style="font-weight: bold;" color="red">
                              <span id="note-tenor"></span>
                              , Angsuran : Rp. <span id="note-installment">0,00</span>
                            </font>
                          </span>
                        </div>
                      </div>
                      <!-- /.info-box-content -->
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

    <!-- Modal -->
      <!-- Modal Tambah Pelanggan -->
      <div class="modal fade" id="modal-pilih-pelanggan">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Pilih Pelanggan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="container row">
                <div class="col-xs-12 col-lg-12" style="margin-bottom: 10px;">
                  <div class="input-group input-group-sm">
                    <input class="form-control" type="search" onkeyup="ctmSearch()" placeholder="Search" aria-label="Search" id="ctm-search">
                    <div class="input-group-append">
                      <button class="btn btn-info" type="submit">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="container row" id="static-choice">
                  <div class="col-lg-6">
                    <button class="btn btn-block btn-flat btn-outline-info" data-dismiss="modal" style="margin: 5px;" onclick="ctmSelected('nctm')" value="nctm"><font style="font-weight: bold">Pelanggan Baru</font></button>
                  </div>
                  <div class="col-lg-6">
                    <button class="btn btn-block btn-flat btn-outline-info" data-dismiss="modal" style="margin: 5px;" onclick="ctmSelected('0000')" value="gctm"><font style="font-weight: bold">Pelanggan Umum</font></button>
                  </div>
                  <?php foreach ($optCtm as $row) : ?>
                    <div class="col-lg-6">
                      <button class="btn btn-block btn-flat btn-outline-info" data-dismiss="modal" style="margin: 5px;" onclick="ctmSelected('<?php echo urlencode(base64_encode($row['ctm_id'])) ?>')" value="<?php echo urlencode(base64_encode($row['ctm_id'])) ?>"><font style="font-weight: bold"><?php echo $row['ctm_name'] ?></font></button>
                    </div>
                  <?php endforeach ?>
                </div>
                <div class="container row" id="ctm-data">
                  <!-- ajax search customer option -->
                </div>
              </div>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>