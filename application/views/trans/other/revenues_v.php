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
              <li class="breadcrumb-item active">Pendapatan Lain</li>
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
                <h5 class="m-0 card-title">Daftar Transaksi Pendapatan Lain</h5>
                <a class="btn btn-sm btn-success float-right" data-toggle="modal" data-target="#modal-add-revenues"> <i class="fas fa-plus"></i> Tambah Transaksi</a>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                    <table id="table-transaction" class="table table-bordered table-striped">
                      <thead>
                        <th>Tanggal</th>
                        <th>No. Transaksi</th>
                        <th>Sumber Pendapatan</th>
                        <th>Metode</th>
                        <th>Total Bayar</th>
                        <th>Aksi</th>
                      </thead>
                      <tbody>
                      </tbody>
                      <tfoot>
                        <th>Tanggal</th>
                        <th>No. Transaksi</th>
                        <th>Sumber Pendapatan</th>
                        <th>Metode</th>
                        <th>Total Bayar</th>
                        <th>Aksi</th>
                      </tfoot>
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

    <!-- Modal -->
     <!-- Modal Tambah Revenues -->
      <div class="modal fade" id="modal-add-revenues">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Pengeluaran</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="<?php echo site_url('Transaction_c/addRevenuesProses') ?>" id="form-add-revenues" enctype="multipart/form-data">
              <div class="modal-body">
                <div class="row">
                    <!-- Form-part input tanggal transaksi -->
                    <div class="col-md-4 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label>Tgl Transaksi</label>
                        <input type="date" class="form-control" name="postRDate" id="input-r-date" required>
                        <small id="error-r-date" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      </div>
                    </div>

                    <!-- Form-part input sumber pemasukan transaksi -->
                    <div class="col-md-8 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label>Sumber pemasukan</label>
                        <input type="text" class="form-control" name="postRIncomeSource" id="input-r-source" required>
                        <small id="error-r-source" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      </div>
                    </div>

                    <!-- Form-part input Biaya -->
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label>Biaya</label>
                        <input type="number" class="form-control" min="0" step="0.01" name="postRPayment" id="input-r-payment" required>
                        <small id="error-r-payment" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      </div>
                    </div>

                    <!-- Form-part input metode bayar -->
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label>Metode pembayaran</label>
                        <select class="form-control float-right" name="postMethod" id="input-method" required>
                          <option value=""> -- Pilih Metode -- </option>
                          <option value="TF"> Transfer </option>
                          <option value="TN"> Tunai </option>
                        </select>
                        <small id="error-r-method" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      </div>
                    </div>

                    <!-- Form-part input Rekening -- Jika metode transfer -->
                    <div class="col-md-6 col-sm-6 col-xs-12 method-tf" style="display: none;">
                      <div class="form-group">
                        <label>Rekening</label>
                        <select class="form-control float-right" name="postAccount" id="input-account" required="" disabled>
                          <option value=""> -- Pilih Rekening -- </option>
                          <?php foreach($optAcc->result_array() as $showOpt): ?>
                            <option value="<?php echo urlencode(base64_encode($showOpt['acc_id'])) ?>"><?php echo $showOpt['bank_name'].' - '.$showOpt['acc_number'].' a/n '.$showOpt['acc_name'] ?></option>
                          <?php endforeach; ?>
                        </select>
                        <small id="error-p-account" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      </div>
                    </div>

                    <!-- Form-part Post script -->
                    <div class="col-md-12 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="postRPS" class="form-control" cols="30" rows="4"></textarea>
                      </div>
                    </div>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" id="submitctgr" class="btn btn-primary">Simpan</button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>