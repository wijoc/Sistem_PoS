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
              <li class="breadcrumb-item"><a href="<?php echo site_url('Transaksi_c') ?>"><i class="fas fa-cubes"></i> Transaksi</a></li>
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
          <div class="col-lg-10">
            <div class="card card-orange card-outline">
              <div class="card-header">
                <h5 class="m-0">Form transaksi pembelian</h5>
              </div>
              <form class="form-horizontal" method="POST" action="<?php echo site_url('Transaksi_c/addBuyingProses') ?>">
                <div class="card-body">

                  <!-- Form-part input Kode Transaksi : Otomatis -->
                    <div class="form-group row">
                      <label for="inputTransKode" class="col-sm-3 col-form-label">Kode Transaksi <a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control float-right" name="postTransKode" id="inputTransKode" value="" placeholder="Kode transaksi terisi otomatis oleh sistem" required readonly>
                      </div>
                    </div>

                  <!-- Form-part input tanggal transaksi -->
                    <div class="form-group row">
                      <label for="inputTransTgl" class="col-sm-3 col-form-label">Tanggal Transaksi<a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <input type="date" class="form-control float-right" name="postTransTgl" id="inputTransTgl" required>
                      </div>
                    </div>

                  <!-- Form-part input supplier -->
                    <div class="form-group row">
                      <label for="inputTransSupp" class="col-sm-3 col-form-label">Supplier <a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <select class="form-control float-right" name="postTransSupp" id="inputTransSupp">
                          <option> -- Pilih Supplier -- </option>
                          <?php foreach ($optSupp as $showOpt): ?>
                            <option value="<?php echo $showOpt['supp_id'] ?>"> <?php echo $showOpt['supp_nama_supplier'] ?> </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                  <!-- Form-part input total harga beli -->
                    <div class="form-group row">
                      <label for="inputTransBeli" class="col-sm-3 col-form-label">Total Pembelian <a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <input type="number" class="form-control float-right" step="0.01" name="postTransBeli" id="inputTransBeli" placeholder="Harga Total Pembelian" required>
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
                    <div class="form-group row">
                      <label for="inputTransRek" class="col-sm-3 col-form-label">Rekening <a class="float-right"> : </a></label>
                      <div class="col-sm-5">
                        <select class="form-control float-right" name="postTransRek" id="inputTransRek">
                          <option> -- Pilih Rekening -- </option>
                          <option value="TF"> AMBIL REKENING DARI DB </option>
                        </select>
                      </div>
                    </div>

                  <!-- Form-part input Dibayar -->
                    <div class="form-group row">
                      <label for="inputTransBayar" class="col-sm-3 col-form-label">Dibayar <a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <input type="number" class="form-control float-right" step="0.01" name="postTransBayar" id="inputTransBayar" placeholder="Pembayaran pertama" required>
                      </div>
                    </div>

                  <!-- Form-part input Kurang -->
                    <div class="form-group row">
                      <label for="inputTransKurang" class="col-sm-3 col-form-label">Kurangan <a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <input type="number" class="form-control float-right" name="postTransKurang" id="inputTransKurang" placeholder="Kurangan dari Pembayaran" required>
                      </div>
                    </div>

                  <!-- Form-part input Status Pembayaran -->
                    <div class="form-group row">
                      <label for="inputTransStatus" class="col-sm-3 col-form-label">Status Pembayaran <a class="float-right"> : </a></label>
                      <div class="col-sm-5">
                        <select class="form-control float-right" name="postTransStatus" id="inputTransStatus">
                          <option> -- Pilih Status -- </option>
                          <option value="L"> Lunas </option>
                          <option value="BL"> Belum Lunas </option>
                        </select>
                      </div>
                    </div>

                  <!-- Form-part input Tenor -->
                    <div class="form-group row">
                      <label for="inputTransTenor" class="col-sm-3 col-form-label">Tenor <a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <input type="number" class="form-control float-right" name="postTransTenor" id="inputTransTenor" placeholder="Kurangan dari Pembayaran" required>
                      </div>
                    </div>

                  <!-- Form-part input Tempo -->
                    <div class="form-group row">
                      <label for="inputTransTempo" class="col-sm-3 col-form-label">Jatuh Tempo <a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <select class="form-control float-right" name="postTransTempo" id="inputTransTempo">
                          <?php for ($i=1; $i <= 31; $i++) { ?> 
                            <option value="<?php echo $i ?>"><?php echo 'Tanggal '.$i ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>

                </div>
                <div class="card-footer">
                  <div class="float-right">
                    <button type="reset" class="btn btn-secondary"><b> Reset </b></button>
                    <button type="submit" class="btn btn-success"><b> Simpan </b></button>
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