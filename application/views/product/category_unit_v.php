    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark text-uppercase">Kategori & Satuan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('Page_c') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo site_url('Product_c') ?>"><i class="fas fa-cubes"></i> Produk</a></li>
              <li class="breadcrumb-item active">Kategori & Satuan</li>
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
              <div class="card-header">
                <ul class="nav nav-pills nav-justified nav-tabs ml-auto p-2" role="tablist">
                  <li class="nav-item">
                      <a class="tabs-nav nav-link font-weight-bold active" id="nav-category" href="#category" data-toggle="tab">Kategori</a>
                  </li>
                  <li class="nav-item">
                      <a class="tabs-nav nav-link font-weight-bold" id="nav-unit" href="#unit" data-toggle="tab">Satuan</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-content-above-tabContent">
                  <div class="tab-pane active" id="category" role="tabpanel">
                    <div class="row">
                      <h5 class="col-sm-6 m-0">Daftar Kategori</h5>
                      <div class="col-sm-6">
                        <a class="btn btn-sm btn-info text-white float-right" id="add-cat-button" data-toggle="modal" data-target="#modal-category">
                          <i class="fas fa-plus"></i>
                        </a>
                      </div>
                    </div>
                    <hr>
                    <table id="table-category" class="table table-bordered table-striped">
                      <thead>
                        <th>No.</th>
                        <th>Kategori</th>
                        <th>Jumlah Produk</th>
                        <?php if( in_array($this->session->userdata('logedInLevel'), ['uAll', 'uO', 'uG']) == TRUE ){ ?><th class="text-center">Aksi</th> <?php } ?>
                      </thead>
                      <tbody>
                      </tbody>
                      <tfoot>
                        <th>No.</th>
                        <th>Kategori</th>
                        <th>Jumlah Produk</th>
                        <?php if( in_array($this->session->userdata('logedInLevel'), ['uAll', 'uO', 'uG']) == TRUE ){ ?><th class="text-center">Aksi</th> <?php } ?>
                      </tfoot>
                    </table>
                  </div>
                </div>
                <div class="tab-content" id="custom-content-above-tabContent">
                  <div class="tab-pane" id="unit" role="tabpanel">
                    <div class="row">
                      <h5 class="col-sm-6 m-0">Daftar Satuan</h5>
                      <div class="col-sm-6">
                        <a class="btn btn-sm btn-info float-right text-white" id="add-unit-button" data-toggle="modal" data-target="#modal-unit">
                          <i class="fas fa-plus"></i></a>
                      </div>
                    </div>
                    <hr>
                    <table id="table-unit" class="table table-bordered table-striped">
                      <thead>
                        <th>No.</th>
                        <th>Satuan</th>
                        <th>Jumlah Produk</th>
                        <?php if( in_array($this->session->userdata('logedInLevel'), ['uAll', 'uO', 'uG']) == TRUE ){ ?><th class="text-center">Aksi</th> <?php } ?>
                      </thead>
                      <tbody>
                      </tbody>
                      <tfoot>
                        <th>No.</th>
                        <th>Satuan</th>
                        <th>Jumlah Produk</th>
                        <?php if( in_array($this->session->userdata('logedInLevel'), ['uAll', 'uO', 'uG']) == TRUE ){ ?><th class="text-center">Aksi</th> <?php } ?>
                      </tfoot>
                    </table>
                  </div>
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
      <div class="modal fade" id="modal-category">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><span id="form-title">Tambah</span> Kategori</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" id="form-cat">
              <div class="modal-body">
                <!-- Form-hidden edit kategori id -->
                  <input type="hidden" id="edit-cat-id" name="editID" required="" disabled="disabled">

                <!-- Form-part input Kategori nama -->
                  <div class="form-group row">
                    <label for="input-cat-name" class="col-sm-4 col-form-label">Nama Kategori <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postCatName" id="input-cat-name" placeholder="Nama kategori..." required>
                      <small id="error-cat-name" class="error-msg" style="display:none; color:red; font-style: italic"></small>
                    </div>
                  </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" id="submit-cat" class="btn btn-primary">Simpan</button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

     <!-- Modal Satuan -->
      <div class="modal fade" id="modal-unit">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><span id="form-unit-title">Tambah</span> Satuan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" id="form-unit">
              <div class="modal-body">
                <!-- Form-hidden edit Unit id -->
                  <input type="hidden" id="edit-unit-id" name="editUnitID" required="" disabled="disabled">

                <!-- Form-part input Unit nama -->
                  <div class="form-group row">
                    <label for="input-unit-name" class="col-sm-3 col-form-label">Nama Satuan <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postUnitName" id="input-unit-name" placeholder="Nama satuan baru" required>
                      <small id="error-unit-name" class="error-msg" style="display:none; color:red; font-style: italic"></small>
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