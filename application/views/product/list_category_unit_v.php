    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Halaman Produk</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo site_url('Page_c') ?>"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="<?php echo site_url('Product_c') ?>"><i class="fas fa-cubes"></i> Produk</a></li>
              <li class="breadcrumb-item active">Kategori</li>
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
                <ul class="nav nav-justified nav-tabs ml-auto p-2" role="tablist">
                  <li class="nav-item">
                      <a class="tabs-nav nav-link active" id="nav-category" href="#category" data-toggle="tab">Kategori</a>
                  </li>
                  <li class="nav-item">
                      <a class="tabs-nav nav-link" id="nav-unit" href="#unit" data-toggle="tab">Satuan</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-content-above-tabContent">
                  <div class="tab-pane active" id="category" role="tabpanel">
                    <div class="row">
                      <h5 class="col-sm-6 m-0">Daftar Kategori</h5>
                      <div class="col-sm-6">
                        <a class="btn btn-sm btn-info float-right" data-toggle="modal" data-target="#modal-category">
                          <i class="fas fa-plus"></i> Tambah Kategori</a>
                      </div>
                    </div>
                    <hr>
                    <div id="alert-category"></div>
                   <?php if($dataCtgr == NULL ){ ?>
                    <div class="alert alert-danger text-center"> Data Kategori belum tersedia !</div>
                   <?php } else { ?>
                    <div class="table-responsive">
                        <table id="table-ctgr" class="table table-bordered table-striped table-catunit">
                          <thead>
                            <th>No.</th>
                            <th>Kategori</th>
                            <th>Produk dalam kategori ini</th>
                            <th class="text-center">Aksi</th>
                          </thead>
                          <tbody>
                            <?php
                              $no = 1; 
                              foreach ($dataCtgr as $showCtgr) { ?>
                              <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $showCtgr['ctgr_name'] ?></td>
                                <td><?php echo $showCtgr['ctgr_name'] ?></td>
                                <td class="text-center">
                                  <a class="btn btn-xs btn-info" href="<?php echo site_url('Product_c/listProductOnCatPage/').urlencode(base64_encode($showCtgr['ctgr_id'])) ?>"><i class="fas fa-search"></i></a>
                                  <a class="btn btn-xs btn-warning ctgrEdit" data-toggle="modal" data-target="#modal-edit" data-id="<?php echo $showCtgr['ctgr_id'] ?>" data-name="<?php echo $showCtgr['ctgr_name'] ?>"><i class="fas fa-edit"></i></a>
                                  <a class="btn btn-xs btn-danger" onclick="confirmDelete('ctgr', '<?php echo urlencode(base64_encode($showCtgr['ctgr_id'])) ?>', '<?php echo site_url('Product_c/deleteCategoryProses') ?>')"><i class="fas fa-trash"></i></a>
                                </td>
                              </tr>
                            <?php } ?>
                          </tbody>
                          <tfoot>
                            <th>No.</th>
                            <th>Kategori</th>
                            <th>Produk dalam kategori ini</th>
                            <th class="text-center">Aksi</th>
                          </tfoot>
                        </table>
                    </div>
                   <?php } ?>
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
                   <?php if($dataUnit == NULL ){ ?>
                    <div class="alert alert-danger text-center"> Data Satuan belum tersedia !</div>
                   <?php } else { ?>
                    <div class="table-responsive">
                      <table id="table-unit" class="table table-bordered table-striped table-catunit">
                        <thead>
                          <th>No.</th>
                          <th>Satuan</th>
                          <th>Aksi</th>
                        </thead>
                        <tbody>
                            <?php
                              $no = 1; 
                              foreach ($dataUnit as $showUnit) { ?>
                              <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $showUnit['unit_name'] ?></td>
                                <td class="text-center">
                                  <a class="btn btn-xs btn-warning unitEdit" data-toggle="modal" data-target="#modal-edit" data-id="<?php echo $showUnit['unit_id'] ?>" data-name="<?php echo $showUnit['unit_name'] ?>"><i class="fas fa-edit"></i></a>
                                  <a class="btn btn-xs btn-danger" onclick="confirmDelete('unit', '<?php echo urlencode(base64_encode($showUnit['unit_id'])) ?>', '<?php echo site_url('Product_c/deleteUnitProses') ?>')"><i class="fas fa-trash"></i></a>
                                </td>
                              </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                          <th>No.</th>
                          <th>Satuan</th>
                          <th>Aksi</th>
                        </tfoot>
                      </table>
                    </div>
                   <?php } ?>
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
            <form method="POST" action="<?php echo site_url('Product_c/addCategoryProses') ?>">
              <div class="modal-body">
                <!-- Form-part input Kategori nama -->
                  <div class="form-group row">
                    <label for="inputCtgrName" class="col-sm-3 col-form-label">Nama Kategori <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postCtgrName" id="inputCtgrName" placeholder="Nama kategori baru" required>
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
            <form method="POST" action="<?php echo site_url('Product_c/addUnitProses') ?>" id="formSatuan">
              <div class="modal-body">
                <!-- Form-part input Kategori -->
                  <div class="form-group row">
                    <label for="inputSatuanNama" class="col-sm-3 col-form-label">Nama Satuan <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postSatuanNama" id="inputSatuanNama" placeholder="Nama satuan baru" required>
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
              <h4 class="modal-title">Ubah Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" action="<?php echo site_url('Product_c') ?>" id="formEdit">
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