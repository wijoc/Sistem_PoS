    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Halaman Transaksi Pendapatan Lain</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('Page_c') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo site_url('Transaksi_c') ?>"><i class="fas fa-cubes"></i> Transaksi</a></li>
              <li class="breadcrumb-item active">Tambah Pendapatan</li>
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
                <h5 class="m-0">Form Tambah Pendapatan</h5>
              </div>
              <div class="card-body">
                <div id="alert-trans"></div>

                <!-- Form Transaksi -->
                <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="<?php echo site_url('Transaksi_c/addRevenuesProses') ?>">

                  <!-- Form-part input Kode Transaksi : Otomatis -->
                    <div class="form-group row">
                      <label for="inputTransKode" class="col-sm-3 col-form-label">Kode Transaksi <a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control float-right" name="postTransKode" id="inputTransKode" value="<?php echo $nextTransCode ?>" placeholder="Kode transaksi terisi otomatis oleh sistem" required readonly>
                      </div>
                    </div>

                  <!-- Form-part input Asal pendapatan -->
                    <div class="form-group row">
                      <label for="inputTransSumber" class="col-sm-3 col-form-label">Asal Pendapatan <font color="red" style="font-weight: italic">*</font><a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control float-right" name="postTransSumber" id="inputTransSumber" placeholder="Asal pemasukan" required>
                      </div>
                    </div>

                  <!-- Form-part input tanggal transaksi -->
                    <div class="form-group row">
                      <label for="inputTransTgl" class="col-sm-3 col-form-label">Tanggal Transaksi <font color="red" style="font-weight: italic">*</font><a class="float-right"> : </a></label>
                      <div class="col-sm-3">
                        <input type="date" class="form-control float-right" name="postTransTgl" id="inputTransTgl" required>
                      </div>
                    </div>

                  <!-- Form-part input Metode Pembayaran -->
                    <div class="form-group row">
                      <label for="inputTransMetode" class="col-sm-3 col-form-label">Metode Pembayaran <font color="red" style="font-weight: italic">*</font><a class="float-right"> : </a></label>
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
                      <label for="inputTransRek" class="col-sm-3 col-form-label">Rekening <font color="red" style="font-weight: italic">*</font><a class="float-right"> : </a></label>
                      <div class="col-sm-5">
                        <select class="form-control float-right" name="postTransRek" id="inputTransRek" required>
                          <option value="0"> -- Pilih Rekening -- </option>
                          <?php foreach($optRek as $showOpt): ?>
                          <option value="<?php echo $showOpt['rek_id'] ?>"> <?php echo '['.$showOpt['bank_name'].'] '.$showOpt['rek_nomor'].' - '.$showOpt['rek_atas_nama'] ?> </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                  <!-- Form-part input total Pendapatan -->
                    <div class="form-group row">
                      <label for="inputTransTotalBayar" class="col-sm-3 col-form-label">Total Pendapatan <font color="red" style="font-weight: italic">*</font><a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                        <input type="number" class="form-control float-right" step="0.01" name="postTransTotalBayar" id="inputTransTotalBayar" required>
                      </div>
                    </div>

                  <!-- Form-part input Keterangan -->
                    <div class="form-group row">
                      <label for="inputTransTotalBayar" class="col-sm-3 col-form-label">Keterangan  <a class="float-right"> : </a></label>
                      <div class="col-sm-8">
                      	<textarea class="form-control" rows="3" name="postTransNote" id="inputTransNote"></textarea>
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