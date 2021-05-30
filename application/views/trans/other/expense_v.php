    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Tambah Transaksi Pengeluaran</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('Page_c') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo site_url('Transaction_c') ?>"><i class="fas fa-cubes"></i> Transaksi</a></li>
              <li class="breadcrumb-item active">Pengeluaran</li>
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
                <h5 class="m-0 card-title">Daftar Transaksi Pengeluaran</h5>
                <a class="btn btn-sm btn-success float-right" data-toggle="modal" data-target="#modal-add-expenses"> <i class="fas fa-plus"></i> Tambah Transaksi</a>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                    <table id="table-transaction" class="table table-bordered table-striped">
                      <thead>
                        <th>Tanggal</th>
                        <th>Keperluan</th>
                        <th>Nota</th>
                        <th>Metode</th>
                        <th>Total Bayar</th>
                        <th>Aksi</th>
                      </thead>
                      <tbody>
                      </tbody>
                      <tfoot>
                        <th>Tanggal</th>
                        <th>Keperluan</th>
                        <th>Nota</th>
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
     <!-- Modal Tambah Expenses -->
      <div class="modal fade" id="modal-add-expenses">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Pengeluaran</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="<?php echo site_url('Transaction_c/addExpensesProses') ?>" id="form-add-expenses" enctype="multipart/form-data">
              <div class="modal-body">
                <div class="row">
                    <!-- Form-part input tanggal transaksi -->
                    <div class="col-md-4 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label>Tgl Transaksi</label>
                        <input type="date" class="form-control" name="postEDate" id="input-e-date" required>
                        <small id="error-e-date" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      </div>
                    </div>

                    <!-- Form-part input keperluan transaksi -->
                    <div class="col-md-8 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label>Keperluan</label>
                        <input type="text" class="form-control" name="postENecessity" id="input-e-necessity" required>
                        <small id="error-e-necessity" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      </div>
                    </div>

                    <!-- Form-part input No nota -->
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label>Nomor Nota</label>
                        <input type="text" class="form-control" name="postENote" id="input-e-note" required>
                        <small id="error-e-note" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                      </div>
                    </div>

                    <!-- Form-part input file nota -->
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label>File Nota</label>
                        <div class="custom-file">
                          <input type="file" class="form-control float-right custom-file-input" name="postNoteFile" id="input-e-file" required>
                          <label class="custom-file-label" for="input-file-invoice"><p>Pilih file Nota</p></label>
                          <small id="error-e-file" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                        </div>
                      </div>
                    </div>

                    <!-- Form-part input Biaya -->
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label>Biaya</label>
                        <input type="number" class="form-control" min="0" step="0.01" name="postEPayment" id="input-e-payment" required>
                        <small id="error-e-payment" class="error-msg" style="display:none; color:red; font-style: italic"></small>
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
                        <small id="error-e-method" class="error-msg" style="display:none; color:red; font-style: italic"></small>
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

    <!-- Modal detail Expenses -->
      <div class="modal fade" id="modal-detail-expenses">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Pengeluaran - No. Nota : <span class="font-weight-bold" id="det-note"></span></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group row">
                <label for="det-date" class="col-md-4 col-sm-12 col-form-label">Tanggal <font class="float-right">:</font></label>
                <div class="col-md-8 col-sm-12">
                  <span id="det-date"></span>
                </div>
              </div>
              <div class="form-group row">
                <label for="det-necessity" class="col-md-4 col-sm-12 col-form-label">Keperluan <font class="float-right">:</font></label>
                <div class="col-md-8 col-sm-12">
                  <span id="det-necessity"></span>
                </div>
              </div>
              <div class="form-group row">
                <label for="det-note-file" class="col-md-4 col-sm-12 col-form-label">File Nota <font class="float-right">:</font></label>
                <div class="col-md-8 col-sm-12">
                  <span id="det-note-file"></span>
                </div>
              </div>
              <div class="form-group row">
                <label for="det-method" class="col-md-4 col-sm-12 col-form-label">Metode Pembayaran <font class="float-right">:</font></label>
                <div class="col-md-8 col-sm-12">
                  <span id="det-method"></span>
                </div>
              </div>
              <div class="form-group row" id="div-acc">
                <label for="det-account" class="col-md-4 col-sm-12 col-form-label">Rekening <font class="float-right">:</font></label>
                <div class="col-md-8 col-sm-12">
                  <span id="det-account"></span>
                </div>
              </div>
              <div class="form-group row">
                <label for="det-expense" class="col-md-4 col-sm-12 col-form-label">Total pengeluaran <font class="float-right">:</font></label>
                <div class="col-md-8 col-sm-12">
                  <span><font class="font-weight-bold" color="green" id="det-expense"></font></span>
                </div>
              </div>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>