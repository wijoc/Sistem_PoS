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
                        <a class="btn btn-sm btn-info text-white float-right" data-toggle="modal" data-target="#modal-category">
                          <i class="fas fa-plus"></i> Tambah Kategori</a>
                      </div>
                    </div>
                    <hr>
                    <div id="alert-category"></div>
                    <table id="table-category" class="table table-bordered table-striped">
                      <thead>
                        <th>No.</th>
                        <th>Kategori</th>
                        <th>Jumlah Produk</th>
                        <th class="text-center">Aksi</th>
                      </thead>
                      <tbody>
                      </tbody>
                      <tfoot>
                        <th>No.</th>
                        <th>Kategori</th>
                        <th>Jumlah Produk</th>
                        <th class="text-center">Aksi</th>
                      </tfoot>
                    </table>
                  </div>
                </div>
                <div class="tab-content" id="custom-content-above-tabContent">
                  <div class="tab-pane" id="unit" role="tabpanel">
                    <div class="row">
                      <h5 class="col-sm-6 m-0">Daftar Satuan</h5>
                      <div class="col-sm-6">
                        <a class="btn btn-sm btn-info float-right" data-toggle="modal" data-target="#modal-unit">
                          <i class="fas fa-plus"></i> Tambah Satuan</a>
                      </div>
                    </div>
                    <hr>
                    <div id="alert-unit"></div>
                    <table id="table-unit" class="table table-bordered table-striped">
                      <thead>
                        <th>No.</th>
                        <th>Satuan</th>
                        <th>Jumlah Produk</th>
                        <th>Aksi</th>
                      </thead>
                      <tbody>
                      </tbody>
                      <tfoot>
                        <th>No.</th>
                        <th>Satuan</th>
                        <th>Jumlah Produk</th>
                        <th>Aksi</th>
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
              <h4 class="modal-title">Tambah Kategori</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" action="<?php echo site_url('Product_c/addCategoryProses') ?>" id="form-ctgr">
              <div class="modal-body">
                <!-- Form-part input Kategori nama -->
                  <div class="form-group row">
                    <label for="inputCtgrName" class="col-sm-3 col-form-label">Nama Kategori <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postCtgrName" id="inputCtgrName" placeholder="Nama kategori baru" required>
                      <small id="errorCtgr" class="error-msg" style="display:none; color:red; font-style: italic"></small>
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

     <!-- Modal Satuan -->
      <div class="modal fade" id="modal-unit">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Satuan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" action="<?php echo site_url('Product_c/addUnitProses') ?>" id="form-unit">
              <div class="modal-body">
                <!-- Form-part input Kategori -->
                  <div class="form-group row">
                    <label for="inputUnitName" class="col-sm-3 col-form-label">Nama Satuan <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postUnitName" id="inputUnitName" placeholder="Nama satuan baru" required>
                      <small id="errorUnit" class="error-msg" style="display:none; color:red; font-style: italic"></small>
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
      <div class="modal fade" id="modal-edit">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Ubah Data <span id="edit-title"></span></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" action="<?php echo site_url('Product_c/') ?>" id="form-edit">
              <div class="modal-body">
                <!-- Form-part hidden Edit id -->
                  <input type="hidden" name="postID" id="editID" value="" disabled="disabled">
                <!-- Form-part input Edit nama -->
                  <div class="form-group row">
                    <label for="editName" class="col-sm-3 col-form-label">Nama <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postName" id="editName" placeholder="" required>
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