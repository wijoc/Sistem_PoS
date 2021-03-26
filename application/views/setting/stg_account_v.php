    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Halaman Pengaturan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('Page_c') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo site_url('Setting_c') ?>" ><i class="fas fa-cogs"></i> Pengaturan</a></li>
              <li class="breadcrumb-item active">Rekening</li>
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
                <h5 class="m-0 card-title">Daftar Rekeing Bank</h5>
                <a class="btn btn-sm btn-success float-right" href="" data-toggle="modal" data-target="#modal-add-account"> <i class="fas fa-plus"></i> &nbsp; Rekening Baru</a>
              </div>
              <div class="card-body">
              	<div class="table-responsive">
              		<table class="table table-bordered table-striped" id="table-account">
              			<thead>
              				<th>No.</th>
              				<th>Bank</th>
              				<th>No Rekening</th>
              				<th>Atas Nama</th>
              				<th>Aksi</th>
              			</thead>
                    <tbody>
                    </tbody>
              			<tfoot>
              				<th>No.</th>
              				<th>Bank</th>
              				<th>No Rekening</th>
              				<th>Atas Nama</th>
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
     <!-- Modal Kategori -->
      <div class="modal fade" id="modal-add-account">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Rekening Baru</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="<?php echo site_url('Setting_c/addAccountProses') ?>" id="form-add-account">
              <div class="modal-body">
                <!-- Form-part input Bank -->
                  <div class="form-group row">
                    <label for="inputAccBank" class="col-sm-3 col-form-label">Bank <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                    	<select class="form-control float-right" name="postAccBank" id="input-acc-bank" required>
                    		<option value=""> -- Pilih Bank -- </option>
                        <?php foreach($optBank->result_array() as $showOpt): ?>
                    		  <option value="<?php echo urlencode(base64_encode($showOpt['bank_id'])) ?>"><?php echo $showOpt['bank_code'].' - '.$showOpt['bank_name'] ?></option>
                        <?php endforeach; ?>
                    	</select>
                      <small id="error-acc-bank" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                    </div>
                  </div>

                <!-- Form-part input Rekening AtasNama -->
                  <div class="form-group row">
                    <label for="inputAccountName" class="col-sm-3 col-form-label">Atas Nama Rekening <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postAccountName" id="input-acc-name" placeholder="Atas Nama Buku Rekening" required>
                      <small id="error-acc-name" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                    </div>
                  </div>

                <!-- Form-part input Nomor Rekening -->
                  <div class="form-group row">
                    <label for="inputAccNumber" class="col-sm-3 col-form-label">Nomor Rekening <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="number" class="form-control float-right" name="postAccNumber" id="input-acc-number" placeholder="Nomor Rekening" required>
                      <small id="error-acc-number" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                    </div>
                  </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

     <!-- Modal Edit -->
      <div class="modal fade" id="modal-edit-rekening">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" action="<?php echo site_url('Product_c') ?>" id="formEdit">
              <div class="modal-body">
                <!-- Form-part hidden Edit id -->
                  <input type="hidden" name="postID" id="editID" value="" disabled="disabled">
                <!-- Form-part input Bank -->
                  <div class="form-group row">
                    <label for="inputRekBank" class="col-sm-3 col-form-label">Bank <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                    	<select class="form-control float-right" name="postRekBank" id="editRekBank">
                    		<option> -- Pilih Bank -- </option>
                    		<option value="kode">AMBIL DARI DATABASE</option>
                    	</select>
                    </div>
                  </div>

                <!-- Form-part input Rekening AtasNama -->
                  <div class="form-group row">
                    <label for="inputRekAN" class="col-sm-3 col-form-label">Atas Nama Rekening <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postRekAN" id="editRekAN" placeholder="Atas Nama Buku Rekening" required>
                    </div>
                  </div>

                <!-- Form-part input Nomor Rekening -->
                  <div class="form-group row">
                    <label for="inputRekNomor" class="col-sm-3 col-form-label">Nomor Rekening <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="number" class="form-control float-right" name="postRekNomor" id="editRekNomor" placeholder="Nomor Rekening " required>
                    </div>
                  </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <?php 
        //print("<pre>".print_r($optBank, true)."</pre>")
      ?>