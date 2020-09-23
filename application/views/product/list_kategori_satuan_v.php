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
                      <a class="tabs-pilihan nav-link active" href="#kategori" data-toggle="tab">Kategori</a>
                  </li>
                  <li class="nav-item">
                      <a class="tabs-pilihan nav-link" href="#satuan" data-toggle="tab">Satuan</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-content-above-tabContent">
                  <div class="tab-pane active" id="kategori" role="tabpanel">
                    <div class="row">
                      <h5 class="col-sm-6 m-0">Daftar Kategori</h5>
                      <div class="col-sm-6">
                        <a class="btn btn-sm btn-info float-right" data-toggle="modal" data-target="#modal-kategori">
                          <i class="fas fa-plus"></i> Tambah Kategori</a>
                      </div>
                    </div>
                    <hr>
                   <?php if($dataKategori == NULL ){ ?>
                    <div class="alert alert-danger text-center"> Data Kategori belum tersedia !</div>
                   <?php } else { ?>
                    <div class="table-responsive">
                        <table id="table-barang" class="table table-bordered table-striped">
                          <thead>
                            <th>No.</th>
                            <th>Kategori</th>
                            <th>Produk dalam kategori ini</th>
                            <th class="text-center">Aksi</th>
                          </thead>
                          <tbody>
                            <?php
                              $no = 1; 
                              foreach ($dataKategori as $showKtgr) { ?>
                              <tr>
                                <td><?php echo $no ?></td>
                                <td><?php echo $showKtgr['ktgr_nama'] ?></td>
                                <td><?php echo $showKtgr['ktgr_nama'] ?></td>
                                <td class="text-center">
                                  <a class="btn btn-xs btn-info" href=""><i class="fas fa-search"></i></a>
                                  <a class="btn btn-xs btn-warning" href=""><i class="fas fa-edit"></i></a>
                                  <a class="btn btn-xs btn-danger" href=""><i class="fas fa-trash"></i></a>
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
                  <div class="tab-pane" id="satuan" role="tabpanel">
                    <div class="row">
                      <h5 class="col-sm-6 m-0">Daftar Satuan</h5>
                      <div class="col-sm-6">
                        <a class="btn btn-sm btn-info float-right" data-toggle="modal" data-target="#modal-satuan">
                          <i class="fas fa-plus"></i> Tambah Satuan</a>
                      </div>
                    </div>
                    <hr>
                   <?php if($dataSatuan == NULL ){ ?>
                    <div class="alert alert-danger text-center"> Data Satuan belum tersedia !</div>
                   <?php } else { ?>
                    <div class="table-responsive">
                      <table id="table-barang" class="table table-bordered table-striped">
                        <thead>
                          <th>No.</th>
                          <th>Satuan</th>
                          <th>Aksi</th>
                        </thead>
                        <tbody>
                            <?php
                              $no = 1; 
                              foreach ($dataSatuan as $showSat) { ?>
                              <tr>
                                <td><?php echo $no ?></td>
                                <td><?php echo $showSat['satuan_nama'] ?></td>
                                <td class="text-center">
                                  <a class="btn btn-xs btn-info" href=""><i class="fas fa-search"></i></a>
                                  <a class="btn btn-xs btn-warning" href=""><i class="fas fa-edit"></i></a>
                                  <a class="btn btn-xs btn-danger" href=""><i class="fas fa-trash"></i></a>
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
      <div class="modal fade" id="modal-kategori">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Kategori</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" action="<?php echo site_url('Product_c/addKategoriProses') ?>">
              <div class="modal-body">
                <!-- Form-part input Kategori -->
                  <div class="form-group row">
                    <label for="inputKategori" class="col-sm-3 col-form-label">Nama Kategori <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postKategori" id="inputKategori" placeholder="Nama kategori baru" required>
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
      <div class="modal fade" id="modal-satuan">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Satuan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" action="<?php echo site_url('Product_c/addSatuanProses') ?>">
              <div class="modal-body">
                <!-- Form-part input Kategori -->
                  <div class="form-group row">
                    <label for="inputSatuan" class="col-sm-3 col-form-label">Nama Satuan <a class="float-right"> : </a></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control float-right" name="postSatuan" id="inputSatuan" placeholder="Nama kategori baru" required>
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
        print("<pre>".print_r($dataSatuan, true)."</pre>")
      ?>