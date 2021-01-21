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
          <!-- Shopping Chart -->
          <div class="col-12">
            <div class="card card-orange card-outline">
              <div class="card-header">
                <h5 class="m-0">Keranjang belanja</h5>
              </div>
              <div class="card-body">
                <div id="alert-trans"></div>
                <!-- Form daftar barang -->
                <form method="POST" action="<?php echo site_url('Transaksi_c/addTransProduct/Sales') ?>">
                  <!-- Autocomplete product -->
                    <div class="row">
                      <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                          <label>Product</label>
                          <input type="hidden" name="postIdPrd">
                          <input type="text" class="form-control form-control-sm" name="postNamaPrd" id="inputNamaPrd" placeholder="Nama / barcode product">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-6">
                        <div class="form-group">
                          <label>Jumlah</label>
                          <input type="text" class="form-control form-control-sm" name="postJumlahPrd" id="inputJumlahPrd" onkeyup="totalBayar('sales')" placeholder="Enter ...">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-6">
                        <div class="form-group">
                          <label>Harga Beli Satuan</label>
                          <input type="text" class="form-control form-control-sm" name="postHargaPrd" id="inputHargaPrd" placeholder="Harga satuan...">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-6">
                        <div class="form-group">
                          <label>Potongan</label>
                          <input type="text" class="form-control form-control-sm" name="postPotonganPrd" id="inputPotonganPrd" value="0" onkeyup="totalBayar('sales')" placeholder="Potongan harga...">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-6">
                        <div class="form-group">
                          <label>Total</label>
                          <input type="text" class="form-control form-control-sm" name="postTotalPrd" id="inputTotalPrd" placeholder="Harga total" readonly>
                        </div>
                      </div>
                      <div class="col-md-1 col-sm-6">
                        <div class="form-group">
                          <label> &nbsp; </label>
                          <input type="submit" class="form-control form-control-sm btn btn-sm btn-success" value="Tambah">
                        </div>
                      </div> 
                    </div>
                  <!-- Table tampilkan product yang dipilih -->
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <thead>
                          <th>No.</th>
                          <th>Product</th>
                          <th>Jumlah</th>
                          <th>Harga satuan</th>
                          <th>Potongan</th>
                          <th>Total</th>
                          <th>Aksi</th>
                        </thead>
                        <tbody>
                          <?php 
                          $no = 1;
                          $totalBayar = 0; 
                          foreach ($daftarPrd as $row): 
                            $totalBayar += $row['temps_total_paid'];
                          ?>
                          <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $row['prd_name']; ?></td>
                            <td><?php echo $row['temps_product_amount'] ?></td>
                            <td><?php echo $row['temps_sale_price'] ?></td>
                            <td><?php echo $row['temps_discount'] ?></td>
                            <td><?php echo $row['temps_total_paid'] ?></td>
                            <td>
                              <a href="<?php echo site_url('Transaksi_c/deleteTransProduct/Sales') ?>/<?php echo urlencode(base64_encode($row['temps_product_fk'])) ?>" class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></a>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                          <th colspan="5" class="text-right">Total : </th>
                          <th><?php echo $totalBayar ?></th>
                          <th>&nbsp;</th>
                        </tfoot>
                      </table>
                    </div>            
                </form>
              </div>
            </div>
          </div>

          <!-- Trans Detail -->
          <div class="col-12">
            <div class="card card-orange card-outline">
              <div class="card-header">
                <h5 class="m-0">No. Transaksi : <b><?php echo $nextTransCode ?></b></h5>
              </div>
              <!-- Form Transaksi -->
              <form class="form-horizontal" method="POST" action="<?php echo site_url('Transaksi_c/addSalesProses') ?>">
                <div class="card-body row">

                  <div class="col-lg-7 col-md-12">

                    <div class="row">
                      <!-- Hidden Form -->
                       <!-- Form-part input Kode Transaksi : Otomatis -->
                        <input type="hidden" class="form-control float-right" name="postTransKode" id="inputTransKode" value="<?php echo $nextTransCode ?>" placeholder="Kode transaksi terisi otomatis oleh sistem" required readonly>
                       <!-- Form-part input tag id customer -->
                        <input type="hidden" class="form-control float-right" name="postTransCtm" id="inputTransCtm" value="0000" readonly>
                       <!-- Form-part input Total Sales -->
                        <input type="hidden" class="form-control float-right" name="postTransTotalBayar" id="inputTransTotalBayar" readonly>
                       <!-- Form-part total keranjang -->
                        <input type="hidden" name="postTransTotalPrd" id="totalBayar" value="<?php echo $totalBayar ?>" disabled>

                      <!-- Form-part input tanggal transaksi -->
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <div class="form-group">
                            <label>Tgl Transaksi</label>
                            <input type="date" class="form-control" name="postTransTgl" id="inputTransTgl" required>
                          </div>
                        </div>

                      <!-- Form-part input customer -->
                        <div class="col-md-8 col-sm-6 col-xs-12">
                          <div class="form-group">
                            <label>Pelanggan</label>
                            <div class="input-group">
                              <input type="text" class="form-control" id="inputCtmName" readonly>
                              <span class="input-group-append">
                                <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-pilih-pelanggan">Pilih Customer</button>
                              </span>
                            </div>
                          </div>
                        </div>

                      <!-- Form-part input customer -->
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <div class="form-group">
                            <label>Pengiriman</label>
                            <select class="form-control" name="postTransDelivery" id="inputTransDelivery">
                              <option value="N"> Tanpa jasa pengiriman </option>
                              <option value="T"> Pengiriman Toko </option>
                              <option value="E"> Ekspedisi </option>
                            </select>
                          </div>
                        </div>

                      <!-- Form-part input Ogkir -->
                        <div class="col-md-4 col-sm-6 col-xs-12" id="divOngkir" style="display: none;">
                          <div class="form-group">
                            <label>Biaya kirim</label>
                            <input type="number" class="form-control" min="0" name="postTransOngkir" id="inputTransOngkir" onkeyup="countTotalSale()" required="" disabled="">
                          </div>
                        </div>

                      <!-- Form-part input Status Pembayaran -->
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <div class="form-group">
                            <label>Status Pembayaran</label>
                            <select class="form-control" name="postTransStatus" id="inputTransStatus" required>
                              <option value="T"> Lunas / Cash / Tunai </option>
                              <option value="K"> Kredit </option>
                            </select>
                          </div>
                        </div>

                      <!-- Form-part input Angsuran -->
                        <div class="col-md-4 col-sm-6 col-xs-12 divKredit" style="display: none;">
                          <div class="form-group">
                            <label>Angsuran</label>
                            <input type="number" class="form-control float-right inputKredit" onkeyup="countPayment()" name="postTransAngsuran" id="inputTransAngsuran" required="" disabled>
                          </div>
                        </div>

                      <!-- Form-part input Tenor -->
                        <div class="col-md-4 col-sm-6 col-xs-12 divKredit" style="display: none;">
                          <div class="form-group">
                            <label>Tenor</label>
                            <div class="input-group">
                              <div class="input-group sm-3">
                                  <input type="number" class="form-control inputKredit" name="postTransTenor" id="inputTransTenor" onkeyup="countPayment()" min="0" required="" disabled>
                                  <div class="input-group-append">
                                      <span class="input-group-text"><i class="fa fa-times"></i></span>
                                  </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12 divKredit" style="display: none;">
                          <div class="form-group">
                            <label> Periode Tenor </label>
                            <select class="form-control float-right inputKredit" name="postTransTenorPeriode" id="inputTransTenorPeriode" onchange="countPayment()" required="" disabled>
                              <option value="D">Harian</option>
                              <option value="W">Mingguan</option>
                              <option value="M">Bulanan</option>
                              <option value="Y">Tahunan</option>
                            </select>
                          </div>
                        </div>

                      <!-- Form-part input Tempo -->
                        <div class="col-md-4 col-sm-6 col-xs-12 divKredit" style="display: none;">
                          <div class="form-group">
                            <label>Tempo</label>
                            <input type="date" class="form-control float-right inputKredit" name="postTransTempo" id="inputTransTempo" required="" disabled>
                          </div>
                        </div>

                      <!-- Form-part input Metode Pembayaran -->
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <div class="form-group">
                            <label>Metode Pembayaran</label>
                            <select class="form-control float-right" name="postTransMetode" id="inputTransMetode" required>
                              <option> -- Pilih Metode -- </option>
                              <option value="TF"> Transfer </option>
                              <option value="TN"> Tunai </option>
                            </select>
                          </div>
                        </div>

                      <!-- Form-part input Rekening -->
                        <div class="col-md-4 col-sm-6 col-xs-12" id="formpartRekening" style="display: none;">
                          <div class="form-group">
                            <label>Rekening</label>
                            <select class="form-control float-right" name="postTransRek" id="inputTransRek" required>
                              <option> -- Pilih Rekening -- </option>
                              <?php foreach($optRek as $showOpt): ?>
                              <option value="<?php echo $showOpt['rek_id'] ?>"> <?php echo '['.$showOpt['bank_name'].'] '.$showOpt['rek_nomor'].' - '.$showOpt['rek_atas_nama'] ?> </option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                        </div>

                      <!-- Form-part input Pembayaran -->
                        <div class="col-12">
                          <div class="form-group">
                            <label id="labelPayment">Pembayaran</label>
                            <input type="number" class="form-control float-right" min="0" step="0.01" name="postTransPembayaran" id="inputTransPembayaran" onkeypress="preventNonNumericalInput(event)" onkeyup="countPayment()" placeholder="Pembayaran pertama" required>
                          </div>
                        </div>
                    </div>
                    <div id="divNewCtm" style="display: none">
                      <hr>
                      <!-- Form-part input Pelanggan nama -->
                        <div class="form-group row">
                          <label for="inputCtmNama" class="col-sm-4 col-form-label">Nama Pelanggan <font color="red">*</font> <a class="float-right"> : </a></label>
                          <div class="col-sm-8">
                            <input type="text" class="inputNewCtm form-control float-right" name="postCtmNama" placeholder="Nama Pelanggan" required disabled>
                          </div>
                        </div>

                      <!-- Form-part input Pelanggan Telp -->
                        <div class="form-group row">
                          <label for="inputCtmTelp" class="col-sm-4 col-form-label">No. Telphone <a class="float-right"> : </a></label>
                          <div class="col-sm-8">
                            <input type="text" class="inputNewCtm form-control float-right" name="postCtmTelp" placeholder="Nomor telepone pelanggan" disabled>
                          </div>
                        </div>

                      <!-- Form-part input Pelanggan Email -->
                        <div class="form-group row">
                          <label for="inputCtmEmail" class="col-sm-4 col-form-label">E - mail <a class="float-right"> : </a></label>
                          <div class="col-sm-8">
                            <input type="email" class="inputNewCtm form-control float-right" name="postCtmEmail" placeholder="Alamat E - mail" disabled>
                          </div>
                        </div>

                      <!-- Form-part input Pelanggan Alamat -->
                        <div class="form-group row">
                          <label for="inputCtmEmail" class="col-sm-4 col-form-label">Alamat <a class="float-right"> : </a></label>
                          <div class="col-sm-8">
                            <textarea class="inputNewCtm form-control" name="postCtmAddress" rows="3" disabled></textarea>
                          </div>
                        </div>
                    </div>
                    
                  </div>
                  <div class="col-lg-5 col-md-12 col-sm-12">
                    <hr>
                    <div class="info-box mb-3">
                      <span class="info-box-icon bg-success"><i class="fas fa-shopping-basket"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">Total</span>
                        <span class="info-box-number float-right"><h2 style="font-weight: bold">Rp. <span id="notaTotal"></span></h2></span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                    <div class="info-box mb-3">
                      <span class="info-box-icon bg-warning"><i class="fas fa-cash-register"></i></span>

                      <div class="info-box-content" id="infoCash">
                        <span class="info-box-text" id="labelChange">Kembalian</span>
                        <span class="info-box-number float-right"><h2 style="font-weight: bold">Rp. <span id="notaChange">0,00</span></h2></span>
                      </div>
                      <div class="info-box-content row divKredit" id="infoKredit" style="display: none">
                        <div class="info-box-content col-12">
                          <span class="info-box-text">Uang muka</span>
                          <span class="info-box-number float-right">
                            <h2 style="font-weight: bold">
                                Rp. <span id="notaDP">0,00</span>
                            </h2>
                          </span>
                        </div>
                        <div class="col-12 ">
                          <span class="float-right">
                            <font style="font-weight: bold;" color="red">
                              <span id="notaTenor"></span>
                              , Angsuran : Rp. <span id="notaInstallment">0,00</span>
                            </font>
                          </span>
                        </div>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                    <!-- / -->
                  </div>

                </div>
                <div class="card-footer">
                  <button type="submit" class="col-12 btn btn-primary">Simpan</button>
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
                <div class="container row" id="staticChoice">
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