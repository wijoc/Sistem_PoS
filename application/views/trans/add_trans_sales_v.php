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
          <div class="col-lg-12">
            <div class="card card-orange card-outline">
              <div class="card-header">
                <h5 class="m-0">Form transaksi pembelian</h5>
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
                          <input type="text" class="form-control" name="postNamaPrd" id="inputNamaPrd" placeholder="Nama / barcode product">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-6">
                        <div class="form-group">
                          <label>Jumlah</label>
                          <input type="text" class="form-control" name="postJumlahPrd" id="inputJumlahPrd" onkeyup="totalBayar('sales')" placeholder="Enter ...">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-6">
                        <div class="form-group">
                          <label>Harga Beli Satuan</label>
                          <input type="text" class="form-control" name="postHargaPrd" id="inputHargaPrd" placeholder="Harga satuan...">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-6">
                        <div class="form-group">
                          <label>Potongan</label>
                          <input type="text" class="form-control" name="postPotonganPrd" id="inputPotonganPrd" value="0" onkeyup="totalBayar('sales')" placeholder="Potongan harga...">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-6">
                        <div class="form-group">
                          <label>Total</label>
                          <input type="text" class="form-control" name="postTotalPrd" id="inputTotalPrd" placeholder="Harga total" readonly>
                        </div>
                      </div>
                      <div class="col-md-1 col-sm-6">
                        <div class="form-group">
                          <label> &nbsp; </label>
                          <input type="submit" class="form-control btn btn-sm btn-success" value="Tambah">
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
                            <td><?php echo $row['prd_nama']; ?></td>
                            <td><?php echo $row['temps_product_amount'] ?></td>
                            <td><?php echo $row['temps_sale_price'] ?></td>
                            <td><?php echo $row['temps_discount'] ?></td>
                            <td><?php echo $row['temps_total_paid'] ?></td>
                            <td>
                              <a href=""><i class="fas fa-trash"></i></a>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                          <th colspan="4" class="text-right">Total : </th>
                          <th><?php echo $totalBayar ?></th>
                          <th>&nbsp;</th>
                        </tfoot>
                      </table>
                    </div>            
                </form>

                <!-- Form Transaksi -->
                <form class="form-horizontal" method="POST" action="<?php echo site_url('Transaksi_c/addSalesProses') ?>">

                  <!-- Form-part input Kode Transaksi : Otomatis -->
                    <div class="form-group row">
                      <label for="inputTransKode" class="col-sm-3 col-form-label">Kode Transaksi <a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control float-right" name="postTransKode" id="inputTransKode" value="<?php echo $nextTransCode ?>" placeholder="Kode transaksi terisi otomatis oleh sistem" required readonly>
                      </div>
                    </div>

                  <!-- Form-part input tanggal transaksi -->
                    <div class="form-group row">
                      <label for="inputTransTgl" class="col-sm-3 col-form-label">Tanggal Transaksi<a class="float-right"> : </a></label>
                      <div class="col-sm-3">
                        <input type="date" class="form-control float-right" name="postTransTgl" id="inputTransTgl" required>
                      </div>
                    </div>

                  <!-- Form-part input supplier -->
                    <div class="form-group row">
                      <label for="inputTransSupp" class="col-sm-3 col-form-label">Pembeli <a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <select class="form-control float-right" name="postTransSupp" id="inputTransSupp">
                          <option> -- Pilih Pembeli -- </option>
                          <?php foreach ($optMember as $showOpt): ?>
                            <option value="<?php echo $showOpt['member_id'] ?>"> <?php echo $showOpt['member_nama'] ?> </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                  <!-- Form-part input total harga beli -->
                    <div class="form-group row">
                      <label for="inputTransTotalBayar" class="col-sm-3 col-form-label">Total Pembelian <a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <input type="number" class="form-control float-right" step="0.01" name="postTransTotalBayar" id="inputTransTotalBayar" value="<?php echo $totalBayar ?>" readonly required>
                      </div>
                    </div>

                  <!-- Form-part input Metode Pembayaran -->
                    <div class="form-group row">
                      <label for="inputTransMetode" class="col-sm-3 col-form-label">Metode Pembayaran <a class="float-right"> : </a></label>
                      <div class="col-sm-5">
                        <select class="form-control float-right" name="postTransMetode" id="inputTransMetode">
                          <option> -- Pilih Metode -- </option>
                          <option value="TF"> Transfer </option>
                          <option value="TN"> Tunai </option>
                        </select>
                      </div>
                    </div>

                  <!-- Form-part input Rekening -->
                    <div class="form-group row" id="formpartRekening" style="display:none">
                      <label for="inputTransRek" class="col-sm-3 col-form-label">Rekening <a class="float-right"> : </a></label>
                      <div class="col-sm-5">
                        <select class="form-control float-right" name="postTransRek" id="inputTransRek" required>
                          <option> -- Pilih Rekening -- </option>
                          <?php foreach($optRek as $showOpt): ?>
                          <option value="<?php echo $showOpt['rek_id'] ?>"> <?php echo '['.$showOpt['bank_name'].'] '.$showOpt['rek_nomor'].' - '.$showOpt['rek_atas_nama'] ?> </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                  <!-- Form-part input Dibayar -->
                    <div class="form-group row">
                      <label for="inputTransPembayaran" class="col-sm-3 col-form-label">Pembayaran Pertama <a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <input type="number" class="form-control float-right" step="0.01" name="postTransPembayaran" id="inputTransPembayaran" onkeyup="hitungPayment()" placeholder="Pembayaran pertama" required>
                      </div>
                    </div>

                  <!-- Form-part input Kurang -->
                    <div class="form-group row">
                      <label for="inputTransKurang" class="col-sm-3 col-form-label">Kurangan <a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <input type="number" class="form-control float-right" name="postTransKurang" id="inputTransKurang" readonly required>
                      </div>
                    </div>

                  <!-- Form-part input Status Pembayaran -->
                    <div class="form-group row">
                      <label for="inputTransStatus" class="col-sm-3 col-form-label">Status Pembayaran <a class="float-right"> : </a></label>
                      <div class="col-sm-5">
                        <select class="form-control float-right" name="postTransStatus" id="inputTransStatus" readonly>
                          <option> -- Pilih Status -- </option>
                          <option value="L"> Lunas </option>
                          <option value="BL"> Belum Lunas </option>
                        </select>
                      </div>
                    </div>

                  <!-- Form-part input Tenor -->
                    <div class="form-group row">
                      <label for="inputTransTenor" class="col-sm-3 col-form-label">Tenor <a class="float-right"> : </a></label>
                      <div class="col-sm-3">  
                        <div class="input-group sm-3">
                            <input type="number" class="form-control tenortempo" name="postTransTenor" id="inputTransTenor" min="0" required="" disabled>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-times"></i></span>
                            </div>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <select class="form-control float-right tenortempo" name="postTransTenorPeriode" id="inputTransTenorPeriode" required="" disabled>
                          <option value="D">Harian</option>
                          <option value="W">Mingguan</option>
                          <option value="M">Bulanan</option>
                          <option value="Y">Tahunan</option>
                        </select>
                      </div>
                    </div>

                  <!-- Form-part input Tempo -->
                    <div class="form-group row">
                      <label for="inputTransTempo" class="col-sm-3 col-form-label"> Tempo selanjutnya <a class="float-right"> : </a></label>
                      <div class="col-sm-3">
                        <input type="date" class="form-control float-right tenortempo" name="postTransTempo" id="inputTransTempo" value="" required="" disabled>
                      </div>
                    </div>

                  <!-- Form Submit Button -->
                  <div class="float-right">
                    <button type="reset" class="btn btn-secondary"><b> Reset </b></button>
                    <button type="submit" class="btn btn-success"><b> Simpan </b></button>
                  </div>

                </form>
                </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    <?php print("<pre>".print_r($daftarPrd, true)."</pre>") ?>